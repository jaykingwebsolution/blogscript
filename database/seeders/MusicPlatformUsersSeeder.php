<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class MusicPlatformUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'approved',
                'approved_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'bio' => 'Platform Administrator',
                'verification_status' => 'verified',
                'active_since' => Carbon::now()->subYears(2),
            ]
        );

        // Create artist user
        User::updateOrCreate(
            ['email' => 'artist@example.com'],
            [
                'name' => 'John Musician',
                'email' => 'artist@example.com',
                'password' => Hash::make('artist123'),
                'role' => 'artist',
                'status' => 'approved',
                'approved_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'bio' => 'Professional musician and songwriter specializing in Afrobeats and Contemporary Pop music.',
                'artist_stage_name' => 'J-Music',
                'artist_genre' => 'Afrobeats, Pop',
                'verification_status' => 'verified',
                'social_links' => [
                    'instagram' => 'https://instagram.com/jmusic_official',
                    'twitter' => 'https://twitter.com/jmusic',
                    'spotify' => 'https://open.spotify.com/artist/jmusic',
                ],
                'active_since' => Carbon::now()->subYear(),
            ]
        );

        // Create record label user
        User::updateOrCreate(
            ['email' => 'label@example.com'],
            [
                'name' => 'Sound Records',
                'email' => 'label@example.com',
                'password' => Hash::make('label123'),
                'role' => 'record_label',
                'status' => 'approved',
                'approved_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'bio' => 'Premier record label specializing in discovering and promoting emerging African talent.',
                'verification_status' => 'verified',
                'social_links' => [
                    'website' => 'https://soundrecords.com',
                    'instagram' => 'https://instagram.com/soundrecords',
                    'twitter' => 'https://twitter.com/soundrecords',
                ],
                'active_since' => Carbon::now()->subYears(3),
            ]
        );

        // Create listener user
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Music Lover',
                'email' => 'user@example.com',
                'password' => Hash::make('user123'),
                'role' => 'listener',
                'status' => 'approved',
                'approved_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'bio' => 'Passionate music enthusiast who loves discovering new artists and creating playlists.',
                'verification_status' => 'unverified',
                'active_since' => Carbon::now()->subMonths(6),
            ]
        );

        // Create additional sample users
        $additionalUsers = [
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah.artist@example.com',
                'role' => 'artist',
                'artist_stage_name' => 'Sarah W',
                'artist_genre' => 'R&B, Soul',
                'bio' => 'Soulful R&B artist with a passion for storytelling through music.',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.listener@example.com',
                'role' => 'listener',
                'bio' => 'Hip-hop enthusiast and playlist curator.',
            ],
            [
                'name' => 'Beat Factory Records',
                'email' => 'contact@beatfactory.com',
                'role' => 'record_label',
                'bio' => 'Independent record label focusing on hip-hop and electronic music.',
            ],
        ];

        foreach ($additionalUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'password' => Hash::make('password123'),
                    'status' => 'approved',
                    'approved_at' => Carbon::now(),
                    'email_verified_at' => Carbon::now(),
                    'verification_status' => 'unverified',
                    'active_since' => Carbon::now()->subMonths(rand(1, 12)),
                ])
            );
        }
    }
}
