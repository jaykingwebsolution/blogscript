<?php

namespace App\Services\Distribution;

use App\Models\DistributionPayout;
use App\Models\DistributionEarning;
use App\Models\DistributionApiSetting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayoutService
{
    protected array $providers = [
        'paystack' => 'Paystack',
        'flutterwave' => 'Flutterwave'
    ];

    /**
     * Process automatic payouts for eligible users
     */
    public function processAutomaticPayouts(): int
    {
        $processedCount = 0;
        $minimumThreshold = config('services.distribution.auto_payout_threshold', 100.00);

        // Find users eligible for automatic payouts
        $eligibleUsers = $this->findEligibleUsers($minimumThreshold);

        foreach ($eligibleUsers as $user) {
            try {
                $availableBalance = $this->calculateAvailableBalance($user);
                
                if ($availableBalance >= $minimumThreshold) {
                    $result = $this->initiateAutomaticPayout($user, $availableBalance);
                    
                    if ($result['success']) {
                        $processedCount++;
                        Log::info('Automatic payout initiated', [
                            'user_id' => $user->id,
                            'amount' => $availableBalance,
                            'payout_id' => $result['payout_id']
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to process automatic payout', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $processedCount;
    }

    /**
     * Process a specific payout request
     */
    public function processPayout(DistributionPayout $payout): array
    {
        try {
            // Update status to processing
            $payout->update(['status' => 'processing']);

            // Get the preferred payout provider
            $provider = $this->getPreferredProvider($payout->method);
            
            if (!$provider) {
                throw new \Exception('No payout provider configured for method: ' . $payout->method);
            }

            $result = $this->sendPayoutToProvider($payout, $provider);

            if ($result['success']) {
                $payout->update([
                    'status' => 'completed',
                    'transaction_reference' => $result['transaction_reference'],
                    'processed_at' => now(),
                    'completed_at' => now(),
                    'notes' => 'Payout completed successfully'
                ]);

                Log::info('Payout completed successfully', [
                    'payout_id' => $payout->id,
                    'transaction_reference' => $result['transaction_reference']
                ]);
            } else {
                $payout->update([
                    'status' => 'failed',
                    'notes' => 'Payout failed: ' . $result['error']
                ]);

                Log::error('Payout failed', [
                    'payout_id' => $payout->id,
                    'error' => $result['error']
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            $payout->update([
                'status' => 'failed',
                'notes' => 'Payout failed: ' . $e->getMessage()
            ]);

            Log::error('Exception during payout processing', [
                'payout_id' => $payout->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Calculate available balance for user
     */
    public function calculateAvailableBalance(User $user): float
    {
        $totalEarnings = DistributionEarning::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        $totalPaid = DistributionPayout::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $pendingPayouts = DistributionPayout::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->sum('amount');

        return max(0, $totalEarnings - $totalPaid - $pendingPayouts);
    }

    /**
     * Find users eligible for automatic payouts
     */
    protected function findEligibleUsers(float $threshold): \Illuminate\Database\Eloquent\Collection
    {
        // This is a simplified query - in production you might want to optimize this
        return User::whereHas('distributionEarnings', function ($query) {
            $query->where('status', 'confirmed');
        })->get()->filter(function ($user) use ($threshold) {
            return $this->calculateAvailableBalance($user) >= $threshold;
        });
    }

    /**
     * Initiate automatic payout for user
     */
    protected function initiateAutomaticPayout(User $user, float $amount): array
    {
        // Get user's preferred payout method from profile or default
        $method = $user->preferred_payout_method ?? 'bank_transfer';
        $paymentDetails = $user->payment_details ?? [];

        if (empty($paymentDetails)) {
            throw new \Exception('No payment details configured for user');
        }

        // Create payout record
        $payout = DistributionPayout::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'method' => $method,
            'payment_details' => $paymentDetails,
            'status' => 'pending',
            'requested_at' => now(),
            'notes' => 'Automatic payout'
        ]);

        // Process the payout
        $result = $this->processPayout($payout);
        
        return array_merge($result, ['payout_id' => $payout->id]);
    }

    /**
     * Get preferred payout provider based on method
     */
    protected function getPreferredProvider(string $method): ?string
    {
        $providerMap = [
            'bank_transfer' => 'paystack', // or 'flutterwave'
            'mobile_money' => 'flutterwave',
            'paypal' => 'paystack'
        ];

        $preferredProvider = $providerMap[$method] ?? 'paystack';

        // Check if provider is active
        $isActive = DistributionApiSetting::isProviderActive($preferredProvider);
        
        return $isActive ? $preferredProvider : null;
    }

    /**
     * Send payout to provider
     */
    protected function sendPayoutToProvider(DistributionPayout $payout, string $provider): array
    {
        $settings = DistributionApiSetting::getActiveForProvider($provider);
        
        if (!$settings) {
            throw new \Exception("Provider {$provider} settings not found");
        }

        switch ($provider) {
            case 'paystack':
                return $this->processPaystackPayout($payout, $settings);
            case 'flutterwave':
                return $this->processFlutterwavePayout($payout, $settings);
            default:
                throw new \Exception("Unsupported provider: {$provider}");
        }
    }

    /**
     * Process payout via Paystack
     */
    protected function processPaystackPayout(DistributionPayout $payout, DistributionApiSetting $settings): array
    {
        $baseUrl = $settings->environment === 'live' 
            ? 'https://api.paystack.co' 
            : 'https://api.paystack.co'; // Paystack doesn't have separate sandbox for payouts

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $settings->secret_key,
                'Content-Type' => 'application/json'
            ])->post("{$baseUrl}/transfer", [
                'source' => 'balance',
                'amount' => $payout->amount * 100, // Convert to kobo
                'recipient' => $this->getPaystackRecipient($payout),
                'reason' => 'Royalty payout for distribution earnings'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'transaction_reference' => $data['data']['transfer_code'],
                    'provider_response' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $response->json()['message'] ?? 'Paystack payout failed'
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Paystack API error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process payout via Flutterwave
     */
    protected function processFlutterwavePayout(DistributionPayout $payout, DistributionApiSetting $settings): array
    {
        $baseUrl = $settings->environment === 'live' 
            ? 'https://api.flutterwave.com/v3' 
            : 'https://ravesandboxapi.flutterwave.com/v3';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $settings->secret_key,
                'Content-Type' => 'application/json'
            ])->post("{$baseUrl}/transfers", [
                'account_bank' => $payout->payment_details['bank_code'] ?? '',
                'account_number' => $payout->payment_details['account_number'] ?? '',
                'amount' => $payout->amount,
                'narration' => 'Distribution royalty payout',
                'currency' => 'USD',
                'beneficiary_name' => $payout->payment_details['account_name'] ?? ''
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'transaction_reference' => $data['data']['reference'],
                    'provider_response' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $response->json()['message'] ?? 'Flutterwave payout failed'
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Flutterwave API error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get or create Paystack recipient
     */
    protected function getPaystackRecipient(DistributionPayout $payout): string
    {
        // This would typically create a recipient if it doesn't exist
        // For now, return the recipient code from payment details
        return $payout->payment_details['recipient_code'] ?? '';
    }
}