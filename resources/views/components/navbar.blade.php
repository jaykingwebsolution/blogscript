<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="#" class="text-2xl font-bold text-primary">BlogScript</a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="#" class="text-gray-900 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Music</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Artists</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Gist</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Video</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">News</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                    <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium transition-colors">Privacy Policy</a>
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="text-gray-600 hover:text-primary focus:outline-none focus:text-primary">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden pb-3">
            <div class="space-y-1">
                <a href="#" class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Music</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Artists</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Gist</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Video</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">News</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Contact</a>
                <a href="#" class="text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-base font-medium">Privacy Policy</a>
            </div>
        </div>
    </div>
</nav>