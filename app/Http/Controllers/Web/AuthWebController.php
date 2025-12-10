<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthWebController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Panggil API /api/login
        $response = Http::post(config('app.url').'/api/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful() && $response->json('true') == true) {
            session([
                'api_token' => $response->json('token'),
                'user'      => $response->json('user'),
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }
}
