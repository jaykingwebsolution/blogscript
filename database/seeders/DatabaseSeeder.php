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
        $admin = User::firstOrCreate(
            ['email' => 'admin@blogscript.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'approved',
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]
        );

        // Create artist user
        $artist = User::firstOrCreate(
            ['email' => 'artist@test.com'],
            [
                'name' => 'Artist User',
                'password' => Hash::make('password'),
                'role' => 'artist',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
                'email_verified_at' => now(),
            ]
        );

        // Create record label user
        $label = User::firstOrCreate(
            ['email' => 'label@test.com'],
            [
                'name' => 'Record Label User',
                'password' => Hash::make('password'),
                'role' => 'record_label',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
                'email_verified_at' => now(),
            ]
        );

        // Create listener user
        $listener = User::firstOrCreate(
            ['email' => 'listener@test.com'],
            [
                'name' => 'Listener User',
                'password' => Hash::make('password'),
                'role' => 'listener',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
                'email_verified_at' => now(),
            ]
        );

        // Create sample pending user (will be rejected/deleted)
        User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'listener',
                'status' => 'pending',
            ]
        );

        // Create sample artists
        $artists = [
            [
                'name' => 'Afrobeats King',
                'username' => 'afrobeats_king',
                'slug' => 'afrobeats-king',
                'bio' => 'Rising star in the Afrobeats scene with multiple chart-topping hits across Africa.',
                'image_url' => '/images/default-artist.svg',
                'genre' => 'Afrobeats',
                'country' => 'Nigeria',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'name' => 'Highlife Legend',
                'username' => 'highlife_legend',
                'slug' => 'highlife-legend',
                'bio' => 'Veteran musician keeping the Highlife tradition alive with modern twists.',
                'image_url' => '/images/default-artist.svg',
                'genre' => 'Highlife',
                'country' => 'Ghana',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'name' => 'Gospel Sensation',
                'username' => 'gospel_sensation',
                'slug' => 'gospel-sensation',
                'bio' => 'Award-winning gospel artist inspiring millions with uplifting music.',
                'image_url' => '/images/default-artist.svg',
                'genre' => 'Gospel',
                'country' => 'South Africa',
                'is_trending' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'name' => 'Hip-Hop Star',
                'username' => 'hiphop_star',
                'slug' => 'hip-hop-star',
                'bio' => 'Young rapper making waves with conscious lyrics and infectious beats.',
                'image_url' => '/images/default-artist.svg',
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

        // Create categories
        $musicCategory = \App\Models\Category::firstOrCreate(
            ['slug' => 'afrobeats'],
            [
                'name' => 'Afrobeats',
                'description' => 'Modern Afrobeats music',
                'type' => 'music',
                'status' => 'active'
            ]
        );

        $videoCategory = \App\Models\Category::firstOrCreate(
            ['slug' => 'music-video'],
            [
                'name' => 'Music Video',
                'description' => 'Music videos and performances',
                'type' => 'video',
                'status' => 'active'
            ]
        );

        $newsCategory = \App\Models\Category::firstOrCreate(
            ['slug' => 'music-industry'],
            [
                'name' => 'Music Industry',
                'description' => 'Music industry news and updates',
                'type' => 'post',
                'status' => 'active'
            ]
        );

        // Create sample music
        $music = [
            [
                'title' => 'Amazing Afrobeats Hit',
                'slug' => 'amazing-afrobeats-hit',
                'description' => 'This incredible Afrobeats track has been trending across all music platforms in Africa. A perfect blend of traditional rhythms and modern production.',
                'artist_name' => 'Afrobeats King',
                'image_url' => '/images/default-music.svg',
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
                'image_url' => '/images/default-music.svg',
                'genre' => 'Highlife',
                'duration' => '4:12',
                'is_featured' => true,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Inspirational Gospel Anthem',
                'slug' => 'inspirational-gospel-anthem',
                'description' => 'An uplifting gospel song that has touched hearts and souls across the continent with its powerful message of hope.',
                'artist_name' => 'Gospel Sensation',
                'image_url' => '/images/default-music.svg',
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
                'slug' => 'afrobeats-music-video',
                'description' => 'Watch this amazing music video featuring stunning African landscapes and incredible dance choreography.',
                'thumbnail_url' => '/images/default.svg',
                'duration' => '3:45',
                'category_id' => $videoCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Behind The Scenes: Highlife Recording',
                'slug' => 'behind-the-scenes-highlife-recording',
                'description' => 'Go behind the scenes of the making of the latest Highlife hit and see the creative process.',
                'thumbnail_url' => '/images/default.svg',
                'duration' => '8:30',
                'category_id' => $videoCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Gospel Concert Highlights',
                'slug' => 'gospel-concert-highlights',
                'description' => 'Highlights from the most inspiring gospel concert of the year featuring multiple award-winning artists.',
                'thumbnail_url' => '/images/default.svg',
                'duration' => '15:20',
                'category_id' => $videoCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ],
            [
                'title' => 'Hip-Hop Freestyle Session',
                'slug' => 'hip-hop-freestyle-session',
                'description' => 'Raw freestyle session showcasing the incredible lyrical skills of up-and-coming hip-hop artists.',
                'thumbnail_url' => '/images/default.svg',
                'duration' => '6:15',
                'category_id' => $videoCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id
            ]
        ];

        foreach ($videos as $videoData) {
            Video::create($videoData);
        }

        // Create sample news
        $news = [
            [
                'title' => 'Afrobeats Takes Over Global Charts',
                'slug' => 'afrobeats-takes-over-global-charts',
                'content' => 'Afrobeats music continues to dominate international music charts, with several African artists breaking into Billboard Top 100. This unprecedented success marks a new era for African music on the global stage. Industry experts predict this is just the beginning of a major cultural shift in the music industry...',
                'excerpt' => 'African artists are making unprecedented waves on international music charts, marking a new era for the continent\'s music industry.',
                'image_url' => '/images/default-news.svg',
                'category_id' => $newsCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'created_by' => $admin->id
            ],
            [
                'title' => 'New Music Festival Announced for Lagos',
                'slug' => 'new-music-festival-announced-for-lagos',
                'content' => 'Lagos is set to host its biggest music festival yet, featuring top artists from across Africa and beyond. The three-day event promises to showcase the diversity and richness of African music culture. Tickets are expected to sell out quickly as international music fans plan their trips to Nigeria...',
                'excerpt' => 'Lagos prepares for its biggest music festival featuring top African artists and international acts.',
                'image_url' => '/images/default-news.svg',
                'category_id' => $newsCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'created_by' => $admin->id
            ],
            [
                'title' => 'Gospel Music Awards Honor Outstanding Artists',
                'slug' => 'gospel-music-awards-honor-outstanding-artists',
                'content' => 'The annual Gospel Music Awards ceremony celebrated the year\'s most inspiring and talented gospel artists. Winners included breakthrough artists and veteran musicians who continue to spread positive messages through their music. The event raised funds for various charitable causes across the continent...',
                'excerpt' => 'Annual Gospel Music Awards celebrates inspiring artists while supporting charitable causes across Africa.',
                'image_url' => '/images/default-news.svg',
                'category_id' => $newsCategory->id,
                'is_featured' => false,
                'status' => 'published',
                'published_at' => now()->subHours(6),
                'created_by' => $admin->id
            ]
        ];

        foreach ($news as $newsData) {
            News::create($newsData);
        }

        // Run the admin dashboard seeder for enhanced admin features
        $this->call(AdminDashboardSeeder::class);
        
        // Seed default site settings
        $this->call(SiteSettingsSeeder::class);
    }
}