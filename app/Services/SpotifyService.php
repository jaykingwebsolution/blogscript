<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SpotifyService
{
    private $clientId;
    private $clientSecret;
    private $baseUrl = 'https://api.spotify.com/v1';
    
    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
    }
    
    /**
     * Get access token from Spotify API using client credentials
     */
    private function getAccessToken()
    {
        $cacheKey = 'spotify_access_token';
        
        // Check if we have a cached token
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        try {
            $response = Http::asForm()->withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
            ])->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials'
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access_token'];
                $expiresIn = $data['expires_in'] - 60; // Expire 1 minute early for safety
                
                // Cache the token
                Cache::put($cacheKey, $token, $expiresIn);
                
                return $token;
            }
            
            Log::error('Failed to get Spotify access token', ['response' => $response->body()]);
            return null;
        } catch (\Exception $e) {
            Log::error('Spotify API authentication error', ['error' => $e->getMessage()]);
            return null;
        }
    }
    
    /**
     * Make authenticated request to Spotify API
     */
    private function makeRequest($endpoint, $params = [])
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            throw new \Exception('Unable to authenticate with Spotify API');
        }
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . $endpoint, $params);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            // Handle rate limiting
            if ($response->status() === 429) {
                $retryAfter = $response->header('Retry-After', 1);
                Log::warning('Spotify API rate limit hit, retrying after ' . $retryAfter . ' seconds');
                sleep($retryAfter);
                return $this->makeRequest($endpoint, $params);
            }
            
            Log::error('Spotify API request failed', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            
            return null;
        } catch (\Exception $e) {
            Log::error('Spotify API request error', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    /**
     * Search for artists on Spotify
     */
    public function searchArtists($query, $limit = 20)
    {
        $data = $this->makeRequest('/search', [
            'q' => $query,
            'type' => 'artist',
            'limit' => $limit
        ]);
        
        return $data['artists']['items'] ?? [];
    }
    
    /**
     * Get artist information by Spotify ID
     */
    public function getArtist($artistId)
    {
        return $this->makeRequest("/artists/{$artistId}");
    }
    
    /**
     * Get artist's albums
     */
    public function getArtistAlbums($artistId, $limit = 50)
    {
        $data = $this->makeRequest("/artists/{$artistId}/albums", [
            'include_groups' => 'album,single,compilation',
            'market' => 'US',
            'limit' => $limit
        ]);
        
        return $data['items'] ?? [];
    }
    
    /**
     * Get album tracks
     */
    public function getAlbumTracks($albumId)
    {
        $data = $this->makeRequest("/albums/{$albumId}/tracks");
        return $data['items'] ?? [];
    }
    
    /**
     * Get full album information
     */
    public function getAlbum($albumId)
    {
        return $this->makeRequest("/albums/{$albumId}");
    }
    
    /**
     * Get track information
     */
    public function getTrack($trackId)
    {
        return $this->makeRequest("/tracks/{$trackId}");
    }
    
    /**
     * Get artist's top tracks
     */
    public function getArtistTopTracks($artistId, $market = 'US')
    {
        $data = $this->makeRequest("/artists/{$artistId}/top-tracks", [
            'market' => $market
        ]);
        
        return $data['tracks'] ?? [];
    }
    
    /**
     * Batch get multiple albums
     */
    public function getMultipleAlbums($albumIds)
    {
        $ids = is_array($albumIds) ? implode(',', $albumIds) : $albumIds;
        $data = $this->makeRequest("/albums", [
            'ids' => $ids
        ]);
        
        return $data['albums'] ?? [];
    }
    
    /**
     * Get featured playlists (for discovering new music)
     */
    public function getFeaturedPlaylists($limit = 20)
    {
        $data = $this->makeRequest("/browse/featured-playlists", [
            'limit' => $limit
        ]);
        
        return $data['playlists']['items'] ?? [];
    }
}