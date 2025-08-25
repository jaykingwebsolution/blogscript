<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingPlan;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Distribution Fee',
                'slug' => 'distribution-fee',
                'description' => 'One-time fee for music distribution to major streaming platforms including Spotify, Apple Music, Boomplay, Audiomack, and more.',
                'amount' => 15.00,
                'currency' => 'USD',
                'type' => 'one_time',
                'interval' => null,
                'features' => [
                    'Distribution to 50+ streaming platforms',
                    'Spotify, Apple Music, YouTube Music',
                    'Boomplay, Audiomack, Deezer',
                    'Keep 100% of your royalties',
                    'Detailed analytics and reporting',
                    'Professional music submission'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Premium Subscription',
                'slug' => 'premium-subscription',
                'description' => 'Monthly premium subscription with advanced features and unlimited distribution.',
                'amount' => 9.99,
                'currency' => 'USD',
                'type' => 'recurring',
                'interval' => 'monthly',
                'features' => [
                    'Unlimited music distribution',
                    'Priority support',
                    'Advanced analytics',
                    'Social media promotion tools',
                    'Playlist pitching',
                    'Revenue optimization'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Pro Annual',
                'slug' => 'pro-annual',
                'description' => 'Annual subscription with all premium features plus exclusive benefits.',
                'amount' => 99.00,
                'currency' => 'USD',
                'type' => 'recurring',
                'interval' => 'yearly',
                'features' => [
                    'Everything in Premium',
                    'Unlimited distribution',
                    '1-on-1 consultation calls',
                    'Custom branding options',
                    'Priority playlist consideration',
                    'Advanced marketing tools'
                ],
                'is_active' => true,
            ]
        ];

        foreach ($plans as $plan) {
            PricingPlan::updateOrCreate(
                ['slug' => $plan['slug']], 
                $plan
            );
        }

        echo "Pricing plans seeded successfully!\n";
    }
}
