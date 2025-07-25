<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Arsip;
use App\Models\ArsipJenis;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');

        if (in_array($role, ['admin', 'superadmin'])) {
            // Admin & Superadmin: tampilkan semua transaksi yang sudah di-approve (true/false)
            $transaksis = Transaksi::with(['user', 'arsip'])
                ->whereNotNull('is_approved')
                ->orderBy('tanggal_pinjam', 'DESC')
                ->get();
        } else {
            // User: hanya transaksi miliknya yang sudah disetujui
            $transaksis = Transaksi::with('arsip')
                ->where('user_id', session('user_id'))
                ->where('is_approved', true)
                ->orderBy('tanggal_pinjam', 'DESC')
                ->get();
        }

        // Statistik
        $transaksiCount    = $transaksis->count();
        $sudahDikembalikan = $transaksis->where('status', 'dikembalikan')->count();
        $belumDikembalikan = $transaksis->where('status', 'dipinjam')->count();
        $belumDiambil      = $transaksis->where('status', 'belum_diambil')->count();

        // Tambahkan daftar jenis arsip untuk dropdown atau filter di view
        $jenisList = ArsipJenis::all(); // Collection model ArsipJenis

        // Data untuk chart (opsional)
        $transaksiChartData   = [$sudahDikembalikan, $belumDikembalikan, $belumDiambil];
        $transaksiChartLabels = ['Sudah Dikembalikan', 'di pinjam', 'Belum Diambil'];

        // Pilih view berdasarkan role
        $view = match ($role) {
            'admin', 'superadmin' => 'admin.pages.transaksis.index',
            'user'                => 'user.transaksis.index',
            default               => abort(403),
        };

        // Kirim semua variabel ke view, termasuk $jenisList
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

    /**
     * Show the form for creating a new resource.
     */
   public function create(Request $request)
{
    $arsips        = Arsip::with('jenis')->get();
    $jenis_arsips   = ArsipJenis::all(); // <- pastikan ini ada dan pakai nama sama persis
    $users         = User::where('role', 'user')->get();
    $selectedArsip = null;

    if ($request->filled('arsip_id')) {
        $selectedArsip = Arsip::with('jenis')->find($request->arsip_id);
    }

    return match (session('role')) {
        'admin', 'superadmin' => view('admin.pages.transaksis.create', compact('arsips', 'jenis_arsips', 'users', 'selectedArsip')),
        'user'                => view('user.transaksis.create', compact('arsips', 'jenis_arsips', 'selectedArsip')),
        default               => abort(403),
    };
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'arsip_id'        => 'nullable|exists:arsip,id',
            'jenis_id'        => 'nullable|exists:arsip_jenis,id',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status'          => 'nullable',
            'alasan'          => 'required|string|max:500',
            'keterangan'      => 'required|string|max:500',
            'is_approved'    => 'nullable|boolean',
        ]);

        if (!empty($validated['arsip_id'])) {
            $arsip = Arsip::find($validated['arsip_id']);
            $validated['jenis_id'] = $arsip->arsip_jenis_id;
        }

        if (empty($validated['jenis_id'])) {
            return back()
                ->withInput()
                ->withErrors(['jenis_id' => 'Jenis arsip harus dipilih atau berasal dari berkas.']);
        }

        $validated['user_id']           = session('user_id');
        $validated['status_konfirmasi'] = 'pending';
        $validated['status']            = null;
        $validated['is_approved']       = null;

        $transaksi = Transaksi::create($validated);

        LogAktivitas::create([
            'user_id'   => session('user_id'),
            'aktivitas' => "Mengajukan transaksi #{$transaksi->id}"
        ]);

        $redirectRoute = session('role') === 'user'
            ? 'user.transaksis.index'
            : 'admin.transaksis.index';

        return redirect()->route($redirectRoute)
            ->with('toast_success', 'Permintaan peminjaman berhasil diajukan. Menunggu konfirmasi.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaksi     = Transaksi::findOrFail($id);
        $arsips        = Arsip::with('jenis')->get();
        $jenis_arsips  = ArsipJenis::all();

        return view('admin.pages.transaksis.edit', compact('transaksi', 'arsips', 'jenis_arsips'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $validated = $request->validate([
            'arsip_id'          => 'nullable|exists:arsip,id',
            'jenis_id'          => 'nullable|exists:arsip_jenis,id',
            'tanggal_pinjam'    => 'required|date',
            'tanggal_kembali'   => 'required|date|after_or_equal:tanggal_pinjam',
            'alasan'            => 'required|string|max:500',
            'keterangan'        => 'required|string|max:500',
            'status_konfirmasi' => 'nullable|in:pending,ditolak,disetujui',
            'status'            => 'nullable',
        ]);

        if (!empty($validated['arsip_id'])) {
            $arsip = Arsip::find($validated['arsip_id']);
            $validated['jenis_id'] = $arsip->arsip_jenis_id;
        }

        if (empty($validated['jenis_id'])) {
            return back()
                ->withInput()
                ->withErrors(['jenis_id' => 'Jenis arsip harus dipilih atau berasal dari berkas.']);
        }

        if (isset($validated['status_konfirmasi']) &&
            $validated['status_konfirmasi'] !== $transaksi->status_konfirmasi) {
            if ($validated['status_konfirmasi'] === 'disetujui') {
                $validated['status']      = 'belum_diambil';
                $validated['is_approved'] = true;
            } elseif ($validated['status_konfirmasi'] === 'ditolak') {
                $validated['status']      = null;
                $validated['is_approved'] = false;
            }
        }

        $transaksi->update($validated);

        LogAktivitas::create([
            'user_id'   => session('user_id'),
            'aktivitas' => "Memperbarui transaksi #{$transaksi->id}"
        ]);

        return redirect()->route('admin.transaksis.index')
            ->with('toast_success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        LogAktivitas::create([
            'user_id'   => session('user_id'),
            'aktivitas' => "Menghapus transaksi #{$id}"
        ]);

        return back()->with('toast_success', 'Data peminjaman berhasil dihapus.');
    }

    /**
     * Confirm the specified transaction.
     */
    public function konfirmasi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'is_approved' => true,
            'status'      => 'belum_diambil'
        ]);

        LogAktivitas::create([
            'user_id'   => session('user_id'),
            'aktivitas' => "Menyetujui transaksi #{$id}"
        ]);

        return back()->with('toast_success', 'Transaksi berhasil dikonfirmasi.');
    }

    /**
     * Reject the specified transaction.
     */
    public function tolak(Request $request, $id)
{
    $transaksi = Transaksi::findOrFail($id);

    $request->validate([
        'alasan_penolakan' => 'required|string|max:500',
    ]);

    $transaksi->update([
        'is_approved' => false,
        'status'      => null,
        'alasan_penolakan'  => $request->alasan_penolakan,
    ]);

    LogAktivitas::create([
        'user_id'   => session('user_id'),
        'aktivitas' => "Menolak transaksi #{$id}"
    ]);

    return back()->with('toast_error', 'Transaksi berhasil ditolak.');
}

}
