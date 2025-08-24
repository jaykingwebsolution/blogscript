<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::with(['category', 'tags'])->published();

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search by title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        $videos = $query->latest()->paginate(12);
        $categories = Category::active()->byType('video')->get();
        $tags = Tag::active()->get();

        return view('videos.index', compact('videos', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $video = Video::with(['category', 'tags'])
                     ->where('slug', $slug)
                     ->published()
                     ->firstOrFail();

        $relatedVideos = Video::with(['category'])
                            ->published()
                            ->where('id', '!=', $video->id)
                            ->where('category_id', $video->category_id)
                            ->limit(6)
                            ->get();

        return view('videos.show', compact('video', 'relatedVideos'));
    }
}