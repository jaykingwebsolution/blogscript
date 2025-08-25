<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Music;
use App\Models\Artist;
use App\Models\Video;
use App\Models\News;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@blogscript.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'approved',
            'approved_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Create sample editor user
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@blogscript.com',
            'password' => Hash::make('editor123'),
            'role' => 'editor',
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $admin->id,
            'email_verified_at' => now(),
        ]);

        // Create sample pending user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'pending',
        ]);

        // Create sample artists
        $artists = [
            [
                'name' => 'Afrobeats King',
                'bio' => 'Rising star in the Afrobeats scene with multiple chart-topping hits across Africa.',
                'image_url' => 'https://via.placeholder.com/400x300/1E40AF/FFFFFF?text=Artist+1',
                'genre' => 'Afrobeats',
                'country' => 'Nigeria',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'name' => 'Highlife Legend',
                'bio' => 'Veteran musician keeping the Highlife tradition alive with modern twists.',
                'image_url' => 'https://via.placeholder.com/400x300/1E40AF/FFFFFF?text=Artist+2',
                'genre' => 'Highlife',
                'country' => 'Ghana',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'name' => 'Gospel Sensation',
                'bio' => 'Award-winning gospel artist inspiring millions with uplifting music.',
                'image_url' => 'https://via.placeholder.com/400x300/1E40AF/FFFFFF?text=Artist+3',
                'genre' => 'Gospel',
                'country' => 'South Africa',
                'is_trending' => false,
                'status' => 'published',
                'created_by' => $editor->id
            ],
            [
                'name' => 'Hip-Hop Star',
                'bio' => 'Young rapper making waves with conscious lyrics and infectious beats.',
                'image_url' => 'https://via.placeholder.com/400x300/1E40AF/FFFFFF?text=Artist+4',
                'genre' => 'Hip-Hop',
                'country' => 'Kenya',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ]
        ];

        foreach ($artists as $artistData) {
            Artist::create($artistData);
        }

        // Create sample music
        $music = [
            [
                'title' => 'Amazing Afrobeats Hit',
                'slug' => 'amazing-afrobeats-hit',
                'description' => 'This incredible Afrobeats track has been trending across all music platforms in Africa. A perfect blend of traditional rhythms and modern production.',
                'artist_name' => 'Afrobeats King',
                'image_url' => 'https://via.placeholder.com/400x300/3B82F6/FFFFFF?text=Music+1',
                'genre' => 'Afrobeats',
                'duration' => '3:45',
                'is_featured' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Highlife Revival',
                'slug' => 'highlife-revival',
                'description' => 'A beautiful revival of classic Highlife music with contemporary elements that speak to both old and new generations.',
                'artist_name' => 'Highlife Legend',
                'image_url' => 'https://via.placeholder.com/400x300/3B82F6/FFFFFF?text=Music+2',
                'genre' => 'Highlife',
                'duration' => '4:12',
                'is_featured' => true,
                'status' => 'published',
                'created_by' => $editor->id
            ],
            [
                'title' => 'Inspirational Gospel Anthem',
                'slug' => 'inspirational-gospel-anthem',
                'description' => 'An uplifting gospel song that has touched hearts and souls across the continent with its powerful message of hope.',
                'artist_name' => 'Gospel Sensation',
                'image_url' => 'https://via.placeholder.com/400x300/3B82F6/FFFFFF?text=Music+3',
                'genre' => 'Gospel',
                'duration' => '5:23',
                'is_featured' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ]
        ];

        foreach ($music as $musicData) {
            Music::create($musicData);
        }

        // Create sample videos
        $videos = [
            [
                'title' => 'Afrobeats Music Video',
                'description' => 'Watch this amazing music video featuring stunning African landscapes and incredible dance choreography.',
                'thumbnail_url' => 'https://via.placeholder.com/400x300/EF4444/FFFFFF?text=Video+1',
                'duration' => '3:45',
                'category' => 'Music Video',
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Behind The Scenes: Highlife Recording',
                'description' => 'Go behind the scenes of the making of the latest Highlife hit and see the creative process.',
                'thumbnail_url' => 'https://via.placeholder.com/400x300/EF4444/FFFFFF?text=Video+2',
                'duration' => '8:30',
                'category' => 'Documentary',
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $editor->id
            ],
            [
                'title' => 'Gospel Concert Highlights',
                'description' => 'Highlights from the most inspiring gospel concert of the year featuring multiple award-winning artists.',
                'thumbnail_url' => 'https://via.placeholder.com/400x300/EF4444/FFFFFF?text=Video+3',
                'duration' => '15:20',
                'category' => 'Concert',
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Hip-Hop Freestyle Session',
                'description' => 'Raw freestyle session showcasing the incredible lyrical skills of up-and-coming hip-hop artists.',
                'thumbnail_url' => 'https://via.placeholder.com/400x300/EF4444/FFFFFF?text=Video+4',
                'duration' => '6:15',
                'category' => 'Freestyle',
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $editor->id
            ]
        ];

        foreach ($videos as $videoData) {
            Video::create($videoData);
        }

        // Create sample news
        $news = [
            [
                'title' => 'Afrobeats Takes Over Global Charts',
                'content' => 'Afrobeats music continues to dominate international music charts, with several African artists breaking into Billboard Top 100. This unprecedented success marks a new era for African music on the global stage. Industry experts predict this is just the beginning of a major cultural shift in the music industry...',
                'excerpt' => 'African artists are making unprecedented waves on international music charts, marking a new era for the continent\'s music industry.',
                'image_url' => 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=News+1',
                'category' => 'Music Industry',
                'tags' => ['afrobeats', 'global music', 'charts'],
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'created_by' => $admin->id
            ],
            [
                'title' => 'New Music Festival Announced for Lagos',
                'content' => 'Lagos is set to host its biggest music festival yet, featuring top artists from across Africa and beyond. The three-day event promises to showcase the diversity and richness of African music culture. Tickets are expected to sell out quickly as international music fans plan their trips to Nigeria...',
                'excerpt' => 'Lagos prepares for its biggest music festival featuring top African artists and international acts.',
                'image_url' => 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=News+2',
                'category' => 'Events',
                'tags' => ['festival', 'lagos', 'music events'],
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'created_by' => $editor->id
            ],
            [
                'title' => 'Gospel Music Awards Honor Outstanding Artists',
                'content' => 'The annual Gospel Music Awards ceremony celebrated the year\'s most inspiring and talented gospel artists. Winners included breakthrough artists and veteran musicians who continue to spread positive messages through their music. The event raised funds for various charitable causes across the continent...',
                'excerpt' => 'Annual Gospel Music Awards celebrates inspiring artists while supporting charitable causes across Africa.',
                'image_url' => 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=News+3',
                'category' => 'Awards',
                'tags' => ['gospel', 'awards', 'charity'],
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subHours(6),
                'created_by' => $admin->id
            ]
        ];

        foreach ($news as $newsData) {
            News::create($newsData);
        }
    }
}