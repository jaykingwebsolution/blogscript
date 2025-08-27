<?php

namespace App\Services\Distribution;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use getID3;

class FileValidationService
{
    /**
     * Audio file specifications for DSP compliance
     */
    protected array $audioSpecs = [
        'formats' => ['mp3', 'wav', 'flac', 'm4a', 'aac'],
        'min_bitrate' => 128, // kbps
        'max_bitrate' => 320, // kbps
        'min_sample_rate' => 44100, // Hz
        'max_sample_rate' => 192000, // Hz
        'min_duration' => 10, // seconds
        'max_duration' => 7200, // 2 hours
        'max_size' => 500 * 1024 * 1024, // 500MB
        'required_channels' => [1, 2], // mono or stereo
    ];

    /**
     * Artwork specifications for DSP compliance
     */
    protected array $artworkSpecs = [
        'formats' => ['jpg', 'jpeg', 'png'],
        'min_dimensions' => 1400, // pixels (width and height)
        'max_dimensions' => 3000, // pixels
        'max_size' => 10 * 1024 * 1024, // 10MB
        'aspect_ratio_tolerance' => 0.02, // 2% tolerance for square ratio
    ];

    /**
     * Validate audio file according to DSP specifications
     */
    public function validateAudioFile(UploadedFile $file): array
    {
        $result = [
            'valid' => false,
            'errors' => [],
            'warnings' => [],
            'metadata' => []
        ];

        try {
            // Basic file checks
            if (!$file->isValid()) {
                $result['errors'][] = 'File upload failed or corrupted';
                return $result;
            }

            // Check file extension
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $this->audioSpecs['formats'])) {
                $result['errors'][] = "Unsupported audio format. Allowed formats: " . implode(', ', $this->audioSpecs['formats']);
                return $result;
            }

            // Check file size
            if ($file->getSize() > $this->audioSpecs['max_size']) {
                $result['errors'][] = "File too large. Maximum size: " . $this->formatBytes($this->audioSpecs['max_size']);
                return $result;
            }

            // Store temporary file for analysis
            $tempPath = $file->store('temp/audio');
            $fullPath = Storage::path($tempPath);

            // Analyze audio file with getID3
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($fullPath);

            // Clean up temp file
            Storage::delete($tempPath);

            if (!isset($fileInfo['audio'])) {
                $result['errors'][] = 'Invalid audio file or corrupted';
                return $result;
            }

            $audio = $fileInfo['audio'];
            $result['metadata'] = [
                'duration' => $fileInfo['playtime_seconds'] ?? 0,
                'bitrate' => $audio['bitrate'] ?? 0,
                'sample_rate' => $audio['sample_rate'] ?? 0,
                'channels' => $audio['channels'] ?? 0,
                'format' => $audio['dataformat'] ?? 'unknown',
                'filesize' => $fileInfo['filesize'] ?? 0,
            ];

            // Validate duration
            $duration = $result['metadata']['duration'];
            if ($duration < $this->audioSpecs['min_duration']) {
                $result['errors'][] = "Track too short. Minimum duration: {$this->audioSpecs['min_duration']} seconds";
            }
            if ($duration > $this->audioSpecs['max_duration']) {
                $result['errors'][] = "Track too long. Maximum duration: " . $this->formatDuration($this->audioSpecs['max_duration']);
            }

            // Validate bitrate
            $bitrate = $result['metadata']['bitrate'];
            if ($bitrate < $this->audioSpecs['min_bitrate'] * 1000) {
                $result['warnings'][] = "Low bitrate ({$bitrate} bps). Recommended minimum: {$this->audioSpecs['min_bitrate']} kbps";
            }
            if ($bitrate > $this->audioSpecs['max_bitrate'] * 1000) {
                $result['warnings'][] = "High bitrate ({$bitrate} bps). Consider optimizing file size";
            }

            // Validate sample rate
            $sampleRate = $result['metadata']['sample_rate'];
            if ($sampleRate < $this->audioSpecs['min_sample_rate']) {
                $result['errors'][] = "Sample rate too low ({$sampleRate} Hz). Minimum: {$this->audioSpecs['min_sample_rate']} Hz";
            }

            // Validate channels
            $channels = $result['metadata']['channels'];
            if (!in_array($channels, $this->audioSpecs['required_channels'])) {
                $result['errors'][] = "Invalid channel configuration ({$channels} channels). Must be mono (1) or stereo (2)";
            }

            // Check for common issues
            if (isset($fileInfo['error'])) {
                foreach ($fileInfo['error'] as $error) {
                    $result['warnings'][] = "Audio analysis warning: " . $error;
                }
            }

            $result['valid'] = empty($result['errors']);

