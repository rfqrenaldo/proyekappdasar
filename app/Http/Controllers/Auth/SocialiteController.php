<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
    try {
        $googleUser = Socialite::driver('google')->user();

        // Cek apakah user Google memiliki email
        if (!$googleUser->getEmail()) {
            return response()->json([
                'status' => false,
                'message' => 'Google account does not have an email address'
            ], 400);
        }

        // Validasi email hanya boleh dari @mail.ugm.ac.id
        if (!str_ends_with($googleUser->getEmail(), '@mail.ugm.ac.id')) {
            return response()->json([
                'status' => false,
                'message' => 'Hanya email UGM (@mail.ugm.ac.id) yang diperbolehkan'
            ], 403);
        }

        // Cek apakah user sudah terdaftar
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

            if (!$user) {
            $user = User::create([
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make('randompassword123'), // Dummy password
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        } else {
            // Update token Google jika user sudah ada
            $user->update([
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        }

        // Buat token Sanctum
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Google login failed',
            'error' => $e->getMessage(),
        ], 500);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
