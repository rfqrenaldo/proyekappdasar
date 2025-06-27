<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     * Mengarahkan pengguna ke halaman otentikasi Google.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        Log::info('Redirecting to Google for OAuth authentication.');
        return Socialite::driver('google')
            ->with([
                'hd' => 'mail.ugm.ac.id',
                'prompt' => 'select_account'
            ])
            ->stateless()
            ->redirect();
        
    }

    /**
     * Obtain the user information from Google after callback and redirect to frontend.
     * Mendapatkan informasi pengguna dari Google setelah callback dan mengarahkan ke frontend.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function callback()
    {
        // Tentukan URL sukses di frontend Anda di sini
        // Ganti 'http://localhost:3000/login-success' dengan URL sebenarnya di frontend Anda.
        $frontendSuccessUrl = env('FRONTEND_SUCCESS_URL', 'http://localhost:3000/login-success'); // Gunakan env variable

        try {
            Log::info('Google OAuth callback initiated.');

            // Mengambil pengguna Google (tetap stateless untuk debugging masalah state)
            $googleUser = Socialite::driver('google')->stateless()->user();

            Log::info('Google user retrieved successfully.', [
                'id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
            ]);

            // Cek apakah user Google memiliki email
            if (!$googleUser->getEmail()) {
                Log::warning('Google account does not have an email address.', ['google_id' => $googleUser->getId()]);
                // Redirect ke halaman error di frontend atau tampilkan JSON error
                return redirect($frontendSuccessUrl . '?status=error&message=' . urlencode('Google account does not have an email address'));
            }

            // Validasi email hanya boleh dari @mail.ugm.ac.id
            if (!str_ends_with($googleUser->getEmail(), '@mail.ugm.ac.id')) {
                Log::warning('Unauthorized email domain attempted to log in.', ['email' => $googleUser->getEmail()]);
                // Redirect ke halaman error di frontend atau tampilkan JSON error
                return redirect($frontendSuccessUrl . '?status=error&message=' . urlencode('Hanya email UGM (@mail.ugm.ac.id) yang diperbolehkan'));
            }

            // Cek apakah user sudah terdaftar berdasarkan google_id atau email.
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$user) {
                // Jika user belum ada, buat user baru
                Log::info('Creating new user from Google OAuth.', ['email' => $googleUser->getEmail()]);
                $user = User::create([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make('randompassword123'),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                // Jika user sudah ada, update token Google mereka
                Log::info('Updating existing user from Google OAuth.', ['email' => $user->email]);
                $user->update([
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            }

            // Buat token Sanctum untuk otentikasi API
            $payload = [
                'iss' => 'ugm-oauth', // issuer
                'sub' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'user', // default fallback
                'iat' => time(),
                'exp' => time() + (60 * 60 * 48), // 24 jam
            ];

            $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
            Log::info('User authenticated successfully and Sanctum token created.', ['user_id' => $user->id, 'email' => $user->email]);

            // Redirect ke frontend dengan token di URL
            // Anda bisa menggunakan hash fragment (#token=...) atau query parameter (?token=...)
            // Hash fragment lebih disukai karena tidak dikirim ke server.
            // Contoh menggunakan query parameter:
            return redirect($frontendSuccessUrl . '?token=' . $token . '&name=' . urlencode($user->name) . '&email=' . urlencode($user->email) . '&status=success');

            // Contoh menggunakan hash fragment (Frontend harus membaca #token=...)
            // return redirect($frontendSuccessUrl . '#token=' . $token . '&name=' . urlencode($user->name) . '&email=' . urlencode($user->email));

        } catch (\Exception $e) {
            Log::error('Google OAuth login failed in callback.', [
                'exception_message' => $e->getMessage(),
                'exception_code' => $e->getCode(),
                'exception_file' => $e->getFile(),
                'exception_line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Jika terjadi error, redirect ke frontend dengan pesan error
            return redirect($frontendSuccessUrl . '?status=error&message=' . urlencode('Google login failed: ' . $e->getMessage()));
        }
    }

    /**
     * Log out the authenticated user.
     * Melakukan logout pengguna yang terotentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
            Log::info('User logged out successfully.', ['user_id' => $request->user()->id]);
        } else {
            Log::warning('Logout attempted by unauthenticated user.');
        }

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
