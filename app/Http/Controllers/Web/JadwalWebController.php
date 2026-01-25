<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalWebController extends Controller
{
    public function index()
    {
        // Get schedules sorted by day and time
        // Note: Field 'hari' is enum, we might need custom sort if we want Mon-Sun order
        // For now just simple get.
        $jadwals = JadwalMengajar::with(['kelas', 'ustadz'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('waktu_mulai')
            ->get();

        return view('ustadz.jadwal', compact('jadwals'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $ustadz = Ustadz::where('status_aktif', true)->get();
        return view('ustadz.jadwal.create', compact('kelas', 'ustadz'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'ustadz_id' => 'required|exists:ustadz,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'materi' => 'nullable|string',
        ]);

        JadwalMengajar::create($request->all());

        return redirect()->route('ustadz.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }
}
