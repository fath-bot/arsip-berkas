<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $jabatans = Jabatan::orderBy('nama', 'ASC')->get();

    return view('admin.pages.arsip.jabatan.index', compact('jabatans'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.arsip.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' =>'required|string',
            'nip' =>'required|integer',
            'jabatan' =>'required|string',
            'no_sk' =>'required|string',
            'tanggal' =>'required|string',
            'letak_berkas' =>'required|string',
        ]);

        Jabatan::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'no_sk' => $request->no_sk,
            'tanggal' => $request->tanggal,
            'letak_berkas' => $request->letak_berkas,
        ]);

        return redirect()->route('admin.jabatans.index')->with('toast_success', 'Berhasil Menambahkan Data SK Jabatan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('admin.pages.arsip.jabatan.edit', compact('jabatan'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jabatans = Jabatan::findOrFail($id);

        $request->validate([
           'nama' =>'required|string',
            'nip' =>'required|integer',
            'jabatan' =>'required|string',
            'no_sk' =>'required|string',
            'tanggal' =>'required|string',
            'letak_berkas' =>'required|string',
        ]);

        $jabatans->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'no_sk' => $request->no_sk,
            'tanggal' => $request->tanggal,
            'letak_berkas' => $request->letak_berkas,
        ]);

        return redirect()->route('admin.jabatans.index')->with('toast_success', 'Berhasil Mengubah Data SK Jabatan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatans = Jabatan::findOrFail($id);
        $jabatans->delete();
        return back()->with('toast_success', 'Berhasil Menghapus Data SK Jabatan.');
    }
}

// <?php

// namespace App\Http\Controllers;

// use App\Models\Transaksi;
// use App\Http\Controllers\TransaksiController;
// use Illuminate\Http\Request;
// use Illuminate\View\View;


// class TransaksiController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index() :View{
//         $transaksis = Transaksi::latest()->paginate(10);
//         return view('transaksi.index', compact('transaksis'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//           return view('transaksis.create');

//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//         ]);

//         Post::create([
//             'title' => $request->title,
//         ]);

//         return redirect()->route('transaksis.create')->with('success', 'Data berhasil ditambahkan!');
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         $transaksis = Transaksi::findOrFail($id);
//         return view('transaksis.edit', compact('transaksis'));
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//         ]);

//         $transaksis = Transaksi::findOrFail($id);
//         $transaksis->update([
//             'title' => $request->title,
//         ]);

//         return redirect()->route('transaksis.index')->with('success', 'Data berhasil diperbarui.');
//     }

//      public function save(Request $request, string $id)
//     {
//         return redirect()->route('transaksi.save');
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function delete(string $id)
//     {
//         $transaksis = Transaksi::findOrFail($id);
//         $transaksis->delete();

//         return redirect()->route('transaksis.index')->with('success', 'Data berhasil dihapus.');
//     }

// }
