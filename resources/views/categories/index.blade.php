@extends('layouts.app')

@section('title', 'Kategori Peralatan')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Daftar Kategori Peralatan</h3>
            <a href="{{ route('categories.create') }}"
                class="px-4 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold">
                + Tambah Kategori
            </a>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-800 text-white text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Jumlah Alat</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($categories as $category)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $category->description ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $category->equipments_count }} jenis</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('categories.edit', $category) }}"
                                class="text-sky-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-slate-400">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $categories->links() }}</div>
    </div>
@endsection