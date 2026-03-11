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

        $role = strtoupper($user['role']);
        $dashboardUrl = match($role) {
            'ADMIN' => '/admin/dashboard',
            'USTADZ' => '/ustadz/dashboard',
            'SANTRI' => '/santri/dashboard',
            default => '/dashboard',
        };

        return view('profile.index', [
            'user' => (object) $user,
            'dashboardUrl' => $dashboardUrl,
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

        try {
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

            // Handle photo upload - store as base64 in database
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                \Illuminate\Support\Facades\Log::info('Photo upload detected', [
                    'user_id' => $userId,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                ]);

                // Read file and convert to base64 data URI
                $imageData = file_get_contents($file->getRealPath());
                $mime = $file->getMimeType();

                // Resize image to save database space (max 300x300)
                if (function_exists('imagecreatefromstring')) {
                    $img = imagecreatefromstring($imageData);
                    if ($img) {
                        $width = imagesx($img);
                        $height = imagesy($img);
                        $maxSize = 300;

                        if ($width > $maxSize || $height > $maxSize) {
                            $ratio = min($maxSize / $width, $maxSize / $height);
                            $newWidth = (int)($width * $ratio);
                            $newHeight = (int)($height * $ratio);
                            $resized = imagecreatetruecolor($newWidth, $newHeight);
                            imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                            ob_start();
                            imagejpeg($resized, null, 80);
                            $imageData = ob_get_clean();
                            $mime = 'image/jpeg';

                            imagedestroy($resized);
                        }
                        imagedestroy($img);
                    }
                }

                $base64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);
                $data['foto'] = $base64;

                \Illuminate\Support\Facades\Log::info('Photo saved as base64', ['size' => strlen($base64)]);
            }

            $user->update($data);

            // Update session with all user data
            session()->put('user', [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'role'   => $user->role,
                'nis'    => $user->nis,
                'nip'    => $user->nip,
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

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Profile update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
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

        try {
            $file = $request->file('foto');
            $imageData = file_get_contents($file->getRealPath());
            $mime = $file->getMimeType();

            if (function_exists('imagecreatefromstring')) {
                $img = @imagecreatefromstring($imageData);
                if ($img) {
                    $width = imagesx($img);
                    $height = imagesy($img);
                    $maxSize = 300;

                    if ($width > $maxSize || $height > $maxSize) {
                        $ratio = min($maxSize / $width, $maxSize / $height);
                        $newWidth = (int)($width * $ratio);
                        $newHeight = (int)($height * $ratio);
                        $resized = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        ob_start();
                        imagejpeg($resized, null, 80);
                        $imageData = ob_get_clean();
                        $mime = 'image/jpeg';

                        imagedestroy($resized);
                    }
                    imagedestroy($img);
                }
            }

            $base64 = 'data:' . $mime . ';base64,' . base64_encode($imageData);

            $user->update(['foto' => $base64]);
            session()->put('user.foto', $base64);

            $role = strtoupper($user->role);
            $redirectUrl = match($role) {
                'ADMIN' => '/admin/settings',
                'USTADZ' => '/ustadz/settings',
                default => '/profile',
            };

            return redirect($redirectUrl)->with('success', 'Foto profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengunggah foto: ' . $e->getMessage()]);
        }
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

        $role = strtoupper($user->role);
        $dashboardUrl = match($role) {
            'ADMIN' => '/admin/dashboard',
            'USTADZ' => '/ustadz/dashboard',
            'SANTRI' => '/santri/dashboard',
            default => '/dashboard',
        };

        return view('profile.notifications', [
            'notifications' => $notifications,
            'dashboardUrl' => $dashboardUrl,
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

