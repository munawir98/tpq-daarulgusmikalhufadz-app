<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SantriAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'password' => 'required',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (!$santri || empty($santri->password)) {
            return response()->json([
                'message' => 'Akun belum diaktifkan'
            ], 403);
        }

        if (!Hash::check($request->password, $santri->password)) {
            return response()->json([
                'message' => 'Password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'santri' => $santri
        ]);
    }
}
