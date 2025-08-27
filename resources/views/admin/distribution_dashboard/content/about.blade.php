@extends('layouts.admin-distribution')

@section('title', 'About Content Management')

@section('header-title', 'About Content Management')

@section('content')
<div class="space-y-8">
    <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
        <h2 class="text-xl font-semibold text-white mb-4">Manage About Page Content</h2>
        <p class="text-gray-400 mb-6">Control what appears on the distribution about page to inform users about your platform.</p>
        
        <form method="POST" action="{{ route('admin.distribution.content.about.update') }}" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Hero Title</label>
                <input type="text" 
                       name="hero_title" 
                       value="About Our Distribution Platform"
                       class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Hero Subtitle</label>
                <textarea name="hero_subtitle" 
                          rows="3"
                          class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">We're revolutionizing music distribution by putting artists first. Learn about our mission, values, and commitment to your success.</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Mission Statement</label>
                <textarea name="mission_statement" 
                          rows="4"
                          class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">To democratize music distribution and empower independent artists and labels to reach global audiences without compromising their rights, royalties, or creative control.</textarea>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Feature 1 Title</label>
                    <input type="text" 
                           name="feature_1_title" 
                           value="Fair Partnership"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    <label class="block text-sm font-medium text-gray-300 mb-2 mt-3">Description</label>
                    <textarea name="feature_1_desc" 
                              rows="2"
                              class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">You keep 100% of your rights and earn fair royalties from every stream and sale.</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Feature 2 Title</label>
                    <input type="text" 
                           name="feature_2_title" 
                           value="Global Reach"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    <label class="block text-sm font-medium text-gray-300 mb-2 mt-3">Description</label>
                    <textarea name="feature_2_desc" 
                              rows="2"
                              class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">Access 150+ digital platforms worldwide with lightning-fast distribution.</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Feature 3 Title</label>
                    <input type="text" 
                           name="feature_3_title" 
                           value="Full Control"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    <label class="block text-sm font-medium text-gray-300 mb-2 mt-3">Description</label>
                    <textarea name="feature_3_desc" 
                              rows="2"
                              class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">Maintain complete ownership and control over your music catalog and metadata.</textarea>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-4">
                <button type="button" 
                        class="px-6 py-2 border border-distro-admin-border text-gray-300 rounded-lg hover:bg-distro-admin-bg transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-distro-admin-accent hover:bg-indigo-600 text-white rounded-lg transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection