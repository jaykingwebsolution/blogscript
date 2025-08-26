<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminNotification;

class TestNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'title' => 'Welcome to MusicStream!',
                'message' => 'Thank you for joining our platform. Explore trending music, create playlists, and start your musical journey with us.',
                'type' => 'feature',
                'is_global' => true,
                'is_active' => true,
            ],
            [
                'title' => 'New Distribution Partnership',
                'message' => 'We\'ve partnered with Boomplay and Audiomack for better music distribution. Submit your tracks now!',
                'type' => 'feature',
                'is_global' => false,
                'target_roles' => ['artist', 'record_label'],
                'action_url' => '/distribution/submit',
                'is_active' => true,
            ],
            [
                'title' => 'Trending Song Alert',
                'message' => 'Check out this week\'s trending Afrobeats tracks. Don\'t miss the hottest sounds!',
                'type' => 'trending_song',
                'is_global' => true,
                'action_url' => '/music?genre=afrobeats',
                'is_active' => true,
            ],
            [
                'title' => 'Platform Maintenance',
                'message' => 'Scheduled maintenance on Sunday 2AM - 4AM UTC. Some features may be temporarily unavailable.',
                'type' => 'general',
                'is_global' => true,
                'expires_at' => now()->addDays(7),
                'is_active' => true,
            ],
            [
                'title' => 'Artist Verification Available',
                'message' => 'Get your blue check mark! Artist verification is now available. Stand out and gain credibility.',
                'type' => 'trending_artist',
                'is_global' => false,
                'target_roles' => ['artist'],
                'action_url' => '/dashboard/verification',
                'is_active' => true,
            ],
        ];

        foreach ($notifications as $notificationData) {
            AdminNotification::create($notificationData);
        }

        echo "Test notifications created successfully!\n";
    }
}
