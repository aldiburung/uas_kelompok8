<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['keuangan']);

        $transactions = Transaction::orderByDesc('transaction_date')->paginate(10);

        return view('keuangan.index', compact('transactions'));
    }

    public function create()
    {
        $this->authorizeRole(['keuangan']);

        return view('keuangan.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['keuangan']);

        $data = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|in:Material,Upah,Operasional',
            'amount' => 'required|integer|min:0',
            'transaction_date' => 'required|date',
            'termin_id' => 'nullable|exists:termins,id',
            'note' => 'nullable|string|max:500',
        ]);

        $data['category'] = ucfirst(strtolower($data['category']));
        $data['user_id'] = Auth::id();

        Transaction::create($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function edit(Transaction $keuangan)
    {
        $this->authorizeRole(['keuangan']);

        return view('keuangan.edit', ['transaction' => $keuangan]);
    }

    public function update(Request $request, Transaction $keuangan)
    {
        $this->authorizeRole(['keuangan']);

        $data = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|in:Material,Upah,Operasional',
            'amount' => 'required|integer|min:0',
            'transaction_date' => 'required|date',
            'termin_id' => 'nullable|exists:termins,id',
            'note' => 'nullable|string|max:500',
        ]);

        $data['category'] = ucfirst(strtolower($data['category']));
        $keuangan->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $keuangan)
    {
        $this->authorizeRole(['keuangan']);

        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
