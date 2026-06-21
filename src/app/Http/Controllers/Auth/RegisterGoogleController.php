<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterGoogleController extends Controller
{
    public function store(Request $request)
    {
        if (!session()->has('google_register_info')) {
            return redirect('/register');
        }

        $googleInfo = session('google_register_info');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $googleInfo['email'],
            'google_id' => $googleInfo['google_id'],
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        session()->forget('google_register_info');

        Auth::login($user);

        return redirect('/dashboard');
    }
}
