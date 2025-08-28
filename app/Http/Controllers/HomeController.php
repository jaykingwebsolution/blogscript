<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Artist;
use App\Models\Video;
use App\Models\News;
use App\Models\SpotifyPost;
use App\Models\SpotifyArtist;
use App\Http\Controllers\Admin\PageController;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get featured/latest content from database
            $latestMusic = Music::published()->with(['category', 'tags'])->latest()->take(4)->get();
            $featuredArtists = Artist::published()->trending()->latest()->take(4)->get();
            $latestPosts = News::published()->latest()->take(3)->get();
            $recentVideos = Video::published()->latest()->take(3)->get();
            $spotifyHighlights = SpotifyPost::getFeatured(5);
            
            // Include Spotify imported content
            $spotifyArtists = SpotifyArtist::getFeatured(6);
            $recentSpotifyImports = SpotifyArtist::getRecentlyImported(4);

            // Get public pages for footer links
            $publicPages = PageController::getPublicPages();

            return view('home', compact(
                'latestMusic', 
                'featuredArtists', 
                'latestPosts', 
                'recentVideos',
                'spotifyHighlights',
                'spotifyArtists',
                'recentSpotifyImports',
                'publicPages'
            ));
        } catch (\Exception $e) {
            // Fallback to empty collections if database is not available
            return view('home', [
                'latestMusic' => collect(),
                'featuredArtists' => collect(),
                'latestPosts' => collect(),
                'recentVideos' => collect(),
                'spotifyHighlights' => collect(),
                'spotifyArtists' => collect(),
                'recentSpotifyImports' => collect(),
                'publicPages' => PageController::getPublicPages(),
                'useDummyData' => true
            ]);
        }
    }
}