            Log::info('Audio file validation completed', [
                'filename' => $file->getClientOriginalName(),
                'valid' => $result['valid'],
                'errors' => count($result['errors']),
                'warnings' => count($result['warnings']),
                'metadata' => $result['metadata']
            ]);

        } catch (\Exception $e) {
            $result['errors'][] = 'Error analyzing audio file: ' . $e->getMessage();
            Log::error('Audio file validation exception', [
                'filename' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
        }

        return $result;
    }

    /**
     * Validate artwork file according to DSP specifications
     */
    public function validateArtworkFile(UploadedFile $file): array
    {
        $result = [
            'valid' => false,
            'errors' => [],
            'warnings' => [],
            'metadata' => []
        ];

        try {
            // Basic file checks
            if (!$file->isValid()) {
                $result['errors'][] = 'File upload failed or corrupted';
                return $result;
            }

            // Check file extension
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $this->artworkSpecs['formats'])) {
                $result['errors'][] = "Unsupported image format. Allowed formats: " . implode(', ', $this->artworkSpecs['formats']);
                return $result;
            }

            // Check file size
            if ($file->getSize() > $this->artworkSpecs['max_size']) {
                $result['errors'][] = "File too large. Maximum size: " . $this->formatBytes($this->artworkSpecs['max_size']);
                return $result;
            }

            // Get image dimensions
            $imageInfo = getimagesize($file->getPathname());
            if (!$imageInfo) {
                $result['errors'][] = 'Invalid image file or corrupted';
                return $result;
            }

            [$width, $height] = $imageInfo;
            $result['metadata'] = [
                'width' => $width,
                'height' => $height,
                'format' => image_type_to_extension($imageInfo[2], false),
                'filesize' => $file->getSize(),
                'aspect_ratio' => $width / $height
            ];

            // Check minimum dimensions
            if ($width < $this->artworkSpecs['min_dimensions'] || $height < $this->artworkSpecs['min_dimensions']) {
                $result['errors'][] = "Image too small. Minimum dimensions: {$this->artworkSpecs['min_dimensions']}x{$this->artworkSpecs['min_dimensions']} pixels";
            }

            // Check maximum dimensions
            if ($width > $this->artworkSpecs['max_dimensions'] || $height > $this->artworkSpecs['max_dimensions']) {
                $result['warnings'][] = "Large image dimensions ({$width}x{$height}). Consider optimizing for faster loading";
            }

            // Check aspect ratio (should be square)
            $aspectRatio = $width / $height;
            $deviation = abs(1 - $aspectRatio);
            if ($deviation > $this->artworkSpecs['aspect_ratio_tolerance']) {
                $result['errors'][] = "Image must be square (1:1 aspect ratio). Current ratio: " . number_format($aspectRatio, 2) . ":1";
            }

            // Check for potential issues
            if ($width !== $height) {
                $result['warnings'][] = "Image is not perfectly square ({$width}x{$height}). Some DSPs may crop or reject non-square artwork";
            }

            $result['valid'] = empty($result['errors']);

            Log::info('Artwork validation completed', [
                'filename' => $file->getClientOriginalName(),
                'valid' => $result['valid'],
                'errors' => count($result['errors']),
                'warnings' => count($result['warnings']),
                'metadata' => $result['metadata']
            ]);

        } catch (\Exception $e) {
            $result['errors'][] = 'Error analyzing artwork file: ' . $e->getMessage();
            Log::error('Artwork validation exception', [
                'filename' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
        }

        return $result;
    }

    /**
     * Validate both audio and artwork files for a distribution request
     */
    public function validateDistributionFiles(?UploadedFile $audioFile, ?UploadedFile $artworkFile): array
    {
        $results = [
            'valid' => true,
            'audio' => null,
            'artwork' => null,
            'overall_errors' => [],
            'overall_warnings' => []
        ];

        if ($audioFile) {
            $results['audio'] = $this->validateAudioFile($audioFile);
            if (!$results['audio']['valid']) {
                $results['valid'] = false;
            }
        } else {
            $results['overall_errors'][] = 'Audio file is required';
            $results['valid'] = false;
        }

        if ($artworkFile) {
            $results['artwork'] = $this->validateArtworkFile($artworkFile);
            if (!$results['artwork']['valid']) {
                $results['valid'] = false;
            }
        } else {
            $results['overall_errors'][] = 'Artwork file is required';
            $results['valid'] = false;
        }

        // Cross-validation checks
        if ($results['audio'] && $results['artwork'] && $results['audio']['valid'] && $results['artwork']['valid']) {
            // Check if audio duration makes sense for single vs album
            $duration = $results['audio']['metadata']['duration'] ?? 0;
            if ($duration > 1800) { // 30 minutes
                $results['overall_warnings'][] = 'Long track duration detected. Consider if this should be submitted as an album instead';
            }
        }

        return $results;
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Format duration in seconds to human readable format
     */
    protected function formatDuration(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m {$seconds}s";
        } elseif ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        } else {
            return "{$seconds}s";
        }
    }

    /**
     * Get DSP-specific requirements for display
     */
    public function getDspRequirements(): array
    {
        return [
            'audio' => [
                'Supported Formats' => implode(', ', $this->audioSpecs['formats']),
                'Bitrate Range' => $this->audioSpecs['min_bitrate'] . ' - ' . $this->audioSpecs['max_bitrate'] . ' kbps',
                'Sample Rate' => 'Minimum ' . number_format($this->audioSpecs['min_sample_rate']) . ' Hz',
                'Duration' => $this->formatDuration($this->audioSpecs['min_duration']) . ' - ' . $this->formatDuration($this->audioSpecs['max_duration']),
                'Channels' => 'Mono or Stereo',
                'Maximum File Size' => $this->formatBytes($this->audioSpecs['max_size'])
            ],
            'artwork' => [
                'Supported Formats' => implode(', ', $this->artworkSpecs['formats']),
                'Minimum Dimensions' => $this->artworkSpecs['min_dimensions'] . 'x' . $this->artworkSpecs['min_dimensions'] . ' pixels',
                'Recommended Dimensions' => '3000x3000 pixels',
                'Aspect Ratio' => 'Square (1:1)',
                'Maximum File Size' => $this->formatBytes($this->artworkSpecs['max_size'])
            ]
        ];
    }
}