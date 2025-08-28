<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Subscription;

class TestDashboardFeatures extends Command
{
    protected $signature = 'test:dashboard-features';
    protected $description = 'Test all dashboard features';

    public function handle()
    {
        $this->info('Testing Dashboard Features...');

        // Test user creation
        $this->info('1. Testing user roles and subscriptions...');
        
        $listener = User::where('email', 'listener@test.com')->first();
        $artist = User::where('email', 'artist@test.com')->first();
        $label = User::where('email', 'label@test.com')->first();

        if (!$listener || !$artist || !$label) {
            $this->error('Test users not found. Creating them...');
            return;
        }

        // Test subscription methods
        $this->info("Listener has subscription: " . ($listener->hasActiveSubscription() ? 'Yes' : 'No'));
        $this->info("Artist has subscription: " . ($artist->hasActiveSubscription() ? 'Yes' : 'No'));
        $this->info("Label has subscription: " . ($label->hasActiveSubscription() ? 'Yes' : 'No'));

        // Test follow system
        $this->info('2. Testing follow system...');
        $this->info("Listener followers count: " . $listener->followers_count);
        $this->info("Artist followers count: " . $artist->followers_count);

        // Create a test subscription for artist
        $subscription = Subscription::create([
            'user_id' => $artist->id,
            'plan_name' => 'artist',
            'amount' => 5000,
            'status' => 'active',
            'expires_at' => now()->addDays(30),
            'started_at' => now(),
        ]);

        $this->info("Created test subscription for artist: " . $subscription->id);
        $this->info("Artist now has subscription: " . ($artist->fresh()->hasActiveSubscription() ? 'Yes' : 'No'));

        $this->info('3. Testing dashboard routes...');
        $dashboardRoutes = [
            'dashboard.listener',
            'dashboard.artist', 
            'dashboard.record-label',
            'upgrade',
            'users.follow.toggle',
            'users.follow.status',
        ];

        foreach ($dashboardRoutes as $route) {
            try {
                $url = route($route, $route === 'users.follow.toggle' || $route === 'users.follow.status' ? ['user' => $listener->id] : []);
                $this->info("✓ Route {$route}: {$url}");
            } catch (\Exception $e) {
                $this->error("✗ Route {$route}: " . $e->getMessage());
            }
        }

        $this->info('Dashboard features test completed!');
        return 0;
    }
}