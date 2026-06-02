<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Fokus dengan Gaya Pastel Soft</title>
    <!-- Import Google Fonts Quicksand & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Quicksand', 'Montserrat', sans-serif;
        }
    </style>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-[#FFFDF6] min-h-screen text-gray-700 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar Premium Pastel -->
        <nav class="bg-white border-b border-pastel-peach/30 shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-2">
                        <span class="text-3xl">🍅</span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">PomoTasky</span>
                    </div>
                    <div class="flex items-center space-x-6">
                        @auth
                            <div class="flex items-center space-x-3 bg-pastel-lavender/40 px-3 py-1.5 rounded-full">
                                <img src="{{ auth()->user()->getFilamentAvatarUrl() }}" class="w-8 h-8 rounded-full border-2 border-white shadow-sm" alt="Avatar">
                                <span class="text-sm font-semibold text-gray-600">{{ auth()->user()->name }}</span>
                            </div>
                            
                            @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
                                <a href="/admin" class="text-sm font-semibold text-blue-500 hover:text-blue-700 flex items-center gap-1">
                                    ⚙️ Panel Admin
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-red-400 hover:text-red-600 transition duration-150 ease-in-out">
                                    Keluar 🚪
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow py-8">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-pastel-peach/20 py-4 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} PomoTasky - Teman Fokus Produktifmu 🌸
        </footer>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>