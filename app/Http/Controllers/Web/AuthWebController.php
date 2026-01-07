<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthWebController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW FORMS
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        $ustadazList = \App\Models\User::where('role', 'USTADZ')->get();
        return view('auth.register', compact('ustadazList'));
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN (WEB → API)
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'nis'      => 'required',
            'password' => 'required',
        ]);

        // Cari user by NIS atau Email, atau NIP
        $user = \App\Models\User::where('nis', $request->nis)
            ->orWhere('email', $request->nis)
            ->orWhere('nip', $request->nis)
            ->first();

        // Debug log
        \Illuminate\Support\Facades\Log::info('Login attempt', [
            'input' => $request->nis,
            'user_found' => $user ? $user->email : 'NOT FOUND',
            'password_check' => $user ? \Illuminate\Support\Facades\Hash::check($request->password, $user->password) : 'N/A',
        ]);

        // Validasi user dan password
        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'NIS/NIP/Email atau password salah.',
            ])->withInput();
        }

        // Generate token
        $token = $user->createToken('web-session')->plainTextToken;

        // Simpan session
        session()->put('api_token', $token);
        session()->put('user', [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
            'nis'   => $user->nis,
            'nip'   => $user->nip,
            'foto'  => $user->foto,
        ]);
        session()->save();

        // Update last login
        $user->update(['last_login' => now()]);

        // Redirect berdasarkan role
        $role = strtoupper($user->role);
        if ($role === 'ADMIN') {
            return redirect('/admin/dashboard');
        } elseif ($role === 'USTADZ') {
            return redirect('/ustadz/dashboard');
        } else {
            return redirect()->route('dashboard'); // Santri
        }
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER (DIRECT DATABASE - untuk testing)
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:SANTRI,USTADZ,ADMIN',
            'password' => 'required|min:6|confirmed',
            'pembimbing_nip' => 'nullable|exists:users,nip',
        ]);

        try {
            $year = date('y'); // 2 digit year
            $month = date('m'); // 2 digit month

            // Generate NIS untuk Santri
            $nis = null;
            $pembimbingNip = null;
            $nip = null;

            if ($request->role === 'SANTRI') {
                $fullYear = date('Y');
                $count = \App\Models\User::where('role', 'SANTRI')
                    ->whereYear('created_at', $fullYear)
                    ->count() + 1;
                $nis = "NIS-{$fullYear}-" . str_pad($count, 4, '0', STR_PAD_LEFT);

                // Set Pembimbing NIP if provided
                if($request->pembimbing_nip) {
                    $pembimbingNip = $request->pembimbing_nip;
                }
            }

            // Generate NIP untuk Ustadz
            if ($request->role === 'USTADZ') {
                // Format: YYMM1XXX (1 = Code for Ustadz)
                $prefix = "{$year}{$month}1";

                // Get last NIP with this prefix
                $lastUser = \App\Models\User::where('role', 'USTADZ')
                    ->where('nip', 'like', "{$prefix}%")
                    ->orderBy('nip', 'desc')
                    ->first();

                if ($lastUser && $lastUser->nip) {
                    $lastSequence = intval(substr($lastUser->nip, -3));
                    $sequence = $lastSequence + 1;
                } else {
                    $sequence = 1;
                }

                $nip = $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
            }

            // Create user directly
            $user = \App\Models\User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role'     => $request->role,
                'nis'      => $nis,
                'nip'      => $nip,
                'pembimbing_nip' => $pembimbingNip,
                'status'   => 'AKTIF',
            ]);

            // Generate token
            $token = $user->createToken('web-session')->plainTextToken;

            // Simpan session
            session()->put('api_token', $token);
            session()->put('user', [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
                'nis'   => $user->nis,
                'nip'   => $user->nip,
            ]);
            session()->save();

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return back()->withErrors([
                'register' => 'Registrasi gagal: ' . $e->getMessage()
            ])->withInput();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        // OPTIONAL: panggil API logout kalau ada
        if (session('api_token')) {
            Http::withToken(session('api_token'))
                ->post(config('app.url') . '/api/logout');
        }

        // HAPUS SESSION
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Cari user by email
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        // Generate random 4-digit OTP
        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Store OTP, email and user info in session
        session([
            'reset_otp' => $otp,
            'reset_email' => $this->maskEmail($request->email),
            'reset_user_email' => $request->email,
        ]);

        // Send OTP via email (will use log driver if MAIL_MAILER=log in .env)
        // For Gmail, set MAIL_MAILER=smtp and configure SMTP settings in .env
        try {
            \Illuminate\Support\Facades\Mail::to($request->email)
                ->send(new \App\Mail\OtpMail($otp, $user->name));
        } catch (\Exception $e) {
            // If email fails, still redirect to verify page (OTP shown in debug mode)
            \Illuminate\Support\Facades\Log::error('Email error: ' . $e->getMessage());
        }

        return redirect('/verify-otp');
    }

    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1] ?? '';
        $masked = substr($name, 0, 2) . str_repeat('*', max(0, strlen($name) - 2));
        return $masked . '@' . $domain;
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */
    public function showVerifyOtpForm()
    {
        if (!session('reset_otp')) {
            return redirect('/forgot-password');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;

        if ($otp !== session('reset_otp')) {
            return back()->withErrors(['otp' => 'Kode verifikasi salah. Silakan coba lagi.']);
        }

        // OTP valid - clear OTP but keep email, set verified flag
        session()->forget(['reset_otp']);
        session(['otp_verified' => true]);

        return redirect('/reset-password');
    }

    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */
    public function showResetPasswordForm()
    {
        if (!session('otp_verified')) {
            return redirect('/forgot-password');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Reset password called', [
            'otp_verified' => session('otp_verified'),
            'reset_user_email' => session('reset_user_email'),
        ]);

        if (!session('otp_verified') || !session('reset_user_email')) {
            \Illuminate\Support\Facades\Log::warning('Reset password blocked - session missing');
            return redirect('/forgot-password');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Find user and update password
        $user = \App\Models\User::where('email', session('reset_user_email'))->first();

        if (!$user) {
            \Illuminate\Support\Facades\Log::error('User not found for email: ' . session('reset_user_email'));
            return redirect('/forgot-password')->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // Update password with Hash::make (cast removed from model)
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        \Illuminate\Support\Facades\Log::info('Password updated for user: ' . $user->email);

        // Clear all reset session data
        session()->forget(['otp_verified', 'reset_email', 'reset_user_email']);

        return redirect('/login')->with('success', 'Kata sandi berhasil diubah! Silakan login dengan kata sandi baru.');
    }
}
