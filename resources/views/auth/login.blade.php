<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - BlogScript</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #10b981 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .spotify-green { background: #1db954; }
        .spotify-green:hover { background: #1ed760; }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="7" cy="7" r="3"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Login Modal -->
    <div class="relative z-10 w-full max-w-md mx-auto">
        <!-- Modal Content -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 transform transition-all duration-300">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Welcome back</h1>
                <p class="text-blue-100">Sign in to your BlogScript account</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500 bg-opacity-20 border border-green-400 border-opacity-50 rounded-lg text-green-100 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-blue-100 mb-2">Email address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                           placeholder="Enter your email"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-blue-100 mb-2">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-3 pr-12 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                               placeholder="Enter your password"
                               required>
                        <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg x-show="!showPassword" class="w-5 h-5 text-blue-200 hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5 text-blue-200 hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember" 
                           class="h-4 w-4 text-green-400 focus:ring-green-400 border-white border-opacity-30 rounded bg-white bg-opacity-10">
                    <label for="remember" class="ml-2 block text-sm text-blue-100">Remember me</label>
                </div>

                <!-- Sign In Button -->
                <button type="submit" 
                        class="w-full spotify-green text-white font-semibold py-3 px-4 rounded-lg hover:scale-[1.02] transition-all duration-200 shadow-lg">
                    Sign In
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-8 mb-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white border-opacity-30"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-transparent text-blue-100">Don't have an account?</span>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <a href="{{ route('register') }}" 
                   class="inline-block w-full py-3 px-4 border-2 border-white border-opacity-30 text-white font-semibold rounded-lg hover:bg-white hover:bg-opacity-10 hover:border-opacity-50 transition-all duration-200">
                    Create Account
                </a>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-blue-200 hover:text-white text-sm transition">
                    ← Back to Homepage
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Music Notes Animation -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 left-1/4 text-white opacity-20 animate-pulse">♪</div>
        <div class="absolute top-1/3 right-1/4 text-white opacity-15 animate-bounce" style="animation-delay: 1s;">♫</div>
        <div class="absolute bottom-1/4 left-1/3 text-white opacity-10 animate-pulse" style="animation-delay: 2s;">♪</div>
        <div class="absolute bottom-1/3 right-1/3 text-white opacity-20 animate-bounce" style="animation-delay: 3s;">♫</div>
    </div>
</body>
</html>