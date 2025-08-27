<?php

namespace App\Services\Distribution\Adapters;

use App\Models\DistributionRequest;
use App\Services\Distribution\BaseAggregatorService;

class FugaAdapter extends BaseAggregatorService
{
    /**
     * Get the base URL for FUGA API
     */
    protected function getBaseUrl(): string
    {
        $config = $this->settings->configuration ?? [];
        $isLive = $this->settings->environment === 'live';
        
        return $isLive 
            ? ($config['live_base_url'] ?? 'https://api.fuga.com/v2')
            : ($config['test_base_url'] ?? 'https://api-sandbox.fuga.com/v2');
    }

    /**
     * Prepare authentication headers for FUGA
     */
    protected function prepareAuthHeaders(): array
    {
        if (!$this->settings->secret_key) {
            throw new \Exception('FUGA API key not configured');
        }

        return [
            'Authorization' => 'Bearer ' . $this->settings->secret_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Transform DistributionRequest to FUGA format
     */
    protected function transformReleaseData(DistributionRequest $request): array
    {
        $audioAsset = $request->audioAsset();
        $coverImageAsset = $request->coverImageAsset();

        return [
            'name' => $request->song_title,
            'artist' => $request->artist_name,
            'label' => $request->record_label ?? 'Independent',
            'genre' => $this->mapGenreToFuga($request->genre),
            'release_date' => $request->release_date,
            'explicit' => $request->explicit_content,
            'upc' => $request->upc,
            'territories' => $this->mapTerritories($request->territories),
            'tracks' => [
                [
                    'name' => $request->song_title,
                    'artist' => $request->artist_name,
                    'isrc' => $request->isrc,
                    'audio_file' => $audioAsset ? asset('storage/' . $audioAsset->file_path) : null,
                    'contributors' => $this->mapContributors($request->contributors),
                    'lyrics' => $request->lyrics
                ]
            ],
            'artwork' => $coverImageAsset ? asset('storage/' . $coverImageAsset->file_path) : null
        ];
    }

    /**
     * Parse FUGA response to standard format
     */
    protected function parseResponse(array $response, string $action): array
    {
        switch ($action) {
            case 'send_release':
                return [
                    'success' => isset($response['id']),
                    'aggregator_release_id' => $response['id'] ?? null,
                    'message' => 'Release submitted to FUGA successfully',
                    'raw_response' => $response
                ];

            case 'get_status':
                return [
                    'success' => isset($response['status']),
                    'status' => $response['status'] ?? 'unknown',
                    'dsp_statuses' => $response['stores'] ?? [],
                    'message' => $response['message'] ?? '',
                    'raw_response' => $response
                ];

            case 'fetch_royalties':
                return [
                    'success' => isset($response['data']),
                    'reports' => $this->mapRoyaltyReports($response['data'] ?? []),
                    'total_earnings' => $response['total'] ?? 0,
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
     * Map genre to FUGA format
     */
    protected function mapGenreToFuga(string $genre): string
    {
        $genreMap = [
            'Afrobeats' => 'World',
            'Hip Hop' => 'Hip-Hop',
            'R&B' => 'R&B',
            'Pop' => 'Pop',
            'Rock' => 'Rock',
            'Gospel' => 'Gospel',
            'Reggae' => 'Reggae',
            'Highlife' => 'World',
            'Fuji' => 'World',
            'Juju' => 'World',
            'Afro-house' => 'Dance',
            'Alternative' => 'Alternative',
            'Electronic' => 'Dance',
            'Jazz' => 'Jazz',
            'Blues' => 'Blues',
            'Country' => 'Country',
            'Folk' => 'Folk',
            'Other' => 'Other'
        ];

        return $genreMap[$genre] ?? 'Other';
    }

    /**
     * Map territories to FUGA format
     */
    protected function mapTerritories(?array $territories): array
    {
        if (!$territories) {
            return ['WW']; // Worldwide
        }

        return $territories;
    }

    /**
     * Map contributors to FUGA format
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
     * Map contributor role to FUGA format
     */
    protected function mapContributorRole(string $role): string
    {
        $roleMap = [
            'vocalist' => 'primary_artist',
            'performer' => 'primary_artist',
            'composer' => 'composer',
            'producer' => 'producer',
            'songwriter' => 'composer',
            'lyricist' => 'lyricist',
            'arranger' => 'arranger'
        ];

        return $roleMap[strtolower($role)] ?? 'primary_artist';
    }

    /**
     * Map royalty reports to standard format
     */
    protected function mapRoyaltyReports(array $reports): array
    {
        return array_map(function ($report) {
            return [
                'platform' => $report['store'] ?? 'unknown',
                'territory' => $report['territory'] ?? null,
                'period_start' => $report['from_date'] ?? null,
                'period_end' => $report['to_date'] ?? null,
                'streams' => (int) ($report['quantity'] ?? 0),
                'downloads' => 0, // FUGA typically reports streams
                'amount' => (float) ($report['net_revenue'] ?? 0),
                'currency' => $report['currency'] ?? 'USD'
            ];
        }, $reports);
    }

    /**
     * Get aggregator name
     */
    public function getName(): string
    {
        return 'FUGA';
    }
}