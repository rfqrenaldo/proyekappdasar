<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken(); // Ambil token dari Authorization: Bearer <token>

            if (!$token) {
                return response()->json(['message' => 'Token not provided'], 401);
            }

            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            // Optional: cari user dari database (bisa juga pake info dari payload langsung)
            $user = User::find($decoded->sub);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 401);
            }

            // Inject user ke request biar bisa diakses pake request()->user()
            $request->setUserResolver(fn () => $user);

        } catch (Exception $e) {
            return response()->json(['message' => 'Invalid or expired token', 'error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
