<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // $transactions = Transaction::latest()->limit(5)->get();
        $transactions = Transaction::orderByDesc('trx_date')->limit(5)->get();

        // $charts = DB::select('
        //     SELECT MONTHNAME(trx_date) month, count(*) total FROM transactions
        //     GROUP BY MONTHNAME(trx_date)
        //     ORDER BY MONTH(trx_date)
        // ');

        // $months = [];
        // $totals = [];

        // foreach ($charts as $chart) {
        //     $months[] = $chart->month;
        //     $totals[] = $chart->total;
        // }

        $totals = [];

        $totals[] = Transaction::whereMonth('trx_date', 1)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 2)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 3)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 4)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 5)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 6)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 7)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 8)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 9)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 10)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 11)->whereYear('trx_date', date('Y'))->count();
        $totals[] = Transaction::whereMonth('trx_date', 12)->whereYear('trx_date', date('Y'))->count();

        return view('admin/dashboard', [
            'transactions' => $transactions,
            // 'months' => $months,
            'totals' => $totals
        ]);
    }
}
