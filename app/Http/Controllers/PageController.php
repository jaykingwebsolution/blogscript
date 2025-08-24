<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function dmca()
    {
        return view('pages.dmca');
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