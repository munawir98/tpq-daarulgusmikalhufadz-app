<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationScan;

class VerificationScanController extends Controller
{
    /**
     * Daftar riwayat scan QR (Admin)
     */
    public function index()
    {
        $scans = VerificationScan::with('verification')
            ->latest()
            ->paginate(20);

        return view('admin.verification-scans.index', compact('scans'));
    }
}
