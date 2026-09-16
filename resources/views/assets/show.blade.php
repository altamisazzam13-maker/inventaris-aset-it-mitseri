<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset - {{ $asset->kode_aset }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen p-6">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Navigation -->
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:underline flex items-center gap-1">
                &larr; Kembali ke Dashboard
            </a>
            <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm">
                🖨️ Cetak Stiker QR
            </button>
        </div>

        <!-- Card Main Detail -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Left Column: Asset Info -->
            <div class="md:col-span-2 space-y-4">
                <div>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold uppercase tracking-wider">{{ $asset->kategori }}</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 mt-2">{{ $asset->nama_aset }}</h1>
                    <p class="text-xs font-mono text-indigo-600 font-bold mt-1">Kode Aset: {{ $asset->kode_aset }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs">
                    <div>
                        <p class="text-slate-400 font-medium">Nomor Seri (S/N)</p>
                        <p class="font-semibold text-slate-800 font-mono">{{ $asset->nomor_seri ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium">Lokasi Aset</p>
                        <p class="font-semibold text-slate-800">{{ $asset->lokasi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium">Penanggung Jawab</p>
                        <p class="font-semibold text-slate-800">👤 {{ $asset->penanggung_jawab ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium">Status & Kondisi</p>
                        <p class="font-semibold text-slate-800">
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-700 text-[10px] font-bold">{{ $asset->kondisi }}</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-[10px] font-bold">{{ $asset->status }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column: QR Code Visual -->
            <div class="flex flex-col items-center justify-center p-4 bg-slate-50 border border-slate-200 rounded-xl text-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ url('/assets/' . $asset->id) }}" alt="QR Code Aset" class="w-36 h-36 bg-white p-2 rounded-lg border border-slate-200 shadow-sm">
                <p class="text-[11px] font-bold text-slate-700 mt-3">{{ $asset->kode_aset }}</p>
                <p class="text-[9px] text-slate-400">Scan QR untuk melihat detail aset ini</p>
            </div>

        </div>

        <!-- History Maintenance Table -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="p-4 border-b border-slate-100 font-bold text-slate-800 text-sm">
                Riwayat Perbaikan & Maintenance Aset Ini
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold">
                        <tr>
                            <th class="px-4 py-3">Tgl Servis</th>
                            <th class="px-4 py-3">Jenis Perbaikan</th>
                            <th class="px-4 py-3">Deskripsi Problem</th>
                            <th class="px-4 py-3">Teknisi / Vendor</th>
                            <th class="px-4 py-3 text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($asset->maintenances as $m)
                        <tr class="text-xs">
                            <td class="px-4 py-3 font-medium text-slate-600">{{ $m->tanggal_servis }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $m->jenis_perbaikan }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $m->deskripsi_kerusakan }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $m->teknisi_vendor ?? '-' }}</td>
                            <td class="px-4 py-3 font-bold text-emerald-600 text-right">Rp {{ number_format($m->biaya ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada riwayat perbaikan untuk aset ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>