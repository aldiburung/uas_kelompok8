<?php

namespace App\Http\Controllers;

use App\Models\BarterRequest;
use App\Models\Commodity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarterRequestController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['barter']);

        $transactions = BarterRequest::where('user_id', auth()->id())
            ->with('commodity', 'targetUser')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('barter-requests.index', compact('transactions'));
    }

    public function create()
    {
        $this->authorizeRole(['barter']);

        $commodities = Commodity::where('user_id', auth()->id())->get();

        return view('barter-requests.create', compact('commodities'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['barter']);

        $validated = $request->validate([
            'commodity_id' => 'required|exists:commodities,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $commodity = Commodity::findOrFail($validated['commodity_id']);
// Tambahkan pengecekan ini di BarterRequestController.php @store
if ($commodity->stock < $request->quantity) {
    return redirect()->back()->with('error', 'Maaf bro, stok tidak mencukupi untuk transaksi ini!');
}
        DB::transaction(function () use ($commodity, $validated) {
            $commodity->decrement('stock', $validated['quantity']);

            BarterRequest::create([
                'user_id' => auth()->id(),
                'commodity_id' => $commodity->id,
                'target_user_id' => auth()->id(),
                'quantity' => $validated['quantity'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'accepted',
            ]);
        });

        return redirect()->route('barter-requests.index')->with('success', 'Transaksi barter internal berhasil dicatat');
    }

    public function destroy(BarterRequest $barterRequest)
    {
        $this->authorize('delete', $barterRequest);
        $barterRequest->delete();

        return redirect()->route('barter-requests.index')->with('success', 'Catatan transaksi barter berhasil dihapus');
    }
}
