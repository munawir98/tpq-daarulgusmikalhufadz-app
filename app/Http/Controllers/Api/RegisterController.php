<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            // 🔐 VALIDASI BUSINESS RULE
            $kelas = Kelas::where('id', $request->kelas_id)
                          ->where('status', 'AKTIF')
                          ->first();

            if (! $kelas) {
                throw ValidationException::withMessages([
                    'kelas_id' => ['Kelas tidak ditemukan atau tidak aktif.'],
                ]);
            }

            // 👤 CREATE USER
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'SANTRI',
                'kelas_id' => $kelas->id,
                'status'   => 'AKTIF',
            ]);

            // 🎓 CREATE SANTRI
            Santri::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $user->name,
                'kelas_id'     => $kelas->id,
                'status_aktif' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => [
                    'user_id' => $user->id,
                    'role'    => $user->role,
                ],
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
