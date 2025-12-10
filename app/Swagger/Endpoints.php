<?php

namespace App\Swagger;

class Endpoints
{
    /* ============================================================
     *                         AUTH MODULE
     * ============================================================ */

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login user menggunakan email & password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="user@mail.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/ApiError")
     * )
     */
    public function login() {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Register user baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess"),
     *     @OA\Response(response=422, ref="#/components/responses/ApiError")
     * )
     */
    public function register() {}

    /**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Auth"},
     *     summary="Ambil data profil user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/ApiError")
     * )
     */
    public function profile() {}

    /**
     * @OA\Post(
     *     path="/api/profile/update",
     *     tags={"Auth"},
     *     summary="Update data profil user",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function updateProfile() {}

    /**
     * @OA\Post(
     *     path="/api/profile/change-password",
     *     tags={"Auth"},
     *     summary="Ganti password user",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"old_password","new_password"},
     *             @OA\Property(property="old_password", type="string"),
     *             @OA\Property(property="new_password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess"),
     *     @OA\Response(response=400, ref="#/components/responses/ApiError")
     * )
     */
    public function changePassword() {}

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function logout() {}



    /* ============================================================
     *                       PRESENSI MODULE
     * ============================================================ */

    /**
     * @OA\Post(
     *     path="/api/presensi/masuk",
     *     tags={"Presensi"},
     *     summary="Presensi masuk menggunakan GPS",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function presensiMasuk() {}

    /**
     * @OA\Post(
     *     path="/api/presensi/pulang",
     *     tags={"Presensi"},
     *     summary="Presensi pulang menggunakan GPS",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function presensiPulang() {}

    /**
     * @OA\Get(
     *     path="/api/presensi/history",
     *     tags={"Presensi"},
     *     summary="Histori presensi user",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Histori presensi",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Presensi")),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     )
     * )
     */
    public function presensiHistory() {}

    /**
     * @OA\Get(
     *     path="/api/presensi/mingguan",
     *     tags={"Presensi"},
     *     summary="Rekap presensi mingguan",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function presensiMingguan() {}

    /**
     * @OA\Get(
     *     path="/api/presensi/bulanan",
     *     tags={"Presensi"},
     *     summary="Rekap presensi bulanan",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function presensiBulanan() {}



    /* ============================================================
     *                     CHAT PRIVATE MODULE
     * ============================================================ */

    /**
     * @OA\Get(
     *     path="/api/chat/private",
     *     tags={"ChatPrivate"},
     *     summary="List percakapan privat",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function chatPrivateList() {}

    /**
     * @OA\Get(
     *     path="/api/chat/private/{user_id}",
     *     tags={"ChatPrivate"},
     *     summary="Percakapan dengan user tertentu",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="user_id", in="path", required=true),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function chatWithUser() {}

    /**
     * @OA\Post(
     *     path="/api/chat/private/send",
     *     tags={"ChatPrivate"},
     *     summary="Kirim pesan privat",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="receiver_id", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function chatPrivateSend() {}

    /**
     * @OA\Post(
     *     path="/api/chat/private/read",
     *     tags={"ChatPrivate"},
     *     summary="Tandai pesan sebagai dibaca",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function chatPrivateRead() {}



    /* ============================================================
     *                       GROUP CHAT MODULE
     * ============================================================ */

    /**
     * @OA\Post(
     *     path="/api/group/chat/send",
     *     tags={"GroupChat"},
     *     summary="Kirim pesan ke grup",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function groupChatSend() {}

    /**
     * @OA\Post(
     *     path="/api/group/chat/send-image",
     *     tags={"GroupChat"},
     *     summary="Kirim gambar ke grup",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function groupChatImage() {}

    /**
     * @OA\Get(
     *     path="/api/group/{id}/chat",
     *     tags={"GroupChat"},
     *     summary="Ambil chat grup",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function groupChatList() {}



    /* ============================================================
     *                 INFAQ / SETORAN / GAJI MODULE
     * ============================================================ */

    /**
     * @OA\Get(
     *     path="/api/infaq",
     *     tags={"Infaq"},
     *     summary="List data infaq",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data infaq",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Infaq")),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     )
     * )
     */
    public function infaqIndex() {}

    /**
     * @OA\Post(
     *     path="/api/infaq",
     *     tags={"Infaq"},
     *     summary="Tambah data infaq",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="santri_id", type="integer"),
     *             @OA\Property(property="nominal", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function infaqStore() {}

    /**
     * @OA\Get(
     *     path="/api/setoran",
     *     tags={"Setoran"},
     *     summary="List data setoran hafalan",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function setoranIndex() {}

    /**
     * @OA\Post(
     *     path="/api/setoran",
     *     tags={"Setoran"},
     *     summary="Tambah data setoran hafalan",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function setoranStore() {}

    /**
     * @OA\Get(
     *     path="/api/gaji",
     *     tags={"Gaji"},
     *     summary="List data gaji ustadz/pengajar",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, ref="#/components/responses/ApiSuccess")
     * )
     */
    public function gajiIndex() {}
}
