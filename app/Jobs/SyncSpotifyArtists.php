<?php

namespace App\Jobs;

use App\Models\SpotifyArtist;
use App\Models\SpotifyAlbum;
use App\Models\SpotifyTrack;
use App\Services\SpotifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SyncSpotifyArtists implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // 1 hour timeout
    public $tries = 3;

    protected $artistIds;
    protected $syncAll;

    /**
     * Create a new job instance.
     *
     * @param array|null $artistIds Array of specific artist IDs to sync, or null to sync all
     * @param bool $syncAll Whether to sync all artists needing sync
     */
    public function __construct($artistIds = null, $syncAll = false)
    {
        $this->artistIds = $artistIds;
        $this->syncAll = $syncAll;
    }

    /**
     * Execute the job.
     */
    public function handle(SpotifyService $spotifyService)
    {
        try {
            Log::info('Starting Spotify sync job', [
                'artist_ids' => $this->artistIds,
                'sync_all' => $this->syncAll
            ]);

            $query = SpotifyArtist::query();

            if ($this->artistIds) {
                $query->whereIn('id', $this->artistIds);
            } elseif ($this->syncAll) {
                $query->needsSync(24); // Artists that haven't been synced in 24 hours
            } else {
                // Default: sync artists that haven't been synced in 48 hours
                $query->needsSync(48);
            }

            $artists = $query->active()->get();

            $syncedCount = 0;
            $failedCount = 0;

            foreach ($artists as $artist) {
                try {
                    $this->syncArtist($artist, $spotifyService);
                    $syncedCount++;
                    
                    // Add a small delay to respect rate limits
                    usleep(100000); // 0.1 second delay
                    
                } catch (\Exception $e) {
                    $failedCount++;
                    Log::error('Failed to sync Spotify artist', [
                        'artist_id' => $artist->id,
                        'artist_name' => $artist->name,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('Completed Spotify sync job', [
                'synced_count' => $syncedCount,
                'failed_count' => $failedCount,
                'total_artists' => $artists->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Spotify sync job failed completely', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Sync a single artist
     */
    private function syncArtist(SpotifyArtist $artist, SpotifyService $spotifyService)
    {
        DB::beginTransaction();

        try {
            // Update artist information
            $spotifyArtistData = $spotifyService->getArtist($artist->spotify_id);
            if ($spotifyArtistData) {
                $this->updateArtistData($artist, $spotifyArtistData);
            }

            // Check for new albums
            $this->syncArtistAlbums($artist, $spotifyService);

            $artist->markAsSynced();
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update artist data from Spotify
     */
    private function updateArtistData(SpotifyArtist $artist, array $spotifyData)
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
     * Sync artist albums and check for new releases
     */
    private function syncArtistAlbums(SpotifyArtist $artist, SpotifyService $spotifyService)
    {
        $albums = $spotifyService->getArtistAlbums($artist->spotify_id, 50);
        $existingAlbumIds = $artist->albums->pluck('spotify_id')->toArray();

        foreach ($albums as $albumData) {
            if (!in_array($albumData['id'], $existingAlbumIds)) {
                // This is a new album, import it
                $this->importNewAlbum($artist, $albumData, $spotifyService);
                
                Log::info('Imported new album during sync', [
                    'artist' => $artist->name,
                    'album' => $albumData['name'],
                    'release_date' => $albumData['release_date'] ?? null
                ]);
            }
        }
    }

    /**
     * Import a new album discovered during sync
     */
    private function importNewAlbum(SpotifyArtist $artist, array $albumData, SpotifyService $spotifyService)
    {
        $album = SpotifyAlbum::create([
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

        // Import tracks for this album
        $this->importAlbumTracks($artist, $album, $spotifyService);
    }

    /**
     * Import tracks for an album
     */
    private function importAlbumTracks(SpotifyArtist $artist, SpotifyAlbum $album, SpotifyService $spotifyService)
    {
        $tracks = $spotifyService->getAlbumTracks($album->spotify_id);

        foreach ($tracks as $trackData) {
            // Check if track already exists
            $existingTrack = SpotifyTrack::where('spotify_id', $trackData['id'])->first();
            if ($existingTrack) {
                continue;
            }

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

            SpotifyTrack::create([
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

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Spotify sync job failed', [
            'error' => $exception->getMessage(),
            'artist_ids' => $this->artistIds,
            'sync_all' => $this->syncAll
        ]);
    }
}
