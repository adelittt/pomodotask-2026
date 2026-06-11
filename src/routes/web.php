<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/


Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        
        // Prevent admin from using user login panel
        if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors([
                'email' => 'Akun Admin tidak bisa login di sini. Silakan login melalui halaman /admin',
            ])->onlyInput('email');
        }
        
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
    ])->onlyInput('email');
});

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    $user->assignRole('user');

    auth()->login($user);

    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')) {
            return redirect('/admin');
        }

        return view('dashboard-user');
    })->name('dashboard.user');

    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');
});

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')) {
            return redirect('/admin');
        }

        return redirect('/dashboard');
    }

    return redirect('/login');
});
