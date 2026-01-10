<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BiometricWebController extends Controller
{
    public function index()
    {
        return view('ustadz.biometric.index');
    }

    public function attendance()
    {
        // Get active Santri
        $santris = \App\Models\Santri::where('status_aktif', 1) // Using boolean 1 for active
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('ustadz.biometric.attendance', compact('santris'));
    }

    public function store(Request $request)
    {
        // In a real WebAuthn implementation, we would verify the attestation object here.
        // For this implementation, we trust the client has successfully retrieved a credential
        // and we store the Credential ID.

        $request->validate([
            'credential_id' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $userId = session('user.id');
            if (!$userId) throw new \Exception('User not authenticated in session.');

            $user = User::find($userId);
            if (!$user) throw new \Exception('User not found in database.');

            $user->biometric_credential = $request->credential_id;
            $user->save();

            // Update session
            $sessionUser = session('user');
            if ($sessionUser && is_array($sessionUser)) {
                $sessionUser['biometric_credential'] = $request->credential_id;
                session(['user' => $sessionUser]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sidik jari berhasil didaftarkan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data biometrik: ' . $e->getMessage()
            ], 500);
        }
    }
}
