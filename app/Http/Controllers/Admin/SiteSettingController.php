<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class SiteSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized. Admin access required.');
            }
            return $next($request);
        });
    }

    /**
     * Show the site settings form
     */
    public function index()
    {
        $settings = SiteSetting::getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update site settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_meta_description' => 'nullable|string|max:160',
            'site_keywords' => 'nullable|string|max:255',
            'contact_content' => 'nullable|string',
            'about_content' => 'nullable|string',
            'footer_copyright' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'site_logo' => [
                'nullable',
                'image',
                'max:2048'
            ],
            'site_favicon' => [
                'nullable',
                'image',
                'max:512'
            ],
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('site_logo')) {
                // Delete old logo
                $oldLogo = SiteSetting::getValue('site_logo');
                if ($oldLogo && Storage::exists('public/' . $oldLogo)) {
                    Storage::delete('public/' . $oldLogo);
                }

                $logoPath = $request->file('site_logo')->store('site-assets', 'public');
                SiteSetting::setValue('site_logo', $logoPath);
            }

            if ($request->hasFile('site_favicon')) {
                // Delete old favicon
                $oldFavicon = SiteSetting::getValue('site_favicon');
                if ($oldFavicon && Storage::exists('public/' . $oldFavicon)) {
                    Storage::delete('public/' . $oldFavicon);
                }

                $faviconPath = $request->file('site_favicon')->store('site-assets', 'public');
                SiteSetting::setValue('site_favicon', $faviconPath);
            }

            // Update other settings
            $settingsToUpdate = [
                'site_title',
                'site_meta_description',
                'site_keywords',
                'contact_content',
                'about_content',
                'footer_copyright',
                'social_facebook',
                'social_twitter',
                'social_instagram',
                'social_youtube'
            ];

            foreach ($settingsToUpdate as $key) {
                if ($request->has($key)) {
                    SiteSetting::setValue($key, $request->input($key));
                }
            }

            // Update SEO enabled
            SiteSetting::setValue('seo_enabled', $request->has('seo_enabled'));

            // Clear all caches
            SiteSetting::clearCache();

            return redirect()->route('admin.settings.index')
                ->with('success', 'Site settings updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating settings: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove uploaded file
     */
    public function removeFile(Request $request)
    {
        $request->validate([
            'type' => 'required|in:logo,favicon'
        ]);

        try {
            $settingKey = 'site_' . $request->type;
            $currentFile = SiteSetting::getValue($settingKey);

            if ($currentFile && Storage::exists('public/' . $currentFile)) {
                Storage::delete('public/' . $currentFile);
            }

            SiteSetting::setValue($settingKey, null);
            SiteSetting::clearCache();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}