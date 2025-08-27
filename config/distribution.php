<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Distribution Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the music distribution service
    |
    */

    'auto_payout_threshold' => env('DISTRIBUTION_AUTO_PAYOUT_THRESHOLD', 100.00),
    
    'minimum_payout_amount' => env('DISTRIBUTION_MIN_PAYOUT', 50.00),
    
    'webhook_secret' => env('DISTRIBUTION_WEBHOOK_SECRET', ''),
    
    'file_validation' => [
        'audio' => [
            'max_size_mb' => env('DISTRIBUTION_AUDIO_MAX_SIZE', 500),
            'min_duration' => env('DISTRIBUTION_AUDIO_MIN_DURATION', 10),
            'max_duration' => env('DISTRIBUTION_AUDIO_MAX_DURATION', 7200),
        ],
        'artwork' => [
            'max_size_mb' => env('DISTRIBUTION_ARTWORK_MAX_SIZE', 10),
            'min_dimensions' => env('DISTRIBUTION_ARTWORK_MIN_SIZE', 1400),
        ]
    ],
    
    'aggregators' => [
        'sonosuite' => [
            'name' => 'SonoSuite',
            'live_url' => 'https://api.sonosuite.com/v1',
            'test_url' => 'https://api-test.sonosuite.com/v1',
            'supported_formats' => ['mp3', 'wav', 'flac'],
            'supported_territories' => 'worldwide',
        ],
        'fuga' => [
            'name' => 'FUGA',
            'live_url' => 'https://api.fuga.com/v2',
            'test_url' => 'https://api-sandbox.fuga.com/v2',
            'supported_formats' => ['mp3', 'wav', 'flac', 'm4a'],
            'supported_territories' => 'worldwide',
        ],
        'audiosalad' => [
            'name' => 'AudioSalad',
            'live_url' => 'https://api.audiosalad.com/v1',
            'test_url' => 'https://sandbox-api.audiosalad.com/v1',
            'supported_formats' => ['mp3', 'wav', 'flac', 'm4a', 'aac'],
            'supported_territories' => 'worldwide',
        ],
        'vydia' => [
            'name' => 'Vydia',
            'live_url' => 'https://api.vydia.com/v1',
            'test_url' => 'https://sandbox-api.vydia.com/v1',
            'supported_formats' => ['mp3', 'wav', 'flac', 'm4a'],
            'supported_territories' => 'worldwide',
        ],
    ],

    'dsps' => [
        'spotify' => 'Spotify',
        'apple_music' => 'Apple Music',
        'youtube_music' => 'YouTube Music',
        'amazon_music' => 'Amazon Music',
        'boomplay' => 'Boomplay',
        'audiomack' => 'Audiomack',
        'deezer' => 'Deezer',
        'tidal' => 'Tidal',
        'pandora' => 'Pandora',
        'soundcloud' => 'SoundCloud',
    ],

    'genres' => [
        'Afrobeats',
        'Hip Hop',
        'R&B',
        'Pop',
        'Rock',
        'Gospel',
        'Reggae',
        'Highlife',
        'Fuji',
        'Juju',
        'Afro-house',
        'Alternative',
        'Electronic',
        'Jazz',
        'Blues',
        'Country',
        'Folk',
        'Other'
    ],

    'territories' => [
        'NG' => 'Nigeria',
        'GH' => 'Ghana',
        'KE' => 'Kenya',
        'ZA' => 'South Africa',
        'EG' => 'Egypt',
        'MA' => 'Morocco',
        'TZ' => 'Tanzania',
        'UG' => 'Uganda',
        'ET' => 'Ethiopia',
        'US' => 'United States',
        'GB' => 'United Kingdom',
        'CA' => 'Canada',
        'AU' => 'Australia',
        'FR' => 'France',
        'DE' => 'Germany',
        'JP' => 'Japan',
        'BR' => 'Brazil',
        'IN' => 'India',
        'CN' => 'China',
    ],

    'payout_methods' => [
        'bank_transfer' => 'Bank Transfer',
        'mobile_money' => 'Mobile Money',
        'paypal' => 'PayPal',
    ],

    'status_mappings' => [
        'pending' => [
            'color' => 'bg-yellow-100 text-yellow-800',
            'icon' => '⏳',
            'description' => 'Awaiting admin approval'
        ],
        'processing' => [
            'color' => 'bg-blue-100 text-blue-800',
            'icon' => '🔄',
            'description' => 'Being distributed to platforms'
        ],
        'delivered' => [
            'color' => 'bg-green-100 text-green-800',
            'icon' => '✅',
            'description' => 'Live on all platforms'
        ],
        'failed' => [
            'color' => 'bg-red-100 text-red-800',
            'icon' => '❌',
            'description' => 'Distribution failed'
        ],
    ],

    'notification_templates' => [
        'release_submitted' => [
            'subject' => 'Release submitted for review',
            'message' => 'Your release "{song_title}" has been submitted for review.',
        ],
        'release_approved' => [
            'subject' => 'Release approved for distribution',
            'message' => 'Your release "{song_title}" has been approved and is being distributed.',
        ],
        'release_live' => [
            'subject' => '🎉 Your music is now live!',
            'message' => 'Your release "{song_title}" is now available on all major streaming platforms.',
        ],
        'royalties_available' => [
            'subject' => '💰 New royalties available',
            'message' => 'You have new royalty earnings of ${amount} available.',
        ],
        'payout_processed' => [
            'subject' => 'Payout processed',
            'message' => 'Your payout of ${amount} has been processed successfully.',
        ],
    ],

];