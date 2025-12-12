<?php

namespace App\Http\Controllers;

use App\Models\AkhlakSantri;
use App\Http\Requests\StoreAkhlakSantriRequest;
use App\Http\Requests\UpdateAkhlakSantriRequest;
use App\Http\Resources\AkhlakSantriResource;
use App\Events\AkhlakCreated;

class AkhlakSantriController extends Controller
{
    public function index()
    {
        return AkhlakSantriResource::collection(
            AkhlakSantri::with('santri')->latest()->get()
        );
    }

    public function show($id)
    {
        return new AkhlakSantriResource(
            AkhlakSantri::with('santri')->findOrFail($id)
        );
    }

    public function store(StoreAkhlakSantriRequest $req)
    {
        // Simpan data
        $data = AkhlakSantri::create($req->validated());

        // Trigger Event → listener akan kirim FCM
        event(new AkhlakCreated($data));

        return new AkhlakSantriResource($data);
    }

    public function update(UpdateAkhlakSantriRequest $req, $id)
    {
        $data = AkhlakSantri::findOrFail($id);
        $data->update($req->validated());

        return new AkhlakSantriResource($data);
    }

    public function destroy($id)
    {
        $data = AkhlakSantri::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }

    // OPSIONAL — Laporan bulanan
    public function laporanBulanan($santri_id)
    {
        $data = AkhlakSantri::where('santri_id', $santri_id)
            ->whereMonth('tanggal_penilaian', now()->month)
            ->selectRaw('
                AVG(disiplin) as avg_disiplin,
                AVG(kerajinan) as avg_kerajinan,
                AVG(kesopanan) as avg_kesopanan
            ')
            ->first();

        return response()->json([
            'bulan'     => now()->format('F Y'),
            'santri_id' => $santri_id,
            'rata_rata' => $data
        ]);
    }
}
