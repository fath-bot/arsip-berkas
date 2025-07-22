<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        if (in_array(session('role'), ['admin', 'superadmin'])) {
            $transaksis = Transaksi::with(['user', 'arsip'])->orderBy('tanggal_pinjam', 'DESC')->get();
        } else {
            $transaksis = Transaksi::where('user_id', session('user_id'))
                ->with('arsip')
                ->orderBy('tanggal_pinjam', 'DESC')
                ->get();
        }

        $transaksiCount = $transaksis->count();
        $sudahDikembalikan = $transaksis->where('status', 'dikembalikan')->count();
        $belumDikembalikan = $transaksis->where('status', 'dipinjam')->count();
        $belumDiambil = $transaksis->where('status', 'belum_diambil')->count();

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

        if ($request->filled('arsip_id')) {
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
            'arsip_id' => 'nullable|exists:arsips,id',
            'jenis_id' => 'nullable|exists:arsip_jenis,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'alasan' => 'required|string|max:500',
            'keterangan' => 'required|string|max:500',
            'status' => 'required|in:belum_diambil,dipinjam,dikembalikan',
        ]);

        // Jika arsip_id tersedia, ambil jenis_id dari relasinya
        if (!empty($validated['arsip_id'])) {
            $arsip = Arsip::find($validated['arsip_id']);
            if ($arsip) {
                $validated['jenis_id'] = $arsip->jenis_id;
            }
        }

        // Validasi jenis_id tetap harus ada
        if (empty($validated['jenis_id'])) {
            return back()->withInput()->withErrors([
                'jenis_id' => 'Jenis arsip harus dipilih atau diturunkan dari berkas.',
            ]);
        }

        $validated['user_id'] = session('user_id');

        $transaksi = Transaksi::create($validated);

        LogAktivitas::create([
            'user_id' => session('user_id'),
            'aktivitas' => "Membuat transaksi #{$transaksi->id}"
        ]);

        $redirectRoute = match (session('role')) {
            'admin', 'superadmin' => 'admin.transaksis.index',
            'user' => 'user.transaksis.index',
            default => 'login',
        };

        return redirect()->route($redirectRoute)
            ->with('toast_success', 'Data peminjaman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $arsips = Arsip::all();
        $jenis_arsips = ArsipJenis::all();

        return view('admin.pages.transaksis.edit', compact('transaksi', 'arsips', 'jenis_arsips'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $validated = $request->validate([
            'arsip_id' => 'nullable|exists:arsips,id',
            'jenis_id' => 'nullable|exists:arsip_jenis,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'alasan' => 'required|string|max:500',
            'keterangan' => 'required|string|max:500',
            'status' => 'required|in:belum_diambil,dipinjam,dikembalikan',
        ]);

        if (!empty($validated['arsip_id'])) {
            $arsip = Arsip::find($validated['arsip_id']);
            if ($arsip) {
                $validated['jenis_id'] = $arsip->jenis_id;
            }
        }

        if (empty($validated['jenis_id'])) {
            return back()->withInput()->withErrors([
                'jenis_id' => 'Jenis arsip harus dipilih atau diturunkan dari berkas.',
            ]);
        }

        $validated['arsip_id'] = $validated['arsip_id'] ?? null;

        $transaksi->update($validated);

        LogAktivitas::create([
            'user_id' => session('user_id'),
            'aktivitas' => "Memperbarui transaksi #{$transaksi->id}"
        ]);

        return redirect()->route('admin.transaksis.index')
            ->with('toast_success', 'Data peminjaman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        LogAktivitas::create([
            'user_id' => session('user_id'),
            'aktivitas' => "Menghapus transaksi #{$id}"
        ]);

        return back()->with('toast_success', 'Data peminjaman berhasil dihapus');
    }
}
