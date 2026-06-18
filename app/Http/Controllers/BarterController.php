<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;

class BarterController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['barter']);

        $commodities = Commodity::where('user_id', auth()->id())->orderBy('name')->paginate(12);

        return view('barter.index', compact('commodities'));
    }

    public function create()
    {
        $this->authorizeRole(['barter']);

        return view('barter.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['barter']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'estimated_value' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $data['user_id'] = auth()->id();
        Commodity::create($data);

        return redirect()->route('barter.index')->with('success', 'Komoditas barter berhasil ditambahkan.');
    }

    public function show(Commodity $commodity)
    {
        $this->authorizeRole(['barter']);

        if ($commodity->user_id !== auth()->id()) {
            abort(403);
        }

        return view('barter.show', compact('commodity'));
    }

    public function edit(Commodity $commodity)
    {
        $this->authorizeRole(['barter']);

        if ($commodity->user_id !== auth()->id()) {
            abort(403);
        }

        return view('barter.edit', compact('commodity'));
    }

    public function update(Request $request, Commodity $commodity)
    {
        $this->authorizeRole(['barter']);

        if ($commodity->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'estimated_value' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $commodity->update($data);

        return redirect()->route('barter.index')->with('success', 'Komoditas barter berhasil diperbarui.');
    }

    public function destroy(Commodity $commodity)
    {
        $this->authorizeRole(['barter']);

        if ($commodity->user_id !== auth()->id()) {
            abort(403);
        }

        $commodity->delete();

        return redirect()->route('barter.index')->with('success', 'Komoditas barter berhasil dihapus.');
    }
}
