@props(['seconds' => 0])

@php
    // Handle different duration formats
    if (is_numeric($seconds)) {
        // If it's numeric (seconds), convert to MM:SS format
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        $formatted = sprintf('%d:%02d', $minutes, $remainingSeconds);
    } elseif (is_string($seconds) && !empty($seconds)) {
        // If it's already a formatted string, use as-is
        $formatted = $seconds;
    } else {
        // Default fallback
        $formatted = '0:00';
    }
@endphp

{{ $formatted }}