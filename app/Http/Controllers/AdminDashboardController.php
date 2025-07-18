<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Arsip;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'arsip'])
                        ->orderBy('tanggal_pinjam', 'DESC')
                        ->get();
                        
        $transaksiCount = $transaksis->count();
        
        // Jenis arsip dari tabel arsip_jenis
        $jenisList = \App\Models\ArsipJenis::pluck('nama_jenis')->toArray();
        
        // Count by status baru
        $sudahDikembalikan = $transaksis->where('status', 'dikembalikan')->count();
        $belumDikembalikan = $transaksis->where('status', 'dipinjam')->count();
        $belumDiambil = $transaksis->where('status', 'belum_diambil')->count();

        // Status chart data
        $transaksiChartData = [
            $sudahDikembalikan,
            $belumDikembalikan,
            $belumDiambil
        ];

        $transaksiChartLabels = ['Sudah Dikembalikan', 'Belum Dikembalikan', 'Belum Diambil'];

        // Monthly transaction count (total)
        $transaksiChartItems = Transaksi::select(DB::raw("MONTH(tanggal_pinjam) as month"), DB::raw("COUNT(*) as count"))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'label' => date('F', mktime(0, 0, 0, $item->month, 10)),
                    'count' => $item->count
                ];
            });

        // Additional: Monthly data by status
        $monthlyStatusData = Transaksi::select(
                DB::raw("MONTH(tanggal_pinjam) as month"),
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN status = 'dikembalikan' THEN 1 ELSE 0 END) as sudah_dikembalikan"),
                DB::raw("SUM(CASE WHEN status = 'dipinjam' THEN 1 ELSE 0 END) as belum_dikembalikan"),
                DB::raw("SUM(CASE WHEN status = 'belum_diambil' THEN 1 ELSE 0 END) as belum_diambil")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

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
            'jenisList'
        ));
    }
}