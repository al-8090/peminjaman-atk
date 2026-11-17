@extends('layouts.app')

@section('title', 'Edit Peralatan')

@section('content')
    <div class="max-w-xl bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('equipments.update', $equipment) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                <select name="category_id" required class="w-full rounded-lg border-slate-300 text-sm">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $equipment->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Peralatan</label>
                <input type="text" name="code" value="{{ old('code', $equipment->code) }}" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Peralatan</label>
                <input type="text" name="name" value="{{ old('name', $equipment->name) }}" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $equipment->stock) }}" min="0" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold">Update</button>
                <a href="{{ route('equipments.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-200 text-slate-700 text-xs font-semibold">Batal</a>
            </div>
        </form>
    </div>
@endsection