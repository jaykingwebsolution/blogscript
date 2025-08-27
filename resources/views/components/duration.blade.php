@props(['seconds' => 0])

@php
    // Handle different duration formats
    if (is_numeric($seconds)) {
        // If it's numeric (seconds), convert to MM:SS format
        $isNegative = $seconds < 0;
        $absSeconds = abs($seconds);
        $minutes = floor($absSeconds / 60);
        $remainingSeconds = $absSeconds % 60;
        $formatted = sprintf('%s%d:%02d', $isNegative ? '-' : '', $minutes, $remainingSeconds);
    } elseif (is_string($seconds) && !empty($seconds)) {
        // If it's already a formatted string, use as-is
        $formatted = $seconds;
    } else {
        // Default fallback
        $formatted = '0:00';
    }
@endphp

{{ $formatted }}