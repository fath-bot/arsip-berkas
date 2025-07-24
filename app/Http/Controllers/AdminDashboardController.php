<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Arsip;
use App\Models\ArsipJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = session('role');
        $userId = session('user_id');

        // === ADMIN & SUPERADMIN DASHBOARD ===
        if (in_array($role, ['admin', 'superadmin'])) {
    $transaksis = Transaksi::with(['user', 'arsip', 'jenis'])
        ->orderBy('tanggal_pinjam', 'DESC')
        ->get();

    $transaksiCount = $transaksis->count();
    $sudahDikembalikan = $transaksis->where('status', 'dikembalikan')->count();
    $belumDikembalikan = $transaksis->where('status', 'dipinjam')->count();
    $belumDiambil = $transaksis->where('status', 'belum_diambil')->count();

    $transaksiChartData = [
        $sudahDikembalikan,
        $belumDikembalikan,
        $belumDiambil
    ];
    $transaksiChartLabels = ['Sudah Dikembalikan', 'Dipinjam', 'Belum Diambil'];

    $monthlyStatusData = Transaksi::select(
            DB::raw("MONTH(tanggal_pinjam) as month"),
            DB::raw("COUNT(*) as total"),
            DB::raw("SUM(CASE WHEN status = 'dikembalikan' THEN 1 ELSE 0 END) as sudah_dikembalikan"),
            DB::raw("SUM(CASE WHEN status = 'dipinjam' THEN 1 ELSE 0 END) as belum_di_kembalikan"),
            DB::raw("SUM(CASE WHEN status = 'belum_diambil' THEN 1 ELSE 0 END) as belum_diambil")
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Ganti: gunakan monthlyStatusData untuk chartData agar tooltip valid
    $transaksiChartItems = $monthlyStatusData->map(function ($item) {
        return [
            'label' => date('F', mktime(0, 0, 0, $item->month, 10)),
            'count' => $item->total,
            'dikembalikan' => $item->sudah_dikembalikan,
            'dipinjam' => $item->belum_di_kembalikan,
            'belum_diambil' => $item->belum_diambil,
        ];
    });

    $jenisList = ArsipJenis::pluck('nama_jenis')->toArray();

    $menungguKonfirmasi = Transaksi::with(['user', 'arsip'])
        ->whereNull('is_approved')
        ->orderBy('created_at', 'asc')
        ->take(3)
        ->get();

    $jumlahMenungguKonfirmasi = Transaksi::whereNull('is_approved')->count();

    return view('admin.dashboard', compact(
        'transaksis',
        'transaksiCount',
        'sudahDikembalikan',
        'belumDikembalikan',
        'belumDiambil',
        'transaksiChartData',
        'transaksiChartLabels',
        'transaksiChartItems',
        'monthlyStatusData',
        'jenisList',
        'menungguKonfirmasi',
        'jumlahMenungguKonfirmasi'
    ));
}


        // === USER DASHBOARD ===
if ($role === 'user') {
    $transaksis = Transaksi::with(['arsip.jenis'])
        ->where('user_id', $userId)
        ->where('is_approved', true)
        ->orderBy('tanggal_pinjam', 'DESC')
        ->get();

    $berlangsung = $transaksis->firstWhere(fn ($trx) => in_array($trx->status, ['dipinjam', 'belum_diambil']));
    $riwayat = $transaksis->take(3)->values();

    // Ambil satu data pending terbaru
    $pending = Transaksi::where('user_id', $userId)
        ->whereNull('is_approved')
        ->latest()
        ->first();

    // Ambil transaksi terakhir yang sudah diproses (ditolak atau disetujui)
    $terakhir = Transaksi::where('user_id', $userId)
        ->whereIn('is_approved', [0, 1])
        ->latest()
        ->first();

    return view('user.dashboard', compact(
        'transaksis',
        'berlangsung',
        'riwayat',
        'pending',
        'terakhir'
    ));
}


        abort(403, 'Unauthorized access');
    }
}
    