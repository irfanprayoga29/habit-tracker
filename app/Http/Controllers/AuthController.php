<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $driver = Socialite::driver('google');
            
            // Hanya matikan verifikasi SSL saat di lokal (untuk menghindari error cURL 60)
            if (app()->environment('local')) {
                $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }
            
            $userdata = $driver->user();

            $user = User::where('email', $userdata->email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $userdata->name,
                    'email' => $userdata->email,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);
            return redirect()->route('tracker');

        } catch (\Exception $e) {
            // Tampilkan error detail hanya di environment lokal
            if (app()->environment('local')) {
                dd($e->getMessage());
            }
            return redirect()->route('landing-page')->with('error', 'Login failed. Please try again.');
        }
    }
}
