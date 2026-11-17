@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <div class="max-w-xl bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('employees.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Divisi / Departemen</label>
                <input type="text" name="department" value="{{ old('department') }}" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon / WA</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    class="w-full rounded-lg border-slate-300 text-sm">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold">Simpan</button>
                <a href="{{ route('employees.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-200 text-slate-700 text-xs font-semibold">Batal</a>
            </div>
        </form>
    </div>
@endsection