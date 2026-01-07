<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileWebController extends Controller
{
    public function index()
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login.form');
        }

        return view('profile.index', [
            'user' => (object) $user,
        ]);
    }

    public function edit()
    {
        $user = session('user');

        return view('profile.edit', [
            'user' => (object) $user,
        ]);
    }

    public function showPasswordForm()
    {
        return view('profile.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect('/login');
        }

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }

            // Store new photo
            $path = $request->file('foto')->store('profile-photos', 'public');
            $data['foto'] = $path;
        }

        $user->update($data);

        // Update session with all user data
        session()->put('user', [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'role'   => $user->role,
            'nis'    => $user->nis,
            'foto'   => $user->foto,
            'no_hp'  => $user->no_hp,
            'alamat' => $user->alamat,
        ]);

        // Redirect based on role
        $role = strtoupper($user->role);
        $redirectUrl = match($role) {
            'ADMIN' => '/admin/settings',
            'USTADZ' => '/ustadz/settings',
            default => '/profile',
        };

        return redirect($redirectUrl)->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect('/login');
        }

        // Verify current password
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        // Update password
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        // Redirect based on role
        $role = strtoupper($user->role);
        $redirectUrl = match($role) {
            'ADMIN' => '/admin/settings',
            'USTADZ' => '/ustadz/settings',
            default => '/profile',
        };

        return redirect($redirectUrl)->with('success', 'Kata sandi berhasil diubah!');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect('/login');
        }

        // Delete old photo if exists
        if ($user->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
        }

        // Store new photo
        $path = $request->file('foto')->store('profile-photos', 'public');
        $user->update(['foto' => $path]);

        // Update session
        session()->put('user.foto', $path);

        // Redirect based on role
        $role = strtoupper($user->role);
        $redirectUrl = match($role) {
            'ADMIN' => '/admin/settings',
            'USTADZ' => '/ustadz/settings',
            default => '/profile',
        };

        return redirect($redirectUrl)->with('success', 'Foto profil berhasil diperbarui!');
    }

    // Alias for changePassword (used by admin route)
    public function updatePassword(Request $request)
    {
        return $this->changePassword($request);
    }

    public function deletePhoto()
    {
        return back()->with('success', 'Foto dihapus');
    }

    /**
     * Display notifications page
     */
    public function notifications()
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect('/login');
        }

        // Get notifications from database
        $dbNotifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        // Transform to match view format
        $notifications = $dbNotifications->map(function ($notification) {
            $data = $notification->data;
            return [
                'id' => $notification->id,
                'type' => $data['type'] ?? 'info',
                'title' => $data['title'] ?? 'Notifikasi',
                'message' => $data['message'] ?? '',
                'created_at' => $notification->created_at,
                'read_at' => $notification->read_at,
            ];
        });

        return view('profile.notifications', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark single notification as read
     */
    public function markNotificationRead($id)
    {
        try {
            $userId = session('user.id');
            $user = \App\Models\User::find($userId);

            if (!$user) {
                return response()->json(['success' => false], 401);
            }

            $notification = $user->notifications()->find($id);

            if ($notification) {
                $notification->markAsRead();
                $url = $notification->data['url'] ?? null;

                return response()->json([
                    'success' => true,
                    'url' => $url,
                ]);
            }

            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsRead()
    {
        try {
            $userId = session('user.id');
            $user = \App\Models\User::find($userId);

            if (!$user) {
                return response()->json(['success' => false], 401);
            }

            $user->unreadNotifications->markAsRead();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}

