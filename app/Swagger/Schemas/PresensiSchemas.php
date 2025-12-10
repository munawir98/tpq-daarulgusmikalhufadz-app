<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Components(
 *
 *     @OA\Schema(
 *         schema="Presensi",
 *         type="object",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="user_id", type="integer"),
 *         @OA\Property(property="tanggal", type="string", example="2025-01-01"),
 *         @OA\Property(property="jam", type="string", example="07:00:00"),
 *         @OA\Property(property="tipe", type="string", example="masuk"),
 *         @OA\Property(property="status_presensi", type="string", example="HADIR"),
 *         @OA\Property(property="latitude", type="string"),
 *         @OA\Property(property="longitude", type="string"),
 *         @OA\Property(property="foto", type="string")
 *     )
 *
 * )
 */
class PresensiSchemas {}
