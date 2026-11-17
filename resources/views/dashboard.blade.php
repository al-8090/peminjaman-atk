@extends('layouts.app')

@section('title', 'Dashboard Ringkasan Sistem')

@section('content')
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-slate-800">
            <p class="text-xs font-semibold text-slate-500 uppercase">Kategori Alat</p>
            <p class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCategories }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-sky-500">
            <p class="text-xs font-semibold text-slate-500 uppercase">Total Stok Tersedia</p>
            <p class="text-3xl font-bold text-sky-600 mt-2">{{ $totalEquipmentStock }} <span class="text-sm font-normal text-slate-400">unit</span></p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
            <p class="text-xs font-semibold text-slate-500 uppercase">Sedang Dipinjam</p>
            <p class="text-3xl font-bold text-orange-500 mt-2">{{ $activeLoans }} <span class="text-sm font-normal text-slate-400">transaksi</span></p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-emerald-500">
            <p class="text-xs font-semibold text-slate-500 uppercase">Telah Dikembalikan</p>
            <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $returnedLoans }} <span class="text-sm font-normal text-slate-400">transaksi</span></p>
        </div>
    </div>

    <!-- Tabel Transaksi Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">5 Peminjaman Terbaru</h3>
            <a href="{{ route('loans.create') }}"
               class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold transition">
                + Catat Peminjaman Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-800 text-white text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Peminjam</th>
                        <th class="px-6 py-3">Peralatan</th>
                        <th class="px-6 py-3">Tgl Pinjam</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($recentLoans as $loan)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-sky-600">
                                <a href="{{ route('loans.show', $loan) }}">{{ $loan->loan_code }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $loan->employee->name }}</div>
                                <div class="text-xs text-slate-500">{{ $loan->employee->department }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <ul class="list-disc pl-4 text-xs space-y-0.5">
                                    @foreach ($loan->items as $item)
                                        <li>{{ $item->equipment->name }} ({{ $item->qty }}x)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-xs">{{ $loan->loan_date->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if ($loan->status === 'dipinjam')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">Dipinjam</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada transaksi peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
