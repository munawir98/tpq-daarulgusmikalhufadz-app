<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Components(
 *
 *     @OA\Schema(
 *         schema="ChatPrivate",
 *         type="object",
 *         description="Schema untuk pesan privat",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="sender_id", type="integer"),
 *         @OA\Property(property="receiver_id", type="integer"),
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(property="type", type="string", example="text"),
 *         @OA\Property(property="read_at", type="string", nullable=true)
 *     ),
 *
 *     @OA\Schema(
 *         schema="Group",
 *         type="object",
 *         description="Schema untuk data group chat",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="created_by", type="integer")
 *     ),
 *
 *     @OA\Schema(
 *         schema="GroupMember",
 *         type="object",
 *         description="Schema anggota group chat",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="group_id", type="integer"),
 *         @OA\Property(property="user_id", type="integer")
 *     ),
 *
 *     @OA\Schema(
 *         schema="GroupMessage",
 *         type="object",
 *         description="Schema pesan group chat",
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
class ChatSchemas {}
