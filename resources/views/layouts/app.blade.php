<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Music Platform - Discover, Upload, Stream')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Tailwind CSS CDN for development -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactive components -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7C3AED',
                        secondary: '#EC4899',
                        accent: '#F59E0B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    @include('components.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')
    
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>