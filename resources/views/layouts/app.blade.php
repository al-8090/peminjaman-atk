<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIP-ATK | PT Cakrawala Teknologi Nusantara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-sans antialiased text-slate-800">
    <div class="min-h-screen flex">
        <!-- Sidebar Navy -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between shrink-0">
            <div>
                <div class="p-6 border-b border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-lg bg-sky-500 flex items-center justify-center font-bold text-white shadow">
                            ATK
                        </div>
                        <div>
                            <h1 class="font-bold text-base tracking-wide">SIP-ATK</h1>
                            <p class="text-[11px] text-slate-400">PT Cakrawala Teknologi</p>
                        </div>
                    </div>
                </div>

                <nav class="p-4 space-y-1.5 text-sm">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4 pb-1 px-4 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        Master Data
                    </div>

                    <a href="{{ route('categories.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('categories.*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>Kategori Peralatan</span>
                    </a>

                    <a href="{{ route('equipments.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('equipments.*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>Data Peralatan</span>
                    </a>

                    <a href="{{ route('employees.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('employees.*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>Data Pegawai</span>
                    </a>

                    <div class="pt-4 pb-1 px-4 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                        Sirkulasi
                    </div>

                    <a href="{{ route('loans.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition {{ request()->routeIs('loans.*') ? 'bg-sky-500 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span>Peminjaman & Riwayat</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-800">
                <div class="mb-3 px-2">
                    <p class="text-xs font-semibold text-white">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold transition">
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm border-b border-slate-200 px-8 py-4 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-800">
                    @yield('title', 'Dashboard')
                </h2>
                <span class="text-xs font-medium px-3 py-1 rounded-full bg-sky-50 text-sky-700 border border-sky-200">
                    Sarana & Prasarana
                </span>
            </header>

            <main class="p-8 flex-1">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>