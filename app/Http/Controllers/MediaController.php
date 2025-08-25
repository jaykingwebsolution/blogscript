<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $media = Media::where('user_id', auth()->id())
                     ->with('category')
                     ->latest()
                     ->paginate(12);
        
        return view('artist.media.index', compact('media'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('artist.media.upload', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:audio,video,image',
            'upload_method' => 'required|in:file,url',
            'file' => 'required_if:upload_method,file|file|max:20480', // 20MB max
            'external_url' => 'required_if:upload_method,url|url',
            'cover_image' => 'nullable|image|max:5120', // 5MB max
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ]);

        // Additional file type validation
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mimeType = $file->getMimeType();
            
            $allowedTypes = [
                'audio' => ['audio/mpeg', 'audio/wav', 'audio/aac', 'audio/ogg'],
                'video' => ['video/mp4', 'video/avi', 'video/mov', 'video/wmv'],
                'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
            ];
            
            if (!in_array($mimeType, $allowedTypes[$request->type] ?? [])) {
                $validator->errors()->add('file', 'Invalid file type for ' . $request->type);
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $mediaData = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'tags' => $request->tags ?? [],
            'status' => 'pending'
        ];

        // Handle file upload
        if ($request->upload_method === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/' . $request->type, $filename, 'public');
            
            $mediaData['file_path'] = $path;
            $mediaData['original_filename'] = $file->getClientOriginalName();
            $mediaData['mime_type'] = $file->getMimeType();
            $mediaData['file_size'] = $file->getSize();
        } elseif ($request->upload_method === 'url') {
            $mediaData['external_url'] = $request->external_url;
        }

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverFilename = time() . '_cover_' . Str::random(10) . '.' . $coverFile->getClientOriginalExtension();
            $coverPath = $coverFile->storeAs('media/covers', $coverFilename, 'public');
            $mediaData['cover_image'] = $coverPath;
        }

        $media = Media::create($mediaData);

        return redirect()->route('artist.media.index')
                       ->with('success', 'Media uploaded successfully! It will be reviewed before going live.');
    }

    public function show(Media $media)
    {
        // Check if user owns this media or is admin
        if ($media->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('artist.media.show', compact('media'));
    }

    public function edit(Media $media)
    {
        // Check if user owns this media
        if ($media->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('artist.media.edit', compact('media', 'categories'));
    }

    public function update(Request $request, Media $media)
    {
        // Check if user owns this media
        if ($media->user_id !== auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $validator->validated();
        $data['tags'] = $data['tags'] ?? [];

        // Handle cover image update
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($media->cover_image) {
                Storage::disk('public')->delete($media->cover_image);
            }
            
            $coverFile = $request->file('cover_image');
            $coverFilename = time() . '_cover_' . Str::random(10) . '.' . $coverFile->getClientOriginalExtension();
            $coverPath = $coverFile->storeAs('media/covers', $coverFilename, 'public');
            $data['cover_image'] = $coverPath;
        }

        $media->update($data);

        return redirect()->route('artist.media.show', $media)
                       ->with('success', 'Media updated successfully!');
    }

    public function destroy(Media $media)
    {
        // Check if user owns this media or is admin
        if ($media->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Delete associated files
        if ($media->file_path) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        if ($media->cover_image) {
            Storage::disk('public')->delete($media->cover_image);
        }

        $media->delete();

        $redirectRoute = auth()->user()->isAdmin() ? 'admin.media.index' : 'artist.media.index';
        
        return redirect()->route($redirectRoute)
                       ->with('success', 'Media deleted successfully!');
    }
}
