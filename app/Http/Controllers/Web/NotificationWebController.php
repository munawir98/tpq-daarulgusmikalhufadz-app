<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationWebController extends Controller
{
    protected function apiUrl($path = '')
    {
        return config('app.api_url', 'http://localhost:8000/api') . $path;
    }

    protected function getToken()
    {
        return session('api_token');
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Display notifications list
     */
    public function index()
    {
        try {
            $response = Http::withToken($this->getToken())
                ->get($this->apiUrl('/notifications'));

            $notifications = $response->successful()
                ? collect($response->json('data', []))
                : collect();

        } catch (\Exception $e) {
            $notifications = collect();
        }

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead()
    {
        try {
            Http::withToken($this->getToken())
                ->post($this->apiUrl('/notifications/mark-all-read'));
        } catch (\Exception $e) {
            // Silent fail
        }

        return response()->json(['success' => true]);
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead($id)
    {
        try {
            $response = Http::withToken($this->getToken())
                ->post($this->apiUrl("/notifications/{$id}/read"));

            $data = $response->json();

            return response()->json([
                'success' => true,
                'url' => $data['url'] ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        try {
            Http::withToken($this->getToken())
                ->delete($this->apiUrl("/notifications/{$id}"));
        } catch (\Exception $e) {
            // Silent fail
        }

        return back();
    }
}
