<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - PT Cakrawala Teknologi Nusantara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-slate-800 p-6 text-center border-b-4 border-sky-500">
            <div
                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-500 text-white font-bold text-lg mb-3">
                ATK
            </div>
            <h1 class="text-white font-bold text-lg">Sistem Peminjaman Peralatan Kantor</h1>
            <p class="text-slate-400 text-xs mt-1">PT Cakrawala Teknologi Nusantara</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="p-6 space-y-4">
            @csrf

            @if ($errors->any())
                <div class="p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-xs">
                    Email atau password tidak sesuai.
                </div>
            @endif

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Email Admin</label>
                <input type="email" name="email" value="{{ old('email', 'admin@cakrawala.co.id') }}" required autofocus
                    class="w-full rounded-lg border-slate-300 text-sm focus:border-sky-500 focus:ring-sky-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" value="password" required
                    class="w-full rounded-lg border-slate-300 text-sm focus:border-sky-500 focus:ring-sky-500">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full py-2.5 px-4 rounded-lg bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm shadow transition">
                    Masuk ke Sistem
                </button>
            </div>
        </form>
    </div>
</body>

</html>