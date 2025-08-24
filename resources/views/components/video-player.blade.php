<!-- Video Player Component -->
@props(['video'])

<div class="bg-black rounded-lg overflow-hidden mb-6" id="video-player">
    @if($video->video_url)
        @if(str_contains($video->video_url, 'youtube.com') || str_contains($video->video_url, 'youtu.be'))
            @php
                // Extract YouTube video ID
                $videoId = '';
                if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $video->video_url, $matches)) {
                    $videoId = $matches[1];
                } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $video->video_url, $matches)) {
                    $videoId = $matches[1];
                }
            @endphp
            @if($videoId)
                <div class="relative w-full" style="padding-bottom: 56.25%; /* 16:9 aspect ratio */">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/{{ $videoId }}"
                        title="{{ $video->title }}"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            @else
                <div class="p-8 text-center text-white">
                    <p>Unable to load YouTube video</p>
                </div>
            @endif
        @else
            <!-- Direct MP4 or other video file -->
            <video controls class="w-full" preload="metadata" poster="{{ $video->thumbnail_url }}">
                <source src="{{ $video->video_url }}" type="video/mp4">
                <source src="{{ $video->video_url }}" type="video/webm">
                <source src="{{ $video->video_url }}" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        @endif
        
        <div class="bg-white p-4">
            <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                    @if(!str_contains($video->video_url, 'youtube.com') && !str_contains($video->video_url, 'youtu.be'))
                        <button onclick="downloadVideo('{{ $video->video_url }}', '{{ $video->title }}')" 
                                class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition-colors text-sm">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                            </svg>
                            Download
                        </button>
                    @endif
                    <button onclick="shareVideo('{{ route('videos.show', $video->slug) }}')" 
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition-colors text-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                        </svg>
                        Share
                    </button>
                </div>
                @if($video->duration)
                    <span class="text-gray-500 text-sm">{{ $video->duration }}</span>
                @endif
            </div>
        </div>
    @else
        <div class="p-8 text-center">
            @if($video->thumbnail_url)
                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="mx-auto mb-4 rounded">
            @endif
            <p class="text-gray-600">Video not available</p>
        </div>
    @endif
</div>

<script>
function downloadVideo(url, title) {
    const link = document.createElement('a');
    link.href = url;
    link.download = title + '.mp4';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function shareVideo(url) {
    if (navigator.share) {
        navigator.share({
            title: '{{ $video->title }}',
            url: url
        });
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Video link copied to clipboard!');
        });
    }
}
</script>