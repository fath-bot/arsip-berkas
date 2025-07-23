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
            // Ambil semua transaksi (statistik, tabel lengkap, dll.)
            $transaksis = Transaksi::with(['user', 'arsip', 'jenis'])
                ->orderBy('tanggal_pinjam', 'DESC')
                ->get();

            // Statistik ringkas
            $transaksiCount = $transaksis->count();
            $sudahDikembalikan = $transaksis->where('status', 'dikembalikan')->count();
            $belumDikembalikan = $transaksis->where('status', 'dipinjam')->count();
            $belumDiambil       = $transaksis->where('status', 'belum_diambil')->count();

            // Data chart bulanan
            $transaksiChartData = [
                $sudahDikembalikan,
                $belumDikembalikan,
                $belumDiambil
            ];
            $transaksiChartLabels = ['Sudah Dikembalikan', 'Belum Dikembalikan', 'Belum Diambil'];

            // Chart per bulan (jumlah peminjaman)
            $transaksiChartItems = Transaksi::select(
                    DB::raw("MONTH(tanggal_pinjam) as month"),
                    DB::raw("COUNT(*) as count")
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'label' => date('F', mktime(0, 0, 0, $item->month, 10)),
                        'count' => $item->count
                    ];
                });

            // Statistik bulanan detail per status
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

            // Daftar jenis arsip untuk filter/dropdown
            $jenisList = ArsipJenis::pluck('nama_jenis')->toArray();

            // Hanya ambil 3 transaksi tertua yang belum di-approve
            $menungguKonfirmasi = Transaksi::with(['user', 'arsip'])
                ->whereNull('is_approved')
                ->orderBy('created_at', 'asc')
                ->take(3)
                ->get();

            // Total semua yang menunggu konfirmasi
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
            // Hanya transaksi yang sudah di-approve untuk user itu
            $transaksis = Transaksi::with(['arsip.jenis'])
                ->where('user_id', $userId)
                ->where('is_approved', true)
                ->orderBy('tanggal_pinjam', 'DESC')
                ->get();

            // Transaksi aktif (dipinjam atau belum diambil)
            $berlangsung = $transaksis->firstWhere(fn ($trx) => in_array($trx->status, ['dipinjam', 'belum_diambil']));

            // 3 riwayat terakhir
            $riwayat = $transaksis->take(3)->values();

            return view('user.dashboard', compact(
                'transaksis',
                'berlangsung',
                'riwayat'
            ));
        }

        abort(403, 'Unauthorized access');
    }
}
