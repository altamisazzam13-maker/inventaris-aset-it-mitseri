<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aset IT - MITSERI</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1e293b; }
        .header { text-align: center; border-bottom: 2px solid #334155; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16pt; }
        .header p { margin: 3px 0 0 0; color: #64748b; font-size: 9pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 7px 9px; text-align: left; font-size: 9pt; }
        th { background-color: #f1f5f9; text-transform: uppercase; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN INVENTARIS ASET IT</h2>
        <p>PT MITSERI INDONESIA — Dicetak: {{ date('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Aset</th>
                <th style="width: 25%;">Nama Hardware</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 15%;">Lokasi</th>
                <th style="width: 15%;">Penanggung Jawab</th>
                <th style="width: 10%;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $index => $asset)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="font-weight: bold; color: #4338ca;">{{ $asset->kode_aset }}</td>
                <td>{{ $asset->nama_aset }}</td>
                <td>{{ $asset->kategori }}</td>
                <td>{{ $asset->lokasi ?? '-' }}</td>
                <td>{{ $asset->penanggung_jawab ?? '-' }}</td>
                <td>{{ $asset->kondisi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data aset terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>