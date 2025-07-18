<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (session('logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string'
    ]);

    try {
        $client = new Client();
        $response = $client->post('https://map.bpkp.go.id/api/v5/login', [
            'form_params' => [
                'username' => $request->username,
                'password' => $request->password,
                'kelas_user' => 0,
            ],
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $nip = $data['message']['nipbaru'] ?? null;
        $name = $data['message']['name'] ?? null;
        $email = $nip . '@example.com';

       // Cek apakah user sudah ada
        $user = \App\Models\User::where('nip', $nip)->first();

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $name,
                'email' => $email,
                'nip' => $nip,
                'role' => 'user', // default role
                'password' => bcrypt(\Illuminate\Support\Str::random(16)) // password dummy agar valid
            ]);
        } else {
            // Update nama & email jika berubah
            $user->update([
                'name' => $name,
                'email' => $email
                // role tidak diubah, karena mungkin sudah diedit oleh admin
            ]);
        }


        // Simpan ke session
        // Di dalam method login(), setelah membuat/update user:
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_nip' => $user->nip,
            'user_token' => $data['access_token'] ?? null,
            'logged_in' => true,
            'role' => $user->role,
            // Tambahkan ini untuk akses cepat:
            'arsip_count' => $user->arsips->count(),
            'transaksi_count' => $user->transaksis->count()
        ]);

        // Redirect berdasarkan role
        $redirectRoute = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'superadmin' => route('superadmin.dashboard'),
            'user' => route('user.dashboard'),
            default => route('login'),
        };

        return response()->json([
            'success' => true,
            'redirect' => $redirectRoute
        ]);

    } catch (\Exception $e) {
        // Login lokal fallback jika gagal API
        $user = \App\Models\User::where('email', $request->username)
            ->orWhere('nip', $request->username)
            ->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_nip' => $user->nip,
                'logged_in' => true,
                'role' => $user->role
            ]);

            $redirectRoute = match ($user->role) {
                'admin' => route('admin.dashboard'),
                'superadmin' => route('superadmin.dashboard'),
                'user' => route('user.dashboard'),
                default => route('login'),
            };

            return response()->json([
                'success' => true,
                'redirect' => $redirectRoute
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Login gagal: kredensial salah atau akun tidak ditemukan.'
        ], 401);
    }
}


    // Proses logout
    public function logout(Request $request)
    {
        // Hapus semua data session
        $request->session()->flush();
        
        // Redirect ke halaman login dengan pesan
        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }

    // Method untuk mengecek status login
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => session('logged_in', false)
        ]);
    }
}