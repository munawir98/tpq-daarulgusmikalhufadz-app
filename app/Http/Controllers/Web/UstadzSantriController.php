<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;

class UstadzSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all santri (or filter by class if ustadz is wali kelas - logic to be added later)
        // For now, list all active santri
        $santri = Santri::where('status', 'active')->orderBy('nama', 'asc')->paginate(10);

        return view('ustadz.santri.index', compact('santri'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $santri = Santri::with(['user', 'kelas'])->findOrFail($id);

        // Fetch recent hafalan history (limit 5)
        $riwayatHafalan = \App\Models\Hafalan::where('santri_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('ustadz.santri.show', compact('santri', 'riwayatHafalan'));
    }

    /**
     * Show form to create akhlak record
     */
    public function createAkhlak($id)
    {
        $santri = Santri::findOrFail($id);
        $riwayat = \App\Models\AkhlakSantri::where('santri_id', $id)
            ->orderBy('tanggal_penilaian', 'desc')
            ->limit(5)
            ->get();

        return view('ustadz.santri.akhlak.create', compact('santri', 'riwayat'));
    }

    /**
     * Store new akhlak record
     */
    public function storeAkhlak(Request $request, $id)
    {
        $request->validate([
            'disiplin' => 'required|integer|min:1|max:5',
            'kerajinan' => 'required|integer|min:1|max:5',
            'kesopanan' => 'required|integer|min:1|max:5',
            'tanggal_penilaian' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        \App\Models\AkhlakSantri::create([
            'santri_id' => $id,
            'disiplin' => $request->disiplin,
            'kerajinan' => $request->kerajinan,
            'kesopanan' => $request->kesopanan,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('ustadz.santri.akhlak.create', $id)
            ->with('success', 'Penilaian akhlak berhasil disimpan!');
    }
}
