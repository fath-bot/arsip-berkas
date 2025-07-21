<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(match (Auth::user()->role) {
                'admin' => 'admin.dashboard',
                'superadmin' => 'superadmin.dashboard',
                'user' => 'user.dashboard',
                default => 'login',
            });
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            // Coba login melalui API eksternal
            $client = new Client();
            $response = $client->post('https://map.bpkp.go.id/api/v5/login', [
                'form_params' => [
                    'username'   => $request->username,
                    'password'   => $request->password,
                    'kelas_user' => 0,
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['status']) && $result['status'] === true) {
                // Ambil data dari respon API
                $nip  = $result['message']['nipbaru'] ?? null;
                $name = $result['message']['name'] ?? $request->username;
                $email = $nip ? $nip . '@example.com' : $request->username . '@example.com';

                // Buat atau cari user lokal
                $user = User::firstOrCreate(
                    ['nip' => $nip],
                    [
                        'name'     => $name,
                        'email'    => $email,
                        'username' => $request->username,
                        'role'     => 'user',
                        'password' => bcrypt(Str::random(16)), // dummy password
                    ]
                );

                // Update jika ada perubahan nama/email
                $user->update([
                    'name' => $name,
                    'email' => $email,
                ]);

                // Login ke sistem Laravel
                Auth::login($user);

                // ✅ Simpan session tambahan
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_name', $user->name);
                $request->session()->put('role', $user->role);

                // Redirect sesuai role
                return redirect()->route(match ($user->role) {
                    'admin' => 'admin.dashboard',
                    'superadmin' => 'superadmin.dashboard',
                    'user' => 'user.dashboard',
                    default => 'login',
                });
            }

            return back()->withErrors(['login' => 'Login gagal: respons API tidak valid.']);
        } catch (\Exception $e) {
            // Jika gagal ke API, fallback ke login lokal
            $user = User::where('email', $request->username)
                        ->orWhere('nip', $request->username) 
                        ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);

                // ✅ Simpan session tambahan
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_name', $user->name);
                $request->session()->put('role', $user->role);

                return redirect()->route(match ($user->role) {
                    'admin' => 'admin.dashboard',
                    'superadmin' => 'superadmin.dashboard',
                    'user' => 'user.dashboard',
                    default => 'login',
                });
            }

            return back()->withErrors(['login' => 'Login gagal: username atau password salah.']);
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    // Cek status login
    public function checkAuth()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::user()
        ]);
    }
}
