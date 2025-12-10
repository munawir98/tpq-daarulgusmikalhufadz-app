<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Components(
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

 *     @OA\Schema(
 *         schema="Santri",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="kelas_id", type="integer"),
 *         @OA\Property(property="orang_tua", type="string")
 *     ),

 *     @OA\Schema(
 *         schema="Ustadz",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="no_hp", type="string")
 *     ),

 *     @OA\Schema(
 *         schema="Pengajar",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="bidang", type="string")
 *     ),

 *     @OA\Schema(
 *         schema="Kelas",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="nama_kelas", type="string"),
 *         @OA\Property(property="ustadz_id", type="integer")
 *     ),

 *     @OA\Schema(
 *         schema="Jadwal",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="hari", type="string"),
 *         @OA\Property(property="jam_mulai", type="string"),
 *         @OA\Property(property="jam_selesai", type="string"),
 *         @OA\Property(property="ustadz_id", type="integer")
 *     )
 * )
 */
class MasterSchemas {}
