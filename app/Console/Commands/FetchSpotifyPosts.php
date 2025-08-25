<?php

namespace App\Console\Commands;

use App\Models\SpotifyPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchSpotifyPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:fetch {--limit=20 : Number of tracks to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest posts from Spotify API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching latest Spotify posts...');

        // Get Spotify access token
        $accessToken = $this->getSpotifyAccessToken();
        
        if (!$accessToken) {
            $this->error('Failed to get Spotify access token');
            return Command::FAILURE;
        }

        // Fetch new releases
        $newReleases = $this->fetchNewReleases($accessToken, $this->option('limit'));
        
        if (!$newReleases) {
            $this->error('Failed to fetch new releases');
            return Command::FAILURE;
        }

        $savedCount = 0;

        foreach ($newReleases['albums']['items'] ?? [] as $album) {
            try {
                // Check if already exists
                if (SpotifyPost::where('spotify_id', $album['id'])->exists()) {
                    continue;
                }

                $spotifyPost = SpotifyPost::create([
                    'spotify_id' => $album['id'],
                    'title' => $album['name'],
                    'artist_name' => $album['artists'][0]['name'] ?? 'Unknown Artist',
                    'album_name' => $album['name'],
                    'image_url' => $album['images'][0]['url'] ?? null,
                    'spotify_url' => $album['external_urls']['spotify'] ?? '',
                    'release_date' => $album['release_date'] ?? null,
                    'artists' => $album['artists'] ?? [],
                    'type' => $album['type'] ?? 'album',
                    'popularity' => $album['popularity'] ?? 0,
                ]);

                $savedCount++;
                $this->info("Saved: {$album['name']} by {$album['artists'][0]['name']}");

            } catch (\Exception $e) {
                $this->error("Error saving album {$album['name']}: " . $e->getMessage());
                Log::error("Spotify fetch error: " . $e->getMessage(), ['album' => $album]);
            }
        }

        $this->info("Fetched and saved {$savedCount} new Spotify posts");
        return Command::SUCCESS;
    }

    private function getSpotifyAccessToken()
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        if (!$clientId || !$clientSecret) {
            $this->error('Spotify credentials not configured');
            return null;
        }

        try {
            $response = Http::asForm()
                ->withBasicAuth($clientId, $clientSecret)
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            $this->error('Failed to authenticate with Spotify: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            $this->error('Spotify authentication error: ' . $e->getMessage());
            return null;
        }
    }

    private function fetchNewReleases($accessToken, $limit = 20)
    {
        try {
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/browse/new-releases', [
                    'limit' => $limit,
                    'country' => 'NG', // Nigeria
                    'offset' => 0
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            $this->error('Failed to fetch new releases: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            $this->error('Error fetching new releases: ' . $e->getMessage());
            return null;
        }
    }
}
