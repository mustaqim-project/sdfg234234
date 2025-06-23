<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserProfileIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->userProfile) {
            return redirect()->route('profile')->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        $profile = $user->profile;
        // Daftar field wajib diisi
        $requiredFields = [
            'date_of_birth',
            'gender_id',
            'bio',
            'height',
            'weight',
            'education_level_id',
            'occupation',
            'company',
            'religion_id',
            'want_children',
            'zodiac_id',
            'smoking_habit_id',
            'drinking_habit_id',
            'income_range_id',
        ];

        foreach ($requiredFields as $field) {
            if (is_null($profile->{$field}) || $profile->{$field} === '') {
                return redirect()->route('profile')
                    ->with('warning', 'Silakan lengkapi semua data profil Anda terlebih dahulu.');
            }
        }

        // Cek MBTI
        if (empty($profile->mbti)) {
            return redirect()->route('mbti.index')
                ->with('warning', 'Silakan isi Tes MBTI terlebih dahulu.');
        }

        // Cek Marriage Test
        if (empty((array) $profile->marriage_test)) {
            return redirect()->route('marriage-test.index')
                ->with('warning', 'Silakan isi Tes Kecocokan Pernikahan terlebih dahulu.');
        }

        // Cek DISC
        if (empty((array) $profile->disc)) {
            return redirect()->route('disc.index')
                ->with('warning', 'Silakan isi Tes DISC terlebih dahulu.');
        }

        return $next($request);
    }
}
