<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Aset - MITSERI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex" x-data="{ openProfileMenu: false }">

    <!-- SIDEBAR LEFT -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex shrink-0">
        <div class="p-5">
            <div class="flex items-center gap-3 mb-8 px-2">
                <div class="p-2 bg-gradient-to-tr from-indigo-600 to-purple-500 rounded-xl shadow-lg shadow-indigo-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                </div>
                <div><h1 class="font-bold text-lg text-white leading-none">Aset IT</h1></div>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard Aset
                </a>
                <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl bg-slate-800 text-white border-l-4 border-indigo-500">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Kategori
                </a>
                <a href="{{ route('assets.exportPdf') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan PDF
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 text-xs font-semibold text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between gap-4 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Kategori Hardware Aset IT</h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:underline">&larr; Kembali ke Dashboard</a>
        </header>

        <main class="flex-1 p-6 overflow-y-auto space-y-6">
            <!-- Grid Card Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($kategoriList as $kat)
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <span class="p-3 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-lg">📦</span>
                        <span class="text-2xl font-extrabold text-slate-900">{{ $kat->total }} <span class="text-xs text-slate-400 font-normal">Unit</span></span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $kat->kategori }}</h3>
                    <p class="text-xs text-slate-500 mb-4">Total perangkat terdaftar dalam kategori {{ $kat->kategori }}.</p>
                    <a href="{{ route('dashboard', ['kategori' => $kat->kategori]) }}" class="inline-block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-semibold text-xs py-2 rounded-xl transition-colors">Lihat Semua Aset {{ $kat->kategori }} &rarr;</a>
                </div>
                @empty
                <div class="col-span-3 text-center py-12 text-slate-400">Belum ada kategori aset.</div>
                @endforelse
            </div>
        </main>
    </div>

</body>
</html>