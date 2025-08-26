<?php

namespace App\Console\Commands;

use App\Models\SpotifyPost;
use App\Models\SpotifyArtist; 
use App\Models\SpotifyAlbum;
use App\Models\SpotifyTrack;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SyncSpotifyContent extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'spotify:sync-content 
                            {--create-categories : Create categories for imported content}
                            {--create-tags : Create tags from genres}
                            {--sync-posts : Create SpotifyPost records from imported tracks}';

    /**
     * The console command description.
     */
    protected $description = 'Sync imported Spotify content with local categories and create SpotifyPost records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $createCategories = $this->option('create-categories');
        $createTags = $this->option('create-tags');
        $syncPosts = $this->option('sync-posts');
        
        // If no options provided, run all
        if (!$createCategories && !$createTags && !$syncPosts) {
            $createCategories = $createTags = $syncPosts = true;
        }

        $this->info('Starting Spotify content synchronization...');

        if ($createCategories) {
            $this->createMusicCategories();
        }

        if ($createTags) {
            $this->createGenreTags();
        }

        if ($syncPosts) {
            $this->syncSpotifyPosts();
        }

        $this->info('Spotify content synchronization completed!');
        return 0;
    }

    /**
     * Create music categories for better organization
     */
    private function createMusicCategories()
    {
        $this->info('Creating music categories...');

        $categories = [
            [
                'name' => 'Hip Hop & Rap',
                'slug' => 'hip-hop-rap',
                'description' => 'Hip hop, rap, and urban music',
                'type' => 'music'
            ],
            [
                'name' => 'Pop Music',
                'slug' => 'pop-music',
                'description' => 'Popular music and mainstream hits',
                'type' => 'music'
            ],
            [
                'name' => 'R&B & Soul',
                'slug' => 'rnb-soul',
                'description' => 'Rhythm & Blues and Soul music',
                'type' => 'music'
            ],
            [
                'name' => 'Afrobeats',
                'slug' => 'afrobeats',
                'description' => 'Afrobeats and African contemporary music',
                'type' => 'music'
            ],
            [
                'name' => 'Alternative',
                'slug' => 'alternative',
                'description' => 'Alternative and indie music',
                'type' => 'music'
            ],
            [
                'name' => 'Electronic',
                'slug' => 'electronic',
                'description' => 'Electronic dance music and EDM',
                'type' => 'music'
            ],
            [
                'name' => 'Jazz & Blues',
                'slug' => 'jazz-blues',
                'description' => 'Jazz, blues, and instrumental music',
                'type' => 'music'
            ],
            [
                'name' => 'World Music',
                'slug' => 'world-music',
                'description' => 'International and world music',
                'type' => 'music'
            ],
            [
                'name' => 'Spotify Imports',
                'slug' => 'spotify-imports',
                'description' => 'Music imported from Spotify',
                'type' => 'music'
            ]
        ];

        $created = 0;
        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug'], 'type' => $categoryData['type']],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'is_active' => true
                ]
            );

            if ($category->wasRecentlyCreated) {
                $created++;
                $this->line("Created category: {$category->name}");
            }
        }

        $this->info("Categories processed: {$created} created, " . (count($categories) - $created) . " already existed");
    }

    /**
     * Create tags from Spotify genres
     */
    private function createGenreTags()
    {
        $this->info('Creating genre tags from Spotify data...');

        // Get all unique genres from Spotify artists
        $artists = SpotifyArtist::whereNotNull('genres')->get();
        $allGenres = [];

        foreach ($artists as $artist) {
            if (is_array($artist->genres)) {
                $allGenres = array_merge($allGenres, $artist->genres);
            }
        }

        $uniqueGenres = array_unique($allGenres);
        $created = 0;

        foreach ($uniqueGenres as $genre) {
            if (empty($genre)) continue;

            $slug = Str::slug($genre);
            $name = ucwords(str_replace(['-', '_'], ' ', $genre));

            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'is_active' => true
                ]
            );

            if ($tag->wasRecentlyCreated) {
                $created++;
                $this->line("Created tag: {$tag->name}");
            }
        }

        $this->info("Genre tags processed: {$created} created");
    }

    /**
     * Create SpotifyPost records from imported tracks and albums
     */
    private function syncSpotifyPosts()
    {
        $this->info('Syncing Spotify posts...');

        $spotifyCategory = Category::where('slug', 'spotify-imports')->where('type', 'music')->first();
        $created = 0;
        $updated = 0;

        // Sync from tracks
        $tracks = SpotifyTrack::with(['artist', 'album'])->get();
        
        foreach ($tracks as $track) {
            $artist = $track->artist;
            $album = $track->album;

            // Create or update SpotifyPost for the track
            $postData = [
                'title' => $track->name,
                'artist_name' => $artist->name ?? 'Unknown Artist',
                'description' => "Track from Spotify: {$track->name}" . ($album ? " (Album: {$album->name})" : ''),
                'album_name' => $album->name ?? null,
                'image_url' => $album->image_url ?? $artist->image_url ?? null,
                'spotify_url' => $track->getSpotifyUrl(),
                'preview_url' => $track->preview_url,
                'release_date' => $album->release_date ?? null,
                'artists' => $track->featured_artists ? array_merge([['name' => $artist->name]], $track->featured_artists) : [['name' => $artist->name]],
                'genres' => $artist->genres ?? [],
                'type' => 'track',
                'popularity' => $track->popularity ?? $artist->popularity ?? 0,
                'is_featured' => false
            ];

            $spotifyPost = SpotifyPost::updateOrCreate(
                ['spotify_id' => $track->spotify_id],
                $postData
            );

            if ($spotifyPost->wasRecentlyCreated) {
                $created++;
                $this->line("Created post for track: {$track->name}");
            } else {
                $updated++;
            }
        }

        // Sync from albums (for albums without individual tracks)
        $albums = SpotifyAlbum::with('artist')->doesntHave('tracks')->get();
        
        foreach ($albums as $album) {
            $artist = $album->artist;

            $postData = [
                'title' => $album->name,
                'artist_name' => $artist->name ?? 'Unknown Artist',
                'description' => "Album from Spotify: {$album->name}",
                'album_name' => $album->name,
                'image_url' => $album->image_url ?? $artist->image_url ?? null,
                'spotify_url' => $album->getSpotifyUrl(),
                'preview_url' => null,
                'release_date' => $album->release_date,
                'artists' => [['name' => $artist->name]],
                'genres' => $album->genres ?? $artist->genres ?? [],
                'type' => $album->album_type,
                'popularity' => $artist->popularity ?? 0,
                'is_featured' => false
            ];

            $spotifyPost = SpotifyPost::updateOrCreate(
                ['spotify_id' => $album->spotify_id],
                $postData
            );

            if ($spotifyPost->wasRecentlyCreated) {
                $created++;
                $this->line("Created post for album: {$album->name}");
            } else {
                $updated++;
            }
        }

        // Feature popular posts (top 10% by popularity)
        $allPosts = SpotifyPost::orderBy('popularity', 'desc')->get();
        $totalPosts = $allPosts->count();
        $featuredCount = max(1, intval($totalPosts * 0.1)); // Top 10% or at least 1

        SpotifyPost::query()->update(['is_featured' => false]);
        $allPosts->take($featuredCount)->each(function($post) {
            $post->update(['is_featured' => true]);
        });

        $this->info("Spotify posts processed: {$created} created, {$updated} updated");
        $this->info("Featured {$featuredCount} posts based on popularity");
    }
}