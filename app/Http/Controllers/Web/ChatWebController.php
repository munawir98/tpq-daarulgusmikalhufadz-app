<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Models\UserStatus;
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
            'message' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|max:5120', // Max 5MB file
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan atau file tidak boleh kosong',
            ], 422);
        }

        $filePath = null;
        $type = 'text';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('chat_attachments', 'public');

            $mimeType = $file->getClientMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $type = 'image';
            } else {
                $type = 'file';
            }
        }

        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $id,
            'message' => $request->message ?: null,
            'file_path' => $filePath,
            'type' => $type,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat,
        ]);
    }

    /**
     * Show Status UI
     */
    public function status()
    {
        $userId = auth()->id();

        // Get my active statuses
        $myStatuses = UserStatus::where('user_id', $userId)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'asc')
            ->get();

        // Get contacts' active statuses
        $statuses = UserStatus::with('user')
            ->whereHas('user')
            ->where('user_id', '!=', $userId)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by user
        $groupedStatuses = $statuses->groupBy('user_id')->map(function ($items) {
            return (object) [
                'user' => $items->first()->user,
                'last_updated' => $items->first()->created_at,
                'statuses' => $items->reverse()->values() // Chronological order for viewing
            ];
        })->sortByDesc('last_updated')->values();

        return view('chat.status', [
            'myStatuses' => $myStatuses,
            'recentUpdates' => $groupedStatuses,
        ]);
    }

    /**
     * Store new status
     */
    public function storeStatus(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,image,video',
            'content' => 'nullable|string',
            'caption' => 'nullable|string|max:255',
            'media' => 'nullable|file|max:10240', // 10MB max
        ]);

        $statusData = [
            'user_id' => auth()->id(),
            'type' => $request->type,
            'caption' => $request->caption,
            'expires_at' => now()->addHours(24),
        ];

        if ($request->type === 'text') {
            $statusData['content'] = $request->content;
        } else if ($request->hasFile('media')) {
            $file = $request->file('media');
            $statusData['content'] = $file->store('status_media', 'public');
        }

        UserStatus::create($statusData);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Show group chat room
     */
    public function groupRoom()
    {
        $hasGroup = $this->hasGroupColumn();

        if ($hasGroup) {
            $messages = Chat::where('group_id', self::GROUP_ID)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $messages = collect(); // Empty collection — show sample messages
        }

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
            'message' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|max:5120', // Max 5MB file
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan atau file tidak boleh kosong',
            ], 422);
        }

        $filePath = null;
        $type = 'text';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('chat_attachments', 'public');

            $mimeType = $file->getClientMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $type = 'image';
            } else {
                $type = 'file';
            }
        }

        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'group_id' => self::GROUP_ID,
            'receiver_id' => null,
            'message' => $request->message ?: null,
            'file_path' => $filePath,
            'type' => $type,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat->load('sender'),
        ]);
    }

    /**
     * Show call history
     */
    public function calls()
    {
        $userId = auth()->id();

        $callLogs = \App\Models\CallLog::with(['caller', 'receiver'])
            ->where('caller_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('chat.calls', [
            'callLogs' => $callLogs
        ]);
    }

    /**
     * Show Active Call Screen
     */
    public function activeCall($id)
    {
        $user = User::findOrFail($id);
        return view('chat.active_call', compact('user'));
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
