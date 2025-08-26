<?php

namespace App\Http\Controllers;

use App\Models\SpotifyPost;
use App\Models\SpotifyArtist;
use App\Models\SpotifyAlbum;
use App\Models\SpotifyTrack;
use Illuminate\Http\Request;

class SpotifyPostController extends Controller
{
    public function index(Request $request)
    {
        $query = SpotifyPost::query();
        
        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('artist_name', 'LIKE', "%{$search}%")
                  ->orWhere('album_name', 'LIKE', "%{$search}%");
            });
        }
        
        $spotifyPosts = $query->latest('release_date')
                            ->latest('created_at')
                            ->paginate(24);
        
        return view('spotify.index', compact('spotifyPosts'));
    }

    public function show(SpotifyPost $spotifyPost)
    {
        return view('spotify.show', compact('spotifyPost'));
    }

    public function featured()
    {
        $featuredPosts = SpotifyPost::featured()
                                  ->latest('created_at')
                                  ->paginate(12);
        
        return view('spotify.featured', compact('featuredPosts'));
    }

    public function getLatestForHomepage($limit = 5)
    {
        return SpotifyPost::getLatest($limit);
    }
    
    /**
     * Get featured Spotify content for homepage
     */
    public function getFeaturedForHomepage($limit = 6)
    {
        return SpotifyPost::getFeatured($limit);
    }
    
    /**
     * Get Spotify artists for homepage
     */
    public function getArtistsForHomepage($limit = 6)
    {
        return SpotifyArtist::getFeatured($limit);
    }
    
    /**
     * Browse by artist
     */
    public function byArtist($artistId)
    {
        $artist = SpotifyArtist::findOrFail($artistId);
        
        $spotifyPosts = SpotifyPost::where('artist_name', $artist->name)
                                 ->orWhereJsonContains('artists', [['name' => $artist->name]])
                                 ->latest('release_date')
                                 ->latest('created_at')
                                 ->paginate(20);
        
        return view('spotify.artist', compact('artist', 'spotifyPosts'));
    }
    
    /**
     * Get statistics for admin dashboard
     */
    public function getStats()
    {
        return [
            'total_posts' => SpotifyPost::count(),
            'total_artists' => SpotifyArtist::count(),
            'total_albums' => SpotifyAlbum::count(),
            'total_tracks' => SpotifyTrack::count(),
            'featured_posts' => SpotifyPost::featured()->count(),
            'recent_imports' => SpotifyPost::where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
}
