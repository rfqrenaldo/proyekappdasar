<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegisterResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'messages' => $validator->errors(),
            ], 400);
        }

        // Cek kredensial
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // === JWT creation ===
            $payload = [
                'iss' => 'simapro', // Issuer (optional)
                'sub' => $user->id,       // Subject (user ID)
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role,
                'iat' => time(),          // Issued at
                'exp' => time() + 60 * 60 * 24 // Expire (24 hours)
            ];

            $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

            // Response
            return response()->json([
                'status' => 'true',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'role' => $user->role,
                    'token' => $token,
                ]
            ])->withCookie(cookie('token', $token, 60 * 48, '/', null, true, true));;
        } else {
            return response()->json([
                'status' => 'false',
                'messages' => ['Invalid credentials'],
            ], 401);
        }
    }


    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'messages' => $validator->errors(),
            ], 400);
        }


        //validation agar pass yang baru tidak sama dengan lama

        // Simpan data pengguna
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Enkripsi password
        ]);

        $data = [
            'status' => 'true',
            'data' => [
                'messages' => new RegisterResource($user),
            ],
        ];
        return response()->json($data, 201);
    }
}
