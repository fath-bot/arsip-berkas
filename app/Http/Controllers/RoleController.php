<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
    public function ubahRole(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'role' => 'required|in:user,admin,superadmin'
        ]);

        $currentRole = session('role');

        if ($currentRole === 'admin' && $request->role === 'superadmin') {
            return back()->with('error', 'Admin tidak dapat mengangkat ke superadmin.');
        }

        if ($currentRole === 'user') {
            return back()->with('error', 'Anda tidak memiliki hak akses.');
        }

        $user = User::where('nip', $request->nip)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role berhasil diperbarui.');
    }
}
