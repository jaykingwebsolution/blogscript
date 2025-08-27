<?php

namespace App\Services\Distribution\Adapters;

use App\Models\DistributionRequest;
use App\Services\Distribution\BaseAggregatorService;

class AudioSaladAdapter extends BaseAggregatorService
{
    /**
     * Get the base URL for AudioSalad API
     */
    protected function getBaseUrl(): string
    {
        $config = $this->settings->configuration ?? [];
        $isLive = $this->settings->environment === 'live';
        
        return $isLive 
            ? ($config['live_base_url'] ?? 'https://api.audiosalad.com/v1')
            : ($config['test_base_url'] ?? 'https://sandbox-api.audiosalad.com/v1');
    }

    /**
     * Prepare authentication headers for AudioSalad
     */
    protected function prepareAuthHeaders(): array
    {
        if (!$this->settings->secret_key) {
            throw new \Exception('AudioSalad API key not configured');
        }

        return [
            'X-API-Key' => $this->settings->secret_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Transform DistributionRequest to AudioSalad format
     */
    protected function transformReleaseData(DistributionRequest $request): array
    {
        $audioAsset = $request->audioAsset();
        $coverImageAsset = $request->coverImageAsset();

        return [
            'release' => [
                'title' => $request->song_title,
                'artist' => $request->artist_name,
                'label' => $request->record_label ?? 'Independent',
                'genre' => $this->mapGenreToAudioSalad($request->genre),
                'release_date' => $request->release_date,
                'parental_advisory' => $request->explicit_content,
                'upc_code' => $request->upc,
                'distribution_territories' => $this->mapTerritories($request->territories),
                'description' => $request->description,
            ],
            'tracks' => [
                [
                    'title' => $request->song_title,
                    'artist' => $request->artist_name,
                    'isrc_code' => $request->isrc,
                    'audio_file_url' => $audioAsset ? asset('storage/' . $audioAsset->file_path) : null,
                    'contributors' => $this->mapContributors($request->contributors),
                    'lyrics' => $request->lyrics
                ]
            ],
            'artwork' => [
                'image_url' => $coverImageAsset ? asset('storage/' . $coverImageAsset->file_path) : null
            ]
        ];
    }

    /**
     * Parse AudioSalad response to standard format
     */
    protected function parseResponse(array $response, string $action): array
    {
        switch ($action) {
            case 'send_release':
                return [
                    'success' => isset($response['release_id']) || isset($response['id']),
                    'aggregator_release_id' => $response['release_id'] ?? $response['id'] ?? null,
                    'message' => $response['message'] ?? 'Release submitted to AudioSalad successfully',
                    'raw_response' => $response
                ];

            case 'get_status':
                return [
                    'success' => isset($response['status']),
                    'status' => $response['status'] ?? 'unknown',
                    'dsp_statuses' => $response['platform_status'] ?? [],
                    'message' => $response['message'] ?? '',
                    'raw_response' => $response
                ];

            case 'fetch_royalties':
                return [
                    'success' => isset($response['royalties']),
                    'reports' => $this->mapRoyaltyReports($response['royalties'] ?? []),
                    'total_earnings' => $response['total_revenue'] ?? 0,
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
     * Map genre to AudioSalad format
     */
    protected function mapGenreToAudioSalad(string $genre): string
    {
        $genreMap = [
            'Afrobeats' => 'Afrobeats',
            'Hip Hop' => 'Hip Hop',
            'R&B' => 'R&B/Soul',
            'Pop' => 'Pop',
            'Rock' => 'Rock',
            'Gospel' => 'Gospel',
            'Reggae' => 'Reggae',
            'Highlife' => 'World Music',
            'Fuji' => 'World Music',
            'Juju' => 'World Music',
            'Afro-house' => 'House',
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
     * Map territories to AudioSalad format
     */
    protected function mapTerritories(?array $territories): string
    {
        if (!$territories) {
            return 'worldwide';
        }

        return implode(',', $territories);
    }

    /**
     * Map contributors to AudioSalad format
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
                'percentage' => (float) ($contributor['percentage'] ?? 0)
            ];
        }, $contributors);
    }

    /**
     * Map contributor role to AudioSalad format
     */
    protected function mapContributorRole(string $role): string
    {
        $roleMap = [
            'vocalist' => 'Artist',
            'performer' => 'Artist',
            'composer' => 'Composer',
            'producer' => 'Producer',
            'songwriter' => 'Songwriter',
            'lyricist' => 'Lyricist',
            'arranger' => 'Arranger'
        ];

        return $roleMap[strtolower($role)] ?? 'Artist';
    }

    /**
     * Map royalty reports to standard format
     */
    protected function mapRoyaltyReports(array $reports): array
    {
        return array_map(function ($report) {
            return [
                'platform' => $report['platform'] ?? 'unknown',
                'territory' => $report['country'] ?? null,
                'period_start' => $report['period_from'] ?? null,
                'period_end' => $report['period_to'] ?? null,
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
        return 'AudioSalad';
    }
}