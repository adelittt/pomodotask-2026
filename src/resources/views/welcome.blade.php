<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Focus and Get Things Done</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FAFAFA;
            color: #1F2937;
        }
        
        .dark body {
            background-color: #111827;
            color: #F9FAFB;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 10px 30px rgba(244, 114, 182, 0.1);
        }

        .dark .glass-panel {
            background: rgba(31, 41, 55, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .bento-card {
            border-radius: 1.5rem; /* 3xl */
            padding: 2rem;
            background: white;
            box-shadow: 0 20px 60px rgba(0,0,0,0.04);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .dark .bento-card {
            background: #1F2937;
        }

        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 65px rgba(0,0,0,0.08);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Floating animation for elements in dashboard mockup */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        /* Progress Ring Animation */
        @keyframes fillProgress {
            from { stroke-dashoffset: 283; }
            to { stroke-dashoffset: 31; } /* ~89% of 283 */
        }
        .progress-ring-circle {
            transition: stroke-dashoffset 1s ease-in-out;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
            stroke-dasharray: 283;
            stroke-dashoffset: 283;
            animation: fillProgress 1.5s ease-out forwards 0.5s;
        }
        
        @keyframes tomatoWiggle {
            0%, 100% { transform: rotate(-10deg) scale(1); }
            50% { transform: rotate(10deg) scale(1.1); }
        }
        .animate-tomato {
            display: inline-block;
            animation: tomatoWiggle 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="antialiased min-h-[100dvh] flex flex-col w-full overflow-x-hidden selection:bg-pomo-pink selection:text-white transition-colors duration-300">
    
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-panel border-b-0">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <span class="text-3xl animate-tomato drop-shadow-sm">🍅</span>
                    <span class="text-2xl font-bold tracking-tight">PomoTasky</span>
                </div>
                
                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-gray-600 hover:text-pomo-pink font-medium transition-colors dark:text-gray-300 dark:hover:text-white">Features</a>
                    
                    <div class="flex items-center gap-4 border-l border-gray-200 dark:border-gray-700 pl-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-pomo-pink font-medium transition-colors dark:text-gray-300 dark:hover:text-white">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-pomo-pink font-medium transition-colors dark:text-gray-300 dark:hover:text-white">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-pomo-pink hover:bg-pink-500 text-white px-6 py-2.5 rounded-full font-semibold transition-all hover:scale-105 active:scale-95 shadow-md shadow-pink-200/50 dark:shadow-none">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 md:pt-40 md:pb-28 px-5 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
        
        <!-- Left Text -->
        <div class="flex-1 w-full text-left z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-pomo-soft-pink text-pomo-pink font-semibold text-sm mb-6 animate-fade-in-up dark:bg-pink-900/30">
                <i class="ph ph-sparkle"></i>
                Focus your mind, complete your tasks
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight leading-[1.1] mb-6 animate-fade-in-up delay-100">
                Master your time.<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-pomo-pink to-pomo-green">Achieve more.</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 leading-8 mb-10 max-w-lg animate-fade-in-up delay-200">
                A premium productivity app that combines the Pomodoro technique with smart task management. Designed for students, freelancers, and professionals.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center gap-4 animate-fade-in-up delay-300">
                <a href="{{ route('register') }}" class="w-full sm:w-auto text-center bg-pomo-pink hover:bg-pink-500 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all hover:scale-105 active:scale-95 shadow-lg shadow-pink-200/50 dark:shadow-none flex justify-center items-center gap-2">
                    Start Focusing <i class="ph ph-arrow-right font-bold"></i>
                </a>
                <a href="#features" class="w-full sm:w-auto text-center px-8 py-4 rounded-full font-semibold text-lg border-2 border-gray-200 hover:border-gray-300 dark:border-gray-700 dark:hover:border-gray-600 transition-all text-gray-700 dark:text-gray-300 flex justify-center items-center gap-2">
                    <i class="ph ph-play-circle text-xl"></i> See How It Works
                </a>
            </div>
        </div>

        <!-- Right Dashboard Mockup -->
        <div class="flex-1 w-full relative animate-fade-in-up delay-300">
            <!-- Background glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-[400px] max-h-[400px] bg-gradient-to-tr from-pomo-pink/20 to-pomo-green/20 blur-3xl rounded-full -z-10"></div>
            
            <!-- Main Mockup -->
            <div class="glass-panel rounded-3xl p-6 sm:p-8 animate-float relative z-10 w-full overflow-hidden">
                <!-- Top Bar -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Today's Focus</h3>
                        <div class="text-4xl font-bold font-mono tracking-tight text-gray-900 dark:text-white mt-1">25:00</div>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-pomo-soft-green flex items-center justify-center text-pomo-green">
                        <i class="ph ph-timer text-2xl"></i>
                    </div>
                </div>

                <!-- Progress Ring -->
                <div class="flex justify-center mb-8 relative">
                    <svg class="w-40 h-40" viewBox="0 0 100 100">
                        <!-- Background circle -->
                        <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="8" class="text-gray-100 dark:text-gray-800" />
                        <!-- Progress circle -->
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#F472B6" stroke-width="8" stroke-linecap="round" class="progress-ring-circle" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold">89%</span>
                        <span class="text-xs text-gray-500">Completed</span>
                    </div>
                </div>

                <!-- Today's Tasks -->
                <div>
                    <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                        <i class="ph-fill ph-list-checks text-pomo-pink"></i> Today's Tasks
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                            <div class="w-5 h-5 rounded-full border-2 border-pomo-green flex items-center justify-center bg-pomo-green text-white">
                                <i class="ph ph-check text-xs"></i>
                            </div>
                            <span class="line-through text-gray-400 dark:text-gray-500">Design UI System</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600"></div>
                            <span class="font-medium">Write Article Draft</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600"></div>
                            <span class="font-medium text-gray-600 dark:text-gray-300">Client Meeting</span>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Stats Badge -->
                <div class="absolute -right-6 -bottom-6 bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-xl border border-gray-100 dark:border-gray-700 flex items-center gap-4 animate-float" style="animation-delay: 1s;">
                    <div class="bg-pomo-soft-pink w-10 h-10 rounded-full flex items-center justify-center text-pomo-pink">
                        <i class="ph-fill ph-fire text-xl"></i>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase font-semibold">Current Streak</div>
                        <div class="text-xl font-bold">12 Days</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Features Section -->
    <section id="features" class="py-20 md:py-28 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">Everything you need to focus.</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    A carefully curated set of tools designed to remove distractions and help you achieve deep work states effortlessly.
                </p>
            </div>

            <!-- Bento Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                
                <!-- Big Feature 1 -->
                <div class="bento-card md:col-span-2 flex flex-col justify-between overflow-hidden relative group">
                    <div class="relative z-10 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-pomo-soft-green text-pomo-green flex items-center justify-center mb-6">
                            <i class="ph-fill ph-timer text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">Customizable Timer</h3>
                        <p class="text-gray-600 dark:text-gray-400">Set your ideal work intervals and break durations. The timer stays in sync across all your devices, so you never lose track.</p>
                    </div>
                    <!-- Decorative Graphic -->
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-pomo-green/10 rounded-full blur-3xl group-hover:bg-pomo-green/20 transition-colors"></div>
                </div>

                <!-- Feature 2 -->
                <div class="bento-card flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-pomo-soft-pink text-pomo-pink flex items-center justify-center mb-6">
                            <i class="ph-fill ph-chart-line-up text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Rich Analytics</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Visualize your productivity trends, peak focus hours, and completion rates over time.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bento-card flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 dark:bg-blue-900/30 flex items-center justify-center mb-6">
                            <i class="ph-fill ph-calendar-blank text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Google Calendar</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Two-way sync with Google Calendar ensures your events and tasks live in harmony.</p>
                    </div>
                </div>

                <!-- Big Feature 4 -->
                <div class="bento-card md:col-span-2 flex flex-col md:flex-row items-center gap-8 bg-gray-900 text-white dark:bg-gray-800">
                    <div class="flex-1">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center mb-6">
                            <i class="ph-fill ph-moon-stars text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">Focus Mode</h3>
                        <p class="text-gray-400">Enter a distraction-free full-screen environment. Block notifications and immerse yourself fully into the current task at hand.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="ph-fill ph-check-circle text-2xl text-pomo-pink"></i>
                        <span class="text-xl font-bold">PomoTasky</span>
                    </div>
                    <p class="text-gray-500 text-sm">Elevating productivity through mindful focus and elegant design.</p>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Download Apps</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Pomodoro Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-pomo-pink transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-sm text-gray-400 pt-8 border-t border-gray-100 dark:border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p>&copy; 2026 PomoTasky. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"><i class="ph-fill ph-twitter-logo text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"><i class="ph-fill ph-github-logo text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
