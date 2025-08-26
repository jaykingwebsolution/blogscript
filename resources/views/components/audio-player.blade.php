<!-- Audio Player Component -->
@props(['music'])

<div class="bg-white rounded-lg shadow-md p-4 mb-6" id="audio-player">
    <div class="flex items-center space-x-4">
        <img src="{{ $music->image_url ?? '/images/default-music.svg' }}" 
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
    
    @php
        $audioUrl = $music->audio_url ?? ($music->audio_file ? asset('storage/' . $music->audio_file) : null);
    @endphp
    
    @if($audioUrl)
        <div class="mt-4">
            <audio controls class="w-full" preload="metadata" id="main-audio-player">
                <source src="{{ $audioUrl }}" type="audio/mpeg">
                <source src="{{ $audioUrl }}" type="audio/wav">
                <source src="{{ $audioUrl }}" type="audio/ogg">
                Your browser does not support the audio element.
            </audio>
        </div>
        
        <div class="mt-3 flex items-center justify-between">
            <div class="flex space-x-2">
                <button onclick="downloadMusic(@json($audioUrl), @json($music->title))" 
                        class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition-colors text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                    </svg>
                    Download
                </button>
                <button onclick="shareMusic(@json(route('music.show', $music->slug)))" 
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
        <!-- Demo Audio Player for Development -->
        <div class="mt-4 p-6 bg-gradient-to-r from-primary/5 to-accent/5 rounded-lg border border-primary/20">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <button id="demo-play-btn" class="bg-primary text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-primary/90 transition-colors">
                        <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </button>
                    <div class="text-sm text-gray-600">
                        <p class="font-medium">Demo Audio Player</p>
                        <p class="text-xs">Click play for a preview experience</p>
                    </div>
                </div>
                @if($music->duration)
                    <span class="text-primary font-medium">{{ $music->duration }}</span>
                @endif
            </div>
            
            <!-- Progress Bar -->
            <div class="relative">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="demo-progress" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span id="demo-current-time">0:00</span>
                    <span id="demo-total-time">{{ $music->duration ?? '3:45' }}</span>
                </div>
            </div>
            
            <div class="mt-4 flex justify-between items-center">
                <div class="flex space-x-2">
                    <button class="bg-white text-primary px-4 py-2 rounded border border-primary/20 hover:bg-primary/5 transition-colors text-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                        </svg>
                        Preview
                    </button>
                    <button onclick="shareMusic(@json(route('music.show', $music->slug)))" 
                            class="bg-white text-gray-700 px-4 py-2 rounded border border-gray-200 hover:bg-gray-50 transition-colors text-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
                        </svg>
                        Share
                    </button>
                </div>
                <p class="text-xs text-gray-500 italic">Audio file will be available when uploaded</p>
            </div>
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
        }).catch(() => {
            // Fallback for older browsers
            const textarea = document.createElement('textarea');
            textarea.value = url;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('Link copied to clipboard!');
        });
    }
}

// Demo Audio Player Functionality
document.addEventListener('DOMContentLoaded', function() {
    const demoPlayBtn = document.getElementById('demo-play-btn');
    const demoProgress = document.getElementById('demo-progress');
    const demoCurrentTime = document.getElementById('demo-current-time');
    
    if (demoPlayBtn) {
        let isPlaying = false;
        let progress = 0;
        let interval;
        
        demoPlayBtn.addEventListener('click', function() {
            if (!isPlaying) {
                // Start demo playback
                isPlaying = true;
                demoPlayBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                    </svg>
                `;
                
                interval = setInterval(() => {
                    progress += 0.5;
                    demoProgress.style.width = progress + '%';
                    
                    const currentSeconds = Math.floor(progress * 225 / 100); // Assuming 3:45 = 225 seconds
                    const minutes = Math.floor(currentSeconds / 60);
                    const seconds = currentSeconds % 60;
                    demoCurrentTime.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        isPlaying = false;
                        progress = 0;
                        demoProgress.style.width = '0%';
                        demoCurrentTime.textContent = '0:00';
                        demoPlayBtn.innerHTML = `
                            <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        `;
                    }
                }, 100);
            } else {
                // Pause demo playback
                isPlaying = false;
                clearInterval(interval);
                demoPlayBtn.innerHTML = `
                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                `;
            }
        });
    }
});
</script>