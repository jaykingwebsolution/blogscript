<?php

namespace App\Services\Distribution;

use App\Models\DistributionRequest;

interface AggregatorServiceInterface
{
    /**
     * Authenticate with the aggregator API
     */
    public function authenticate(): bool;

    /**
     * Send a release to the aggregator
     */
    public function sendRelease(DistributionRequest $request): array;

    /**
     * Get release status from aggregator
     */
    public function getReleaseStatus(string $aggregatorReleaseId): array;

    /**
     * Fetch royalty reports from aggregator
     */
    public function fetchRoyaltyReports(string $aggregatorReleaseId, array $dateRange = []): array;

    /**
     * Update release metadata
     */
    public function updateRelease(string $aggregatorReleaseId, array $metadata): array;

    /**
     * Test API connection
     */
    public function testConnection(): array;

    /**
     * Get aggregator name
     */
    public function getName(): string;
}