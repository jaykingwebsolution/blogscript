@extends('layouts.admin-distribution')

@section('title', 'Contact Settings')

@section('header-title', 'Contact Settings')

@section('content')
<div class="space-y-8">
    <div class="bg-distro-admin-card rounded-lg p-6 border border-distro-admin-border">
        <h2 class="text-xl font-semibold text-white mb-4">Contact Information Settings</h2>
        <p class="text-gray-400 mb-6">Manage contact information and support details displayed on the distribution contact page.</p>
        
        <form method="POST" action="{{ route('admin.distribution.content.contact.update') }}" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Support Email</label>
                    <input type="email" 
                           name="support_email" 
                           value="support@musicdistribution.com"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Response Time</label>
                    <input type="text" 
                           name="response_time" 
                           value="2-4 hours"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Artist Success Email</label>
                    <input type="email" 
                           name="success_email" 
                           value="success@musicdistribution.com"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Success Team Hours</label>
                    <input type="text" 
                           name="success_hours" 
                           value="Monday-Friday 9AM-6PM"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Technical Support Email</label>
                    <input type="email" 
                           name="tech_email" 
                           value="tech@musicdistribution.com"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Emergency Contact Email</label>
                    <input type="email" 
                           name="urgent_email" 
                           value="urgent@musicdistribution.com"
                           class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Emergency Phone Number</label>
                <input type="text" 
                       name="urgent_phone" 
                       value="+1 (555) URGENT"
                       class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
            </div>
            
            <hr class="border-distro-admin-border">
            
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Social Media Links</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Twitter URL</label>
                        <input type="url" 
                               name="twitter_url" 
                               value="https://twitter.com/musicdistro"
                               class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Instagram URL</label>
                        <input type="url" 
                               name="instagram_url" 
                               value="https://instagram.com/musicdistro"
                               class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Facebook URL</label>
                        <input type="url" 
                               name="facebook_url" 
                               value="https://facebook.com/musicdistro"
                               class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">YouTube URL</label>
                        <input type="url" 
                               name="youtube_url" 
                               value="https://youtube.com/musicdistro"
                               class="w-full px-4 py-3 bg-distro-admin-bg border border-distro-admin-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-distro-admin-accent focus:border-distro-admin-accent">
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-4">
                <button type="button" 
                        class="px-6 py-2 border border-distro-admin-border text-gray-300 rounded-lg hover:bg-distro-admin-bg transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-distro-admin-accent hover:bg-indigo-600 text-white rounded-lg transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection