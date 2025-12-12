<?php

namespace App\Services\Fcm;

use GuzzleHttp\Client;
use Firebase\JWT\JWT;

class FcmService
{
    protected $client;
    protected $projectId;
    protected $clientEmail;
    protected $privateKey;

    public function __construct()
    {
        $this->client      = new Client(["verify" => false, "timeout" => 10]);
        $this->projectId   = env('FCM_PROJECT_ID');
        $this->clientEmail = env('FCM_CLIENT_EMAIL');

        // Fix private key newlines
        $this->privateKey  = str_replace("\\n", "\n", env('FCM_PRIVATE_KEY'));
    }


    /**
     * =====================================================================
     * GET ACCESS TOKEN FOR FCM HTTP v1
     * =====================================================================
     */
    private function getAccessToken()
    {
        $now = time();
        $exp = $now + 3600;

        $payload = [
            "iss"   => $this->clientEmail,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging",
            "aud"   => "https://oauth2.googleapis.com/token",
            "iat"   => $now,
            "exp"   => $exp
        ];

        $jwt = JWT::encode($payload, $this->privateKey, 'RS256');

        $response = $this->client->post("https://oauth2.googleapis.com/token", [
            "form_params" => [
                "grant_type" => "urn:ietf:params:oauth:grant-type:token-assertion",
                "assertion"  => $jwt
            ]
        ]);

        return json_decode($response->getBody(), true)["access_token"];
    }


    /**
     * =====================================================================
     * SEND NOTIFICATION TO A SINGLE DEVICE TOKEN
     * =====================================================================
     */
    public function sendToToken($token, $title, $body, array $data = [])
    {
        $accessToken = $this->getAccessToken();

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";


        $message = [
            "message" => [
                "token" => $token,

                // NOTIFICATION (Android/iOS foreground)
                "notification" => [
                    "title" => $title,
                    "body"  => $body,
                    "image" => $data["avatar"] ?? null
                ],

                // ANDROID EXTRA CONFIG
                "android" => [
                    "priority" => "high",
                    "ttl" => "30s",
                    "collapse_key" => $data["collapse_key"] ?? null,
                    "notification" => [
                        "channel_id" => "tpq_chat_channel",
                        "sound"      => "default",
                        "image"      => $data["avatar"] ?? null,
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    ]
                ],

                // iOS EXTRA CONFIG
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "default",
                            "badge" => (int) ($data["badge"] ?? 0),
                            "content-available" => 1
                        ]
                    ],
                    "fcm_options" => [
                        "image" => $data["avatar"] ?? null,
                    ]
                ],

                // DATA FOR FLUTTER BACKGROUND HANDLER
                "data" => array_map('strval', array_merge($data, [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                ]))
            ]
        ];

        return $this->client->post($url, [
            "headers" => [
                "Authorization" => "Bearer {$accessToken}",
                "Content-Type"  => "application/json",
            ],
            "json" => $message
        ]);
    }

    public function sendToMany(array $tokens, string $title, string $body, array $data = [])
{
    if (empty($tokens)) {
        return;
    }

    $accessToken = $this->getAccessToken();

    $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

    foreach ($tokens as $token) {

        $message = [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => $title,
                    "body"  => $body,
                ],
                "data" => $data,
            ]
        ];

        $this->client->post($url, [
            "headers" => [
                "Authorization" => "Bearer {$accessToken}",
                "Content-Type"  => "application/json",
            ],
            "json" => $message,
        ]);
    }
}

}
