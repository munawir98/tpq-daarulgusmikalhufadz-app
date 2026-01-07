<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Santri;
use App\Helpers\ApiResponse;

// Intervention Image v3
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AuthController extends Controller
{
    /**
     * ============================
     * REGISTER
     * ============================
     */
        public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['password']   = Hash::make($data['password']);
        $data['role']       = $data['role'] ?? 'SANTRI';
        $data['foto']       = 'default/profile.png';
        $data['status']     = 'aktif';
        $data['last_login'] = now();

        $user = User::create($data);

        $nis = null;

        if ($user->role === 'SANTRI') {
            $nis = 'NIS-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

            Santri::create([
                'user_id'      => $user->id,
                'kelas_id'     => $request->kelas_id ?? null,
                'nis'          => $nis,
                'nama_lengkap' => $user->name,
                'status'       => 'AKTIF',
            ]);
        }

        // ✅ AUTO LOGIN
        $token = $user->createToken('web')->plainTextToken;

        return ApiResponse::success([
            'token' => $token,
            'user'  => [
                'id'   => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'nis'  => $nis, // 🔥 INI KUNCI
            ],
        ], 'Registrasi berhasil');
    }

    /**
     * ============================
     * LOGIN (MULTI DEVICE + LIMIT)
     * ============================
     */
        public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'login'    => 'required', // bisa NIS atau email
            'device_name' => 'nullable|string',
            'fcm_token'   => 'nullable|string',
        ]);

        /**
         * ============================
         * LOGIN VIA NIS (SANTRI)
         * ============================
         */
        if (str_starts_with($request->login, 'NIS')) {

            $santri = Santri::where('nis', $request->login)->first();

            if (! $santri) {
                return ApiResponse::error('NIS tidak ditemukan', 404);
            }

            $user = $santri->user;

        } else {

            /**
             * ============================
             * LOGIN VIA EMAIL (ADMIN / USTADZ)
             * ============================
             */
            $user = User::where('email', $request->login)->first();
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return ApiResponse::error('Login atau password salah', 401);
        }

        if ($user->status !== 'aktif') {
            return ApiResponse::error('Akun tidak aktif', 403);
        }

        // update login info
        $user->update([
            'last_login' => now(),
            'fcm_token'  => $request->fcm_token ?? $user->fcm_token,
        ]);

        // limit device
        $maxDevice = match ($user->role) {
            'ADMIN'  => 1,
            'SANTRI' => 2,
            default  => 1,
        };

        if ($user->tokens()->count() >= $maxDevice) {
            $user->tokens()->oldest()->first()?->delete();
        }

        $token = $user->createToken(
            $request->device_name ?? 'web',
            ['*'],
            now()->addDays(7)
        );

        return ApiResponse::success([
            'token' => $token->plainTextToken,
            'user'  => [
                'id'   => $user->id,
                'name' => $user->name,
                'email'=> $user->email,
                'role' => $user->role,
            ],
        ], 'Login berhasil');
    }


    /**
     * ============================
     * REFRESH TOKEN
     * ============================
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();

        $request->user()->currentAccessToken()->delete();

        $token = $user->createToken(
            'refresh-' . now()->timestamp,
            ['*'],
            now()->addDays(7)
        );

        return ApiResponse::success([
            'token'      => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at,
        ], 'Token berhasil diperbarui');
    }

    /**
     * ============================
     * PROFILE
     * ============================
     */
    public function profile()
    {
        return ApiResponse::success(auth()->user(), 'Profil user');
    }

    /**
     * ============================
     * LOGOUT (CURRENT DEVICE)
     * ============================
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success(null, 'Logout berhasil');
    }

    /**
     * ============================
     * LIST DEVICE AKTIF
     * ============================
     */
    public function devices()
    {
        return ApiResponse::success(
            auth()->user()->tokens->map(fn ($t) => [
                'id'         => $t->id,
                'device'     => $t->name,
                'last_used'  => $t->last_used_at,
                'expires_at' => $t->expires_at,
            ]),
            'Daftar device aktif'
        );
    }

    /**
     * ============================
     * LOGOUT DEVICE TERTENTU
     * ============================
     */
    public function logoutDevice($tokenId)
    {
        $user = auth()->user();

        $token = $user->tokens()->where('id', $tokenId)->first();

        if (! $token) {
            return ApiResponse::error('Device tidak ditemukan', 404);
        }

        $token->delete();

        return ApiResponse::success(null, 'Device berhasil logout');
    }

    /**
     * ============================
     * UPLOAD FOTO PROFIL
     * ============================
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($user->foto && $user->foto !== 'default/profile.png') {
            @unlink(storage_path('app/public/' . $user->foto));
            @unlink(storage_path('app/public/profile/thumb_' . basename($user->foto)));
        }

        $filename = uniqid() . '.' . $request->file('photo')->extension();

        $manager = new ImageManager(new Driver());
        $image   = $manager->read($request->file('photo'));

        $image->cover(500, 500)->save(storage_path("app/public/profile/{$filename}"));
        $image->cover(100, 100)->save(storage_path("app/public/profile/thumb_{$filename}"));

        $user->update(['foto' => "profile/{$filename}"]);

        return ApiResponse::success([
            'foto_url'      => asset("storage/profile/{$filename}"),
            'thumbnail_url' => asset("storage/profile/thumb_{$filename}"),
        ], 'Foto profil diperbarui');
    }

    /**
     * ============================
     * UPDATE PROFILE
     * ============================
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return ApiResponse::success($user, 'Profil berhasil diperbarui');
    }

    /**
     * ============================
     * CHANGE PASSWORD
     * ============================
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        if (! Hash::check($request->old_password, $user->password)) {
            return ApiResponse::error('Password lama salah', 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // logout semua device
        $user->tokens()->delete();

        return ApiResponse::success(null, 'Password berhasil diganti');
    }
}
