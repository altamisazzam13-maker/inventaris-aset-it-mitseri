<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Maintenance - MITSERI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex" x-data="{ openMaintenance: false }">

    <!-- Pop-up Toast Alert -->
    @if (session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-600 text-white px-5 py-3.5 rounded-xl shadow-xl border border-emerald-500">
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

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
                <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Kategori
                </a>
                <a href="{{ route('maintenances.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl bg-slate-800 text-white border-l-4 border-indigo-500">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 012.828 0L20 4.828a2 2 0 010 2.828l-8.586 8.586a2 2 0 01-.707.393l-3.321 1.107a.5.5 0 01-.632-.632l1.107-3.321a2 2 0 01.393-.707l8.586-8.586z"></path></svg>
                    Maintenances
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
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Riwayat Maintenance & Perbaikan Aset</h2>
            @if((Auth::user()->role ?? 'staff') === 'admin')
                <button @click="openMaintenance = true" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-4 py-2 rounded-xl shadow-md transition-all">
                    + Catat Maintenance Baru
                </button>
            @endif
        </header>

        <main class="flex-1 p-6 overflow-y-auto space-y-6">
            
            <!-- STATS SUMMARY -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-500 mb-1">Total Kejadian Maintenance</p>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $totalServis }} <span class="text-xs font-normal text-slate-400">Kali Servis</span></h3>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-semibold text-indigo-600 mb-1">Total Biaya Perbaikan Ex. PPN</p>
                    <h3 class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- TABEL MAINTENANCE LOG -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="p-4 border-b border-slate-100 font-bold text-slate-800 text-sm">
                    Log Catatan Servis Hardware
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-4">Tgl Servis</th>
                                <th class="px-6 py-4">Aset Hardware</th>
                                <th class="px-6 py-4">Jenis Perbaikan</th>
                                <th class="px-6 py-4">Deskripsi Problem</th>
                                <th class="px-6 py-4">Teknisi / Vendor</th>
                                <th class="px-6 py-4 text-right">Biaya (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($maintenances as $m)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-xs font-semibold text-slate-600 whitespace-nowrap">{{ $m->tanggal_servis }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $m->asset->nama_aset ?? 'Aset Dihapus' }}</div>
                                    <div class="text-xs font-mono text-indigo-600">{{ $m->asset->kode_aset ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-800">{{ $m->jenis_perbaikan }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">{{ $m->deskripsi_kerusakan }}</td>
                                <td class="px-6 py-4 text-xs text-slate-600 font-medium">{{ $m->teknisi_vendor ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs font-bold text-emerald-600 text-right">Rp {{ number_format($m->biaya ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat perbaikan yang dicatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL CATAT MAINTENANCE -->
    @if((Auth::user()->role ?? 'staff') === 'admin')
    <div x-show="openMaintenance" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-lg">Catat Riwayat Maintenance</h3>
                <button @click="openMaintenance = false" class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <form action="{{ route('maintenances.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Aset IT</label>
                    <select name="asset_id" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800">
                        @foreach($assets as $ast)
                            <option value="{{ $ast->id }}">{{ $ast->kode_aset }} - {{ $ast->nama_aset }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Servis</label>
                        <input type="date" name="tanggal_servis" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Perbaikan</label>
                        <input type="text" name="jenis_perbaikan" placeholder="e.g. Upgrade RAM / Fan" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Kerusakan</label>
                    <textarea name="deskripsi_kerusakan" rows="2" placeholder="Jelaskan detail masalah..." required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Biaya (Rp)</label>
                        <input type="number" name="biaya" placeholder="0" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Teknisi / Vendor</label>
                        <input type="text" name="teknisi_vendor" placeholder="e.g. Service Center" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm text-slate-800">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-200">
                    <button type="button" @click="openMaintenance = false" class="px-4 py-2 text-sm text-slate-600 font-medium">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-5 py-2 rounded-xl">Simpan Riwayat</button>
                </div>
            </form>
        </div>
    </div>
    @endif

</body>
</html>