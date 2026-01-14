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
    public function index(Request $request)
    {
            $user = auth()->user();
            $query = $user->notifications();

            // Search
            if ($request->has('search') && $request->search != '') {
                $query->where('data', 'like', '%' . $request->search . '%');
            }

            // Filter
            if ($request->has('filter') && $request->filter != '') {
                $filter = $request->filter;
                if ($filter == 'unread') {
                    $query->whereNull('read_at');
                } elseif ($filter == 'read') {
                    $query->whereNotNull('read_at');
                } elseif ($filter == 'failed') {
                     $query->where('data', 'like', '%"status":"failed"%');
                } elseif ($filter == 'sent') {
                     $query->where('data', 'like', '%"status":"sent"%');
                }
            }

            $notifications = $query->latest()->paginate(20);

        return view('notifications.index', [
            'notifications' => $notifications,
            'currentSearch' => $request->query('search'),
            'currentFilter' => $request->query('filter'),
        ]);
    }

    /**
     * Display the specified notification.
     */
    public function show($id)
    {
        return view('notifications.show');
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
