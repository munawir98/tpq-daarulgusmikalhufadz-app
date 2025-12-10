<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Components(
 *
 *     @OA\Schema(
 *         schema="Infaq",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="santri_id", type="integer"),
 *         @OA\Property(property="nominal", type="integer"),
 *         @OA\Property(property="tanggal", type="string")
 *     ),

 *     @OA\Schema(
 *         schema="Setoran",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="santri_id", type="integer"),
 *         @OA\Property(property="surah", type="string"),
 *         @OA\Property(property="ayat", type="string"),
 *         @OA\Property(property="tanggal", type="string")
 *     ),

 *     @OA\Schema(
 *         schema="Gaji",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="pengajar_id", type="integer"),
 *         @OA\Property(property="jumlah", type="integer"),
 *         @OA\Property(property="bulan", type="string")
 *     )
 *
 * )
 */
class KeuanganSchemas {}
