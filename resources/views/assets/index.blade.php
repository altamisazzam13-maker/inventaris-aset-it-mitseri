<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Aset IT - MITSERI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex" 
      x-data="{ 
          activeTab: 'grafik',
          openTambah: false, 
          openMaintenance: false, 
          openEdit: false, 
          openUserModal: false, 
          openProfileMenu: false, 
          openScanner: false, 
          openImport: false, 
          editAsset: {}, 
          isLoggingOut: false,
          searchQuery: '',
          currentUserName: '{{ Auth::user()->name }}',
          rawAssets: {{ json_encode($assets) }},
          get filteredAssets() {
              let q = this.searchQuery.toLowerCase().trim();
              let result = this.rawAssets;
              
              if (q !== '') {
                  result = result.filter(a => 
                      (a.nama_aset && a.nama_aset.toLowerCase().includes(q)) ||
                      (a.kode_aset && a.kode_aset.toLowerCase().includes(q)) ||
                      (a.kategori && a.kategori.toLowerCase().includes(q)) ||
                      (a.lokasi && a.lokasi.toLowerCase().includes(q)) ||
                      (a.penanggung_jawab && a.penanggung_jawab.toLowerCase().includes(q))
                  );
              }
              
              return result.sort((a, b) => (a.nama_aset || '').localeCompare(b.nama_aset || ''));
          }
      }">

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-600 text-white px-5 py-3.5 rounded-xl shadow-xl border border-emerald-500">
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
@endif

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex shrink-0">
        <div class="p-5">
            <div class="flex items-center gap-3 mb-8 px-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo MITSERI" class="w-10 h-10 object-contain rounded-xl">
                <div>
                    <h1 class="font-bold text-base text-white leading-none">MITSERI</h1>
                    <p class="text-[10px] text-slate-400 mt-1">Aset IT Management</p>
                </div>
            </div>

            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl bg-slate-800 text-white border-l-4 border-indigo-500">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard Aset
                </a>

                @if((Auth::user()->role ?? 'staff') === 'admin')
                    <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Kategori
                    </a>
                    <a href="{{ route('maintenances.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 012.828 0L20 4.828a2 2 0 010 2.828l-8.586 8.586a2 2 0 01-.707.393l-3.321 1.107a.5.5 0 01-.632-.632l1.107-3.321a2 2 0 01.393-.707l8.586-8.586z"></path></svg>
                        Maintenances
                    </a>
                @endif

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
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- HEADER UTAMA -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between gap-4 shadow-sm">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo.png') }}" alt="Logo MITSERI" class="w-7 h-7 object-contain md:hidden">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Inventaris Aset IT - MITSERI</h2>
            </div>

            <div class="flex items-center gap-3">
                <button @click="openScanner = true; startQrScanner()" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs px-3.5 py-2 rounded-xl flex items-center gap-1.5 border border-slate-300 transition-all">
                    📷 <span>Scan QR</span>
                </button>

                <!-- INFO USER & BADGE ROLE LOGIN -->
                <div class="relative">
                    <button @click="openProfileMenu = !openProfileMenu" class="flex items-center gap-2 text-sm text-slate-700 font-medium hover:text-slate-900 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <span>Info</span>
                        
                        @if((Auth::user()->role ?? 'staff') === 'admin')
                            <span class="bg-rose-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full shadow-sm">ADMIN</span>
                        @else
                            <span class="bg-blue-500 text-white font-bold text-[10px] px-2 py-0.5 rounded-full shadow-sm">STAFF</span>
                        @endif
                    </button>
                    
                    <div x-show="openProfileMenu" @click.away="openProfileMenu = false" class="absolute right-0 mt-2 w-52 bg-white border border-slate-200 rounded-xl shadow-lg py-2 z-50 text-xs" x-cloak>
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-slate-400 text-[10px]">{{ Auth::user()->email }}</p>
                        </div>
                        @if((Auth::user()->role ?? 'staff') === 'admin')
                            <button @click="openUserModal = true; openProfileMenu = false" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-indigo-600 font-semibold">👥 Kelola Hak Akses User</button>
                        @endif
                    </div>
                </div>

                @if((Auth::user()->role ?? 'staff') === 'admin')
                    <button type="button" @click="openTambah = true" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-4 py-2 rounded-xl shadow-md cursor-pointer">
                        Action (+ Aset)
                    </button>
                @endif
            </div>
        </header>

        <main class="flex-1 p-6 overflow-y-auto space-y-6">

            <!-- TAB SWITCHER NAVIGASI (OPSI 2) -->
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <div class="flex items-center gap-2 bg-slate-200/60 p-1 rounded-xl">
                    <button @click="activeTab = 'grafik'" 
                            :class="activeTab === 'grafik' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" 
                            class="px-4 py-2 rounded-lg text-xs transition-all flex items-center gap-2">
                        📊 <span>Ringkasan & Grafik</span>
                    </button>
                    <button @click="activeTab = 'tabel'" 
                            :class="activeTab === 'tabel' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" 
                            class="px-4 py-2 rounded-lg text-xs transition-all flex items-center gap-2">
                        📋 <span>Data & Tabel Aset</span>
                    </button>
                </div>

                <!-- LIVE SEARCH INPUT (BILA TAB TABEL DIBUKA) -->
                <div x-show="activeTab === 'tabel'" x-transition class="relative w-64 hidden sm:block">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Cari aset (nama, kode, lokasi)..." 
                           class="w-full bg-white border border-slate-200 rounded-xl pl-4 pr-10 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all">
                    <button x-show="searchQuery !== ''" @click="searchQuery = ''" class="absolute right-3 top-2 text-xs text-slate-400 hover:text-slate-600 font-bold">&times;</button>
                </div>
            </div>

            <!-- ISI TAB 1: GRAFIK & ANALITIK -->
            <div x-show="activeTab === 'grafik'" x-transition.duration.300ms class="space-y-6">
                <!-- STAT CARDS RINGKAS -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                        <p class="text-xs font-semibold text-slate-400">Total Aset</p>
                        <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $totalAset }} Unit</h4>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                        <p class="text-xs font-semibold text-slate-400">Kondisi Bagus</p>
                        <h4 class="text-2xl font-black text-emerald-600 mt-1">{{ $persenBagus }}%</h4>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                        <p class="text-xs font-semibold text-slate-400">Perlu Servis</p>
                        <h4 class="text-2xl font-black text-amber-500 mt-1">{{ $chartKondisi['rusak_ringan'] + $chartKondisi['rusak_berat'] }} Unit</h4>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-4 rounded-2xl shadow-sm">
                        <p class="text-xs font-semibold text-slate-400">Kategori Hardware</p>
                        <h4 class="text-2xl font-black text-indigo-600 mt-1">{{ count($chartKategori) }} Jenis</h4>
                    </div>
                </div>

                <!-- CHARTS GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-slate-800 text-base">Kondisi Aset</h3>
                        </div>
                        <div class="relative h-56 flex items-center justify-center">
                            <canvas id="chartKondisiGauge"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-end pb-8 pointer-events-none">
                                <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $persenBagus }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-slate-800 text-base">Pengeluaran Servis Per Bulan</h3>
                        </div>
                        <div class="relative h-60"><canvas id="chartServisBar"></canvas></div>
                    </div>

                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4"><h3 class="font-bold text-slate-800 text-base">Sebaran Kategori Hardware</h3></div>
                        <div class="relative h-56 flex items-center justify-center"><canvas id="chartKategoriPie"></canvas></div>
                    </div>

                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4"><h3 class="font-bold text-slate-800 text-base">Aset Digunakan</h3></div>
                        <div class="relative h-56"><canvas id="chartPeminjamanLine"></canvas></div>
                    </div>
                </div>
            </div>

            <!-- ISI TAB 2: TABEL DATA OPERASIONAL ASET -->
            <div x-show="activeTab === 'tabel'" x-transition.duration.300ms class="space-y-4">
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">
                                <span x-text="(searchQuery && searchQuery.trim() !== '') ? 'Hasil Pencarian Aset (' + filteredAssets.length + ')' : 'Daftar Seluruh Aset (Urut A-Z)'"></span>
                            </h3>
                            
                            <div x-show="!searchQuery || searchQuery.trim() === ''" class="flex items-center gap-4 mt-1.5 text-[11px]">
                                <span class="flex items-center gap-1.5 font-medium text-slate-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                                    Aset Milik Anda (Login saat ini)
                                </span>
                                <span class="flex items-center gap-1.5 font-medium text-slate-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 inline-block"></span>
                                    Pegangan Pegawai Lain
                                </span>
                                <span class="flex items-center gap-1.5 font-medium text-slate-400">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block"></span>
                                    Belum Ada Pemegang
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('assets.exportExcel') }}" class="text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-lg border border-emerald-200 transition-colors">📊 Export Excel</a>
                            
                            @if((Auth::user()->role ?? 'staff') === 'admin')
                                <button @click="openImport = true" class="text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg border border-indigo-200 transition-colors">📥 Import Excel</button>
                            @endif

                            <a href="{{ route('assets.exportPdf') }}" target="_blank" class="text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg border border-rose-200 transition-colors">📄 Cetak PDF</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700">
                            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[11px] font-bold">
                                <tr>
                                    <th class="px-6 py-4">Aset</th>
                                    <th class="px-6 py-4">Kategori / SN</th>
                                    <th class="px-6 py-4">Lokasi & Pemegang</th>
                                    <th class="px-6 py-4">Status & Kondisi</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="asset in filteredAssets" :key="asset.id">
                                    <tr class="hover:bg-slate-50/80 transition-colors"
                                        :class="(asset.penanggung_jawab && asset.penanggung_jawab.toLowerCase() === currentUserName.toLowerCase()) ? 'bg-emerald-50/30' : ''">
                                        <td class="px-6 py-4">
                                            <a :href="'/assets/' + asset.id" class="font-bold text-slate-900 hover:text-indigo-600 block" x-text="asset.nama_aset"></a>
                                            <div class="text-xs text-indigo-600 font-mono font-semibold" x-text="asset.kode_aset"></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-semibold text-slate-800" x-text="asset.kategori"></div>
                                            <div class="text-[11px] font-mono text-slate-400" x-text="'SN: ' + (asset.nomor_seri ? asset.nomor_seri : '-')"></div>
                                        </td>
                                        <td class="px-6 py-4 text-xs">
                                            <div class="text-slate-800 font-medium" x-text="asset.lokasi ? asset.lokasi : '-'"></div>
                                            
                                            <template x-if="asset.penanggung_jawab && asset.penanggung_jawab.toLowerCase() === currentUserName.toLowerCase()">
                                                <div class="mt-0.5 inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md border border-emerald-200">
                                                    👤 <span x-text="asset.penanggung_jawab + ' (Saya)'"></span>
                                                </div>
                                            </template>
                                            <template x-if="asset.penanggung_jawab && asset.penanggung_jawab !== 'Belum Diatur' && asset.penanggung_jawab.toLowerCase() !== currentUserName.toLowerCase()">
                                                <div class="mt-0.5 inline-flex items-center gap-1 text-[11px] font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md">
                                                    👤 <span x-text="asset.penanggung_jawab"></span>
                                                </div>
                                            </template>
                                            <template x-if="!asset.penanggung_jawab || asset.penanggung_jawab === 'Belum Diatur'">
                                                <div class="mt-0.5 inline-flex items-center gap-1 text-[11px] text-slate-400 font-normal">
                                                    👤 Belum Diatur
                                                </div>
                                            </template>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold"
                                                  :class="asset.kondisi === 'Bagus' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'"
                                                  x-text="asset.kondisi"></span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center items-center gap-3">
                                                <a :href="'/assets/' + asset.id" class="text-indigo-600 font-bold text-xs hover:underline">Detail</a>
                                                @if((Auth::user()->role ?? 'staff') === 'admin')
                                                    <button type="button" @click="openEdit = true; editAsset = asset" class="text-amber-600 font-bold text-xs hover:underline cursor-pointer">Edit</button>
                                                    <form :action="'/assets/' + asset.id" method="POST" onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-600 font-bold text-xs hover:underline">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                <tr x-show="filteredAssets.length === 0">
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        Tidak ada data aset yang cocok dengan kata kunci "<span class="font-semibold text-slate-600" x-text="searchQuery"></span>".
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL TAMBAH ASET (KHUSUS ADMIN) -->
    @if((Auth::user()->role ?? 'staff') === 'admin')
    <div x-show="openTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">+ Tambah Aset IT Baru</h3>
                <button type="button" @click="openTambah = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>
            <form action="{{ route('assets.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Aset</label>
                    <input type="text" name="nama_aset" required placeholder="Contoh: Laptop Dell Latitude 3420" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kode Aset</label>
                        <input type="text" name="kode_aset" required placeholder="AST-IT-01" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                        <select name="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                            <option value="Laptop">Laptop</option>
                            <option value="PC Desktop">PC Desktop</option>
                            <option value="Printer">Printer</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" placeholder="Ruang IT / Lab 1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" placeholder="Nama Staff / Belum Diatur" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi</label>
                        <select name="kondisi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                            <option value="Bagus">Bagus</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor Seri (SN)</label>
                        <input type="text" name="nomor_seri" placeholder="SN-12345678" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-200">
                    <button type="button" @click="openTambah = false" class="px-4 py-2 text-xs text-slate-600 font-medium hover:bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-md">Simpan Data Baru</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL EDIT ASET (KHUSUS ADMIN) -->
    @if((Auth::user()->role ?? 'staff') === 'admin')
    <div x-show="openEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">Edit Data Aset IT</h3>
                <button type="button" @click="openEdit = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>
            <form :action="'/assets/' + editAsset.id" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Aset</label>
                    <input type="text" name="nama_aset" x-model="editAsset.nama_aset" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kode Aset</label>
                        <input type="text" name="kode_aset" x-model="editAsset.kode_aset" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                        <input type="text" name="kategori" x-model="editAsset.kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" x-model="editAsset.lokasi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" x-model="editAsset.penanggung_jawab" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi</label>
                        <select name="kondisi" x-model="editAsset.kondisi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                            <option value="Bagus">Bagus</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor Seri (SN)</label>
                        <input type="text" name="nomor_seri" x-model="editAsset.nomor_seri" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-200">
                    <button type="button" @click="openEdit = false" class="px-4 py-2 text-xs text-slate-600 font-medium hover:bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-500 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL KELOLA USER (KHUSUS ADMIN) -->
    @if((Auth::user()->role ?? 'staff') === 'admin')
    <div x-show="openUserModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <h3 class="font-bold text-slate-900 text-base">👥 Kelola Hak Akses Pengguna</h3>
                <button type="button" @click="openUserModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto space-y-4">
                @foreach($users as $user)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $user->email }}</p>
                        </div>
                        <form action="/users/{{ $user->id }}/role" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <select name="role" onchange="this.form.submit()" class="bg-white border border-slate-300 rounded-lg text-xs px-2.5 py-1.5 font-semibold text-slate-700">
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ADMIN</option>
                                <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>STAFF</option>
                            </select>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL IMPORT EXCEL / CSV -->
    @if((Auth::user()->role ?? 'staff') === 'admin')
    <div x-show="openImport" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-base">Import Data Aset via CSV/Excel</h3>
                <button type="button" @click="openImport = false" class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <form action="{{ route('assets.importExcel') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Pilih File (.CSV)</label>
                    <input type="file" name="file" required class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-200">
                    <button type="button" @click="openImport = false" class="px-4 py-2 text-xs text-slate-600 font-medium">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-4 py-2 rounded-xl">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL SCANNER -->
    <div x-show="openScanner" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-base">Scan QR Code Aset</h3>
                <button type="button" @click="openScanner = false; stopQrScanner()" class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <div class="p-5 flex flex-col items-center">
                <div id="reader" class="w-full rounded-xl overflow-hidden border border-slate-300"></div>
            </div>
        </div>
    </div>

    <!-- SCRIPT INITIALIZE CHARTS & SCANNER -->
    <script>
        let html5QrcodeScanner = null;
        function startQrScanner() {
            setTimeout(() => {
                if (!html5QrcodeScanner) {
                    html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
                    html5QrcodeScanner.render((decodedText) => { html5QrcodeScanner.clear(); window.location.href = decodedText; });
                }
            }, 300);
        }
        function stopQrScanner() { if (html5QrcodeScanner) { html5QrcodeScanner.clear(); html5QrcodeScanner = null; } }

        document.addEventListener('DOMContentLoaded', function() {
            const elGauge = document.getElementById('chartKondisiGauge');
            if (elGauge) {
                new Chart(elGauge.getContext('2d'), { type: 'doughnut', data: { labels: ['Bagus', 'Rusak Ringan', 'Rusak Berat'], datasets: [{ data: [{{ $chartKondisi['bagus'] }}, {{ $chartKondisi['rusak_ringan'] }}, {{ $chartKondisi['rusak_berat'] }}], backgroundColor: ['#10b981', '#f59e0b', '#f43f5e'], borderWidth: 0 }] }, options: { responsive: true, maintainAspectRatio: false, rotation: -90, circumference: 180, cutout: '78%', plugins: { legend: { display: false } } } });
            }

            const elServis = document.getElementById('chartServisBar');
            if (elServis) {
                new Chart(elServis.getContext('2d'), { type: 'bar', data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], datasets: [{ data: {!! json_encode($monthlyCosts) !!}, backgroundColor: '#10b981', borderRadius: 4, barThickness: 18 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } } });
            }

            const elKategori = document.getElementById('chartKategoriPie');
            if (elKategori) {
                new Chart(elKategori.getContext('2d'), { type: 'pie', data: { labels: {!! json_encode(array_keys($chartKategori)) !!}, datasets: [{ data: {!! json_encode(array_values($chartKategori)) !!}, backgroundColor: ['#10b981', '#22c55e', '#eab308', '#6366f1', '#f43f5e'], borderWidth: 0 }] }, options: { responsive: true, maintainAspectRatio: false } });
            }

            const elPeminjaman = document.getElementById('chartPeminjamanLine');
            if (elPeminjaman) {
                new Chart(elPeminjaman.getContext('2d'), { type: 'line', data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], datasets: [{ data: {!! json_encode($trendPeminjaman) !!}, borderColor: '#3b82f6', borderWidth: 3, fill: true, backgroundColor: 'rgba(59, 130, 246, 0.05)', tension: 0.4 }] }, options: { responsive: true, maintainAspectRatio: false } });
            }
        });
    </script>
</body>
</html>