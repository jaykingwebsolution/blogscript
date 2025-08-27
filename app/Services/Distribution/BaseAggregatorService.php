<?php

namespace App\Services\Distribution;

use App\Models\DistributionRequest;
use App\Models\AggregatorSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

abstract class BaseAggregatorService implements AggregatorServiceInterface
{
    protected AggregatorSetting $settings;
    protected string $baseUrl;
    protected array $authHeaders = [];

    public function __construct(AggregatorSetting $settings)
    {
        $this->settings = $settings;
        $this->baseUrl = $this->getBaseUrl();
    }

    /**
     * Get the base URL for the aggregator API
     */
    abstract protected function getBaseUrl(): string;

    /**
     * Prepare authentication headers
     */
    abstract protected function prepareAuthHeaders(): array;

    /**
     * Transform DistributionRequest to aggregator format
     */
    abstract protected function transformReleaseData(DistributionRequest $request): array;

    /**
     * Parse aggregator response to standard format
     */
    abstract protected function parseResponse(array $response, string $action): array;

    /**
     * Make authenticated HTTP request to aggregator API
     */
    protected function makeRequest(string $method, string $endpoint, array $data = []): array
    {
        try {
            if (!$this->authenticate()) {
                throw new \Exception('Authentication failed');
            }

            $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
            
            Log::info("Making {$method} request to {$url}", [
                'aggregator' => $this->getName(),
                'endpoint' => $endpoint,
                'data_keys' => array_keys($data)
            ]);

            $response = Http::withHeaders($this->authHeaders)
                ->timeout(30)
                ->{strtolower($method)}($url, $data);

            if (!$response->successful()) {
                throw new \Exception("HTTP {$response->status()}: {$response->body()}");
            }

            $responseData = $response->json();
            
            Log::info("Successful API response from {$this->getName()}", [
                'status' => $response->status(),
                'response_keys' => array_keys($responseData ?? [])
            ]);

            return $responseData ?? [];

        } catch (\Exception $e) {
            Log::error("Aggregator API request failed", [
                'aggregator' => $this->getName(),
                'method' => $method,
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Authenticate with the aggregator API
     */
    public function authenticate(): bool
    {
        if (!empty($this->authHeaders)) {
            return true; // Already authenticated
        }

        try {
            $this->authHeaders = $this->prepareAuthHeaders();
            return true;
        } catch (\Exception $e) {
            Log::error("Authentication failed for {$this->getName()}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send a release to the aggregator
     */
    public function sendRelease(DistributionRequest $request): array
    {
        try {
            $releaseData = $this->transformReleaseData($request);
            $response = $this->makeRequest('POST', '/releases', $releaseData);
            return $this->parseResponse($response, 'send_release');
        } catch (\Exception $e) {
            Log::error("Failed to send release to {$this->getName()}", [
                'distribution_request_id' => $request->id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'aggregator_release_id' => null
            ];
        }
    }

    /**
     * Get release status from aggregator
     */
    public function getReleaseStatus(string $aggregatorReleaseId): array
    {
        try {
            $response = $this->makeRequest('GET', "/releases/{$aggregatorReleaseId}/status");
            return $this->parseResponse($response, 'get_status');
        } catch (\Exception $e) {
            Log::error("Failed to get release status from {$this->getName()}", [
                'aggregator_release_id' => $aggregatorReleaseId,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status' => 'unknown'
            ];
        }
    }

    /**
     * Fetch royalty reports from aggregator
     */
    public function fetchRoyaltyReports(string $aggregatorReleaseId, array $dateRange = []): array
    {
        try {
            $params = [];
            if (!empty($dateRange)) {
                $params['from_date'] = $dateRange['from'] ?? null;
                $params['to_date'] = $dateRange['to'] ?? null;
            }

            $endpoint = "/releases/{$aggregatorReleaseId}/royalties";
            if (!empty($params)) {
                $endpoint .= '?' . http_build_query($params);
            }

            $response = $this->makeRequest('GET', $endpoint);
            return $this->parseResponse($response, 'fetch_royalties');
        } catch (\Exception $e) {
            Log::error("Failed to fetch royalty reports from {$this->getName()}", [
                'aggregator_release_id' => $aggregatorReleaseId,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'reports' => []
            ];
        }
    }

    /**
     * Update release metadata
     */
    public function updateRelease(string $aggregatorReleaseId, array $metadata): array
    {
        try {
            $response = $this->makeRequest('PUT', "/releases/{$aggregatorReleaseId}", $metadata);
            return $this->parseResponse($response, 'update_release');
        } catch (\Exception $e) {
            Log::error("Failed to update release on {$this->getName()}", [
                'aggregator_release_id' => $aggregatorReleaseId,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Test API connection
     */
    public function testConnection(): array
    {
        try {
            if (!$this->authenticate()) {
                return [
                    'success' => false,
                    'error' => 'Authentication failed'
                ];
            }

            // Make a simple API call to test connection
            $this->makeRequest('GET', '/status');
            
            return [
                'success' => true,
                'message' => "Successfully connected to {$this->getName()}"
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}