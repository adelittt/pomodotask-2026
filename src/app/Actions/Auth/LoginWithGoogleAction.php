<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginWithGoogleAction
{
    /**
     * Handle the incoming request.
     */
    public function execute()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            $intent = session('google_auth_intent', 'login');
            
            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();

            if ($intent === 'register') {
                if ($user) {
                    // Already registered, just log them in or show message
                    if (!$user->google_id) {
                        $user->update(['google_id' => $googleUser->id]);
                    }
                    // User wants to enter password manually after Google verification
                    return redirect('/login')->withInput(['email' => $googleUser->email])->with('message', 'Akun sudah terdaftar. Silakan masukkan kata sandi Anda untuk masuk ke Dashboard.');
                } else {
                    // Not registered yet, save to session and redirect to complete register
                    session(['google_register_info' => [
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                    ]]);
                    return redirect()->route('register.google.complete');
                }
            } else {
                // Intent is login
                if ($user) {
                    // Update google_id if not present
                    if (!$user->google_id) {
                        $user->update([
                            'google_id' => $googleUser->id,
                        ]);
                    }
                    // User wants to enter password manually after Google verification
                    return redirect('/login')->withInput(['email' => $googleUser->email])->with('message', 'Akun Google berhasil dikonfirmasi. Silakan masukkan kata sandi Anda untuk masuk ke Dashboard.');
                } else {
                    // Not registered yet, cannot login
                    return redirect('/login')->withErrors(['email' => 'Akun Google belum terdaftar di sistem. Silakan register terlebih dahulu.']);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Login Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return redirect('/login')->withErrors(['email' => 'Gagal login menggunakan Google. Silakan coba lagi.']);
        }
    }
}
