<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksiCount = Transaksi::count();
        $transaksiChartItems = $this->generateTransaksiChartItems();
        $chartMonths = $this->generateChartMonths(6);

        return view('admin.pages.home.index', compact('transaksiCount', 'transaksiChartItems', 'chartMonths'));
    }

    /**
     * Generate income chart items per month.
     *
     * @return array
     */
    public function generateTransaksiChartItems($month = 6)
    {
        $transaksiChartItems = [];

        for ($i = $month - 1; $i >= 0; $i--) {
            $transaksi = Transaksi::where('type', 'transaksi')
                ->whereMonth('date', Carbon::now()->subMonthNoOverflow($i))
                ->whereYear('date', Carbon::now()->subMonthNoOverflow($i)->format('Y'))
                ->sum('amount_idr');

            array_push($transaksiChartItems, $transaksi);
        }

        return $transaksiChartItems;
    }

    /**
     * Generate chart months.
     *
     * @return array
     */
    public function generateChartMonths($month = 12)
    {
        $chartMonths = [];

        for ($i = $month - 1; $i >= 0; $i--) {
            if ($i > 0) {
                $month = Carbon::now()->subMonthNoOverflow($i)->endOfMonth();
            } else {
                $month = Carbon::now();
            }

            array_push($chartMonths, $month);
        }

        return $chartMonths;
    }
}
