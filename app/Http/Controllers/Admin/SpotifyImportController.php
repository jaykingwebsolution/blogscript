<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SpotifyService;
use App\Models\SpotifyArtist;
use App\Models\SpotifyAlbum;
use App\Models\SpotifyTrack;
use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SpotifyImportController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Access denied. Admin access required.');
            }
            return $next($request);
        });
    }

    /**
     * Display Spotify import dashboard
     */
    public function index()
    {
        $importedArtists = SpotifyArtist::with(['albums', 'tracks'])
            ->active()
            ->latest()
            ->paginate(12);

        $stats = [
            'total_artists' => SpotifyArtist::count(),
            'total_albums' => SpotifyAlbum::count(),
            'total_tracks' => SpotifyTrack::count(),
            'artists_needing_sync' => SpotifyArtist::needsSync()->count()
        ];

        return view('admin.spotify-import.index', compact('importedArtists', 'stats'));
    }

    /**
     * Search for artists on Spotify
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2|max:100'
        ]);

        try {
            $artists = $this->spotifyService->searchArtists($request->query, 20);
            
            // Check which artists are already imported
            $spotifyIds = collect($artists)->pluck('id');
            $existingArtists = SpotifyArtist::whereIn('spotify_id', $spotifyIds)->pluck('spotify_id');
            
            foreach ($artists as &$artist) {
                $artist['is_imported'] = $existingArtists->contains($artist['id']);
            }

            return response()->json([
                'success' => true,
                'artists' => $artists
            ]);

        } catch (\Exception $e) {
            Log::error('Spotify search error', ['error' => $e->getMessage(), 'query' => $request->query]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to search Spotify. Please check your API credentials.'
            ], 500);
        }
    }

    /**
     * Import an artist and their discography from Spotify
     */
    public function importArtist(Request $request)
    {
        $request->validate([
            'spotify_id' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            // Check if artist already exists
            $existingArtist = SpotifyArtist::where('spotify_id', $request->spotify_id)->first();
            if ($existingArtist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artist already imported.'
                ]);
            }

            // Get artist data from Spotify
            $spotifyArtistData = $this->spotifyService->getArtist($request->spotify_id);
            if (!$spotifyArtistData) {
                throw new \Exception('Failed to fetch artist data from Spotify');
            }

            // Create Spotify artist record
            $spotifyArtist = $this->createSpotifyArtist($spotifyArtistData);

            // Import artist's albums and tracks
            $this->importArtistDiscography($spotifyArtist);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully imported {$spotifyArtist->name} with their discography.",
                'artist' => $spotifyArtist->load(['albums', 'tracks'])
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Spotify import error', [
                'error' => $e->getMessage(),
                'spotify_id' => $request->spotify_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to import artist: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh/sync an existing artist's data
     */
    public function syncArtist(SpotifyArtist $spotifyArtist)
    {
        try {
            DB::beginTransaction();

            // Update artist data
            $spotifyArtistData = $this->spotifyService->getArtist($spotifyArtist->spotify_id);
            if ($spotifyArtistData) {
                $this->updateSpotifyArtist($spotifyArtist, $spotifyArtistData);
            }

            // Import new releases
            $this->importArtistDiscography($spotifyArtist, true);

            $spotifyArtist->markAsSynced();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully synced {$spotifyArtist->name}'s data."
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Spotify sync error', [
                'error' => $e->getMessage(),
                'artist_id' => $spotifyArtist->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to sync artist: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk sync multiple artists
     */
    public function bulkSync(Request $request)
    {
        $request->validate([
            'artist_ids' => 'required|array',
            'artist_ids.*' => 'exists:spotify_artists,id'
        ]);

        $syncedCount = 0;
        $failedCount = 0;

        foreach ($request->artist_ids as $artistId) {
            try {
                $spotifyArtist = SpotifyArtist::findOrFail($artistId);
                
                // Update artist data
                $spotifyArtistData = $this->spotifyService->getArtist($spotifyArtist->spotify_id);
                if ($spotifyArtistData) {
                    $this->updateSpotifyArtist($spotifyArtist, $spotifyArtistData);
                }

                // Import new releases
                $this->importArtistDiscography($spotifyArtist, true);
                $spotifyArtist->markAsSynced();
                
                $syncedCount++;
            } catch (\Exception $e) {
                $failedCount++;
                Log::error('Bulk sync error', [
                    'error' => $e->getMessage(),
                    'artist_id' => $artistId
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Synced {$syncedCount} artists. {$failedCount} failed."
        ]);
    }

    /**
     * Delete a Spotify artist and related data
     */
    public function deleteArtist(SpotifyArtist $spotifyArtist)
    {
        try {
            $artistName = $spotifyArtist->name;
            $spotifyArtist->delete(); // Cascades to albums and tracks

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$artistName} and all related data."
            ]);

        } catch (\Exception $e) {
            Log::error('Spotify delete error', [
                'error' => $e->getMessage(),
                'artist_id' => $spotifyArtist->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete artist: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Spotify artist record from API data
     */
    private function createSpotifyArtist($spotifyData)
    {
        return SpotifyArtist::create([
            'spotify_id' => $spotifyData['id'],
            'name' => $spotifyData['name'],
            'image_url' => $spotifyData['images'][0]['url'] ?? null,
            'genres' => $spotifyData['genres'] ?? [],
            'popularity' => $spotifyData['popularity'] ?? null,
            'followers' => $spotifyData['followers']['total'] ?? 0,
            'external_urls' => $spotifyData['external_urls'] ?? [],
            'is_imported' => true,
            'is_active' => true
        ]);
    }

    /**
     * Update existing Spotify artist with fresh data
     */
    private function updateSpotifyArtist(SpotifyArtist $artist, $spotifyData)
    {
        $artist->update([
            'name' => $spotifyData['name'],
            'image_url' => $spotifyData['images'][0]['url'] ?? $artist->image_url,
            'genres' => $spotifyData['genres'] ?? $artist->genres,
            'popularity' => $spotifyData['popularity'] ?? $artist->popularity,
            'followers' => $spotifyData['followers']['total'] ?? $artist->followers,
            'external_urls' => $spotifyData['external_urls'] ?? $artist->external_urls,
        ]);
    }

    /**
     * Import artist's albums and tracks
     */
    private function importArtistDiscography(SpotifyArtist $spotifyArtist, $syncOnly = false)
    {
        // Get albums
        $albums = $this->spotifyService->getArtistAlbums($spotifyArtist->spotify_id);

        foreach ($albums as $albumData) {
            $existingAlbum = SpotifyAlbum::where('spotify_id', $albumData['id'])->first();
            
            if ($syncOnly && $existingAlbum) {
                continue; // Skip existing albums during sync
            }

            if (!$existingAlbum) {
                $spotifyAlbum = $this->createSpotifyAlbum($spotifyArtist, $albumData);
            } else {
                $spotifyAlbum = $existingAlbum;
            }

            // Import tracks for this album
            $this->importAlbumTracks($spotifyArtist, $spotifyAlbum, $syncOnly);
        }
    }

    /**
     * Create Spotify album record
     */
    private function createSpotifyAlbum(SpotifyArtist $artist, $albumData)
    {
        return SpotifyAlbum::create([
            'spotify_id' => $albumData['id'],
            'name' => $albumData['name'],
            'album_type' => $albumData['album_type'],
            'image_url' => $albumData['images'][0]['url'] ?? null,
            'release_date' => $albumData['release_date'] ?? null,
            'release_date_precision' => $albumData['release_date_precision'] ?? null,
            'total_tracks' => $albumData['total_tracks'] ?? 0,
            'external_urls' => $albumData['external_urls'] ?? [],
            'spotify_artist_id' => $artist->id,
            'is_imported' => true,
            'is_active' => true
        ]);
    }

    /**
     * Import tracks for an album
     */
    private function importAlbumTracks(SpotifyArtist $artist, SpotifyAlbum $album, $syncOnly = false)
    {
        $tracks = $this->spotifyService->getAlbumTracks($album->spotify_id);

        foreach ($tracks as $trackData) {
            $existingTrack = SpotifyTrack::where('spotify_id', $trackData['id'])->first();
            
            if ($syncOnly && $existingTrack) {
                continue; // Skip existing tracks during sync
            }

            if (!$existingTrack) {
                $this->createSpotifyTrack($artist, $album, $trackData);
            }
        }
    }

    /**
     * Create Spotify track record
     */
    private function createSpotifyTrack(SpotifyArtist $artist, SpotifyAlbum $album, $trackData)
    {
        // Extract featured artists
        $featuredArtists = [];
        if (!empty($trackData['artists'])) {
            foreach ($trackData['artists'] as $artistData) {
                if ($artistData['id'] !== $artist->spotify_id) {
                    $featuredArtists[] = [
                        'id' => $artistData['id'],
                        'name' => $artistData['name'],
                        'spotify_url' => $artistData['external_urls']['spotify'] ?? null
                    ];
                }
            }
        }

        return SpotifyTrack::create([
            'spotify_id' => $trackData['id'],
            'name' => $trackData['name'],
            'duration_ms' => $trackData['duration_ms'] ?? null,
            'track_number' => $trackData['track_number'] ?? null,
            'disc_number' => $trackData['disc_number'] ?? 1,
            'explicit' => $trackData['explicit'] ?? false,
            'preview_url' => $trackData['preview_url'] ?? null,
            'external_urls' => $trackData['external_urls'] ?? [],
            'featured_artists' => $featuredArtists,
            'spotify_artist_id' => $artist->id,
            'spotify_album_id' => $album->id,
            'is_imported' => true,
            'is_active' => true
        ]);
    }
}
