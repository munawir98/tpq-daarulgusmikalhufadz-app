<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    /**
     * Show broadcast form
     */
    public function create()
    {
        return view('ustadz.broadcast.create');
    }

    /**
     * Store and send broadcast
     */
    public function store(Request $request)
    {
        $request->validate([
            'target' => 'required|in:all_santri,all_ustadz,all_users',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Get target users based on selection
        $query = User::query();

        switch ($request->target) {
            case 'all_santri':
                $query->where('role', 'SANTRI');
                break;
            case 'all_ustadz':
                $query->where('role', 'USTADZ');
                break;
            case 'all_users':
                // All users
                break;
        }

        $users = $query->get();
        $sentCount = 0;

        // Send notification to each user
        foreach ($users as $user) {
            Notification::createForUser(
                $user->id,
                $request->title,
                $request->content,
                'broadcast'
            );
            $sentCount++;
        }

        return back()->with('success', "Pengumuman berhasil dikirim ke {$sentCount} penerima!");
    }

    /**
     * Search santri for auto-complete
     */
    public function searchSantri(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            return response()->json([]);
        }

        $santri = Santri::where('nama_lengkap', 'like', "%{$search}%")
            ->orWhere('nama_panggilan', 'like', "%{$search}%")
            ->orWhere('nis', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'nama_lengkap', 'nis']);

        return response()->json($santri);
    }

    /**
     * Show broadcast history
     */
    public function index()
    {
        // Get recent broadcasts (notifications with type 'broadcast')
        $broadcasts = Notification::where('type', 'broadcast')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->unique('title'); // Remove duplicates by title

        return view('ustadz.broadcast.index', compact('broadcasts'));
    }
}
