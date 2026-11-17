@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex flex-wrap gap-4 justify-between items-center">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIP / nama pegawai..."
                    class="rounded-lg border-slate-300 text-xs">
                <button type="submit"
                    class="px-3 py-2 rounded-lg bg-slate-800 text-white text-xs font-semibold">Cari</button>
            </form>
            <a href="{{ route('employees.create') }}"
                class="px-4 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold">
                + Tambah Pegawai
            </a>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-800 text-white text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">NIP</th>
                    <th class="px-6 py-3">Nama Pegawai</th>
                    <th class="px-6 py-3">Divisi / Departemen</th>
                    <th class="px-6 py-3">No. Telepon</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($employees as $emp)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-mono text-xs font-semibold">{{ $emp->nip }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $emp->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $emp->department }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $emp->phone }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('employees.edit', $emp) }}"
                                class="text-sky-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('employees.destroy', $emp) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus data pegawai ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-slate-400">Belum ada data pegawai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $employees->withQueryString()->links() }}</div>
    </div>
@endsection