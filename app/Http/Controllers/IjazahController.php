<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\Ijazah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class IjazahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $ijazahs = Ijazah::orderBy('nama', 'ASC')->get();
    $ijazahCount = $ijazahs->count(); // Ambil jumlah dari koleksi hasil query di atas

    return view('admin.pages.arsip.ijazah.index', compact('ijazahs', 'ijazahCount'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.arsip.ijazah.create');
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
            'jenjang' =>'required|enum:ijazahs,jenjang',
            'universitas' =>'required|string',
            'letak_berkas' =>'required|string',
        ]);

        Transaksi::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'jenjang' => $request->janjang,
            'universitas' => $request->universitas,
            'letak_berkas' => $request->letak_berkas,
        ]);

        return redirect()->route('admin.ijazahs.index')->with('toast_success', 'Berhasil menambahkan data ijazah.');
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
        $transaksi = Transaksi::findOrFail($id);
        return view('admin.pages.arsip.ijazah.edit', compact('ijazah'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ijazahs = Ijazah::findOrFail($id);

        $request->validate([
            'nama' =>'required|string',
            'nip' =>'required|integer',
            'jabatan' =>'required|string',
            'jenjang' =>'required|enum:ijazahs,jenjang',
            'universitas' =>'required|string',
            'letak_berkas' =>'required|string',
        ]);

        $transaksis->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'jenjang' => $request->jenjang,
            'universitas' => $request->universitas,
            'letak_berkas' => $request->letak_berkas,
        ]);

        return redirect()->route('admin.ijazahs.index')->with('toast_success', 'Berhasil mengubah data ijazah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ijazahs = Ijazah::findOrFail($id);
        $ijazahs->delete();
        return back()->with('toast_success', 'Berhasil menghapus data ijazah.');
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
