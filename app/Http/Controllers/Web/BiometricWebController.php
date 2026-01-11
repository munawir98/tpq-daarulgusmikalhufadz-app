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

    public function submitAttendance(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'latitude' => 'nullable', // Optional for biometric/ustadz mode
            'longitude' => 'nullable',
        ]);

        $santri = \App\Models\Santri::find($request->santri_id);
        if (!$santri) return response()->json(['success' => false, 'message' => 'Santri tidak ditemukan'], 404);

        // Use Santri's linked user ID if available, or just record by Santri ID if Presensi supports it.
        // Looking at Presensi model, it links to User.
        // We assume Santri has a User account.
        $userId = $santri->user_id;

        if (!$userId) {
             // Fallback or Error if system requires User ID
             // For now, let's assume we need a user ID.
             return response()->json(['success' => false, 'message' => 'Santri belum memiliki akun User terhubung.'], 400);
        }

        $today = now()->format('Y-m-d');

        // Cek Double
        $exists = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->where('tipe', 'masuk')
            ->exists();

        if ($exists) {
             return response()->json(['success' => true, 'message' => 'Santri sudah absen hari ini.']);
        }

        \App\Models\Presensi::create([
            'user_id' => $userId,
            'ustadz_id' => auth()->id(), // Recorded by Ustadz
            'tanggal' => $today,
            'jam' => now()->format('H:i:s'),
            'tipe' => 'masuk',
            'status_presensi' => 'HADIR',
            'metode' => 'BIOMETRIC', // or FINGERPRINT
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json(['success' => true, 'message' => "Absen {$santri->nama_lengkap} berhasil dicatat."]);
    }

    public function register()
    {
        // Initial view with empty list or preloaded small set if needed.
        // For AJAX Select2, we can just pass empty or let the view handle it.
        // But to keep manual fallback, we pass all (might be heavy later).
        // Let's keep passing all for now, but enabling AJAX in view will override.
// [DEBUG] Removed status_aktif check to verify data existence
        // $santris = \App\Models\Santri::where('status_aktif', 1)
        $santris = \App\Models\Santri::query()
            ->orderBy('nama_lengkap', 'asc')
            ->limit(10)
            ->get();

        return view('ustadz.biometric.register', compact('santris'));
    }

    public function search(Request $request)
    {
        $term = $request->q;
        \Illuminate\Support\Facades\Log::info("Biometric Search Query: " . json_encode($request->all()));

        // [DEBUG] Removed status_aktif check
        // $query = \App\Models\Santri::where('status_aktif', 1);
        $query = \App\Models\Santri::query();

        if ($term) {
            $query->where('nama_lengkap', 'like', '%' . $term . '%');
        }

        $results = $query->orderBy('nama_lengkap', 'asc')
            ->limit(20)
            ->get()
            ->map(function ($santri) {
                return [
                    'id' => $santri->id,
                    'text' => $santri->nama_lengkap
                ];
            });

        \Illuminate\Support\Facades\Log::info("Biometric Search Results Found: " . $results->count());

        return response()->json([
            'results' => $results
        ]);
    }

    public function storeCredential(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'credential_id' => 'required|string',
            'name' => 'nullable|string|max:50',
        ]);

        try {
            $santri = \App\Models\Santri::find($request->santri_id);
            $userId = $santri->user_id;

            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Santri tidak memiliki akun user.'], 400);
            }

            $name = $request->name ?? 'Jari ' . now()->format('d/m H:i');

            \App\Models\BiometricCredential::create([
                'user_id' => $userId,
                'credential_id' => $request->credential_id,
                'name' => $name,
            ]);

            return response()->json(['success' => true, 'message' => 'Sidik jari berhasil didaftarkan.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
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
