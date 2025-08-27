<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    /**
     * Display a listing of static pages for management
     */
    public function index(): View
    {
        $pages = [
            [
                'id' => 'about',
                'title' => 'About Us',
                'slug' => 'about',
                'status' => 'published',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'status' => 'published',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 'dmca',
                'title' => 'DMCA Policy',
                'slug' => 'dmca',
                'status' => 'published',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 'terms-of-service',
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'status' => 'published',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 'contact',
                'title' => 'Contact',
                'slug' => 'contact',
                'status' => 'published',
                'last_updated' => now()->format('Y-m-d H:i:s')
            ],
        ];

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(string $page): View
    {
        $pageData = $this->getPageData($page);
        
        if (!$pageData) {
            abort(404, 'Page not found');
        }

        return view('admin.pages.edit', compact('pageData'));
    }

    /**
     * Update the specified page content.
     */
    public function update(Request $request, string $page): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Save the page content to site settings based on the page type
        // This maintains compatibility with existing frontend while allowing admin management
        $settingKey = '';
        switch ($page) {
            case 'about':
                $settingKey = 'about_content';
                break;
            case 'privacy-policy':
                $settingKey = 'privacy_policy_content';
                break;
            case 'dmca':
                $settingKey = 'dmca_policy_content';
                break;
            case 'terms-of-service':
                $settingKey = 'terms_of_service_content';
                break;
            case 'contact':
                $settingKey = 'contact_content';
                break;
            default:
                return redirect()->route('admin.pages.index')
                    ->with('error', 'Invalid page type.');
        }

        // Update the setting
        SiteSetting::setValue($settingKey, $request->input('content'));
        
        return redirect()->route('admin.pages.index')
            ->with('success', ucfirst(str_replace('-', ' ', $page)) . ' page updated successfully.');
    }

    /**
     * Get page data based on page slug
     */
    private function getPageData(string $page): ?array
    {
        // Get content from site settings for legal pages to maintain existing functionality
        // but manage them through the admin pages interface
        $pages = [
            'about' => [
                'id' => 'about',
                'title' => 'About Us',
                'slug' => 'about',
                'content' => \App\Models\SiteSetting::get('about_content', '<h1>About BlogScript Music Platform</h1><p>Welcome to BlogScript Music Platform - your premier destination for discovering, streaming, and distributing music.</p>'),
            ],
            'privacy-policy' => [
                'id' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => \App\Models\SiteSetting::get('privacy_policy_content', '<h1>Privacy Policy</h1><p>This Privacy Policy describes how your personal information is collected, used, and shared when you use our music platform.</p>'),
            ],
            'dmca' => [
                'id' => 'dmca',
                'title' => 'DMCA Policy',
                'slug' => 'dmca',
                'content' => \App\Models\SiteSetting::get('dmca_policy_content', '<h1>DMCA Copyright Policy</h1><p>BlogScript respects the intellectual property rights of others and expects users to do the same.</p>'),
            ],
            'terms-of-service' => [
                'id' => 'terms-of-service',
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => \App\Models\SiteSetting::get('terms_of_service_content', '<h1>Terms of Service</h1><p>By using our music platform, you agree to these Terms of Service.</p>'),
            ],
            'contact' => [
                'id' => 'contact',
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => \App\Models\SiteSetting::get('contact_content', '<h1>Contact Us</h1><p>Contact us for any questions or feedback.</p>'),
            ],
        ];

        return $pages[$page] ?? null;
    }
}