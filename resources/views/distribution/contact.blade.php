@extends('layouts.distribution')

@section('title', 'Contact Distribution Support')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 distro-gradient rounded-full mb-6">
                <i class="fas fa-envelope text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Get in <span class="text-spotify-green">Touch</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Have questions about distribution? Need support with your account? Our team is here to help you succeed.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-distro-gray rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6">Send us a Message</h2>
                
                <form class="space-y-6" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <input type="hidden" name="source" value="distribution">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                        <input type="text" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 bg-distro-dark border border-distro-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green transition-colors"
                               placeholder="Your full name">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 bg-distro-dark border border-distro-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green transition-colors"
                               placeholder="your@email.com">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                        <select name="subject" 
                                required
                                class="w-full px-4 py-3 bg-distro-dark border border-distro-border rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green transition-colors">
                            <option value="">Select a topic</option>
                            <option value="distribution-support">Distribution Support</option>
                            <option value="technical-issue">Technical Issue</option>
                            <option value="payment-inquiry">Payment Inquiry</option>
                            <option value="account-help">Account Help</option>
                            <option value="partnership">Partnership Inquiry</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                        <textarea name="message" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-3 bg-distro-dark border border-distro-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-spotify-green focus:border-spotify-green transition-colors"
                                  placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full py-3 distro-gradient text-white font-semibold rounded-lg hover:scale-[1.02] transition-transform">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Information & Support -->
            <div class="space-y-8">
                <!-- Contact Cards -->
                <div class="space-y-6">
                    <div class="bg-distro-gray rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-spotify-green/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-headset text-spotify-green text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-white mb-2">24/7 Support</h3>
                                <p class="text-gray-300 mb-4">
                                    Our distribution support team is available around the clock to help with any questions or issues.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <p>Email: support@musicdistribution.com</p>
                                    <p>Average response time: 2-4 hours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-distro-gray rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-distro-accent/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-rocket text-distro-accent text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-white mb-2">Artist Success Team</h3>
                                <p class="text-gray-300 mb-4">
                                    Get personalized advice on growing your music career and maximizing your distribution strategy.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <p>Email: success@musicdistribution.com</p>
                                    <p>Available: Monday-Friday 9AM-6PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-distro-gray rounded-2xl p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-tools text-yellow-500 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-white mb-2">Technical Support</h3>
                                <p class="text-gray-300 mb-4">
                                    Having technical issues with uploads or account access? Our tech team can help.
                                </p>
                                <div class="text-sm text-gray-400">
                                    <p>Email: tech@musicdistribution.com</p>
                                    <p>Priority support for urgent issues</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Help -->
                <div class="bg-distro-gray rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Quick Help Topics</h3>
                    <div class="space-y-3">
                        <a href="#" class="block p-3 bg-distro-dark rounded-lg hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 group-hover:text-white">How to upload my first song</span>
                                <i class="fas fa-chevron-right text-gray-500 group-hover:text-white"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block p-3 bg-distro-dark rounded-lg hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 group-hover:text-white">Track my distribution status</span>
                                <i class="fas fa-chevron-right text-gray-500 group-hover:text-white"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block p-3 bg-distro-dark rounded-lg hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 group-hover:text-white">Request a payout</span>
                                <i class="fas fa-chevron-right text-gray-500 group-hover:text-white"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block p-3 bg-distro-dark rounded-lg hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 group-hover:text-white">Update my music metadata</span>
                                <i class="fas fa-chevron-right text-gray-500 group-hover:text-white"></i>
                            </div>
                        </a>
                        
                        <a href="#" class="block p-3 bg-distro-dark rounded-lg hover:bg-gray-700 transition-colors group">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 group-hover:text-white">Understanding analytics</span>
                                <i class="fas fa-chevron-right text-gray-500 group-hover:text-white"></i>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="bg-distro-gray rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Follow Us</h3>
                    <p class="text-gray-300 mb-4">
                        Stay updated with the latest distribution news, tips, and success stories from our community.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-[#1DA1F2] rounded-lg flex items-center justify-center hover:scale-110 transition-transform">
                            <i class="fab fa-twitter text-white"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-[#833AB4] rounded-lg flex items-center justify-center hover:scale-110 transition-transform">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-[#1877F2] rounded-lg flex items-center justify-center hover:scale-110 transition-transform">
                            <i class="fab fa-facebook text-white"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-[#FF0000] rounded-lg flex items-center justify-center hover:scale-110 transition-transform">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">Common Questions</h2>
                <p class="text-gray-400 text-lg">Find quick answers to frequently asked questions</p>
            </div>
            
            <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
                <div class="bg-distro-gray rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-3">How can I track my submission status?</h3>
                    <p class="text-gray-300">
                        Log into your dashboard and navigate to "My Submissions" to see real-time status updates for all your releases.
                    </p>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-3">When will I receive my earnings?</h3>
                    <p class="text-gray-300">
                        Earnings are updated monthly and available for instant payout once they reach the minimum threshold of $10.
                    </p>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-3">Can I edit my music after distribution?</h3>
                    <p class="text-gray-300">
                        You can update metadata at any time, but audio files cannot be changed. You'll need to submit a new version if needed.
                    </p>
                </div>
                
                <div class="bg-distro-gray rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-3">What if my music is rejected?</h3>
                    <p class="text-gray-300">
                        You'll receive detailed feedback on why it was rejected and instructions on how to fix any issues before resubmission.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Emergency Contact -->
        <div class="mt-16 bg-red-900/20 border border-red-800 rounded-3xl p-8 text-center">
            <div class="max-w-2xl mx-auto">
                <i class="fas fa-exclamation-triangle text-red-400 text-3xl mb-4"></i>
                <h2 class="text-2xl font-bold text-white mb-4">Urgent Issue?</h2>
                <p class="text-gray-300 mb-6">
                    If you have an urgent issue that requires immediate attention (such as copyright claims or takedown requests), contact our emergency support line.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:urgent@musicdistribution.com" 
                       class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-2"></i>
                        urgent@musicdistribution.com
                    </a>
                    <a href="tel:+1-555-URGENT" 
                       class="inline-flex items-center px-6 py-3 border-2 border-red-600 text-red-400 font-semibold rounded-lg hover:bg-red-600 hover:text-white transition-colors">
                        <i class="fas fa-phone mr-2"></i>
                        +1 (555) URGENT
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection