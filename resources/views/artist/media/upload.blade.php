@extends('layouts.dashboard')

@section('title', 'Upload Media')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('artist.media.index') }}" class="text-purple-600 hover:text-purple-800 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Upload Media</h1>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('artist.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Media Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Media Type</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="type" value="audio" {{ old('type', 'audio') == 'audio' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Audio</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="video" {{ old('type') == 'video' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Video</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="image" {{ old('type') == 'image' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Image</span>
                        </label>
                    </div>
                </div>

                <!-- Upload Method Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Upload Method</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="upload_method" value="file" {{ old('upload_method', 'file') == 'file' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500" 
                                   onchange="toggleUploadMethod()">
                            <span class="ml-2 text-sm text-gray-700">Upload File</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="upload_method" value="url" {{ old('upload_method') == 'url' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500" 
                                   onchange="toggleUploadMethod()">
                            <span class="ml-2 text-sm text-gray-700">External URL (YouTube, SoundCloud, etc.)</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                               placeholder="Enter media title" required>
                    </div>

                    <!-- File Upload Section -->
                    <div id="file-upload-section" class="md:col-span-2" style="{{ old('upload_method', 'file') == 'file' ? '' : 'display: none;' }}">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            Media File
                            <span class="text-xs text-gray-500">(Max: 20MB for audio/video, 5MB for images)</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-purple-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                        <span>Upload a file</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".mp3,.wav,.aac,.ogg,.mp4,.avi,.mov,.wmv,.jpg,.jpeg,.png,.gif,.webp">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500" id="file-type-hint">
                                    Audio: MP3, WAV, AAC, OGG | Video: MP4, AVI, MOV, WMV | Image: JPG, PNG, GIF, WEBP
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- URL Input Section -->
                    <div id="url-input-section" class="md:col-span-2" style="{{ old('upload_method') == 'url' ? '' : 'display: none;' }}">
                        <label for="external_url" class="block text-sm font-medium text-gray-700 mb-2">External URL</label>
                        <input type="url" id="external_url" name="external_url" value="{{ old('external_url') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                               placeholder="https://youtube.com/watch?v=... or https://soundcloud.com/...">
                        <p class="text-xs text-gray-500 mt-1">Supported platforms: YouTube, SoundCloud, Vimeo, and more</p>
                    </div>

                    <!-- Cover Image -->
                    <div class="md:col-span-2">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Cover Image (Optional)
                            <span class="text-xs text-gray-500">(Max: 5MB)</span>
                        </label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category (Optional)</label>
                        <select id="category_id" name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label for="tags_input" class="block text-sm font-medium text-gray-700 mb-2">Tags (Optional)</label>
                        <input type="text" id="tags_input" placeholder="Enter tags separated by commas" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <div id="tags-container" class="mt-2 flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                              placeholder="Describe your media...">{{ old('description') }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('artist.media.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-md">
                        Cancel
                    </a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-md">
                        <i class="fas fa-upload mr-2"></i>Upload Media
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let tags = @json(old('tags', []));

function toggleUploadMethod() {
    const fileSection = document.getElementById('file-upload-section');
    const urlSection = document.getElementById('url-input-section');
    const uploadMethod = document.querySelector('input[name="upload_method"]:checked').value;
    
    if (uploadMethod === 'file') {
        fileSection.style.display = '';
        urlSection.style.display = 'none';
    } else {
        fileSection.style.display = 'none';
        urlSection.style.display = '';
    }
}

function updateFileTypeHint() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const hint = document.getElementById('file-type-hint');
    const fileInput = document.getElementById('file');
    
    if (type === 'audio') {
        hint.textContent = 'Supported formats: MP3, WAV, AAC, OGG (Max: 20MB)';
        fileInput.accept = '.mp3,.wav,.aac,.ogg';
    } else if (type === 'video') {
        hint.textContent = 'Supported formats: MP4, AVI, MOV, WMV (Max: 20MB)';
        fileInput.accept = '.mp4,.avi,.mov,.wmv';
    } else if (type === 'image') {
        hint.textContent = 'Supported formats: JPG, PNG, GIF, WEBP (Max: 5MB)';
        fileInput.accept = '.jpg,.jpeg,.png,.gif,.webp';
    }
}

function addTag(tag) {
    if (tag && !tags.includes(tag)) {
        tags.push(tag);
        updateTagsDisplay();
        updateTagsInput();
    }
}

function removeTag(index) {
    tags.splice(index, 1);
    updateTagsDisplay();
    updateTagsInput();
}

function updateTagsDisplay() {
    const container = document.getElementById('tags-container');
    container.innerHTML = '';
    
    tags.forEach((tag, index) => {
        const tagElement = document.createElement('span');
        tagElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800';
        tagElement.innerHTML = `
            ${tag}
            <button type="button" onclick="removeTag(${index})" class="ml-2 text-purple-600 hover:text-purple-800">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(tagElement);
    });
}

function updateTagsInput() {
    // Remove existing tag inputs
    document.querySelectorAll('input[name="tags[]"]').forEach(input => input.remove());
    
    // Add new hidden inputs for each tag
    const form = document.querySelector('form');
    tags.forEach(tag => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'tags[]';
        input.value = tag;
        form.appendChild(input);
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tags display
    updateTagsDisplay();
    updateTagsInput();
    updateFileTypeHint();
    
    // Type change event
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', updateFileTypeHint);
    });
    
    // Tags input handling
    document.getElementById('tags_input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const tag = this.value.trim();
            if (tag) {
                addTag(tag);
                this.value = '';
            }
        }
    });
    
    // File name display
    document.getElementById('file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = document.querySelector('label[for="file"] span');
            label.textContent = fileName;
        }
    });
});
</script>
@endsection