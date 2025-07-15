<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::orderBy('tanggal_masuk', 'DESC')->get();
        $transaksiCount = $transaksis->count();

        // Count by status
        $sudahDikembalikan = $transaksis->where('status', 'Sudah Dikembalikan')->count();
        $belumDikembalikan = $transaksis->where('status', 'Belum Dikembalikan')->count();
        $belumDiambil = $transaksis->where('status', 'Belum Diambil')->count();

        // Status chart data
        $transaksiChartData = [
            $sudahDikembalikan,
            $belumDikembalikan,
            $belumDiambil
        ];

        $transaksiChartLabels = ['Sudah Dikembalikan', 'Belum Dikembalikan', 'Belum Diambil'];

        // Monthly transaction count (total)
        $transaksiChartItems = Transaksi::select(DB::raw("MONTH(tanggal_masuk) as month"), DB::raw("COUNT(*) as count"))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'label' => date('F', mktime(0, 0, 0, $item->month, 10)),
                    'count' => $item->count
                ];
            });

        // Additional: Monthly data by status (untuk chart lebih detail jika diperlukan)
        $monthlyStatusData = Transaksi::select(
                DB::raw("MONTH(tanggal_masuk) as month"),
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN status = 'Sudah Dikembalikan' THEN 1 ELSE 0 END) as sudah_dikembalikan"),
                DB::raw("SUM(CASE WHEN status = 'Belum Dikembalikan' THEN 1 ELSE 0 END) as belum_dikembalikan"),
                DB::raw("SUM(CASE WHEN status = 'Belum Diambil' THEN 1 ELSE 0 END) as belum_diambil")
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
            'monthlyStatusData' // Tambahkan ini jika ingin menggunakan data per status di view
        ));
    }
}