@extends('layouts.app')

@section('title', 'Data Peralatan Kantor')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex flex-wrap gap-4 justify-between items-center">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode / nama alat..."
                    class="rounded-lg border-slate-300 text-xs">
                <button type="submit"
                    class="px-3 py-2 rounded-lg bg-slate-800 text-white text-xs font-semibold">Cari</button>
            </form>
            <a href="{{ route('equipments.create') }}"
                class="px-4 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold">
                + Tambah Peralatan
            </a>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-800 text-white text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Peralatan</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Stok Tersedia</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($equipments as $eq)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-mono text-xs font-semibold text-sky-700">{{ $eq->code }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $eq->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $eq->category->name }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $eq->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $eq->stock }} unit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('equipments.edit', $eq) }}"
                                class="text-sky-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('equipments.destroy', $eq) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus peralatan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-slate-400">Data peralatan tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $equipments->withQueryString()->links() }}</div>
    </div>
@endsection