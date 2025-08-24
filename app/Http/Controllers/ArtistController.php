<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Music;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::with(['music' => function($q) {
            $q->published()->limit(3);
        }])->published();

        // Search by name or genre
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('genre', 'LIKE', "%{$search}%");
            });
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        $artists = $query->latest()->paginate(12);
        $genres = Artist::published()->distinct()->pluck('genre')->filter();

        return view('artists.index', compact('artists', 'genres'));
    }

    public function show($username)
    {
        $artist = Artist::with(['music' => function($q) {
                       $q->published()->latest();
                   }])
                   ->where('username', $username)
                   ->orWhere('slug', $username)
                   ->published()
                   ->firstOrFail();

        $musicCount = $artist->music()->published()->count();
        
        return view('artists.show', compact('artist', 'musicCount'));
    }
}