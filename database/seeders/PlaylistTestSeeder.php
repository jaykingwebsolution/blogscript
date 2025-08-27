<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Music;
use App\Models\Playlist;
use Illuminate\Support\Facades\Hash;

class PlaylistTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creating test users for playlist functionality...\n";
        
        // Create Test User A
        $userA = User::firstOrCreate([
            'email' => 'testuser.a@example.com'
        ], [
            'name' => 'Alex Johnson',
            'password' => Hash::make('password123'),
            'role' => 'listener',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create Test User B  
        $userB = User::firstOrCreate([
            'email' => 'testuser.b@example.com'
        ], [
            'name' => 'Sarah Williams',
            'password' => Hash::make('password123'),
            'role' => 'listener',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        echo "✓ Created test users: Alex Johnson and Sarah Williams\n";

        // Get some songs to work with
        $songs = Music::take(10)->get();
        
        if ($songs->count() < 5) {
            echo "⚠️  Warning: Not enough songs in database. Creating some sample songs...\n";
            
            // Create some sample songs if none exist
            $sampleSongs = [
                ['title' => 'Love Me Tonight', 'artist_name' => 'Sample Artist 1', 'genre' => 'Pop'],
                ['title' => 'Dance All Night', 'artist_name' => 'Sample Artist 2', 'genre' => 'Dance'],
                ['title' => 'Heart & Soul', 'artist_name' => 'Sample Artist 3', 'genre' => 'R&B'],
                ['title' => 'Electric Dreams', 'artist_name' => 'Sample Artist 4', 'genre' => 'Electronic'],
                ['title' => 'Midnight Vibes', 'artist_name' => 'Sample Artist 5', 'genre' => 'Hip Hop'],
            ];
            
            foreach ($sampleSongs as $songData) {
                Music::firstOrCreate([
                    'title' => $songData['title']
                ], [
                    'artist_name' => $songData['artist_name'],
                    'genre' => $songData['genre'],
                    'status' => 'published',
                    'created_by' => $userA->id,
                    'duration' => rand(180, 300), // 3-5 minutes
                ]);
            }
            
            $songs = Music::take(10)->get();
        }

        // Create playlists for User A
        $playlistA1 = Playlist::firstOrCreate([
            'title' => 'My Chill Vibes',
            'user_id' => $userA->id
        ], [
            'description' => 'Perfect songs for relaxing and unwinding after a long day',
            'visibility' => 'public',
        ]);

        $playlistA2 = Playlist::firstOrCreate([
            'title' => 'Workout Mix',
            'user_id' => $userA->id
        ], [
            'description' => 'High energy tracks to keep you motivated during workouts',
            'visibility' => 'public',
        ]);

        // Create playlists for User B
        $playlistB1 = Playlist::firstOrCreate([
            'title' => 'Late Night Study',
            'user_id' => $userB->id
        ], [
            'description' => 'Ambient and focus music for productive study sessions',
            'visibility' => 'public',
        ]);

        $playlistB2 = Playlist::firstOrCreate([
            'title' => 'Road Trip Anthems',
            'user_id' => $userB->id
        ], [
            'description' => 'Epic songs for long drives and adventures',
            'visibility' => 'private',
        ]);

        echo "✓ Created playlists for both users\n";

        // Add songs to playlists
        if ($songs->count() >= 3) {
            // Add songs to User A's playlists
            $playlistA1->music()->sync($songs->take(3)->pluck('id')->toArray());
            $playlistA2->music()->sync($songs->skip(3)->take(3)->pluck('id')->toArray());

            // Add songs to User B's playlists
            $playlistB1->music()->sync($songs->skip(6)->take(2)->pluck('id')->toArray());
            $playlistB2->music()->sync($songs->skip(2)->take(4)->pluck('id')->toArray());

            echo "✓ Added songs to playlists\n";
        }

        // Add liked songs for both users
        if ($songs->count() >= 5) {
            // User A likes some songs
            $userA->likedSongs()->sync($songs->take(4)->pluck('id')->toArray());
            
            // User B likes different songs
            $userB->likedSongs()->sync($songs->skip(4)->take(3)->pluck('id')->toArray());
            
            echo "✓ Added liked songs for both users\n";
        }

        echo "\n";
        echo "🎵 Playlist Test Data Summary:\n";
        echo "=============================\n";
        echo "User A (Alex Johnson): testuser.a@example.com / password123\n";
        echo "  - Created 2 playlists: 'My Chill Vibes', 'Workout Mix'\n";
        echo "  - Liked " . $userA->likedSongs()->count() . " songs\n";
        echo "\n";
        echo "User B (Sarah Williams): testuser.b@example.com / password123\n";
        echo "  - Created 2 playlists: 'Late Night Study', 'Road Trip Anthems'\n";
        echo "  - Liked " . $userB->likedSongs()->count() . " songs\n";
        echo "\n";
        echo "Test the playlist functionality by logging in as either user!\n";
        echo "=============================\n";
    }
}
