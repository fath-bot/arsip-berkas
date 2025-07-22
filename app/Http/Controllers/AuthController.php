<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (session('logged_in')) {
            // Redirect sesuai role yang disimpan di session
            return redirect()->route(
                match (session('role')) {
                    'admin'      => 'admin.dashboard',
                    'superadmin' => 'superadmin.dashboard',
                    'user'       => 'user.dashboard',
                    default      => 'login',
                }
            );
        }

        return view('auth.login');
    }

    /**
     * Proses login via API eksternal, dengan fallback ke login lokal.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Coba login ke API eksternal
        try {
            $client = new Client();
            $response = $client->post('https://map.bpkp.go.id/api/v5/login', [
                'form_params' => [
                    'username'   => $username,
                    'password'   => $password,
                    'kelas_user' => 0,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Ambil data yang diperlukan
            $nip   = $data['message']['nipbaru'] ?? null;
            $name  = $data['message']['name']    ?? $username;
            $email = $nip ? "{$nip}@example.com" : "{$username}@example.com";
            $token = $data['access_token']       ?? null;

            // Cari atau buat user di database lokal
            $user = User::firstOrCreate(
                ['nip' => $nip],
                [
                    'name'     => $name,
                    'email'    => $email,
                    'role'     => 'user',
                    'password' => bcrypt(\Illuminate\Support\Str::random(16)),
                ]
            );

            // Update nama/email jika ada perubahan
            $user->update([
                'name'  => $name,
                'email' => $email,
            ]);

            // Simpan data ke session
            session([
                'user_id'         => $user->id,
                'user_name'       => $user->name,
                'user_nip'        => $user->nip,
                'user_token'      => $token,
                'logged_in'       => true,
                'role'            => $user->role,
                'arsip_count'     => $user->arsips()->count(),
                'transaksi_count' => $user->transaksis()->count(),
            ]);

            // Beri respons JSON untuk AJAX
            return response()->json([
                'success'  => true,
                'redirect' => route(
                    match ($user->role) {
                        'admin'      => 'admin.dashboard',
                        'superadmin' => 'superadmin.dashboard',
                        'user'       => 'user.dashboard',
                        default      => 'login',
                    }
                ),
            ]);
        }
        catch (\Exception $e) {
            // Fallback: login lokal
            $user = User::where('email', $username)
                        ->orWhere('nip', $username)
                        ->first();

            if ($user && Hash::check($password, $user->password)) {
                session([
                    'user_id'   => $user->id,
                    'user_name' => $user->name,
                    'user_nip'  => $user->nip,
                    'logged_in' => true,
                    'role'      => $user->role,
                ]);

                return response()->json([
                    'success'  => true,
                    'redirect' => route(
                        match ($user->role) {
                            'admin'      => 'admin.dashboard',
                            'superadmin' => 'superadmin.dashboard',
                            'user'       => 'user.dashboard',
                            default      => 'login',
                        }
                    ),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Login gagal: kredensial salah atau akun tidak ditemukan.'
            ], 401);
        }
    }

    /**
     * Proses logout (flush session).
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Cek status login (untuk API testing).
     */
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => session('logged_in', false),
        ]);
    }
}
