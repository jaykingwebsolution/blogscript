@extends('admin.layout')

@section('title', 'Edit Page')
@section('header', 'Edit ' . $pageData['title'])

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.pages.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-spotify-gray border border-spotify-light-gray text-spotify-light-gray hover:text-white hover:border-white rounded-lg transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Pages
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-spotify-gray rounded-lg border border-spotify-dark-gray p-8">
        <form action="{{ route('admin.pages.update', $pageData['id']) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Page Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-white mb-2">Page Title</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $pageData['title']) }}"
                       class="w-full px-4 py-3 bg-spotify-dark-gray border border-spotify-gray text-white placeholder-spotify-light-gray rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent"
                       required>
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Page Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-white mb-2">Page URL Slug</label>
                <div class="flex items-center">
                    <span class="inline-flex items-center px-3 py-3 rounded-l-lg border border-r-0 border-spotify-gray bg-spotify-dark-gray text-spotify-light-gray text-sm">
                        {{ url('/') }}/
                    </span>
                    <input type="text" 
                           name="slug" 
                           id="slug" 
                           value="{{ $pageData['slug'] }}"
                           readonly
                           class="flex-1 px-4 py-3 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray rounded-r-lg cursor-not-allowed">
                </div>
                <p class="mt-2 text-sm text-spotify-light-gray">The URL slug cannot be changed to maintain SEO and existing links.</p>
            </div>

            <!-- Page Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-white mb-2">Page Content</label>
                <div class="mb-2">
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="insertTag('h1')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">H1</button>
                        <button type="button" onclick="insertTag('h2')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">H2</button>
                        <button type="button" onclick="insertTag('p')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">Paragraph</button>
                        <button type="button" onclick="insertTag('strong')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">Bold</button>
                        <button type="button" onclick="insertTag('em')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">Italic</button>
                        <button type="button" onclick="insertTag('ul')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">List</button>
                        <button type="button" onclick="insertTag('a')" class="px-3 py-1 bg-spotify-dark-gray border border-spotify-gray text-spotify-light-gray hover:text-white hover:border-spotify-green rounded text-sm transition-colors">Link</button>
                    </div>
                </div>
                <textarea name="content" 
                          id="content" 
                          rows="20"
                          class="w-full px-4 py-3 bg-spotify-dark-gray border border-spotify-gray text-white placeholder-spotify-light-gray rounded-lg focus:ring-2 focus:ring-spotify-green focus:border-transparent font-mono text-sm"
                          placeholder="Enter page content using HTML..."
                          required>{{ old('content', $pageData['content']) }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-spotify-light-gray">You can use HTML tags to format your content. Use the buttons above to insert common tags.</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-spotify-dark-gray">
                <div class="flex items-center space-x-4">
                    <a href="{{ url($pageData['slug']) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-spotify-gray border border-spotify-green text-spotify-green hover:bg-spotify-green hover:text-white rounded-lg transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Preview Live Page
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.pages.index') }}" 
                       class="px-6 py-2 bg-spotify-gray border border-spotify-light-gray text-spotify-light-gray hover:text-white hover:border-white rounded-lg transition-all">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-spotify-green hover:bg-spotify-green-light text-white rounded-lg font-medium transition-colors">
                        Update Page
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function insertTag(tag) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let insertText = '';
    
    switch(tag) {
        case 'a':
            insertText = `<a href="${selectedText ? '#' : 'URL_HERE'}">${selectedText || 'Link Text'}</a>`;
            break;
        case 'ul':
            insertText = `<ul>\n    <li>${selectedText || 'List item'}</li>\n    <li>List item</li>\n</ul>`;
            break;
        default:
            insertText = `<${tag}>${selectedText || `${tag.toUpperCase()} content`}</${tag}>`;
    }
    
    textarea.value = textarea.value.substring(0, start) + insertText + textarea.value.substring(end);
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + insertText.length;
}
</script>
@endsection