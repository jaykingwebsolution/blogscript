<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Plan;
use App\Models\Music;
use App\Models\Artist;
use App\Models\Media;
use App\Models\AdminNotification;
use App\Models\VerificationRequest;
use App\Models\TrendingRequest;
use App\Models\Subscription;

class AdminDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@blogscript.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'approved',
                'approved_at' => now(),
                'bio' => 'System Administrator'
            ]
        );

        // Create Demo Users with different roles and statuses
        $users = [
            [
                'name' => 'John Artist',
                'email' => 'artist@test.com',
                'password' => Hash::make('password'),
                'role' => 'artist',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => $admin->id,
                'artist_stage_name' => 'DJ Johnny',
                'artist_genre' => 'Hip Hop',
                'bio' => 'Professional music artist specializing in hip hop and R&B.'
            ],
            [
                'name' => 'Sarah Producer',
                'email' => 'producer@test.com',
                'password' => Hash::make('password'),
                'role' => 'record_label',
                'status' => 'pending',
                'artist_stage_name' => 'Sound Wave Records',
                'bio' => 'Independent record label focusing on emerging artists.'
            ],
            [
                'name' => 'Mike Listener',
                'email' => 'listener@test.com',
                'password' => Hash::make('password'),
                'role' => 'listener',
                'status' => 'approved',
                'approved_at' => now()->subDays(5),
                'approved_by' => $admin->id,
                'bio' => 'Music enthusiast and playlist curator.'
            ],
            [
                'name' => 'Emma Editor',
                'email' => 'editor@test.com',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'status' => 'approved',
                'approved_at' => now()->subDays(2),
                'approved_by' => $admin->id,
                'bio' => 'Content editor and music journalist.'
            ],
            [
                'name' => 'Alex Pending',
                'email' => 'pending@test.com',
                'password' => Hash::make('password'),
                'role' => 'artist',
                'status' => 'pending',
                'artist_stage_name' => 'AlexBeats',
                'artist_genre' => 'Electronic',
                'bio' => 'Electronic music producer seeking platform approval.'
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        // Create Plans
        $plans = [
            [
                'name' => 'Free',
                'description' => 'Basic plan for listeners',
                'price' => 0.00,
                'currency' => 'NGN',
                'duration_days' => 0,
                'features' => ['Stream music', 'Create playlists', 'Basic recommendations'],
                'type' => 'free',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Artist Basic',
                'description' => 'For emerging artists',
                'price' => 2500.00,
                'currency' => 'NGN',
                'duration_days' => 30,
                'features' => ['Upload up to 10 tracks', 'Basic analytics', 'Artist profile'],
                'type' => 'artist',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Artist Pro',
                'description' => 'For professional artists',
                'price' => 5000.00,
                'currency' => 'NGN',
                'duration_days' => 30,
                'features' => ['Unlimited uploads', 'Advanced analytics', 'Trending features', 'Priority support'],
                'type' => 'artist',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Record Label',
                'description' => 'For record labels and distributors',
                'price' => 15000.00,
                'currency' => 'NGN',
                'duration_days' => 30,
                'features' => ['Manage multiple artists', 'Bulk uploads', 'Advanced reporting', 'White-label options'],
                'type' => 'record_label',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($plans as $planData) {
            Plan::firstOrCreate(['name' => $planData['name']], $planData);
        }

        // Create Artists
        $artists = [
            [
                'name' => 'Burna Boy',
                'bio' => 'Grammy-winning Nigerian artist known for Afrobeat music.',
                'genre' => 'Afrobeat',
                'country' => 'Nigeria',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=Burna+Boy'
            ],
            [
                'name' => 'Wizkid',
                'bio' => 'International Afrobeats superstar and Grammy winner.',
                'genre' => 'Afrobeats',
                'country' => 'Nigeria',
                'is_trending' => true,
                'status' => 'published',
                'created_by' => $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=Wizkid'
            ],
            [
                'name' => 'Tiwa Savage',
                'bio' => 'Queen of Afrobeats and international recording artist.',
                'genre' => 'Afrobeats',
                'country' => 'Nigeria',
                'is_trending' => false,
                'status' => 'published',
                'created_by' => $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=Tiwa+Savage'
            ]
        ];

        foreach ($artists as $artistData) {
            Artist::firstOrCreate(['name' => $artistData['name']], $artistData);
        }

        // Create Music
        $musicTracks = [
            [
                'title' => 'Last Last',
                'artist_name' => 'Burna Boy',
                'description' => 'Hit single from the Grammy winner.',
                'genre' => 'Afrobeat',
                'is_featured' => true,
                'status' => 'published',
                'created_by' => $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=Last+Last',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
                'duration' => '3:42'
            ],
            [
                'title' => 'Essence',
                'artist_name' => 'Wizkid ft. Tems',
                'description' => 'Global hit featuring Tems.',
                'genre' => 'Afrobeats',
                'is_featured' => true,
                'status' => 'published',
                'created_by' => $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=Essence',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
                'duration' => '4:15'
            ],
            [
                'title' => 'Somebody Son',
                'artist_name' => 'Tiwa Savage',
                'description' => 'Popular track from the Afrobeats queen.',
                'genre' => 'Afrobeats',
                'is_featured' => false,
                'status' => 'published',
                'created_by' => $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=Somebody+Son',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3',
                'duration' => '3:28'
            ],
            [
                'title' => 'New Beat',
                'artist_name' => 'DJ Johnny',
                'description' => 'Fresh hip hop track awaiting approval.',
                'genre' => 'Hip Hop',
                'is_featured' => false,
                'status' => 'draft',
                'created_by' => User::where('email', 'artist@test.com')->first()->id ?? $admin->id,
                'image_url' => 'https://via.placeholder.com/400x400?text=New+Beat',
                'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3',
                'duration' => '4:02'
            ]
        ];

        foreach ($musicTracks as $musicData) {
            Music::firstOrCreate(['title' => $musicData['title']], $musicData);
        }

        // Create Media uploads for approval
        $mediaItems = [
            [
                'user_id' => User::where('email', 'artist@test.com')->first()->id ?? $admin->id,
                'title' => 'Studio Recording Session',
                'description' => 'Behind the scenes of my latest recording.',
                'type' => 'image',
                'external_url' => 'https://via.placeholder.com/800x600?text=Studio+Session',
                'mime_type' => 'image/jpeg',
                'file_size' => 245678,
                'metadata' => ['dimensions' => '800x600'],
                'tags' => ['studio', 'recording', 'music'],
                'status' => 'pending'
            ],
            [
                'user_id' => User::where('email', 'producer@test.com')->first()->id ?? $admin->id,
                'title' => 'Beat Preview',
                'description' => 'New instrumental beat for approval.',
                'type' => 'audio',
                'external_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3',
                'mime_type' => 'audio/mpeg',
                'file_size' => 3456789,
                'metadata' => ['duration' => 180, 'bitrate' => 320],
                'tags' => ['beat', 'instrumental', 'hip-hop'],
                'status' => 'pending'
            ],
            [
                'user_id' => User::where('email', 'pending@test.com')->first()->id ?? $admin->id,
                'title' => 'Music Video Teaser',
                'description' => 'Teaser for upcoming music video.',
                'type' => 'video',
                'external_url' => 'https://via.placeholder.com/1280x720?text=Video+Teaser',
                'mime_type' => 'video/mp4',
                'file_size' => 12345678,
                'metadata' => ['duration' => 30, 'resolution' => '1280x720'],
                'tags' => ['video', 'teaser', 'electronic'],
                'status' => 'approved'
            ]
        ];

        foreach ($mediaItems as $mediaData) {
            Media::firstOrCreate([
                'title' => $mediaData['title'],
                'user_id' => $mediaData['user_id']
            ], $mediaData);
        }

        // Create Verification Requests
        $verificationRequests = [
            [
                'user_id' => User::where('email', 'artist@test.com')->first()->id ?? $admin->id,
                'status' => 'pending',
                'message' => 'I am a verified artist with released music on major platforms. Please verify my account.'
            ],
            [
                'user_id' => User::where('email', 'producer@test.com')->first()->id ?? $admin->id,
                'status' => 'pending',
                'message' => 'Record label with 10+ artists signed. Need verification for enhanced features.'
            ]
        ];

        foreach ($verificationRequests as $verificationData) {
            VerificationRequest::firstOrCreate([
                'user_id' => $verificationData['user_id'],
                'status' => 'pending'
            ], $verificationData);
        }

        // Create Trending Requests
        $trendingRequests = [
            [
                'user_id' => User::where('email', 'artist@test.com')->first()->id ?? $admin->id,
                'type' => 'week',
                'status' => 'pending',
                'message' => 'My latest track has gained significant traction. Request for trending feature.'
            ]
        ];

        foreach ($trendingRequests as $trendingData) {
            TrendingRequest::firstOrCreate([
                'user_id' => $trendingData['user_id'],
                'type' => $trendingData['type']
            ], $trendingData);
        }

        // Create Subscriptions
        $subscriptions = [
            [
                'user_id' => User::where('email', 'artist@test.com')->first()->id ?? $admin->id,
                'plan_id' => Plan::where('name', 'Artist Basic')->first()->id ?? 1,
                'status' => 'active',
                'amount' => 2500.00,
                'currency' => 'NGN',
                'starts_at' => now()->subDays(10),
                'expires_at' => now()->addDays(20),
                'payment_method' => 'paystack'
            ]
        ];

        foreach ($subscriptions as $subscriptionData) {
            Subscription::firstOrCreate([
                'user_id' => $subscriptionData['user_id'],
                'plan_id' => $subscriptionData['plan_id']
            ], $subscriptionData);
        }

        // Create Admin Notifications
        $notifications = [
            [
                'title' => 'Welcome to the Music Platform',
                'message' => 'Thank you for joining our platform. Start exploring and sharing your music with the world!',
                'type' => 'general',
                'is_global' => true,
                'is_active' => true,
                'icon' => 'fas fa-music'
            ],
            [
                'title' => 'New Featured Songs Available',
                'message' => 'Check out the latest featured songs from top artists on our platform.',
                'type' => 'feature',
                'is_global' => true,
                'target_roles' => ['listener'],
                'is_active' => true,
                'icon' => 'fas fa-star'
            ],
            [
                'title' => 'Artist Verification Program',
                'message' => 'Apply for artist verification to get enhanced features and credibility on your profile.',
                'type' => 'general',
                'is_global' => false,
                'target_roles' => ['artist'],
                'is_active' => true,
                'icon' => 'fas fa-check-circle'
            ]
        ];

        foreach ($notifications as $notificationData) {
            AdminNotification::firstOrCreate([
                'title' => $notificationData['title']
            ], $notificationData);
        }

        $this->command->info('Admin Dashboard seeder completed successfully!');
        $this->command->info('Admin Login: admin@blogscript.com / admin123');
        $this->command->info('Artist Login: artist@test.com / password');
        $this->command->info('Producer Login: producer@test.com / password');
        $this->command->info('Listener Login: listener@test.com / password');
        $this->command->info('Editor Login: editor@test.com / password');
    }
}