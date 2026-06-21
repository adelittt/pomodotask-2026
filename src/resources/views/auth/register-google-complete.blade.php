<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Lengkapi Profil</title>
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
<body class="bg-[#FFFDF6] min-h-screen text-gray-700 antialiased flex items-center justify-center py-10">

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-pastel-peach/30 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-32 h-32 bg-pastel-pink/30 rounded-full blur-2xl z-0"></div>
        <div class="absolute -left-16 -bottom-16 w-32 h-32 bg-pastel-blue/30 rounded-full blur-2xl z-0"></div>

        <div class="relative z-10">
            <div class="text-center mb-8">
                <span class="text-5xl block mb-2">🍅</span>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">Lengkapi Akun</h2>
                <p class="text-sm text-gray-400 font-semibold mt-2">Halo {{ session('google_register_info.email') }}, silakan isi nama panggilan (nickname) dan buat kata sandi untuk akunmu.</p>
            </div>

            <form method="POST" action="{{ route('register.google.store') }}" class="space-y-4">
                @csrf

                <!-- Name / Nickname -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nickname / Nama</label>
                    <input id="name" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-pastel-peach focus:ring focus:ring-pastel-peach/20 outline-none transition-all duration-200 bg-gray-50/50 text-gray-700" type="text" name="name" value="{{ old('name', session('google_register_info.name')) }}" required autofocus autocomplete="name" />
                    @error('name')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-pastel-peach focus:ring focus:ring-pastel-peach/20 outline-none transition-all duration-200 bg-gray-50/50 text-gray-700" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" class="block w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-pastel-peach focus:ring focus:ring-pastel-peach/20 outline-none transition-all duration-200 bg-gray-50/50 text-gray-700" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-400 to-pink-400 hover:from-orange-500 hover:to-pink-500 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        Selesaikan Pendaftaran 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
