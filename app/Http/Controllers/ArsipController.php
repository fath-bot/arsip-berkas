<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ArsipController extends Controller
{
    // Method untuk menampilkan semua arsip berdasarkan jenis
    public function index($type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $items = Arsip::with(['user', 'jenis'])
                    ->where('arsip_jenis_id', $jenisArsip->id)
                    ->latest()
                    ->get();
        
        return view('admin.pages.arsip.index', [
            'type' => $type,
            'items' => $items,
            'title' => $jenisArsip->nama_jenis
        ]);
    }

    // Method untuk menampilkan form create
    public function create($type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $users = User::all();
        
        return view('admin.pages.arsip.create', compact('type', 'jenisArsip', 'users'));
    }

    // Method untuk menyimpan data baru
    public function store(Request $request, $type)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_arsip' => 'nullable|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:255',
            'letak_berkas' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
        ]);
        
        $validated['arsip_jenis_id'] = $jenisArsip->id;
        
        Arsip::create($validated);

        return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil disimpan');
    }

    // Method untuk menampilkan form edit
    public function edit($type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);
        $users = User::all();
        
        return view('admin.pages.arsip.edit', [
            'type' => $type,
            'item' => $item,
            'users' => $users,
            'jenisArsip' => $jenisArsip
        ]);
    }

    // Method untuk update data
    public function update(Request $request, $type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_arsip' => 'nullable|string|max:255',
            'nama_arsip' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:255',
            'letak_berkas' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
        ]);
        
        $item->update($validated);

        return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil diperbarui');
    }

    // Method untuk menghapus data
    public function destroy($type, $id)
    {
        $jenisArsip = ArsipJenis::where('nama_jenis', $type)->firstOrFail();
        $item = Arsip::where('arsip_jenis_id', $jenisArsip->id)->findOrFail($id);
        $item->delete();

        return back()->with('success', 'Data arsip berhasil dihapus');
    }
}