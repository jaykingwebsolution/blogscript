<!-- Audio Player Component -->
@props(['music'])

<div class="bg-white rounded-lg shadow-md p-4 mb-6" id="audio-player">
    <div class="flex items-center space-x-4">
        <img src="{{ $music->image_url ?? '/images/default-music.jpg' }}" 
             alt="{{ $music->title }}" 
             class="w-16 h-16 rounded-lg object-cover">
        <div class="flex-1">
            <h4 class="font-semibold text-gray-900">{{ $music->title }}</h4>
            <p class="text-gray-600">
                @if($music->artist)
                    {{ $music->artist->name }}
                @else
                    {{ $music->artist_name }}
                @endif
            </p>
        </div>
    </div>
    
    @if($music->audio_url)
        <div class="mt-4">
            <audio controls class="w-full" preload="metadata">
                <source src="{{ $music->audio_url }}" type="audio/mpeg">
                <source src="{{ $music->audio_url }}" type="audio/wav">
                <source src="{{ $music->audio_url }}" type="audio/ogg">
                Your browser does not support the audio element.
            </audio>
        </div>
        
        <div class="mt-3 flex items-center justify-between">
            <div class="flex space-x-2">
                <button onclick="downloadMusic('{{ $music->audio_url }}', '{{ $music->title }}')" 
                        class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition-colors text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                    </svg>
                    Download
                </button>
                <button onclick="shareMusic('{{ route('music.show', $music->slug) }}')" 
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition-colors text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                    </svg>
                    Share
                </button>
            </div>
            @if($music->duration)
                <span class="text-gray-500 text-sm">{{ $music->duration }}</span>
            @endif
        </div>
    @else
        <div class="mt-4 p-4 bg-gray-100 rounded text-center">
            <p class="text-gray-600">Audio file not available</p>
        </div>
    @endif
</div>

<script>
function downloadMusic(url, title) {
    const link = document.createElement('a');
    link.href = url;
    link.download = title + '.mp3';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function shareMusic(url) {
    if (navigator.share) {
        navigator.share({
            title: '{{ $music->title }}',
            url: url
        });
    } else {
        // Fallback - copy to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        });
    }
}
</script>