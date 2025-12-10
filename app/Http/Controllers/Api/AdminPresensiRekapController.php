<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPresensiRekapController extends Controller
{
    public function monthly(Request $request)
    {
        $month = $request->month; // format: 2025-12

        $data = Presensi::with('user')
            ->whereRaw("DATE_FORMAT(tanggal,'%Y-%m') = ?", [$month])
            ->orderBy('tanggal', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'month'  => $month,
            'rekap'  => $data->groupBy('user_id')->map(function ($item) {
                return [
                    'nama' => $item->first()->user->name,
                    'hadir'     => $item->where('status_presensi', 'Hadir')->count(),
                    'sakit'     => $item->where('status_presensi', 'Sakit')->count(),
                    'izin'      => $item->where('status_presensi', 'Izin')->count(),
                    'alpha'     => $item->where('status_presensi', 'Alpha')->count(),
                    'terlambat' => $item->where('status_presensi', 'Terlambat')->count(),
                ];
            })
        ]);
    }
}
