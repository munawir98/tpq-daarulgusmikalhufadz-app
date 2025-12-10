<?php

namespace App\Services\Notification;

use Google\Client;
use Illuminate\Support\Facades\Http;

class FcmService
{
    protected $credentials;
    protected $projectId;

    public function __construct()
    {
        $path = storage_path('app/' . env('FIREBASE_CREDENTIALS'));

        $this->credentials = json_decode(file_get_contents($path), true);
        $this->projectId   = $this->credentials['project_id'];
    }

    private function getAccessToken()
    {
        $client = new Client();
        $client->setAuthConfig($this->credentials);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();

        return $token['access_token'];
    }

    public function send(string $token, string $title, string $body)
    {
        if (!$token) return;

        $accessToken = $this->getAccessToken();

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
            ]
        ];

        return Http::withToken($accessToken)
            ->post($url, $payload)
            ->json();
    }
}

