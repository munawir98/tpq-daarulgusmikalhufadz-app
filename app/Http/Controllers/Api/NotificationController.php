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
    public function index()
    {
        $user = auth()->user();
        $query = $user->notifications();

        // Search by title or body (data JSON column)
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $query->where('data', 'like', '%' . $search . '%');
        }

        // Filter by type or status
        if (request()->has('filter') && request('filter') != '') {
            $filter = request('filter');
            if ($filter == 'unread') {
                $query->whereNull('read_at');
            } elseif ($filter == 'read') {
                $query->whereNotNull('read_at');
            } elseif ($filter == 'failed') {
                // Assuming 'failed' might be a specific type or logic,
                // but for now let's just use 'unread' as a placeholder or specific type if defined.
                // Or if we check the data for status.
                // For this implementation, let's assume 'failed' is a status in the data column for now,
                // or just leave it for future specific implementation if not defined.
                // Let's filter by data->status if possible, or just ignore if not applicable yet.
                 $query->where('data', 'like', '%"status":"failed"%');
            } elseif ($filter == 'sent') {
                 // Similarly for sent
                 $query->where('data', 'like', '%"status":"sent"%');
            }
        }

        $notifications = $query->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $notifications->items(),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'total' => $notifications->total(),
            ]
        ]);
    }
}
