<?php

namespace App\Services\Distribution;

use App\Models\DistributionRequest;
use App\Models\AggregatorSetting;
use Illuminate\Support\Facades\Log;

class AggregatorService
{
    protected array $aggregators = [];
    protected array $adapterClasses = [
        'sonosuite' => \App\Services\Distribution\Adapters\SonoSuiteAdapter::class,
        'fuga' => \App\Services\Distribution\Adapters\FugaAdapter::class,
        'audiosalad' => \App\Services\Distribution\Adapters\AudioSaladAdapter::class,
        'vydia' => \App\Services\Distribution\Adapters\VydiaAdapter::class,
    ];

    public function __construct()
    {
        $this->loadActiveAggregators();
    }

    /**
     * Load all active aggregator configurations
     */
    protected function loadActiveAggregators(): void
    {
        $settings = AggregatorSetting::where('is_active', true)
            ->whereIn('provider', array_keys($this->adapterClasses))
            ->get();

        foreach ($settings as $setting) {
            $adapterClass = $this->adapterClasses[$setting->provider] ?? null;
            
            if ($adapterClass && class_exists($adapterClass)) {
                $this->aggregators[$setting->provider] = new $adapterClass($setting);
            }
        }

        Log::info('Loaded aggregator services', [
            'count' => count($this->aggregators),
            'providers' => array_keys($this->aggregators)
        ]);
    }

    /**
     * Get specific aggregator service
     */
    public function getAggregator(string $provider): ?AggregatorServiceInterface
    {
        return $this->aggregators[$provider] ?? null;
    }

    /**
     * Get all available aggregators
     */
    public function getAvailableAggregators(): array
    {
        return $this->aggregators;
    }

    /**
     * Send release to primary aggregator or specific one
     */
    public function sendRelease(DistributionRequest $request, ?string $preferredProvider = null): array
    {
        $provider = $preferredProvider ?? $this->getPrimaryAggregator();
        
        if (!$provider) {
            return [
                'success' => false,
                'error' => 'No active aggregator available',
                'aggregator_release_id' => null
            ];
        }

        $aggregator = $this->getAggregator($provider);
        if (!$aggregator) {
            return [
                'success' => false,
                'error' => "Aggregator {$provider} not available",
                'aggregator_release_id' => null
            ];
        }

        Log::info("Sending release to {$provider}", [
            'distribution_request_id' => $request->id,
            'artist_name' => $request->artist_name,
            'song_title' => $request->song_title
        ]);

        $result = $aggregator->sendRelease($request);
        
        if ($result['success']) {
            // Store aggregator release ID in distribution request
            $request->update([
                'aggregator_provider' => $provider,
                'aggregator_release_id' => $result['aggregator_release_id'],
                'dsp_delivery_status' => 'processing'
            ]);

            Log::info("Release successfully sent to {$provider}", [
                'distribution_request_id' => $request->id,
                'aggregator_release_id' => $result['aggregator_release_id']
            ]);
        }

        return $result;
    }

    /**
     * Update release status from aggregator
     */
    public function updateReleaseStatus(DistributionRequest $request): array
    {
        if (!$request->aggregator_provider || !$request->aggregator_release_id) {
            return [
                'success' => false,
                'error' => 'No aggregator information available'
            ];
        }

        $aggregator = $this->getAggregator($request->aggregator_provider);
        if (!$aggregator) {
            return [
                'success' => false,
                'error' => "Aggregator {$request->aggregator_provider} not available"
            ];
        }

        $result = $aggregator->getReleaseStatus($request->aggregator_release_id);
        
        if ($result['success']) {
            // Update distribution request status based on aggregator response
            $newStatus = $this->mapAggregatorStatusToLocal($result['status']);
            
            if ($newStatus !== $request->dsp_delivery_status) {
                $request->update(['dsp_delivery_status' => $newStatus]);
                
                Log::info("Updated release status", [
                    'distribution_request_id' => $request->id,
                    'old_status' => $request->dsp_delivery_status,
                    'new_status' => $newStatus,
                    'aggregator_status' => $result['status']
                ]);
            }
        }

        return $result;
    }

    /**
     * Fetch royalty reports for a release
     */
    public function fetchRoyaltyReports(DistributionRequest $request, array $dateRange = []): array
    {
        if (!$request->aggregator_provider || !$request->aggregator_release_id) {
            return [
                'success' => false,
                'error' => 'No aggregator information available',
                'reports' => []
            ];
        }

        $aggregator = $this->getAggregator($request->aggregator_provider);
        if (!$aggregator) {
            return [
                'success' => false,
                'error' => "Aggregator {$request->aggregator_provider} not available",
                'reports' => []
            ];
        }

        return $aggregator->fetchRoyaltyReports($request->aggregator_release_id, $dateRange);
    }

    /**
     * Test connection to all aggregators
     */
    public function testAllConnections(): array
    {
        $results = [];
        
        foreach ($this->aggregators as $provider => $aggregator) {
            $results[$provider] = $aggregator->testConnection();
        }

        return $results;
    }

    /**
     * Test connection to specific aggregator
     */
    public function testConnection(string $provider): array
    {
        $aggregator = $this->getAggregator($provider);
        
        if (!$aggregator) {
            return [
                'success' => false,
                'error' => "Aggregator {$provider} not available"
            ];
        }

        return $aggregator->testConnection();
    }

    /**
     * Get primary aggregator (first active one)
     */
    protected function getPrimaryAggregator(): ?string
    {
        return !empty($this->aggregators) ? array_key_first($this->aggregators) : null;
    }

    /**
     * Map aggregator-specific status to local status
     */
    protected function mapAggregatorStatusToLocal(string $aggregatorStatus): string
    {
        // Map various aggregator statuses to our local statuses
        $statusMap = [
            'submitted' => 'processing',
            'processing' => 'processing',
            'pending' => 'processing',
            'approved' => 'processing',
            'delivered' => 'delivered',
            'live' => 'delivered',
            'published' => 'delivered',
            'rejected' => 'failed',
            'failed' => 'failed',
            'error' => 'failed',
        ];

        return $statusMap[strtolower($aggregatorStatus)] ?? 'pending';
    }

    /**
     * Get aggregator statistics
     */
    public function getStatistics(): array
    {
        $stats = [
            'total_aggregators' => count($this->aggregators),
            'active_providers' => array_keys($this->aggregators),
            'connection_status' => []
        ];

        foreach ($this->aggregators as $provider => $aggregator) {
            $stats['connection_status'][$provider] = $aggregator->testConnection();
        }

        return $stats;
    }
}