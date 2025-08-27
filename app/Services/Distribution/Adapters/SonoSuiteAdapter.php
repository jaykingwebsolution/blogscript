<?php

namespace App\Services\Distribution\Adapters;

use App\Models\DistributionRequest;
use App\Services\Distribution\BaseAggregatorService;

class SonoSuiteAdapter extends BaseAggregatorService
{
    /**
     * Get the base URL for SonoSuite API
     */
    protected function getBaseUrl(): string
    {
        $config = $this->settings->configuration ?? [];
        $isLive = $this->settings->environment === 'live';
        
        return $isLive 
            ? ($config['live_base_url'] ?? 'https://api.sonosuite.com/v1')
            : ($config['test_base_url'] ?? 'https://api-test.sonosuite.com/v1');
    }

    /**
     * Prepare authentication headers for SonoSuite
     */
    protected function prepareAuthHeaders(): array
    {
        if (!$this->settings->secret_key) {
            throw new \Exception('SonoSuite API key not configured');
        }

        return [
            'Authorization' => 'Bearer ' . $this->settings->secret_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Transform DistributionRequest to SonoSuite format
     */
    protected function transformReleaseData(DistributionRequest $request): array
    {
        $audioAsset = $request->audioAsset();
        $coverImageAsset = $request->coverImageAsset();

        return [
            'release' => [
                'title' => $request->song_title,
                'artist_name' => $request->artist_name,
                'label' => $request->record_label ?? 'Independent',
                'genre' => $this->mapGenreToSonoSuite($request->genre),
                'release_date' => $request->release_date,
                'explicit_content' => $request->explicit_content,
                'upc' => $request->upc,
                'territories' => $this->mapTerritories($request->territories),
                'description' => $request->description,
            ],
            'tracks' => [
                [
                    'title' => $request->song_title,
                    'artist_name' => $request->artist_name,
                    'isrc' => $request->isrc,
                    'duration' => null, // Will be detected from audio file
                    'lyrics' => $request->lyrics,
                    'contributors' => $this->mapContributors($request->contributors),
                    'audio_file_url' => $audioAsset ? asset('storage/' . $audioAsset->file_path) : null,
                ]
            ],
            'artwork' => [
                'url' => $coverImageAsset ? asset('storage/' . $coverImageAsset->file_path) : null,
                'format' => 'jpg'
            ]
        ];
    }

    /**
     * Parse SonoSuite response to standard format
     */
    protected function parseResponse(array $response, string $action): array
    {
        switch ($action) {
            case 'send_release':
                return [
                    'success' => isset($response['release_id']),
                    'aggregator_release_id' => $response['release_id'] ?? null,
                    'message' => $response['message'] ?? 'Release submitted successfully',
                    'raw_response' => $response
                ];

            case 'get_status':
                return [
                    'success' => isset($response['status']),
                    'status' => $response['status'] ?? 'unknown',
                    'dsp_statuses' => $response['dsp_delivery'] ?? [],
                    'message' => $response['message'] ?? '',
                    'raw_response' => $response
                ];

            case 'fetch_royalties':
                return [
                    'success' => isset($response['reports']),
                    'reports' => $this->mapRoyaltyReports($response['reports'] ?? []),
                    'total_earnings' => $response['total_earnings'] ?? 0,
                    'raw_response' => $response
                ];

            case 'update_release':
                return [
                    'success' => isset($response['updated']) && $response['updated'],
                    'message' => $response['message'] ?? 'Release updated successfully',
                    'raw_response' => $response
                ];

            default:
                return [
                    'success' => true,
                    'raw_response' => $response
                ];
        }
    }

    /**
     * Map genre to SonoSuite format
     */
    protected function mapGenreToSonoSuite(string $genre): string
    {
        $genreMap = [
            'Afrobeats' => 'World Music',
            'Hip Hop' => 'Hip-Hop/Rap',
            'R&B' => 'R&B/Soul',
            'Pop' => 'Pop',
            'Rock' => 'Rock',
            'Gospel' => 'Christian & Gospel',
            'Reggae' => 'Reggae',
            'Highlife' => 'World Music',
            'Fuji' => 'World Music',
            'Juju' => 'World Music',
            'Afro-house' => 'Electronic',
            'Alternative' => 'Alternative',
            'Electronic' => 'Electronic',
            'Jazz' => 'Jazz',
            'Blues' => 'Blues',
            'Country' => 'Country',
            'Folk' => 'Folk',
            'Other' => 'Other'
        ];

        return $genreMap[$genre] ?? 'Other';
    }

    /**
     * Map territories to SonoSuite format
     */
    protected function mapTerritories(?array $territories): array
    {
        if (!$territories) {
            return ['worldwide' => true];
        }

        // SonoSuite expects ISO country codes
        return [
            'countries' => $territories,
            'worldwide' => false
        ];
    }

    /**
     * Map contributors to SonoSuite format
     */
    protected function mapContributors(?array $contributors): array
    {
        if (!$contributors) {
            return [];
        }

        return array_map(function ($contributor) {
            return [
                'name' => $contributor['name'],
                'role' => $this->mapContributorRole($contributor['role'] ?? 'performer'),
                'share' => (float) ($contributor['percentage'] ?? 0)
            ];
        }, $contributors);
    }

    /**
     * Map contributor role to SonoSuite format
     */
    protected function mapContributorRole(string $role): string
    {
        $roleMap = [
            'vocalist' => 'MainArtist',
            'performer' => 'MainArtist',
            'composer' => 'Composer',
            'producer' => 'Producer',
            'songwriter' => 'Composer',
            'lyricist' => 'Lyricist',
            'arranger' => 'Arranger'
        ];

        return $roleMap[strtolower($role)] ?? 'MainArtist';
    }

    /**
     * Map royalty reports to standard format
     */
    protected function mapRoyaltyReports(array $reports): array
    {
        return array_map(function ($report) {
            return [
                'platform' => $report['dsp'] ?? 'unknown',
                'territory' => $report['country'] ?? null,
                'period_start' => $report['period_start'] ?? null,
                'period_end' => $report['period_end'] ?? null,
                'streams' => (int) ($report['streams'] ?? 0),
                'downloads' => (int) ($report['downloads'] ?? 0),
                'amount' => (float) ($report['revenue'] ?? 0),
                'currency' => $report['currency'] ?? 'USD'
            ];
        }, $reports);
    }

    /**
     * Get aggregator name
     */
    public function getName(): string
    {
        return 'SonoSuite';
    }
}