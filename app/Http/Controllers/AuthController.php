<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => __('auth.throttle', replace: [
                    'seconds' => RateLimiter::availableIn($key),
                ]),
            ]);
        }

        //chek apakah user terdaftar
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if ($user->active == false) {
                return redirect()->back()->with('error', 'Akun anda belum aktif');
            }
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // Ganti 'dashboard' dengan route yang diinginkan
        }

        RateLimiter::hit($key);

        return redirect()->back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
