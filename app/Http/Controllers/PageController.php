<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class PageController extends Controller
{
    public function contact()
    {
        $content = SiteSetting::get('contact_content', '<p>Contact us for any questions or feedback.</p>');
        return view('pages.contact', compact('content'));
    }

    public function about()
    {
        $content = SiteSetting::get('about_content', '<p>Learn more about our platform.</p>');
        return view('pages.about', compact('content'));
    }

    public function privacyPolicy()
    {
        $content = SiteSetting::get('privacy_policy_content', '<p>Privacy policy content goes here.</p>');
        return view('pages.privacy-policy', compact('content'));
    }

    public function dmca()
    {
        $content = SiteSetting::get('dmca_policy_content', '<p>DMCA policy content goes here.</p>');
        return view('pages.dmca', compact('content'));
    }

    public function submitContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Here you would typically send an email or save to database
        // For now, just redirect back with success message
        
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function newsletterSubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Here you would typically save to database or send to email service
        // For now, just redirect back with success message
        
        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}