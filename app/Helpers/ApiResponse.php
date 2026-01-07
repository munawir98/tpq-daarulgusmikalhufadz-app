<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApiResponse
{
    /**
     * =========================
     * SUCCESS RESPONSE
     * =========================
     */
    public static function success(
        $data = null,
        string $message = 'OK',
        int $code = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * =========================
     * ERROR RESPONSE
     * =========================
     */
    public static function error(
        string $message = 'Error',
        int $code = 400,
        $errors = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * =========================
     * PAGINATION RESPONSE
     * =========================
     */
    public static function paginate(
        LengthAwarePaginator $paginator,
        string $resourceClass = null,
        string $message = 'Data berhasil dimuat',
        int $code = 200
    ): JsonResponse {
        $items = collect($paginator->items());

        if ($resourceClass) {
            $items = $resourceClass::collection($items);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $items,
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ], $code);
    }
}
