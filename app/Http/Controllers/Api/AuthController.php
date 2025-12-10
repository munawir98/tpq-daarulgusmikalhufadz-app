<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ApiResponse;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{
    /**
     * REGISTER - POST /api/register
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Default role
        $data['role'] = $data['role'] ?? 'santri';

        // Foto default
        $data['foto'] = 'default/profile.png';

        // Last login default
        $data['last_login'] = now();

        $user = User::create($data);

        return ApiResponse::success($user, "Registrasi berhasil");
    }


    /**
     * LOGIN - POST /api/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'fcm_token'=> 'nullable|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error("Email atau password salah", 401);
        }

        // Update FCM & last login
        $user->update([
            'fcm_token'  => $request->fcm_token ?? $user->fcm_token,
            'last_login' => now(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success([
            'user'  => $user,
            'token' => $token
        ], "Login berhasil");
    }


    /**
     * PROFILE - GET /api/profile
     */
    public function profile()
    {
        return ApiResponse::success(auth()->user(), "Profile user ditemukan");
    }


    /**
     * LOGOUT - POST /api/logout
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return ApiResponse::success(null, "Logout berhasil");
    }


    /**
     * UPLOAD FOTO PROFIL
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        // Hapus foto lama jika bukan default
        if ($user->foto && $user->foto !== 'default/profile.png') {
            @unlink(storage_path("app/public/" . $user->foto));
            @unlink(storage_path("app/public/profile/thumb_" . basename($user->foto)));
        }

        // Nama file unik
        $filename = uniqid() . "." . $request->photo->extension();

        // Lokasi penyimpanan
        $originalPath = storage_path("app/public/profile/$filename");
        $thumbPath    = storage_path("app/public/profile/thumb_$filename");

        // Simpan foto utama 500x500
        $img = Image::make($request->photo);
        $img->fit(500, 500)->save($originalPath);

        // Simpan thumbnail 100x100
        $img->fit(100, 100)->save($thumbPath);

        // Update database
        $user->update([
            'foto' => "profile/$filename"
        ]);

        return ApiResponse::success([
            'foto_url'      => asset("storage/profile/$filename"),
            'thumbnail_url' => asset("storage/profile/thumb_$filename")
        ], "Foto profil berhasil diperbarui");
    }


    /**
     * HAPUS FOTO PROFIL
     */
    public function deletePhoto()
    {
        $user = auth()->user();

        if (!$user->foto || $user->foto === 'default/profile.png') {
            return ApiResponse::error("Tidak ada foto yang dapat dihapus");
        }

        @unlink(storage_path("app/public/" . $user->foto));
        @unlink(storage_path("app/public/profile/thumb_" . basename($user->foto)));

        $user->update(['foto' => null]);

        return ApiResponse::success(null, "Foto profil berhasil dihapus");
    }


    /**
     * UPDATE PROFILE (via FormRequest)
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        $user->update($data);

        return ApiResponse::success($user, "Profil berhasil diperbarui");
    }


    /**
     * CHANGE PASSWORD (VERIFIKASI PASSWORD LAMA)
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        // Cek password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return ApiResponse::error("Password lama salah", 400);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return ApiResponse::success(null, "Password berhasil diganti");
    }
}
