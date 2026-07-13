<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Lupa Password</title>
    <!-- Import Google Fonts Quicksand & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Quicksand', 'Montserrat', sans-serif;
            color: #4b5563;
        }
        .hero-bg {
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
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-pink-accent transition-colors font-bold bg-white/50 hover:bg-white px-4 py-2 rounded-full border border-white/60 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Login
                </a>
            </div>

            <div class="text-center mb-8">
                <span class="text-5xl block mb-2">🔑</span>
                <h2 class="text-3xl font-extrabold bg-gradient-to-r from-[#F46B7E] to-[#10B981] bg-clip-text text-transparent">Lupa Password?</h2>
                <p class="text-sm text-gray-500 font-semibold mt-2">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm font-semibold text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Anda</label>
                    <input id="email" class="block w-full px-4 py-3 rounded-xl border border-white focus:border-emerald-500 outline-none transition-all duration-200 bg-white/70 text-gray-700 shadow-sm input-pastel" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full btn-emerald font-bold py-3 px-6 rounded-xl transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Kirim Link Reset 📧
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
