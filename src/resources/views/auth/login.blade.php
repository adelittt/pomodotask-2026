<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Masuk</title>
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
</head>
<body class="bg-[#FFFDF6] min-h-screen text-gray-700 antialiased flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-pastel-peach/30 relative overflow-hidden">
        <!-- Dekorasi latar belakang -->
        <div class="absolute -right-16 -top-16 w-32 h-32 bg-pastel-pink/30 rounded-full blur-2xl z-0"></div>
        <div class="absolute -left-16 -bottom-16 w-32 h-32 bg-pastel-blue/30 rounded-full blur-2xl z-0"></div>

        <div class="relative z-10">
            <div class="text-center mb-8">
                <span class="text-5xl block mb-2">🍅</span>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">PomoTasky</h2>
                <p class="text-sm text-gray-400 font-semibold mt-2">Masuk untuk melanjutkan ke Dashboard</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input id="email" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-pastel-peach focus:ring focus:ring-pastel-peach/20 outline-none transition-all duration-200 bg-gray-50/50 text-gray-700" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-pastel-peach focus:ring focus:ring-pastel-peach/20 outline-none transition-all duration-200 bg-gray-50/50 text-gray-700" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-400 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600 font-semibold">Ingat Saya</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-400 to-pink-400 hover:from-orange-500 hover:to-pink-500 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Masuk 🚀
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500 font-semibold">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-pink-500 hover:text-pink-600 hover:underline transition">Daftar sekarang</a>
            </div>
        </div>
    </div>

</body>
</html>
