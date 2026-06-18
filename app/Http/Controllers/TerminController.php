<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use Illuminate\Http\Request;

class TerminController extends Controller
{
    public function index()
    {
        $this->authorizeRole(['keuangan']);

        $termins = Termin::orderBy('name')->get();

        return view('termins.index', compact('termins'));
    }

    public function create()
    {
        $this->authorizeRole(['keuangan']);

        return view('termins.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole(['keuangan']);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:termins,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Termin::create($data);

        return redirect()->route('termins.index')->with('success', 'Termin berhasil ditambahkan.');
    }

    public function edit(Termin $termin)
    {
        $this->authorizeRole(['keuangan']);

        return view('termins.edit', compact('termin'));
    }

    public function update(Request $request, Termin $termin)
    {
        $this->authorizeRole(['keuangan']);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:termins,name,' . $termin->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $termin->update($data);

        return redirect()->route('termins.index')->with('success', 'Termin berhasil diperbarui.');
    }

    public function destroy(Termin $termin)
    {
        $this->authorizeRole(['keuangan']);

        $termin->delete();

        return redirect()->route('termins.index')->with('success', 'Termin berhasil dihapus.');
    }
}
