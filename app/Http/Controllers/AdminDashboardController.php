<?php

namespace App\Http\Controllers;


use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
{
    $transaksiCount = Transaksi::count();

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

    return view('admin.dashboard', compact('transaksiCount', 'transaksiChartItems'));
}


}
