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
    public function index(Request $request)
    {
        $query = Santri::aktif()->with('kelas');

        // Search by name or NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter by kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $santri = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();

        // Get all kelas for filter dropdown
        $kelasList = \App\Models\Kelas::orderBy('nama_kelas')->get();

        return view('ustadz.santri.index', compact('santri', 'kelasList'));
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $santri = Santri::with('user')->findOrFail($id);
        return view('ustadz.santri.edit', compact('santri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|max:50|unique:santri,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'no_hp_orang_tua' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // Update Santri Data
        $santri->update([
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'nama_ayah' => $request->nama_ayah,
            'no_hp_orang_tua' => $request->no_hp_orang_tua,
        ]);

        // Update User Data (Name & Photo)
        if ($santri->user) {
            $user = $santri->user;
            $user->name = $request->nama_lengkap; // Sync name

            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($user->foto && \Illuminate\Support\Facades\Storage::exists('public/' . $user->foto)) {
                    \Illuminate\Support\Facades\Storage::delete('public/' . $user->foto);
                }

                // Store new photo
                $path = $request->file('foto')->store('photos', 'public');
                $user->foto = $path;
            }
            $user->save();
        }

        return redirect()->route('ustadz.santri.index')->with('success', 'Data santri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $santri = Santri::with('user')->findOrFail($id);
        $user = $santri->user;

        // Delete Santri Profile (will likely cascade delete related data if set in DB)
        $santri->delete();

        // Delete User Account
        if ($user) {
            // Delete photo if exists
            if ($user->foto && \Illuminate\Support\Facades\Storage::exists('public/' . $user->foto)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $user->foto);
            }
            $user->delete();
        }

        return redirect()->route('ustadz.santri.index')->with('success', 'Data santri dan akun berhasil dihapus');
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
