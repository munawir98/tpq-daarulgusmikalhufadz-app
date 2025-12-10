<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function sendFCM($token, $title, $body)
    {
        $serverKey = env('FCM_SERVER_KEY');
        $url = "https://fcm.googleapis.com/fcm/send";

        $payload = [
            "to" => $token,
            "notification" => [
                "title" => $title,
                "body" => $body
            ],
            "priority" => "high"
        ];

        $response = Http::withHeaders([
            "Authorization" => "key={$serverKey}",
            "Content-Type" => "application/json"
        ])->post($url, $payload);

        return $response->json();
    }
}
