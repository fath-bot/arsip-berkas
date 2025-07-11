<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::orderBy('tanggal_masuk', 'DESC')->get();
        $transaksiCount = $transaksis->count();

        // Count by status
        $sudahDikembalikan = $transaksis->where('status', 'Sudah Dikembalikan')->count();
        $belumDikembalikan = $transaksis->where('status', 'Belum Dikembalikan')->count();
        $belumDiambil = $transaksis->where('status', 'Belum Diambil')->count();

        // For chart data (example - adjust based on your needs)
        $transaksiChartData = [
            $sudahDikembalikan,
            $belumDikembalikan,
            $belumDiambil
        ];

        $transaksiChartLabels = ['Sudah Dikembalikan', 'Belum Dikembalikan', 'Belum Diambil'];

        return view('admin.pages.transaksis.index', compact(
            'transaksis',
            'transaksiCount',
            'sudahDikembalikan',
            'belumDikembalikan',
            'belumDiambil',
            'transaksiChartData',
            'transaksiChartLabels'
        ));
    }

    public function create()
    {
        return view('admin.pages.transaksis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_berkas' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_masuk',
            'alasan' => 'required|string|max:500',
            'status' => 'required|string|in:Belum Diambil,Sudah Dikembalikan,Belum Dikembalikan',
        ]);

        Transaksi::create($validated);

        return redirect()->route('admin.transaksis.index')
            ->with('toast_success', 'Data peminjaman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('admin.pages.transaksis.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $validated = $request->validate([
            'jenis_berkas' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_masuk',
            'alasan' => 'required|string|max:500',
            'status' => 'required|string|in:Belum Diambil,Sudah Dikembalikan,Belum Dikembalikan',
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