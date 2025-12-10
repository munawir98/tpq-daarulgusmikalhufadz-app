<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'fcm_token' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        // Update FCM token jika dikirim dari Flutter
        if ($request->has('fcm_token')) {
            $user->update([
                'fcm_token' => $request->fcm_token
            ]);
        }

        // Generate token Sanctum
        $token = $user->createToken('TPQToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user->only([
                'id', 'name', 'email', 'role', 'fcm_token'
            ])
        ]);
    }

    /**
     * PROFILE
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load(['santri', 'ustadz']);

        return response()->json([
            'status' => true,
            'user' => $user,
            'santri' => $user->santri ?? null,
            'ustadz' => $user->ustadz ?? null
        ]);
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
