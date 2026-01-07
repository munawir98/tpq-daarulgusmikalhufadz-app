<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationScan;
use App\Models\ActivityLogVerification;

class VerificationDashboardController extends Controller
{
    public function index()
    {
        return view('admin.verification-dashboard', [
            'totalDocuments' => ActivityLogVerification::count(),
            'totalScans'     => VerificationScan::count(),
            'scansToday'     => VerificationScan::today()->count(),
            'latestScans'    => VerificationScan::with('verification')
                                ->latest()
                                ->limit(10)
                                ->get(),
        ]);
    }
}
