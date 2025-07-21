<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    // INDEX: ADMIN dan USER (tergantung route)
    public function index(?string $type = null)
    {
        $arsipJenisList = ArsipJenis::all();

        if (request()->is('admin/*')) {
            if (!$type) abort(404, 'Jenis arsip diperlukan untuk admin.');

            $jenisArsip = $arsipJenisList->first(fn($j) => Str::slug($j->nama_jenis) === $type)
                ?? abort(404, "Jenis arsip “{$type}” tidak ditemukan.");

            // ADMIN: ambil semua arsip berdasarkan jenis
            $items = Arsip::with(['user', 'jenis'])
                ->where('arsip_jenis_id', $jenisArsip->id)
                ->latest()
                ->get();

            return view('admin.pages.arsip.index', [
                'type' => $type,
                'items' => $items,
                'title' => $jenisArsip->nama_jenis,
                'arsipJenisList' => $arsipJenisList,
            ]);
        }

        // USER: tampilkan semua arsip miliknya tanpa filter arsip
        $items = Arsip::with(['arsip'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.arsip.index', [
            'items' => $items,
            'title' => 'Semua Arsip Saya',
        ]);
    }

    // CREATE: Admin
    public function create($type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $users = User::all();

        return view('admin.pages.arsip.create', compact('type', 'jenisArsip', 'users'));
    }

    // STORE: Admin
    public function store(Request $request, $type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_arsip' => 'nullable|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:255',
            'letak_berkas' => 'nullable|string|max:255',
            'tanggal_upload' => 'required|date',
        ]);

        $validated['arsip_jenis_id'] = $jenisArsip->id;

        Arsip::create($validated);

        return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil disimpan');
    }

    // EDIT: Admin
    public function edit($type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);
        $users = User::all();

        return view('admin.pages.arsip.edit', compact('type', 'item', 'users', 'jenisArsip'));
    }

    // UPDATE: Admin
    public function update(Request $request, $type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_arsip' => 'nullable|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:255',
            'letak_berkas' => 'nullable|string|max:255',
            'tanggal_upload' => 'required|date',
        ]);

        $item->update($validated);

        return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil diperbarui');
    }

    // DESTROY: Admin
    public function destroy($type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);
        $item->delete();

        return back()->with('success', 'Data arsip berhasil dihapus');
    }

    // SHOW: Admin dan User (detail)
    public function show($type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);

        if (request()->is('user/*') && $item->user_id !== Auth::id()) {
            abort(403, 'Tidak boleh akses arsip orang lain.');
        }

        $view = request()->is('admin/*') ? 'admin.pages.arsip.show' : 'user.arsip.show';

        return view($view, compact('type', 'item', 'jenisArsip'));
    }
}
