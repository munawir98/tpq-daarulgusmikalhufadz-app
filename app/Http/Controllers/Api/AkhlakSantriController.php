<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AkhlakSantriRequest;
use App\Http\Resources\AkhlakSantriResource;
use App\Services\AkhlakSantri\AkhlakSantriService;

class AkhlakSantriController extends Controller
{
    protected AkhlakSantriService $service;

    public function __construct(AkhlakSantriService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->listAll();
        return AkhlakSantriResource::collection($data);
    }

    public function show($id)
    {
        $data = $this->service->find($id);
        return new AkhlakSantriResource($data);
    }

    public function store(AkhlakSantriRequest $req)
    {
        // Simpan data lewat service
        $data = $this->service->create($req->validated());

        // Ambil token FCM user santri terkait
        $token = optional($data->santri->user->tokens->first())->fcm_token;

        // Jika ada token, kirim notifikasi
        if ($token) {
            $fcm = app(\App\Services\Fcm\FcmService::class);

            $fcm->sendToToken(
                $token,
                "Penilaian Akhlak Baru",
                "Akhlak santri telah dinilai hari ini",
                [
                    "akhlak_id" => $data->id,
                    "santri_id" => $data->santri_id
                ]
            );
        }

        return new AkhlakSantriResource($data);
    }


    public function update(AkhlakSantriRequest $req, $id)
    {
        $data = $this->service->update($id, $req->validated());
        return new AkhlakSantriResource($data);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function bySantri($santriId)
    {
        $data = $this->service->listBySantri($santriId);
        return AkhlakSantriResource::collection($data);
    }
}
