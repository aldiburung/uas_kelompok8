<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['keuangan']);

        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $this->authorizeRole(['keuangan']);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::query();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        $transactions = $query->with('user', 'termin')
            ->orderBy('transaction_date', 'desc')
            ->get();

        $totalAmount = $transactions->sum('amount');
        $totalTransactions = $transactions->count();
        $categoryTotals = collect(Transaction::categories())
            ->mapWithKeys(fn ($category) => [
                $category => $transactions->where('category', $category)->sum('amount'),
            ]);

        return view('reports.generate', compact(
            'transactions',
            'totalAmount',
            'totalTransactions',
            'categoryTotals',
            'startDate',
            'endDate'
        ));
    }
}
