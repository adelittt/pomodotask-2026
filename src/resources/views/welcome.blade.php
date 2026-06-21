<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Fokus dengan Gaya Pastel Soft</title>
    
    <!-- Import Google Fonts Quicksand & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    <style>
        body {
            font-family: 'Quicksand', 'Montserrat', sans-serif;
            color: #4b5563; /* text-gray-600 */
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        .hero-bg {
            /* Vibrant Pink and Green Gradient */
            background: linear-gradient(135deg, #FFE4E8 0%, #D1FAE5 100%);
        }
        .tomato-bounce {
            animation: bounce-slow 3s infinite ease-in-out;
        }
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        /* Custom arbitrary colors to ensure they work even if tailwind didn't compile */
        .btn-emerald {
            background-color: #10B981 !important;
            color: white !important;
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.3) !important;
        }
        .btn-emerald:hover {
            background-color: #059669 !important;
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.5) !important;
        }
        .text-pink-accent {
            color: #F46B7E !important;
        }
        .text-emerald-accent {
            color: #10B981 !important;
        }
        .bg-pink-accent {
            background-color: #F46B7E !important;
        }
        .icon-box-green {
            background-color: #D1FAE5 !important;
            border-color: #A7F3D0 !important;
        }
        .icon-box-pink {
            background-color: #FFE4E8 !important;
            border-color: #FECDD3 !important;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col hero-bg">
    
    <!-- Navigation -->
    <nav class="w-full px-6 py-4 flex items-center justify-between lg:px-12 z-50 relative">
        <div class="flex items-center gap-3">
            <span class="text-3xl drop-shadow-sm flex-shrink-0">🍅</span>
            <span class="text-2xl font-extrabold text-gray-800 tracking-tight whitespace-nowrap">Pomo<span class="text-pink-accent">Tasky</span></span>
        </div>
        
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-pink-accent font-bold hover:text-red-600 transition-colors">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 font-semibold hover:text-[#F46B7E] transition-colors hidden sm:block">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-pink-accent text-white px-5 py-2.5 rounded-full font-bold shadow-md hover:bg-red-500 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Daftar Gratis
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-16 lg:py-24 z-10 relative text-center">
        <div class="max-w-3xl mx-auto space-y-8">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 border border-green-100 shadow-sm text-sm font-semibold text-emerald-accent mb-4">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-accent"></span>
                </span>
                Aplikasi Pomodoro & Manajemen Tugas
            </div>
            
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Fokus dan Selesaikan <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F46B7E] to-[#10B981]">Lebih Banyak Hari Ini</span>
            </h1>
            
            <p class="text-lg sm:text-xl text-gray-700 max-w-2xl mx-auto leading-relaxed font-medium">
                Tingkatkan produktivitas Anda dengan perpaduan sempurna antara teknik Pomodoro, manajemen tugas yang rapi, dan sistem pencapaian yang menyenangkan.
            </p>
            
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="btn-emerald w-full sm:w-auto px-8 py-4 rounded-full font-bold text-lg transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    Mulai Fokus Sekarang <span class="text-xl">🍅</span>
                </a>
                <a href="#fitur" class="w-full sm:w-auto bg-white text-gray-700 border border-white/50 px-8 py-4 rounded-full font-bold text-lg shadow-sm hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                    Pelajari Fitur
                </a>
            </div>
            
        </div>
    </main>

    <!-- Features Showcase -->
    <section id="fitur" class="w-full max-w-7xl mx-auto px-6 lg:px-12 py-16 z-10 relative">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Fitur Utama PomoTasky</h2>
            <p class="text-gray-700 font-medium max-w-2xl mx-auto">Semua yang Anda butuhkan untuk mengatur waktu dan mencapai target harian dengan cara yang menyenangkan.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="glass-card rounded-3xl p-8 transition-transform hover:-translate-y-2 duration-300">
                <div class="w-14 h-14 icon-box-pink rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border">
                    ⏱️
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pomodoro Timer</h3>
                <p class="text-gray-700 leading-relaxed text-sm">Gunakan teknik Pomodoro standar (25 menit fokus, 5 menit istirahat) atau sesuaikan durasi sesuai ritme kerja Anda.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="glass-card rounded-3xl p-8 transition-transform hover:-translate-y-2 duration-300">
                <div class="w-14 h-14 icon-box-green rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border">
                    📝
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Manajemen Tugas</h3>
                <p class="text-gray-700 leading-relaxed text-sm">Catat tugas, tetapkan tenggat waktu, dan hubungkan tugas Anda langsung ke sesi Pomodoro untuk melacak estimasi waktu.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="glass-card rounded-3xl p-8 transition-transform hover:-translate-y-2 duration-300">
                <div class="w-14 h-14 icon-box-pink rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border">
                    🏅
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Sistem Pencapaian</h3>
                <p class="text-gray-700 leading-relaxed text-sm">Kumpulkan badge unik (seperti *Fokus Master* atau *Pomodoro Pro*) dan selesaikan tantangan harian agar lebih termotivasi.</p>
            </div>
        </div>
        
        <!-- Mockup Idea -->
        <div class="mt-20 relative w-full rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-[8px] border-white/60 glass-card">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#FFE4E8]/50 to-[#D1FAE5]/50 opacity-50"></div>
            <div class="p-4 sm:p-8 flex items-center justify-center min-h-[300px] sm:min-h-[400px]">
                <div class="text-center relative">
                    <div class="text-[80px] sm:text-[120px] tomato-bounce drop-shadow-xl inline-block">🍅</div>
                    <div class="mt-4 bg-white/80 backdrop-blur-md rounded-2xl p-4 shadow-sm inline-block border border-red-50">
                        <p class="font-bold text-pink-accent text-2xl sm:text-4xl">25:00</p>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">Sesi Fokus Sedang Berjalan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full bg-white/50 backdrop-blur-md border-t border-white/60 py-12 mt-auto z-10 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl">🍅</span>
                <span class="text-xl font-extrabold text-gray-800 tracking-tight">Pomo<span class="text-pink-accent">Tasky</span></span>
            </div>
            <p class="text-gray-600 text-sm font-medium">© 2026 PomoTasky. Dibuat dengan 💖 untuk produktivitas Anda.</p>
            <div class="flex gap-4 text-sm font-medium">
                <a href="#" class="text-gray-600 hover:text-pink-accent transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="text-gray-600 hover:text-pink-accent transition-colors">Privasi</a>
            </div>
        </div>
    </footer>

</body>
</html>
