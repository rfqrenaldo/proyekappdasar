<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'messages' => $validator->errors(),
            ], 400);
        }

        // Cek kredensial
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $data = [
                'status' => 'true',
                'data' => [
                    'email' => $user->email,
                    'name' => $user->name,
                ],
            ];
            return response()->json($data, 200);
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);

        $data = [
            'status' => 'true',
            'data' => [
                'messages' => 'User registered successfully',
            ],
        ];
        return response()->json($data, 201);
    }
}
