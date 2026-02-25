<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChatWebController extends Controller
{
    /**
     * Display chat list / conversations
     */
    public function index()
    {
        $userId = auth()->id();

        // Get all chats involving the current user
        $allChats = Chat::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by the other user (conversation partner)
        $grouped = $allChats->groupBy(function ($chat) use ($userId) {
            return $chat->sender_id == $userId ? $chat->receiver_id : $chat->sender_id;
        });

        // Build conversation list
        $conversations = $grouped->map(function ($chats, $otherUserId) use ($userId) {
            $lastChat = $chats->first(); // already sorted desc
            $otherUser = User::find($otherUserId);

            if (!$otherUser) return null;

            $unreadCount = $chats->where('sender_id', $otherUserId)
                ->where('is_read', false)
                ->count();

            return (object) [
                'id' => $otherUserId,
                'is_group' => false,
                'unread_count' => $unreadCount,
                'last_message' => $lastChat->message,
                'last_message_at' => $lastChat->created_at,
                'recipient' => (object) [
                    'name' => $otherUser->name,
                    'foto' => $otherUser->foto,
                    'is_online' => false,
                ],
            ];
        })->filter()->sortByDesc(function ($conv) {
            return $conv->last_message_at;
        })->values();

        return view('chat.index', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Show new chat / contact picker
     */
    public function create()
    {
        $userId = auth()->id();

        // Get all users except the current user and admins
        $contacts = User::where('id', '!=', $userId)
            ->whereNotIn('role', ['ADMIN', 'admin'])
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($user) {
                return (object) [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => strtoupper($user->role),
                    'foto' => $user->foto,
                    'is_online' => false,
                ];
            });

        return view('chat.new', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show chat room
     */
    public function room($id)
    {
        $userId = auth()->id();
        $otherUser = User::find($id);

        if (!$otherUser) {
            return redirect()->route('chat.index')
                ->with('error', 'User tidak ditemukan');
        }

        // Get all messages between the two users
        $messages = Chat::where(function ($q) use ($userId, $id) {
                $q->where('sender_id', $userId)->where('receiver_id', $id);
            })
            ->orWhere(function ($q) use ($userId, $id) {
                $q->where('sender_id', $id)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark unread messages from the other user as read
        Chat::where('sender_id', $id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.room', [
            'recipient' => (object) [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'foto' => $otherUser->foto,
            ],
            'messages' => $messages,
            'isGroup' => false,
        ]);
    }

    /**
     * Send message
     */
    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
            'message' => $request->message,
            'type' => 'text',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat,
        ]);
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
            $data = [
                'name' => $request->name,
                'email' => $request->email ?? $request->name . '@tpq.local',
                'password' => bcrypt('password123'),
                'role' => strtoupper($request->role ?? 'SANTRI'),
                'no_hp' => $request->phone,
                'status' => 'AKTIF',
            ];

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('contacts', 'public');
            }

            User::create($data);

            return redirect()->route('chat.new')
                ->with('success', 'Kontak berhasil disimpan!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
