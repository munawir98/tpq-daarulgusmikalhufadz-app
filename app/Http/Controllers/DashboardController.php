<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function summary(): JsonResponse
    {
        return response()->json([
            'data' => [
                'total_santri' => Santri::count(),
                'total_kelas'  => Kelas::count(),
            ]
        ]);
    }
}
