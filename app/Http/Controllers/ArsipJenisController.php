<?php

namespace App\Http\Controllers;

use App\Models\ArsipJenis;
use Illuminate\Http\Request;

class ArsipJenisController extends Controller
{
    public function index()
    {
        $jenisArsip = ArsipJenis::all();
        return view('admin.pages.arsip_jenis.index', compact('jenisArsip'));
    }

    public function create()
    {
        return view('admin.pages.arsip_jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:arsip_jenis'
        ]);

        ArsipJenis::create($request->all());

        return redirect()->route('admin.arsip_jenis.index')
            ->with('success', 'Jenis arsip berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenis = ArsipJenis::findOrFail($id);
        return view('admin.pages.arsip_jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = ArsipJenis::findOrFail($id);

        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:arsip_jenis,nama_jenis,'.$id
        ]);

        $jenis->update(['nama_jenis' => $request->nama_jenis]);

        return redirect()->route('admin.arsip_jenis.index')
            ->with('success', 'Jenis arsip berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenis = ArsipJenis::findOrFail($id);
        $jenis->delete();

        return back()->with('success', 'Jenis arsip berhasil dihapus');
    }
}