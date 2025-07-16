<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

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
        $jenisList = $transaksis->pluck('jenis_berkas')->unique()->sort()->values();
 

        // For chart data (example - adjust based on your needs)
        $transaksiChartData = [
            $sudahDikembalikan,
            $belumDikembalikan,
            $belumDiambil
        ];
        $name = session('name');
        $nip = session('nip');
        $email = session('email');
        $role = session('role');


        $user = \App\Models\User::where('nip', $nip)->first();
        $transaksiChartLabels = ['Sudah Dikembalikan', 'Belum Dikembalikan', 'Belum Diambil'];
        $view = match ($role) {
            'admin', 'superadmin' => 'admin.pages.transaksis.index',
            'user' => 'user.transaksis.index',
            default => 'login',
        };

        return view($view, compact(
            'transaksis',
            'transaksiCount',
            'sudahDikembalikan',
            'belumDikembalikan',
            'transaksiChartData',
            'transaksiChartLabels',
            'jenisList'
        ));

    }

   public function create()
{
    $role = session('role');

    // Cek role dan arahkan ke view yang sesuai
    return match ($role) {
        'admin', 'superadmin' => view('admin.pages.transaksis.create'),
        'user' => view('user.transaksis.create'),
        default => abort(403, 'Unauthorized'),
    };
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'jenis_berkas' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_masuk',
            'alasan' => 'required|string|max:500',
            'status' => 'required|string|in:Belum Diambil,Sudah Dikembalikan,Belum Dikembalikan',
        ]);

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