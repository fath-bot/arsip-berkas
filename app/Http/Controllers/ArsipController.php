<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    // INDEX: ADMIN dan USER
    public function index(?string $type = null)
    {
        $arsipJenisList = ArsipJenis::all();

        if (request()->is('admin/*')) {
            if (!$type) abort(404, 'Jenis arsip diperlukan untuk admin.');

            $jenisArsip = $arsipJenisList->first(fn($j) => Str::slug($j->nama_jenis) === $type)
                ?? abort(404, "Jenis arsip “{$type}” tidak ditemukan.");

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

        // USER
        $userId = session('user_id');

        $items = Arsip::with(['jenis'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('user.arsip.index', [
            'items' => $items,
            'title' => 'Semua Arsip Saya',
        ]);
    }

    // CREATE
    public function create($type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $users = User::all();

        return view('admin.pages.arsip.create', compact('type', 'jenisArsip', 'users'));
    }

    // STORE
    public function store(Request $request, $type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan_arsip' => 'nullable|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'letak_berkas' => 'nullable|string|max:255',
            'tanggal_upload' => 'required|date',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('arsip', 'public');
        }

        Arsip::create([
            'user_id' => $validated['user_id'],
            'arsip_jenis_id' => $jenisArsip->id,
            'keterangan_arsip' => $validated['keterangan_arsip'] ?? null,
            'nama_arsip' => $validated['nama_arsip'],
            'file_path' => $filePath,
            'letak_berkas' => $validated['letak_berkas'] ?? null,
            'tanggal_upload' => $validated['tanggal_upload'],
        ]);

        return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil disimpan');
    }

    // EDIT
    public function edit($type, $id)
    {
        $jenisArsip = ArsipJenis::whereRaw('LOWER(REPLACE(nama_jenis, " ", "-")) = ?', [$type])->firstOrFail();

        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);
        $users = User::all();

        return view('admin.pages.arsip.edit', compact('type', 'item', 'users', 'jenisArsip'));
    }

    // UPDATE
    public function update(Request $request, $type, $id)
    {
        $jenisArsip = ArsipJenis::whereRaw('LOWER(REPLACE(nama_jenis, " ", "-")) = ?', [$type])->firstOrFail();

        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan_arsip' => 'nullable|string|max:255', 
            'nama_arsip' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'letak_berkas' => 'nullable|string|max:255',
            'tanggal_upload' => 'nullable|date',
        ]);

        // Hapus file lama jika upload baru
        if ($request->hasFile('file')) {
            if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                Storage::disk('public')->delete($item->file_path);
            }
            $item->file_path = $request->file('file')->store('arsip', 'public');
        }

        $item->update([
            'user_id' => $validated['user_id'],
            'keterangan_arsip' => $validated['keterangan_arsip']  ?? null, 
            'nama_arsip' => $validated['nama_arsip'],
            'letak_berkas' => $validated['letak_berkas'] ?? null,
            'tanggal_upload' => $validated['tanggal_upload'],
            'file_path' => $item->file_path  ?? null, // update jika file baru di-upload
        ]);

        return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil diperbarui');
    }

    // DESTROY
    public function destroy($type, $id)
    {$jenisArsip = ArsipJenis::whereRaw('LOWER(REPLACE(nama_jenis, " ", "-")) = ?', [$type])->firstOrFail();

        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);

        // Hapus file dari storage jika ada
        if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return back()->with('success', 'Data arsip berhasil dihapus');
    }

    // SHOW
    public function show($type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);

        if (request()->is('user/*') && $item->user_id !== session('user_id')) {
            abort(403, 'Tidak boleh akses arsip orang lain.');
        }

        $view = request()->is('admin/*') ? 'admin.pages.arsip.show' : 'user.arsip.show';

        return view($view, compact('type', 'item', 'jenisArsip'));
    }
}
