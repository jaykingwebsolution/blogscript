<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Artist;
use App\Models\Video;
use App\Models\News;

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

            return view('home', compact(
                'latestMusic', 
                'featuredArtists', 
                'latestPosts', 
                'recentVideos'
            ));
        } catch (\Exception $e) {
            // Fallback to empty collections if database is not available
            return view('home', [
                'latestMusic' => collect(),
                'featuredArtists' => collect(),
                'latestPosts' => collect(),
                'recentVideos' => collect(),
                'useDummyData' => true
            ]);
        }
    }
}