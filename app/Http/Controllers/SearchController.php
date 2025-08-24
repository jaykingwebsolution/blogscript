<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Artist;
use App\Models\Video;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');
        
        if (empty($query)) {
            return view('search.index', [
                'query' => '',
                'type' => $type,
                'results' => collect(),
                'counts' => [
                    'music' => 0,
                    'artists' => 0,
                    'videos' => 0,
                    'posts' => 0,
                    'total' => 0
                ]
            ]);
        }

        $results = collect();
        $counts = [
            'music' => 0,
            'artists' => 0,
            'videos' => 0,
            'posts' => 0,
            'total' => 0
        ];

        // Search Music
        if ($type === 'all' || $type === 'music') {
            $musicResults = Music::with(['artist', 'category', 'tags'])
                ->published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('artist_name', 'LIKE', "%{$query}%")
                      ->orWhere('genre', 'LIKE', "%{$query}%")
                      ->orWhereHas('artist', function($subQ) use ($query) {
                          $subQ->where('name', 'LIKE', "%{$query}%");
                      })
                      ->orWhereHas('tags', function($subQ) use ($query) {
                          $subQ->where('name', 'LIKE', "%{$query}%");
                      });
                })
                ->limit($type === 'music' ? 20 : 5)
                ->get()
                ->map(function($item) {
                    $item->type = 'music';
                    $item->url = route('music.show', $item->slug);
                    return $item;
                });
            
            $counts['music'] = $musicResults->count();
            if ($type === 'all' || $type === 'music') {
                $results = $results->merge($musicResults);
            }
        }

        // Search Artists
        if ($type === 'all' || $type === 'artists') {
            $artistResults = Artist::published()
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('genre', 'LIKE', "%{$query}%")
                      ->orWhere('country', 'LIKE', "%{$query}%")
                      ->orWhere('bio', 'LIKE', "%{$query}%");
                })
                ->limit($type === 'artists' ? 20 : 5)
                ->get()
                ->map(function($item) {
                    $item->type = 'artist';
                    $item->url = route('artists.show', $item->username ?? $item->slug);
                    return $item;
                });
            
            $counts['artists'] = $artistResults->count();
            if ($type === 'all' || $type === 'artists') {
                $results = $results->merge($artistResults);
            }
        }

        // Search Videos
        if ($type === 'all' || $type === 'videos') {
            $videoResults = Video::with(['category', 'tags'])
                ->published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%")
                      ->orWhereHas('tags', function($subQ) use ($query) {
                          $subQ->where('name', 'LIKE', "%{$query}%");
                      });
                })
                ->limit($type === 'videos' ? 20 : 5)
                ->get()
                ->map(function($item) {
                    $item->type = 'video';
                    $item->url = route('videos.show', $item->slug);
                    return $item;
                });
            
            $counts['videos'] = $videoResults->count();
            if ($type === 'all' || $type === 'videos') {
                $results = $results->merge($videoResults);
            }
        }

        // Search Posts/News
        if ($type === 'all' || $type === 'posts') {
            $postResults = News::with(['category', 'tags', 'creator'])
                ->published()
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('content', 'LIKE', "%{$query}%")
                      ->orWhere('excerpt', 'LIKE', "%{$query}%")
                      ->orWhereHas('tags', function($subQ) use ($query) {
                          $subQ->where('name', 'LIKE', "%{$query}%");
                      });
                })
                ->limit($type === 'posts' ? 20 : 5)
                ->get()
                ->map(function($item) {
                    $item->type = 'post';
                    $item->url = route('posts.show', $item->slug);
                    return $item;
                });
            
            $counts['posts'] = $postResults->count();
            if ($type === 'all' || $type === 'posts') {
                $results = $results->merge($postResults);
            }
        }

        $counts['total'] = $counts['music'] + $counts['artists'] + $counts['videos'] + $counts['posts'];

        return view('search.index', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
            'counts' => $counts
        ]);
    }
}