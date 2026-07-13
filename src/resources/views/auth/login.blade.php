<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Masuk</title>
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
        .hero-bg {
            /* Vibrant Pink and Green Gradient */
            background: linear-gradient(135deg, #FFE4E8 0%, #D1FAE5 100%);
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }
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
        .input-pastel:focus {
            border-color: #10B981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
        }
    </style>
</head>
<body class="hero-bg min-h-screen antialiased flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-md glass-card p-8 rounded-3xl relative overflow-hidden">
        <div class="relative z-10">
            <!-- Explicit Back Button -->
            <div class="mb-6 flex justify-start">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-pink-accent transition-colors font-bold bg-white/50 hover:bg-white px-4 py-2 rounded-full border border-white/60 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block hover:opacity-80 transition-opacity">
                    <span class="text-5xl block mb-2">🍅</span>
                    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-[#F46B7E] to-[#10B981] bg-clip-text text-transparent">PomoTasky</h2>
                </a>
                <p class="text-sm text-gray-500 font-semibold mt-2">Masuk untuk melanjutkan ke Dashboard</p>
            </div>

            @if (session('message'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm font-semibold text-center">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input id="email" class="block w-full px-4 py-3 rounded-xl border border-white focus:border-emerald-500 outline-none transition-all duration-200 bg-white/70 text-gray-700 shadow-sm input-pastel" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password" class="block w-full px-4 py-3 rounded-xl border border-white focus:border-emerald-500 outline-none transition-all duration-200 bg-white/70 text-gray-700 shadow-sm input-pastel" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <!-- Remember Me -->
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-500 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600 font-semibold">Ingat Saya</span>
                    </label>
                    
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-pink-accent hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full btn-emerald font-bold py-3 px-6 rounded-xl transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Masuk 🚀
                    </button>
                </div>
                
                <div class="relative mt-6 mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300/50"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 text-gray-500 font-semibold">Atau</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2 bg-white/80 hover:bg-white border border-white text-gray-700 font-bold py-3 px-6 rounded-xl shadow-sm transition-all duration-200 ease-in-out">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Masuk dengan Google
                    </a>
                </div>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-600 font-semibold">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-pink-accent hover:underline transition">Daftar sekarang</a>
            </div>
        </div>
    </div>

</body>
</html>
