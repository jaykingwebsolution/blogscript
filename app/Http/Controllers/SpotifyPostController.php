<?php

namespace App\Http\Controllers;

use App\Models\SpotifyPost;
use Illuminate\Http\Request;

class SpotifyPostController extends Controller
{
    public function index()
    {
        $spotifyPosts = SpotifyPost::latest('release_date')
                                 ->latest('created_at')
                                 ->paginate(20);
        
        return view('spotify.index', compact('spotifyPosts'));
    }

    public function show(SpotifyPost $spotifyPost)
    {
        return view('spotify.show', compact('spotifyPost'));
    }

    public function featured()
    {
        $featuredPosts = SpotifyPost::featured()
                                  ->latest()
                                  ->paginate(12);
        
        return view('spotify.featured', compact('featuredPosts'));
    }

    public function getLatestForHomepage($limit = 5)
    {
        return SpotifyPost::getLatest($limit);
    }
}
