<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveFcmTokenRequest;
use App\Models\UserToken;

class FcmTokenController extends Controller
{
    /**
     * Store or update the authenticated user's FCM token.
     *
     * Behaviour:
     * - If token exists for the user → updated (no duplication)
     * - If token is new → inserted
     *
     * @param  SaveFcmTokenRequest  $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SaveFcmTokenRequest $req)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized user'
            ], 401);
        }

        UserToken::updateOrCreate(
            [
                'user_id'   => $userId,
                'fcm_token' => $req->fcm_token,
            ],
            [
                'fcm_token' => $req->fcm_token
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'FCM token saved successfully',
            'data'    => [
                'user_id'    => $userId,
                'fcm_token'  => $req->fcm_token
            ]
        ], 200);
    }
}
