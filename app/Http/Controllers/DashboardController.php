<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'transactionCount' => Transaction::count(),
            'commodityCount' => Commodity::whereHas('user', function ($query) {
                $query->where('role', 'barter');
            })->count(),
            'recentTransactions' => Transaction::latest('transaction_date')->limit(5)->get(),
        ]);
    }
}
