<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * =========================
     * POST /api/login
     * =========================
     */
    public function login(Request $request)
    {
        // =========================
        // VALIDASI REQUEST
        // =========================
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'device'   => 'nullable|string|max:50', // optional (mobile/web)
        ]);

        // =========================
        // CARI USER
        // =========================
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // =========================
        // CEK PASSWORD
        // =========================
        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // =========================
        // CEK STATUS USER
        // =========================
        if ($user->status !== 'AKTIF') {
            throw ValidationException::withMessages([
                'email' => ['Akun Anda tidak aktif.'],
            ]);
        }

        // =========================
        // HAPUS TOKEN LAMA (OPTIONAL)
        // =========================
        // $user->tokens()->delete();

        // =========================
        // BUAT TOKEN SANCTUM
        // =========================
        $tokenName = $request->device ?? 'api-token';

        $token = $user->createToken($tokenName)->plainTextToken;

        // =========================
        // RESPONSE
        // =========================
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'role'     => $user->role,
                    'kelas_id' => $user->kelas_id,
                ],
            ],
        ]);
    }

    /**
     * =========================
     * POST /api/logout
     * =========================
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
