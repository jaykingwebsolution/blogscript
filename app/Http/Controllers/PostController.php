<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'tags', 'creator'])->published();

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

        // Search by title or content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(10);
        $categories = Category::active()->byType('post')->get();
        $tags = Tag::active()->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $post = News::with(['category', 'tags', 'creator'])
                   ->where('slug', $slug)
                   ->published()
                   ->firstOrFail();

        $relatedPosts = News::with(['category'])
                          ->published()
                          ->where('id', '!=', $post->id)
                          ->where('category_id', $post->category_id)
                          ->limit(4)
                          ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}