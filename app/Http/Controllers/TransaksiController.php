<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Arsip;
use App\Models\ArsipJenis;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Jika admin/superadmin, tampilkan semua
        if (in_array(session('role'), ['admin', 'superadmin'])) {
            $transaksis = Transaksi::with(['user', 'arsip'])->orderBy('tanggal_pinjam', 'DESC')->get();
        } 
        // Jika user biasa, tampilkan hanya miliknya
        else {
            $transaksis = Transaksi::where('user_id', session('user_id'))
                                ->with('arsip')
                                ->orderBy('tanggal_pinjam', 'DESC')
                                ->get();
        }
        
        $transaksiCount = $transaksis->count();
        
        // Count by status baru
        $sudahDikembalikan = $transaksis->where('status', 'dikembalikan')->count();
        $belumDikembalikan = $transaksis->where('status', 'dipinjam')->count();
        $belumDiambil = $transaksis->where('status', 'belum_diambil')->count();
        
        // Jenis arsip dari tabel arsip_jenis
        $jenisList = ArsipJenis::pluck('nama_jenis')->toArray();

        $transaksiChartData = [
            $sudahDikembalikan,
            $belumDikembalikan,
            $belumDiambil
        ];
        
        $transaksiChartLabels = ['Sudah Dikembalikan', 'Belum Dikembalikan', 'Belum Diambil'];

        $view = match (session('role')) {
            'admin', 'superadmin' => 'admin.pages.transaksis.index',
            'user' => 'user.transaksis.index',
            default => 'login',
        };

        return view($view, compact(
            'transaksis',
            'transaksiCount',
            'sudahDikembalikan',
            'belumDikembalikan',
            'belumDiambil',
            'transaksiChartData',
            'transaksiChartLabels',
            'jenisList'
        ));
    }

    public function create(Request $request)
{
    $arsips = Arsip::all();
    $jenis_arsips = ArsipJenis::all();
    $selectedArsip = null;

    if ($request->has('arsip_id')) {
        $selectedArsip = Arsip::with('jenis')->find($request->arsip_id);
    }

    return match (session('role')) {
        'admin', 'superadmin' => view('admin.pages.transaksis.create', compact('arsips', 'selectedArsip')),
        'user' => view('user.transaksis.create', compact('arsips', 'jenis_arsips', 'selectedArsip')),
        default => abort(403),
    };
}


   public function store(Request $request)
{
    $validated = $request->validate([
        'arsip_id' => 'nullable|exists:arsip,id',
        'arsip_jenis_id' => 'required|exists:arsip_jenis,id',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        'alasan' => 'required|string|max:500',
        'keterangan' => 'required|string|max:500',
        'status' => 'required|in:belum_diambil,dipinjam,dikembalikan',
    ]);

    // Tambahkan arsip jika tidak dipilih (nullable)
    if (empty($validated['arsip_id'])) {
        $jenis = ArsipJenis::find($validated['arsip_jenis_id']);

        $arsipBaru = Arsip::create([
            'arsip_jenis_id' => $validated['arsip_jenis_id'],
            'nama_arsip'     => $jenis->nama_jenis . ' - ' . $validated['alasan'],
            'user_id'        => session('user_id'),
            'letak_berkas'   => null,
        ]);

        $validated['arsip_id'] = $arsipBaru->id;
    }

    if (session('role') === 'user') {
        $validated['user_id'] = session('user_id');
    }

    Transaksi::create($validated);

    $redirectRoute = match (session('role')) {
        'admin', 'superadmin' => 'admin.transaksis.index',
        'user' => 'user.transaksis.index',
        default => 'login'
    };

    return redirect()->route($redirectRoute)
        ->with('toast_success', 'Data peminjaman berhasil ditambahkan');
}



    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $arsips = Arsip::all();
        return view('admin.pages.transaksis.edit', compact('transaksi', 'arsips'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $validated = $request->validate([
            'arsip_id' => 'required|exists:arsip,id',
            'arsip_jenis_id' => 'required|exists:arsip_jenis,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'alasan' => 'required|string|max:500',
            'status' => 'required|in:belum_diambil,dipinjam,dikembalikan',
        ]);

        $transaksi->update($validated);

        return redirect()->route('admin.transaksis.index')
            ->with('toast_success', 'Data peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return back()->with('toast_success', 'Data peminjaman berhasil dihapus');
    }
}