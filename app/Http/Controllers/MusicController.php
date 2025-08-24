<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index(Request $request)
    {
        $query = Music::with(['artist', 'category', 'tags'])->published();

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search by title or artist
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('artist_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('artist', function($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $music = $query->latest()->paginate(12);
        $categories = Category::active()->byType('music')->get();
        $tags = Tag::active()->get();
        $genres = Music::published()->distinct()->pluck('genre')->filter();

        return view('music.index', compact('music', 'categories', 'tags', 'genres'));
    }

    public function show($slug)
    {
        $music = Music::with(['artist', 'category', 'tags'])
                     ->where('slug', $slug)
                     ->published()
                     ->firstOrFail();

        $relatedMusic = Music::with(['artist', 'category'])
                           ->published()
                           ->where('id', '!=', $music->id)
                           ->where(function($query) use ($music) {
                               if ($music->artist_id) {
                                   $query->where('artist_id', $music->artist_id);
                               } else {
                                   $query->where('genre', $music->genre);
                               }
                           })
                           ->limit(6)
                           ->get();

        return view('music.show', compact('music', 'relatedMusic'));
    }
}