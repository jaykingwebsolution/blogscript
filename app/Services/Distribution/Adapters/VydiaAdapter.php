<?php

namespace App\Services\Distribution\Adapters;

use App\Models\DistributionRequest;
use App\Services\Distribution\BaseAggregatorService;

class VydiaAdapter extends BaseAggregatorService
{
    /**
     * Get the base URL for Vydia API
     */
    protected function getBaseUrl(): string
    {
        $config = $this->settings->configuration ?? [];
        $isLive = $this->settings->environment === 'live';
        
        return $isLive 
            ? ($config['live_base_url'] ?? 'https://api.vydia.com/v1')
            : ($config['test_base_url'] ?? 'https://sandbox-api.vydia.com/v1');
    }

    /**
     * Prepare authentication headers for Vydia
     */
    protected function prepareAuthHeaders(): array
    {
        if (!$this->settings->secret_key) {
            throw new \Exception('Vydia API key not configured');
        }

        return [
            'Authorization' => 'Bearer ' . $this->settings->secret_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Vydia-Client' => 'BlogScript-Platform'
        ];
    }

    /**
     * Transform DistributionRequest to Vydia format
     */
    protected function transformReleaseData(DistributionRequest $request): array
    {
        $audioAsset = $request->audioAsset();
        $coverImageAsset = $request->coverImageAsset();

        return [
            'album' => [
                'title' => $request->song_title,
                'primary_artist' => $request->artist_name,
                'label' => $request->record_label ?? 'Independent',
                'genre' => $this->mapGenreToVydia($request->genre),
                'release_date' => $request->release_date,
                'explicit' => $request->explicit_content,
                'upc' => $request->upc,
                'territories' => $this->mapTerritories($request->territories),
                'cover_art_url' => $coverImageAsset ? asset('storage/' . $coverImageAsset->file_path) : null,
            ],
            'tracks' => [
                [
                    'title' => $request->song_title,
                    'primary_artist' => $request->artist_name,
                    'isrc' => $request->isrc,
                    'audio_url' => $audioAsset ? asset('storage/' . $audioAsset->file_path) : null,
                    'track_number' => 1,
                    'contributors' => $this->mapContributors($request->contributors),
                    'lyrics' => $request->lyrics,
                    'explicit' => $request->explicit_content
                ]
            ]
        ];
    }

    /**
     * Parse Vydia response to standard format
     */
    protected function parseResponse(array $response, string $action): array
    {
        switch ($action) {
            case 'send_release':
                return [
                    'success' => isset($response['album_id']),
                    'aggregator_release_id' => $response['album_id'] ?? null,
                    'message' => $response['message'] ?? 'Release submitted to Vydia successfully',
                    'raw_response' => $response
                ];

            case 'get_status':
                return [
                    'success' => isset($response['status']),
                    'status' => $response['status'] ?? 'unknown',
                    'dsp_statuses' => $response['distribution_status'] ?? [],
                    'message' => $response['message'] ?? '',
                    'raw_response' => $response
                ];

            case 'fetch_royalties':
                return [
                    'success' => isset($response['earnings']),
                    'reports' => $this->mapRoyaltyReports($response['earnings'] ?? []),
                    'total_earnings' => $response['total_net'] ?? 0,
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
     * Map genre to Vydia format
     */
    protected function mapGenreToVydia(string $genre): string
    {
        $genreMap = [
            'Afrobeats' => 'Afro-Pop',
            'Hip Hop' => 'Hip-Hop/Rap',
            'R&B' => 'R&B',
            'Pop' => 'Pop',
            'Rock' => 'Rock',
            'Gospel' => 'Christian',
            'Reggae' => 'Reggae',
            'Highlife' => 'World',
            'Fuji' => 'World',
            'Juju' => 'World',
            'Afro-house' => 'Dance/Electronic',
            'Alternative' => 'Alternative',
            'Electronic' => 'Dance/Electronic',
            'Jazz' => 'Jazz',
            'Blues' => 'Blues',
            'Country' => 'Country',
            'Folk' => 'Folk',
            'Other' => 'Other'
        ];

        return $genreMap[$genre] ?? 'Other';
    }

    /**
     * Map territories to Vydia format
     */
    protected function mapTerritories(?array $territories): array
    {
        if (!$territories) {
            return ['WW']; // Worldwide in Vydia format
        }

        return $territories;
    }

    /**
     * Map contributors to Vydia format
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
                'split_percentage' => (float) ($contributor['percentage'] ?? 0)
            ];
        }, $contributors);
    }

    /**
     * Map contributor role to Vydia format
     */
    protected function mapContributorRole(string $role): string
    {
        $roleMap = [
            'vocalist' => 'MainArtist',
            'performer' => 'MainArtist',
            'composer' => 'Composer',
            'producer' => 'Producer',
            'songwriter' => 'Songwriter',
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
                'territory' => $report['territory'] ?? null,
                'period_start' => $report['start_date'] ?? null,
                'period_end' => $report['end_date'] ?? null,
                'streams' => (int) ($report['streams'] ?? 0),
                'downloads' => (int) ($report['downloads'] ?? 0),
                'amount' => (float) ($report['net_amount'] ?? 0),
                'currency' => $report['currency'] ?? 'USD'
            ];
        }, $reports);
    }

    /**
     * Get aggregator name
     */
    public function getName(): string
    {
        return 'Vydia';
    }
}