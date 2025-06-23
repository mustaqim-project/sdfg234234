<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user(); // Ambil data user dari Google

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Jika user belum ada, buat baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Password acak
                    'google_id' => $googleUser->getId(), // Pastikan kolom ini ada di tabel users jika digunakan
                ]);
            }

            Auth::login($user); // Login user
            return redirect()->route('marriage-test.index'); // Arahkan ke halaman utama setelah login

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Login dengan Google gagal!');
        }
    }
}
