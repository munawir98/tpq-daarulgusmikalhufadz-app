<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NilaiUjianRequest;
use App\Http\Resources\NilaiUjianResource;
use App\Services\NilaiUjian\NilaiUjianService;
use App\Events\NilaiUjianCreated;

class NilaiUjianController extends Controller
{
    protected NilaiUjianService $service;

    public function __construct(NilaiUjianService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return NilaiUjianResource::collection(
            $this->service->listAll()
        );
    }

    public function show($id)
    {
        return new NilaiUjianResource(
            $this->service->find($id)
        );
    }

    public function store(NilaiUjianRequest $req)
    {
        // Simpan data nilai ujian
        $nilai = $this->service->create($req->validated());

        // Trigger event → listener akan mengirim FCM
        event(new NilaiUjianCreated($nilai));

        return new NilaiUjianResource($nilai);
    }

    public function update(NilaiUjianRequest $req, $id)
    {
        $nilai = $this->service->update($id, $req->validated());

        // Jika ingin notif update nilai, bisa tambahkan event di sini
        // event(new NilaiUjianUpdated($nilai));

        return new NilaiUjianResource($nilai);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'message' => 'Data nilai ujian berhasil dihapus'
        ]);
    }

    public function bySantri($santriId)
    {
        return NilaiUjianResource::collection(
            $this->service->listBySantri($santriId)
        );
    }
}
