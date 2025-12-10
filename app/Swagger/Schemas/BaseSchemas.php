<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Components(
 *     @OA\Response(
 *         response="ApiSuccess",
 *         description="Response sukses standar",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Berhasil"),
 *             @OA\Property(property="data", type="object", nullable=true)
 *         )
 *     ),

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

 *     @OA\Schema(
 *         schema="PaginationMeta",
 *         type="object",
 *         @OA\Property(property="current_page", type="integer", example=1),
 *         @OA\Property(property="last_page", type="integer", example=5),
 *         @OA\Property(property="per_page", type="integer", example=10),
 *         @OA\Property(property="total", type="integer", example=47)
 *     ),

 *     @OA\SecurityScheme(
 *         securityScheme="sanctum",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT"
 *     )
 * )
 */
class BaseSchemas {}
