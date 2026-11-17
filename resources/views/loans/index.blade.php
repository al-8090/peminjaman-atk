@extends('layouts.app')

@section('title', 'Peminjaman & Riwayat Transaksi')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex flex-wrap gap-4 justify-between items-center">
            <form method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari kode pinjam / nama / NIP..." class="rounded-lg border-slate-300 text-xs">
                <select name="status" class="rounded-lg border-slate-300 text-xs">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan
                    </option>
                </select>
                <button type="submit"
                    class="px-3 py-2 rounded-lg bg-slate-800 text-white text-xs font-semibold">Filter</button>
            </form>

            <a href="{{ route('loans.create') }}"
                class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold">
                + Transaksi Peminjaman Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-800 text-white text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Pegawai</th>
                        <th class="px-6 py-3">Barang Dipinjam</th>
                        <th class="px-6 py-3">Tgl Pinjam / Kembali</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($loans as $loan)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-sky-600">{{ $loan->loan_code }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $loan->employee->name }}</div>
                                <div class="text-xs text-slate-500">{{ $loan->employee->nip }} •
                                    {{ $loan->employee->department }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <ul class="list-disc pl-4 text-xs space-y-0.5">
                                    @foreach ($loan->items as $item)
                                        <li>{{ $item->equipment->name }} ({{ $item->qty }}x)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div>Pinjam: {{ $loan->loan_date->format('d/m/Y') }}</div>
                                <div class="text-slate-500">Jatuh Tempo: {{ $loan->due_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($loan->status === 'dipinjam')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">Dipinjam</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Dikembalikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('loans.show', $loan) }}"
                                    class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-700 hover:bg-sky-100 text-xs font-semibold">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $loans->withQueryString()->links() }}</div>
    </div>
@endsection