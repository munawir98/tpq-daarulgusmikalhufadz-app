<?php

namespace App\Swagger;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="3.0.0",
 *         title="TPQ Daarul Gusmik Al-Hufadz — ULTRA ENTERPRISE API",
 *         description="Dokumentasi API lengkap tingkat enterprise++ dengan modular schemas & endpoints."
 *     ),

 *     @OA\Server(
 *         url="http://localhost:8000",
 *         description="Local Development Server"
 *     ),

 *     @OA\Server(
 *         url="https://tpq-daarulgusmik.id/api",
 *         description="Production Server"
 *     ),

 *     @OA\Tag(name="Auth", description="Authentication API"),
 *     @OA\Tag(name="Presensi", description="Presensi GPS/QR, laporan, rekap"),
 *     @OA\Tag(name="Setoran", description="Setoran hafalan santri"),
 *     @OA\Tag(name="Infaq", description="Infaq santri & keuangan"),
 *     @OA\Tag(name="Gaji", description="Gaji ustadz/pengajar"),
 *     @OA\Tag(name="ChatPrivate", description="Chat privat mirip WhatsApp"),
 *     @OA\Tag(name="GroupChat", description="Chat grup seperti WA Group"),
 *     @OA\Tag(name="MasterData", description="Santri, Ustadz, Pengajar, Kelas, Jadwal")
 * )
 */
class SwaggerInfo {}
