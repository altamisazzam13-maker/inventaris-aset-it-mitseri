<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with('maintenances');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_aset', 'like', '%' . $search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $search . '%')
                  ->orWhere('nomor_seri', 'like', '%' . $search . '%')
                  ->orWhere('penanggung_jawab', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assets = $query->latest()->get();
        $allAssets = Asset::all();

        $totalAset = $allAssets->count();
        $asetBagus = $allAssets->where('kondisi', 'Bagus')->count();
        $asetDigunakan = $allAssets->where('status', 'Digunakan')->count();
        $asetRusak = $allAssets->whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();

        $chartKondisi = [
            'bagus' => $allAssets->where('kondisi', 'Bagus')->count(),
            'rusak_ringan' => $allAssets->where('kondisi', 'Rusak Ringan')->count(),
            'rusak_berat' => $allAssets->where('kondisi', 'Rusak Berat')->count(),
        ];
        $persenBagus = $totalAset > 0 ? round(($asetBagus / $totalAset) * 100) : 0;

        $chartKategori = Asset::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        $maintenanceMonthly = Maintenance::select(
            DB::raw('MONTH(tanggal_servis) as month'),
            DB::raw('SUM(biaya) as total_biaya')
        )
        ->whereYear('tanggal_servis', date('Y'))
        ->groupBy('month')
        ->pluck('total_biaya', 'month')
        ->toArray();

        $monthlyCosts = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyCosts[] = $maintenanceMonthly[$m] ?? 0;
        }

        $peminjamanMonthly = Asset::where('status', 'Digunakan')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $trendPeminjaman = [];
        for ($m = 1; $m <= 12; $m++) {
            $trendPeminjaman[] = $peminjamanMonthly[$m] ?? 0;
        }

        $users = User::orderBy('id', 'asc')->get();

        return view('assets.index', compact(
            'assets', 'totalAset', 'asetBagus', 'asetDigunakan', 'asetRusak',
            'chartKondisi', 'persenBagus', 'chartKategori', 'monthlyCosts',
            'trendPeminjaman', 'users'
        ));
    }

    public function dashboard(Request $request)
    {
        return $this->index($request);
    }

    public function kategoriIndex()
    {
        $kategoriList = Asset::select('kategori', DB::raw('count(*) as total'))->groupBy('kategori')->get();
        $assets = Asset::all();
        $users = User::orderBy('id', 'asc')->get();
        $asetRusak = Asset::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();

        return view('assets.kategori', compact('kategoriList', 'assets', 'users', 'asetRusak'));
    }

    public function maintenanceIndex()
    {
        $maintenances = Maintenance::with('asset')->latest()->get();
        $totalBiaya = Maintenance::sum('biaya');
        $totalServis = Maintenance::count();
        $assets = Asset::all();
        $users = User::orderBy('id', 'asc')->get();

        return view('assets.maintenance', compact('maintenances', 'totalBiaya', 'totalServis', 'assets', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_aset'        => 'required|unique:assets',
            'nama_aset'        => 'required|string|max:255',
            'kategori'         => 'required|string',
            'nomor_seri'       => 'nullable|string',
            'lokasi'           => 'nullable|string',
            'penanggung_jawab' => 'nullable|string',
            'kondisi'          => 'required|string',
            'status'           => 'nullable|string',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = !empty($validated['penanggung_jawab']) && $validated['penanggung_jawab'] !== 'Belum Diatur' ? 'Digunakan' : 'Tersedia';
        }

        Asset::create($validated);
        return redirect()->back()->with('success', 'Aset baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $validated = $request->validate([
            'kode_aset'        => 'required|unique:assets,kode_aset,' . $id,
            'nama_aset'        => 'required|string|max:255',
            'kategori'         => 'required|string',
            'nomor_seri'       => 'nullable|string',
            'lokasi'           => 'nullable|string',
            'penanggung_jawab' => 'nullable|string',
            'kondisi'          => 'required|string',
            'status'           => 'nullable|string',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = !empty($validated['penanggung_jawab']) && $validated['penanggung_jawab'] !== 'Belum Diatur' ? 'Digunakan' : 'Tersedia';
        }

        $asset->update($validated);
        return redirect()->back()->with('success', 'Data aset berhasil diperbarui!');
    }

    public function show($id)
    {
        $asset = Asset::with('maintenances')->findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();
        return redirect()->back()->with('success', 'Aset berhasil dihapus!');
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'asset_id'            => 'required|exists:assets,id',
            'tanggal_servis'      => 'required|date',
            'jenis_perbaikan'     => 'required|string',
            'deskripsi_kerusakan' => 'required|string',
            'biaya'               => 'nullable|numeric',
            'teknisi_vendor'      => 'nullable|string',
        ]);

        Maintenance::create($validated);
        $asset = Asset::find($request->asset_id);
        $asset->update(['status' => 'Perbaikan']);

        return redirect()->back()->with('success', 'Riwayat maintenance berhasil dicatat!');
    }

    public function exportPdf()
    {
        $assets = Asset::all();
        $pdf = Pdf::loadView('assets.pdf', compact('assets'));
        return $pdf->download('Laporan_Aset_IT_MITSERI.pdf');
    }

    public function exportExcel()
    {
        $fileName = 'Data_Aset_IT_MITSERI_' . date('Y-m-d') . '.csv';
        $assets = Asset::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Kode Aset', 'Nama Aset', 'Kategori', 'Nomor Seri', 'Lokasi', 'Penanggung Jawab', 'Kondisi', 'Status');

        $callback = function() use($assets, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($assets as $asset) {
                fputcsv($file, array(
                    $asset->kode_aset,
                    $asset->nama_aset,
                    $asset->kategori,
                    $asset->nomor_seri ?? '-',
                    $asset->lokasi ?? '-',
                    $asset->penanggung_jawab ?? '-',
                    $asset->kondisi,
                    $asset->status
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,txt']);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        fgetcsv($handle);

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (isset($row[0]) && !empty($row[0])) {
                Asset::updateOrCreate(
                    ['kode_aset' => $row[0]],
                    [
                        'nama_aset'        => $row[1] ?? 'Aset Perangkat',
                        'kategori'         => $row[2] ?? 'Laptop',
                        'nomor_seri'       => $row[3] ?? null,
                        'lokasi'           => $row[4] ?? 'Gudang IT',
                        'penanggung_jawab' => $row[5] ?? null,
                        'kondisi'          => $row[6] ?? 'Bagus',
                        'status'           => $row[7] ?? 'Tersedia',
                    ]
                );
            }
        }

        fclose($handle);

        return redirect()->back()->with('success', 'Data aset masal berhasil di-import dari CSV Excel!');
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|in:admin,staff']);
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role pengguna ' . $user->name . ' berhasil diubah menjadi ' . strtoupper($request->role) . '!');
    }
}