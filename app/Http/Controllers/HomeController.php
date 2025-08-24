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
            $featuredMusic = Music::published()->featured()->latest()->take(3)->get();
            $trendingArtists = Artist::published()->trending()->latest()->take(4)->get();
            $latestNews = News::published()->latest()->take(3)->get();
            $recentVideos = Video::published()->latest()->take(4)->get();

            return view('home', compact(
                'featuredMusic', 
                'trendingArtists', 
                'latestNews', 
                'recentVideos'
            ));
        } catch (\Exception $e) {
            // Fallback to dummy data if database is not available
            return view('home', [
                'featuredMusic' => collect(),
                'trendingArtists' => collect(),
                'latestNews' => collect(),
                'recentVideos' => collect(),
                'useDummyData' => true
            ]);
        }
    }
}