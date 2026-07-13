<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Reset Password</title>
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
            <div class="text-center mb-8">
                <span class="text-5xl block mb-2">🔒</span>
                <h2 class="text-3xl font-extrabold bg-gradient-to-r from-[#F46B7E] to-[#10B981] bg-clip-text text-transparent">Reset Password</h2>
                <p class="text-sm text-gray-500 font-semibold mt-2">Buat kata sandi baru untuk akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input id="email" class="block w-full px-4 py-3 rounded-xl border border-white focus:border-emerald-500 outline-none transition-all duration-200 bg-white/70 text-gray-700 shadow-sm input-pastel" type="email" name="email" value="{{ request()->email ?? old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input id="password" class="block w-full px-4 py-3 rounded-xl border border-white focus:border-emerald-500 outline-none transition-all duration-200 bg-white/70 text-gray-700 shadow-sm input-pastel" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input id="password_confirmation" class="block w-full px-4 py-3 rounded-xl border border-white focus:border-emerald-500 outline-none transition-all duration-200 bg-white/70 text-gray-700 shadow-sm input-pastel" type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full btn-emerald font-bold py-3 px-6 rounded-xl transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Simpan Password Baru 💾
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
