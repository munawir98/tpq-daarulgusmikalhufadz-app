<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogVerification;
use App\Models\VerificationScan;
use Illuminate\Http\Request;

class ActivityLogVerificationController extends Controller
{
    /**
     * Halaman verifikasi dokumen via QR (Publik)
     * URL: /verifikasi/{hash}
     */
    public function show($hash)
    {
        // 1️⃣ Cari dokumen berdasarkan hash
        $verification = ActivityLogVerification::where('hash', $hash)->firstOrFail();

        // 2️⃣ Simpan riwayat scan
        VerificationScan::create([
            'activity_log_verification_id' => $verification->id,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);

        // 3️⃣ Hitung jumlah scan
        $scanCount = $verification->scans()->count();

        // 4️⃣ Tampilkan halaman verifikasi publik
        return view('verification.show', [
            'verification' => $verification,
            'scanCount'    => $scanCount,
        ]);
    }
}
