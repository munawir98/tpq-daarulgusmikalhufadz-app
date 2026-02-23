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

    /**
     * Show new contact form
     */
    public function contactNew()
    {
        return view('chat.contact-new');
    }

    /**
     * Store new contact
     */
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|in:santri,ustadz,wali',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'phone', 'role', 'email']);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('contacts', 'public');
            }

            $response = Http::withToken($this->getToken())
                ->post($this->apiUrl('/chat/contacts'), $data);

            if ($response->successful()) {
                return redirect()->route('chat.new')
                    ->with('success', 'Kontak berhasil disimpan!');
            }

            return back()->withInput()
                ->with('error', 'Gagal menyimpan kontak.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
