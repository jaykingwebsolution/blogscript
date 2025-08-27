<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Music;
use App\Models\Category;
use App\Models\Playlist;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user (if doesn't exist)
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'listener',
                'status' => 'approved',
                'verification_status' => 'unverified'
            ]
        );

        // Create another user for testing (if doesn't exist)
        $artist = User::firstOrCreate(
            ['email' => 'artist@example.com'],
            [
                'name' => 'Test Artist',
                'password' => Hash::make('password'),
                'role' => 'artist',
                'status' => 'approved',
                'verification_status' => 'verified',
                'artist_stage_name' => 'Test Artist'
            ]
        );

        // Create a category (if doesn't exist)
        $category = Category::firstOrCreate(
            ['slug' => 'hip-hop'],
            ['name' => 'Hip Hop']
        );

        // Create some test music
        $music1 = Music::create([
            'title' => 'Test Song 1',
            'slug' => 'test-song-1',
            'description' => 'A great test song',
            'audio_url' => 'https://example.com/audio1.mp3',
            'image_url' => null,
            'genre' => 'Hip Hop',
            'created_by' => $artist->id,
            'category_id' => $category->id,
            'status' => 'published',
            'artist_name' => 'Test Artist',
            'duration' => '3:30'
        ]);

        $music2 = Music::create([
            'title' => 'Test Song 2',
            'slug' => 'test-song-2',
            'description' => 'Another great test song',
            'audio_url' => 'https://example.com/audio2.mp3',
            'image_url' => null,
            'genre' => 'R&B',
            'created_by' => $artist->id,
            'category_id' => $category->id,
            'status' => 'published',
            'artist_name' => 'Test Artist',
            'duration' => '4:15'
        ]);

        // Create a test playlist
        $playlist = Playlist::create([
            'title' => 'My Test Playlist',
            'description' => 'A great test playlist',
            'visibility' => 'public',
            'user_id' => $user->id,
            'slug' => 'my-test-playlist'
        ]);

        // Add music to the playlist
        $playlist->music()->attach($music1->id, ['order_in_playlist' => 1]);
        $playlist->music()->attach($music2->id, ['order_in_playlist' => 2]);

        // Add likes
        $user->likedSongs()->attach($music1->id);

        echo "Test data created successfully!\n";
        echo "User: test@example.com / password\n";
        echo "Artist: artist@example.com / password\n";
    }
}
