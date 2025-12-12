<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveFcmTokenRequest;
use App\Models\UserToken;

class FcmTokenController extends Controller
{
    /**
     * Store or update the authenticated user's FCM token.
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
                'user_id' => $userId,
            ],
            [
                'fcm_token' => $req->fcm_token,
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'FCM token saved successfully',
            'data'    => [
                'user_id'   => $userId,
                'fcm_token' => $req->fcm_token,
            ]
        ], 200);
    }
}
