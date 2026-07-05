<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Productivity & To-Do List</title>
    
    <!-- Import Google Fonts: Quicksand & Fraunces -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100..900;1,9..144,100..900&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            color: #333;
            background-color: #FAFAFA;
        }
        .font-coquette {
            font-family: 'Fraunces', serif;
            font-weight: 700;
        }
        
        /* Custom Colors: Green and Pink Theme */
        .bg-cream { background-color: #fdfaf6; }
        .bg-pink { background-color: #f9d5e1; } /* Slightly more vibrant pastel pink */
        .bg-green { background-color: #d1e2a5; } /* Aesthetic pastel green */
        
        /* Box Colors */
        .box-green { background-color: #c9df8a; }
        .box-pink { background-color: #fdc3da; }
        .box-purple { background-color: #d2bee5; }
        .box-blue { background-color: #a8d5e2; }
        
        .text-dark { color: #1a1a1a; }
        
        .wavy-underline {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 20'%3E%3Cpath d='M0,10 Q25,20 50,10 T100,10' fill='none' stroke='%23f9d5e1' stroke-width='4' stroke-linecap='round'/%3E%3C/svg%3E") repeat-x bottom;
            background-size: 50px 10px;
            padding-bottom: 12px;
        }

        .flower-icon {
            display: inline-block;
            animation: spin-slow 12s linear infinite;
        }
        @keyframes spin-slow { 100% { transform: rotate(360deg); } }

        /* Morphing shape */
        .wavy-blob {
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation: morph 8s ease-in-out infinite;
        }
        
        @keyframes morph {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }

        /* Tomato Animation */
        .tomato-bounce {
            display: inline-block;
            font-size: 14rem;
            animation: bounce-float 3s ease-in-out infinite;
            filter: drop-shadow(0 20px 20px rgba(0,0,0,0.15));
        }

        @media (min-width: 640px) {
            .tomato-bounce { font-size: 18rem; }
        }

        @keyframes bounce-float {
            0%, 100% { transform: translateY(0) rotate(-5deg) scale(1); }
            50% { transform: translateY(-30px) rotate(5deg) scale(1.05); }
        }

        /* Cute Inner Dashed Border for Features */
        .inner-dashed {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
        }
        .inner-dashed::after {
            content: '';
            position: absolute;
            top: 8px; left: 8px; right: 8px; bottom: 8px;
            border: 2px dashed rgba(255,255,255,0.7);
            border-radius: 12px;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col bg-cream">
    
    <!-- Announcement Bar -->
    <div class="bg-pink text-dark text-xs font-bold tracking-widest py-2 text-center uppercase relative z-20">
        WELCOME TO POMOTASKY - YOUR PRODUCTIVITY BESTIE 🎀
    </div>

    <!-- Header -->
    <header class="bg-white py-4 relative z-20">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            
            <!-- Search Icon (Left) -->
            <div class="w-1/4 hidden md:block">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <!-- Logo -->
            <div class="w-full md:w-2/4 text-center">
                <h1 class="font-coquette text-4xl text-dark flex items-center justify-center gap-1">
                    PomoTasky<span class="text-[#f98cb6] text-2xl">✿</span>
                </h1>
            </div>

            <!-- Icons Top Right -->
            <div class="w-1/4 hidden md:flex items-center justify-end gap-4 text-sm font-bold tracking-widest uppercase">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-500 hover:text-pink-500 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-pink-500 transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-pink text-dark px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow-sm">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
        
        <!-- Navbar -->
        <nav class="bg-green w-full mt-4">
            <div class="max-w-4xl mx-auto px-4 flex flex-wrap justify-center py-3 text-dark text-xs font-bold tracking-widest uppercase" style="gap: 2rem;">
                <a href="#" class="hover:text-white transition">HOME</a>
                <a href="#about" class="hover:text-white transition">ABOUT</a>
                <a href="#features" class="hover:text-white transition">FEATURES</a>
                <a href="#discover" class="hover:text-white transition">DISCOVER</a>
                <a href="{{ route('register') }}" class="hover:text-white transition">ACCOUNT</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-[500px] sm:min-h-[600px] flex items-center py-12 sm:py-16 overflow-hidden">
        <!-- Floating Stars/Flowers -->
        <div class="absolute top-10 left-10 text-[#f98cb6] text-xl opacity-60">✨</div>
        <div class="absolute top-1/4 right-20 text-[#f98cb6] text-3xl opacity-80 flower-icon">✿</div>
        <div class="absolute bottom-20 right-1/3 text-white text-4xl opacity-80 flower-icon">✿</div>
        <div class="absolute top-10 right-1/3 text-green-300 text-xl opacity-80">✨</div>
        <div class="absolute top-1/2 left-1/3 text-[#f98cb6] text-4xl opacity-40 flower-icon">✿</div>

        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10 w-full">
            
            <!-- Left: Animated Tomato -->
            <div class="flex justify-center items-center relative">
                <!-- Background Blob -->
                <div class="absolute inset-0 bg-white/50 w-[90%] h-[90%] m-auto wavy-blob z-0"></div>
                <div class="absolute inset-0 bg-pink/20 w-[100%] h-[100%] m-auto wavy-blob z-0" style="animation-duration: 12s; animation-direction: reverse;"></div>
                
                <div class="relative z-10 flex items-center justify-center">
                    <span class="tomato-bounce">🍅</span>
                </div>
            </div>

            <!-- Right: Text Content -->
            <div class="text-center md:text-left flex flex-col items-center md:items-start pl-0 md:pl-12">
                <p class="text-[#f98cb6] font-bold tracking-widest uppercase mb-2 text-sm">PomoTasky Aplikasi Manajemen Tugas</p>
                <h2 class="font-coquette text-dark mb-4" style="font-size: 3.5rem; line-height: 1.1;">
                    Fokus dan Selesaikan Lebih Banyak Tugas Hari Ini
                </h2>
                <div class="wavy-underline w-48 mb-6 mx-auto md:mx-0"></div>
                <p class="text-gray-600 mb-8 max-w-lg text-lg leading-relaxed">
                    Tingkatkan produktivitas Anda dengan perpaduan sempurna antara teknik Pomodoro, manajemen tugas yang rapi, dan sistem pencapaian yang menyenangkan.
                </p>
                
                <a href="{{ route('register') }}" class="bg-pink text-dark font-bold tracking-widest text-sm uppercase px-8 py-4 rounded-full hover:bg-opacity-80 transition transform hover:scale-105 shadow-sm inline-block mt-2">
                    EXPLORE NOW
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 relative z-10 bg-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-coquette text-4xl sm:text-5xl text-dark mb-6">What is PomoTasky? 🎀</h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-8 max-w-2xl mx-auto">
                PomoTasky is your aesthetic productivity companion! We combine the power of the <strong>Pomodoro Technique</strong> with an easy-to-use <strong>To-Do List</strong> to help you stay focused, organized, and motivated. Say goodbye to boring task managers and hello to a cute, stress-free workflow!
            </p>
            <div class="flex justify-center gap-4 text-3xl opacity-80">
                <span>🍅</span>
                <span>✨</span>
                <span>📝</span>
            </div>
        </div>
    </section>

    <!-- Detailed Features Grid -->
    <section id="features" class="py-20 relative z-10 bg-cream">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-coquette text-4xl sm:text-5xl text-dark mb-4">Cute Features ✨</h2>
                <p class="text-gray-500">Everything you need to be productive and happy.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                
                <!-- Feature 1: Timer -->
                <div class="box-green inner-dashed p-8 flex flex-col items-center text-center shadow-sm group hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-5xl text-white mb-4 drop-shadow-sm group-hover:scale-110 transition">🍅</div>
                    <h3 class="font-coquette text-white text-2xl leading-tight mb-3 drop-shadow-sm">Pomodoro<br>Timer</h3>
                    <p class="text-white/90 text-sm font-medium">Stay locked in with customizable focus sessions and short breaks.</p>
                    <div class="absolute top-3 left-3 text-white text-xl opacity-60">🌿</div>
                </div>

                <!-- Feature 2: To-Do -->
                <div class="box-pink inner-dashed p-8 flex flex-col items-center text-center shadow-sm group hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-5xl text-white mb-4 drop-shadow-sm group-hover:scale-110 transition">📝</div>
                    <h3 class="font-coquette text-white text-2xl leading-tight mb-3 drop-shadow-sm">Task<br>Manager</h3>
                    <p class="text-white/90 text-sm font-medium">Organize your daily tasks easily. Tick them off and feel the satisfaction!</p>
                    <div class="absolute top-3 right-3 text-white text-xl opacity-60">♥</div>
                </div>

                <!-- Feature 3: Calendar -->
                <div class="box-purple inner-dashed p-8 flex flex-col items-center text-center shadow-sm group hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-5xl text-white mb-4 drop-shadow-sm group-hover:scale-110 transition">📅</div>
                    <h3 class="font-coquette text-white text-2xl leading-tight mb-3 drop-shadow-sm">Google<br>Calendar</h3>
                    <p class="text-white/90 text-sm font-medium">Sync seamlessly with Google Calendar to manage all your events in one place.</p>
                </div>

                <!-- Feature 4: Stats -->
                <div class="box-blue inner-dashed p-8 flex flex-col items-center text-center shadow-sm group hover:-translate-y-2 transition-transform duration-300">
                    <div class="text-5xl text-white mb-4 drop-shadow-sm group-hover:scale-110 transition">🏆</div>
                    <h3 class="font-coquette text-white text-2xl leading-tight mb-3 drop-shadow-sm">Track<br>Stats</h3>
                    <p class="text-white/90 text-sm font-medium">Monitor your productivity over time and earn cool badges for your hard work!</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Collection Section -->
    <section id="discover" class="bg-pink relative py-20 overflow-hidden">
        <!-- Wavy top overlay -->
        <div class="absolute -top-1 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[50px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-cream" style="fill: #fdfaf6;"></path>
            </svg>
        </div>
        
        <div class="absolute top-20 left-10 text-white text-4xl opacity-50 flower-icon">✿</div>
        <div class="absolute bottom-10 right-10 text-white text-4xl opacity-50 flower-icon">✿</div>

        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10 pt-10">
            
            <!-- Left Text -->
            <div class="text-center md:text-right flex flex-col items-center md:items-end">
                <p class="font-coquette text-white text-3xl mb-1 italic">the</p>
                <h2 class="font-coquette text-5xl sm:text-6xl text-dark leading-tight mb-2">
                    Dreamiest <br>
                </h2>
                <h2 class="font-coquette text-5xl sm:text-6xl text-white leading-tight mb-8">
                    productivity
                </h2>
                
                <a href="{{ route('register') }}" class="bg-green text-dark font-bold tracking-widest text-xs uppercase px-6 py-2.5 rounded-full hover:bg-opacity-80 transition shadow-sm inline-block">
                    GET THE APP
                </a>
            </div>

            <!-- Right Image/Mockup (Tomato) -->
            <div class="relative flex justify-center items-center">
                <div class="relative z-10 flex items-center justify-center">
                    <span class="tomato-bounce" style="font-size: 12rem;">🍅</span>
                </div>
                <div class="absolute -bottom-8 -right-4 text-white text-6xl drop-shadow-lg z-20" style="animation: pulse 2s infinite;">♥</div>
                <div class="absolute top-1/4 -left-8 text-white text-4xl flower-icon drop-shadow-md z-20">✿</div>
            </div>
        </div>
    </section>

    <!-- Subscribe / Footer Banner -->
    <section class="bg-green py-20 text-center relative overflow-hidden flex-grow flex flex-col justify-center">
        <!-- Floating decors -->
        <div class="absolute top-10 left-1/4 text-white text-2xl opacity-70 flower-icon">✿</div>
        <div class="absolute bottom-12 right-1/4 text-white text-2xl opacity-70 flower-icon">✿</div>
        <div class="absolute top-1/3 right-1/3 text-white text-lg">✨</div>
        
        <p class="text-dark text-xs font-bold tracking-widest uppercase mb-2">JOIN THE LIST <span class="flower-icon inline-block ml-1">✿</span></p>
        <h2 class="font-coquette text-5xl sm:text-6xl text-dark mb-8">Subscribe</h2>
        
        <div class="flex justify-center mb-6 z-10 relative">
            <div class="bg-white px-6 py-3 shadow-sm border border-white flex items-center gap-2 cursor-text w-64 justify-center">
                <span class="text-green-500">💌</span>
            </div>
        </div>
        
        <p class="text-xs text-dark/80 font-medium max-w-sm mx-auto z-10 relative">Receive exclusive updates on new features and aesthetic drops!</p>
    </section>

    <footer class="bg-green py-4 text-center border-t border-white/30">
        <p class="text-dark/50 text-xs font-bold tracking-widest uppercase">© 2026 PomoTasky Team</p>
    </footer>

</body>
</html>
