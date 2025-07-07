<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\Cpns;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CpnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $cpnss = Cpns::orderBy('nama', 'ASC')->get();

    return view('admin.pages.arsip.cpns.index', compact('cpnss'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.arsip.cpns.create');
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

        Transaksi::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'no_sk' => $request->no_sk,
            'tanggal' => $request->tanggal,
            'letak_berkas' => $request->letak_berkas,
        ]);

        return redirect()->route('admin.cpnss.index')->with('toast_success', 'Berhasil Menambahkan Data SK CPNS.');
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
        $pangkat = Pangkat::findOrFail($id);
        return view('admin.pages.arsip.pangkat.edit', compact('pangkat'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pangkats = Pangkat::findOrFail($id);

        $request->validate([
           'nama' =>'required|string',
            'nip' =>'required|integer',
            'jabatan' =>'required|string',
            'no_sk' =>'required|string',
            'tanggal' =>'required|string',
            'letak_berkas' =>'required|string',
        ]);

        $cpnss->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'no_sk' => $request->no_sk,
            'tanggal' => $request->tanggal,
            'letak_berkas' => $request->letak_berkas,
        ]);

        return redirect()->route('admin.cpnss.index')->with('toast_success', 'Berhasil Mengubah Data SK CPNS.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cpnss = Cpns::findOrFail($id);
        $cpnss->delete();
        return back()->with('toast_success', 'Berhasil Menghapus Data SK CPNS.');
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
