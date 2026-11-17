<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $equipments = $query->paginate(10);
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:equipment,code',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Equipment::create($validated);
        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::all();
        return view('equipments.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:50|unique:equipment,code,' . $equipment->id,
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $equipment->update($validated);
        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Peralatan berhasil dihapus.');
    }
}
