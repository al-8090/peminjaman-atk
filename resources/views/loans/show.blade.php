@extends('layouts.app')

@section('title', 'Detail Transaksi Peminjaman')

@section('content')
    <div class="max-w-3xl bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 bg-slate-800 text-white flex justify-between items-center">
            <div>
                <p class="text-xs text-slate-400">Kode Peminjaman</p>
                <h3 class="text-lg font-bold font-mono">{{ $loan->loan_code }}</h3>
            </div>
            @if ($loan->status === 'dipinjam')
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-500 text-white">Sedang Dipinjam</span>
            @else
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white">Sudah Dikembalikan</span>
            @endif
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-slate-500">Pegawai Peminjam</p>
                    <p class="font-bold">{{ $loan->employee->name }} ({{ $loan->employee->nip }})</p>
                    <p class="text-xs text-slate-600">{{ $loan->employee->department }} • {{ $loan->employee->phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Waktu Peminjaman</p>
                    <p>Tanggal Pinjam: <strong>{{ $loan->loan_date->format('d M Y') }}</strong></p>
                    <p>Rencana Kembali: <strong>{{ $loan->due_date->format('d M Y') }}</strong></p>
                    @if ($loan->return_date)
                        <p class="text-emerald-600">Dikembalikan Pada:
                            <strong>{{ $loan->return_date->format('d M Y') }}</strong></p>
                    @endif
                </div>
            </div>

            @if ($loan->notes)
                <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs">
                    <strong>Catatan:</strong> {{ $loan->notes }}
                </div>
            @endif

            <div>
                <h4 class="text-xs font-bold uppercase text-slate-500 mb-2">Rincian Peralatan Dipinjam</h4>
                <table class="w-full text-sm border border-slate-200">
                    <thead class="bg-slate-100 text-xs uppercase">
                        <tr>
                            <th class="p-3 text-left">Kode</th>
                            <th class="p-3 text-left">Nama Peralatan</th>
                            <th class="p-3 text-left">Kategori</th>
                            <th class="p-3 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($loan->items as $item)
                            <tr>
                                <td class="p-3 font-mono text-xs">{{ $item->equipment->code }}</td>
                                <td class="p-3 font-semibold">{{ $item->equipment->name }}</td>
                                <td class="p-3 text-slate-600">{{ $item->equipment->category->name }}</td>
                                <td class="p-3 text-right font-bold">{{ $item->qty }} unit</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-slate-200">
                <a href="{{ route('loans.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-200 text-slate-700 text-xs font-semibold">
                    &larr; Kembali ke Daftar
                </a>

                @if ($loan->status === 'dipinjam')
                    <form action="{{ route('loans.return', $loan) }}" method="POST"
                        onsubmit="return confirm('Konfirmasi pengembalian seluruh peralatan ini? Stok akan otomatis bertambah kembali.')">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow">
                            Proses Pengembalian Barang
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection