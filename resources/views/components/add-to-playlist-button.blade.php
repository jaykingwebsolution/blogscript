@auth
<button onclick="showPlaylistModal({{ $musicId }})" 
        class="flex items-center space-x-2 px-4 py-2 {{ $class ?? 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-lg transition-colors">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    <span>{{ $text ?? 'Add to Playlist' }}</span>
</button>
@endauth