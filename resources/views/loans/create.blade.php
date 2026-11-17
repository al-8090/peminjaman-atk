@extends('layouts.app')

@section('title', 'Catat Peminjaman Peralatan')

@section('content')
    <div class="max-w-3xl bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('loans.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pegawai Peminjam</label>
                    <select name="employee_id" required class="w-full rounded-lg border-slate-300 text-sm">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->nip }} - {{ $emp->name }} ({{ $emp->department }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" required
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Rencana Kembali</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan (Opsional)</label>
                    <input type="text" name="notes" placeholder="Keperluan meeting / event"
                        class="w-full rounded-lg border-slate-300 text-sm">
                </div>
            </div>

            <div class="border-t border-slate-200 pt-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-bold text-slate-800">Daftar Peralatan yang Dipinjam</h4>
                    <button type="button" onclick="addRow()"
                        class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold">
                        + Tambah Baris Alat
                    </button>
                </div>

                <div id="items-container" class="space-y-3">
                    <div class="grid grid-cols-12 gap-3 item-row">
                        <div class="col-span-8">
                            <select name="equipment_id[]" required class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="">-- Pilih Peralatan --</option>
                                @foreach ($equipments as $eq)
                                    <option value="{{ $eq->id }}">[{{ $eq->code }}] {{ $eq->name }} (Stok: {{ $eq->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <input type="number" name="qty[]" value="1" min="1" required placeholder="Qty"
                                class="w-full rounded-lg border-slate-300 text-sm">
                        </div>
                        <div class="col-span-1 flex items-center">
                            <button type="button" onclick="removeRow(this)"
                                class="text-red-500 hover:text-red-700 font-bold text-sm px-2">X</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-2 pt-3 border-t border-slate-200">
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold">
                    Simpan Transaksi Peminjaman
                </button>
                <a href="{{ route('loans.index') }}"
                    class="px-4 py-2.5 rounded-lg bg-slate-200 text-slate-700 text-xs font-semibold">Batal</a>
            </div>
        </form>
    </div>

    <script>
        function addRow() {
            const container = document.getElementById('items-container');
            const firstRow = container.querySelector('.item-row');
            const clone = firstRow.cloneNode(true);
            clone.querySelector('select').value = '';
            clone.querySelector('input').value = 1;
            container.appendChild(clone);
        }

        function removeRow(btn) {
            const container = document.getElementById('items-container');
            if (container.querySelectorAll('.item-row').length > 1) {
                btn.closest('.item-row').remove();
            }
        }
    </script>
@endsection