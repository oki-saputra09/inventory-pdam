<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Transaksi - INVENDAM</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            margin: 30px;
        }

        .no-print {
            margin-bottom: 20px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-print {
            background: #0d6f9d;
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-excel {
            background: #198754;
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back {
            background: #f1f5f9;
            color: #222;
            border: 1px solid #ccc;
            padding: 9px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            display: inline-block;
        }

        .kop {
            display: grid;
            grid-template-columns: 90px 1fr 90px;
            align-items: center;
            border-bottom: 3px solid #222;
            padding-bottom: 14px;
            margin-bottom: 24px;
        }

        .kop-logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kop-logo {
            width: 78px;
            height: 78px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text h3 {
            margin: 4px 0;
            font-size: 18px;
            font-weight: normal;
        }

        .kop-text p {
            margin: 4px 0 0;
            font-size: 13px;
        }

        .judul {
            text-align: center;
            margin-bottom: 18px;
        }

        .judul h3 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .info {
            margin-bottom: 14px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            gap: 18px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 18px;
        }

        .summary-box {
            border: 1px solid #222;
            padding: 8px;
            text-align: center;
            font-size: 13px;
        }

        .summary-box strong {
            display: block;
            font-size: 18px;
            margin-top: 4px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin: 18px 0 8px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 18px;
        }

        th,
        td {
            border: 1px solid #222;
            padding: 7px;
            vertical-align: middle;
        }

        th {
            background: #eaf4ff;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .ttd {
            width: 260px;
            margin-left: auto;
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
        }

        .ttd .nama {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            @page {
                size: A4 landscape;
                margin: 15mm;
            }
        }
    </style>
</head>

<body>
<?php
    $logoPath = public_path('images/logo.png');
    $logoUrl = file_exists($logoPath) ? asset('images/logo.png') : null;

    $totalMasuk = $barangMasuk->count();
    $totalKeluar = $barangKeluar->count();
    $jumlahMasuk = $barangMasuk->sum('jumlah');
    $jumlahKeluar = $barangKeluar->sum('jumlah');
?>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">
            Cetak / Save PDF
        </button>

        <a href="{{ route('admin.laporan-transaksi.excel') }}" class="btn-excel">
            Export Excel
        </a>

        <a href="{{ route('admin.laporan-transaksi.index') }}" class="btn-back">
            Kembali
        </a>
    </div>

    <div class="kop">
        <div class="kop-logo-wrap">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo PDAM" class="kop-logo">
            @endif
        </div>

        <div class="kop-text">
            <h2>INVENDAM</h2>
            <h3>Sistem Inventory PDAM Bengkayang</h3>
            <p>Laporan Transaksi Barang</p>
        </div>

        <div></div>
    </div>

    <div class="judul">
        <h3>Laporan Transaksi Barang</h3>
    </div>

    <div class="info">
        <div>
            <strong>Tanggal Cetak:</strong> {{ now()->format('d-m-Y H:i') }}
        </div>

        <div>
            <strong>Dicetak Oleh:</strong> {{ auth()->user()->name ?? 'Admin' }}
        </div>
    </div>

    <div class="summary">
        <div class="summary-box">
            Total Barang Masuk
            <strong>{{ $totalMasuk }}</strong>
        </div>

        <div class="summary-box">
            Total Barang Keluar
            <strong>{{ $totalKeluar }}</strong>
        </div>

        <div class="summary-box">
            Jumlah Masuk
            <strong>{{ $jumlahMasuk }}</strong>
        </div>

        <div class="summary-box">
            Jumlah Keluar
            <strong>{{ $jumlahKeluar }}</strong>
        </div>
    </div>

    <div class="section-title">A. Barang Masuk</div>

    <table>
        <thead>
            <tr>
                <th width="35">No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($barangMasuk as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td>{{ $item->keterangan ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Belum ada data barang masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">B. Barang Keluar</div>

    <table>
        <thead>
            <tr>
                <th width="35">No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tujuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($barangKeluar as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_keluar ? \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td>{{ $item->tujuan ?: '-' }}</td>
                    <td>{{ $item->keterangan ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Belum ada data barang keluar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd">
        <p>Bengkayang, {{ now()->format('d-m-Y') }}</p>
        <p>Admin Inventory</p>

        <div class="nama">
            {{ auth()->user()->name ?? 'Admin' }}
        </div>
    </div>
</body>
</html>