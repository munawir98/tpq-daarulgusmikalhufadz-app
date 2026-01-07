<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatWebController extends Controller
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
     * Display chat list / conversations
     */
    public function index()
    {
        try {
            $response = Http::withToken($this->getToken())
                ->get($this->apiUrl('/chat/conversations'));

            $conversations = $response->successful()
                ? collect($response->json('data', []))
                : collect();

        } catch (\Exception $e) {
            $conversations = collect();
        }

        return view('chat.index', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Show new chat / contact picker
     */
    public function create()
    {
        try {
            $response = Http::withToken($this->getToken())
                ->get($this->apiUrl('/chat/contacts'));

            $contacts = $response->successful()
                ? collect($response->json('data', []))
                : collect();

        } catch (\Exception $e) {
            $contacts = collect();
        }

        return view('chat.new', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show chat room
     */
    public function room($id)
    {
        try {
            $response = Http::withToken($this->getToken())
                ->get($this->apiUrl("/chat/{$id}"));

            if (!$response->successful()) {
                return redirect()->route('chat.index')
                    ->with('error', 'Chat tidak ditemukan');
            }

            $data = $response->json('data');

            return view('chat.room', [
                'recipient' => (object) $data['recipient'],
                'messages' => collect($data['messages'] ?? []),
                'isGroup' => $data['is_group'] ?? false,
            ]);

        } catch (\Exception $e) {
            return redirect()->route('chat.index')
                ->with('error', 'Gagal memuat chat');
        }
    }

    /**
     * Send message
     */
    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $response = Http::withToken($this->getToken())
                ->post($this->apiUrl("/chat/{$id}/send"), [
                    'message' => $request->message,
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => $response->json('data'),
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Gagal mengirim pesan',
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan',
            ], 500);
        }
    }
}
