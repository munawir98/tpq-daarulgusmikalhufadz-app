<?php

namespace App\Swagger;

/**
 * @OA\Components(
 *
 *     @OA\Response(
 *         response="ApiSuccess",
 *         description="Response sukses standar",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Berhasil"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response="ApiError",
 *         description="Response error standar",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
 *             @OA\Property(property="errors", type="object", nullable=true)
 *         )
 *     ),
 *
 *     @OA\Schema(
 *         schema="PaginationMeta",
 *         type="object",
 *         @OA\Property(property="current_page", type="integer"),
 *         @OA\Property(property="last_page", type="integer"),
 *         @OA\Property(property="per_page", type="integer"),
 *         @OA\Property(property="total", type="integer")
 *     ),
 *
 *     @OA\SecurityScheme(
 *         securityScheme="sanctum",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT"
 *     ),
 *
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="role", type="string"),
 *         @OA\Property(property="no_hp", type="string"),
 *         @OA\Property(property="alamat", type="string"),
 *         @OA\Property(property="foto", type="string"),
 *         @OA\Property(property="status", type="string"),
 *         @OA\Property(property="last_login", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Santri",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="kelas_id", type="integer"),
 *         @OA\Property(property="orang_tua", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Ustadz",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="no_hp", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Pengajar",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="bidang", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Kelas",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama_kelas", type="string"),
 *         @OA\Property(property="ustadz_id", type="integer")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Jadwal",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="hari", type="string"),
 *         @OA\Property(property="jam_mulai", type="string"),
 *         @OA\Property(property="jam_selesai", type="string"),
 *         @OA\Property(property="ustadz_id", type="integer")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Presensi",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="user_id", type="integer"),
 *         @OA\Property(property="tanggal", type="string"),
 *         @OA\Property(property="jam", type="string"),
 *         @OA\Property(property="tipe", type="string"),
 *         @OA\Property(property="status_presensi", type="string"),
 *         @OA\Property(property="latitude", type="string"),
 *         @OA\Property(property="longitude", type="string"),
 *         @OA\Property(property="foto", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Setoran",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="santri_id", type="integer"),
 *         @OA\Property(property="surah", type="string"),
 *         @OA\Property(property="ayat", type="string"),
 *         @OA\Property(property="tanggal", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Infaq",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="santri_id", type="integer"),
 *         @OA\Property(property="nominal", type="integer"),
 *         @OA\Property(property="tanggal", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="Gaji",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="pengajar_id", type="integer"),
 *         @OA\Property(property="jumlah", type="integer"),
 *         @OA\Property(property="bulan", type="string")
 *     ),
 *
 *     @OA\Schema(
 *         schema="ChatPrivate",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="sender_id", type="integer"),
 *         @OA\Property(property="receiver_id", type="integer"),
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(property="type", type="string"),
 *         @OA\Property(property="read_at", type="string", nullable=true)
 *     ),
 *
 *     @OA\Schema(
 *         schema="Group",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="created_by", type="integer")
 *     ),
 *
 *     @OA\Schema(
 *         schema="GroupMember",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="group_id", type="integer"),
 *         @OA\Property(property="user_id", type="integer")
 *     ),
 *
 *     @OA\Schema(
 *         schema="GroupMessage",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="group_id", type="integer"),
 *         @OA\Property(property="sender_id", type="integer"),
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(property="type", type="string"),
 *         @OA\Property(property="created_at", type="string")
 *     )
 *
 * )
 */
class Schemas {}
