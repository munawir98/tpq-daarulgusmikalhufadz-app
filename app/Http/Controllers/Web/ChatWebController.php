<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ChatWebController extends Controller
{
    const GROUP_ID = 'grup-utama';
    const GROUP_NAME = 'Grup TPQ Daarul Gusmikalhufadz';

    /**
     * Check if group_id column exists
     */
    private function hasGroupColumn(): bool
    {
        return Schema::hasColumn('chats', 'group_id');
    }

    /**
     * Display chat list / conversations
     */
    public function index()
    {
        $userId = auth()->id();
        $hasGroup = $this->hasGroupColumn();

        // Get all 1-to-1 chats involving the current user
        $query = Chat::query();
        if ($hasGroup) {
            $query->whereNull('group_id');
        }
        $allChats = $query->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by the other user (conversation partner)
        $grouped = $allChats->groupBy(function ($chat) use ($userId) {
            return $chat->sender_id == $userId ? $chat->receiver_id : $chat->sender_id;
        });

        // Build conversation list
        $conversations = $grouped->map(function ($chats, $otherUserId) use ($userId) {
            $lastChat = $chats->first();
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
        })->filter()->values();

        // Add group chat to the top (only if migration has been run)
        if ($hasGroup) {
            $lastGroupMsg = Chat::where('group_id', self::GROUP_ID)
                ->orderBy('created_at', 'desc')
                ->first();

            $memberCount = User::whereNotIn('role', ['ADMIN', 'admin'])->count();

            $groupConversation = (object) [
                'id' => 'group',
                'is_group' => true,
                'name' => self::GROUP_NAME,
                'unread_count' => 0,
                'last_message' => $lastGroupMsg ? $lastGroupMsg->message : 'Belum ada pesan',
                'last_message_at' => $lastGroupMsg ? $lastGroupMsg->created_at : now(),
                'recipient' => (object) [
                    'name' => self::GROUP_NAME,
                    'foto' => null,
                    'is_online' => false,
                    'member_count' => $memberCount,
                ],
            ];

            $conversations = collect([$groupConversation])->merge($conversations);
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
        $userId = auth()->id();

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
     * Show chat room (1-to-1)
     */
    public function room($id)
    {
        $userId = auth()->id();
        $otherUser = User::find($id);

        if (!$otherUser) {
            return redirect()->route('chat.index')
                ->with('error', 'User tidak ditemukan');
        }

        $hasGroup = $this->hasGroupColumn();

        $query = Chat::query();
        if ($hasGroup) {
            $query->whereNull('group_id');
        }
        $messages = $query->where(function ($q) use ($userId, $id) {
                $q->where('sender_id', $userId)->where('receiver_id', $id);
            })
            ->orWhere(function ($q) use ($userId, $id, $hasGroup) {
                if ($hasGroup) {
                    $q->whereNull('group_id');
                }
                $q->where('sender_id', $id)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

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
     * Send message (1-to-1)
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
     * Show group chat room
     */
    public function groupRoom()
    {
        if (!$this->hasGroupColumn()) {
            return redirect()->route('chat.index')
                ->with('error', 'Fitur grup belum tersedia. Jalankan migration terlebih dahulu.');
        }

        $messages = Chat::where('group_id', self::GROUP_ID)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $members = User::whereNotIn('role', ['ADMIN', 'admin'])
            ->orderBy('name')
            ->get();

        return view('chat.group', [
            'groupName' => self::GROUP_NAME,
            'members' => $members,
            'messages' => $messages,
        ]);
    }

    /**
     * Send group message
     */
    public function groupSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'group_id' => self::GROUP_ID,
            'receiver_id' => null,
            'message' => $request->message,
            'type' => 'text',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat->load('sender'),
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
