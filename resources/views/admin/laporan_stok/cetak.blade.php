<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Stok - INVENDAM</title>

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

        .btn-print,
        .btn-excel,
        .btn-back {
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #0d6f9d;
            color: #fff;
        }

        .btn-excel {
            background: #198754;
            color: #fff;
        }

        .btn-back {
            background: #f1f5f9;
            color: #222;
            border: 1px solid #ccc;
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
            margin-bottom: 16px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
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

        .status-aman {
            color: #198754;
            font-weight: bold;
        }

        .status-minimum {
            color: #b7791f;
            font-weight: bold;
        }

        .status-rendah {
            color: #dc3545;
            font-weight: bold;
        }

        .ttd {
            width: 260px;
            margin-left: auto;
            margin-top: 45px;
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
    $totalBarang = $totalBarang ?? $barang->count();
    $stokAman = $stokAman ?? $barang->where(fn ($item) => $item->stok > $item->minimum_stok)->count();
    $stokMinimum = $stokMinimum ?? $barang->where(fn ($item) => $item->stok == $item->minimum_stok)->count();
    $stokRendah = $stokRendah ?? $barang->where(fn ($item) => $item->stok < $item->minimum_stok)->count();
?>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">
            Cetak / Save PDF
        </button>

        <a href="{{ route('admin.laporan-stok.excel') }}" class="btn-excel">
            Export Excel
        </a>

        <a href="{{ route('admin.laporan-stok.index') }}" class="btn-back">
            Kembali
        </a>
    </div>

    <div class="kop">
        <div class="kop-logo-wrap">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Logo PDAM"
                class="kop-logo"
            >
        </div>

        <div class="kop-text">
            <h2>INVENDAM</h2>
            <h3>Sistem Inventory PDAM Bengkayang</h3>
            <p>Laporan Data Stok Barang</p>
        </div>

        <div></div>
    </div>

    <div class="judul">
        <h3>Laporan Stok Barang</h3>
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
            Total Barang
            <strong>{{ $totalBarang }}</strong>
        </div>

        <div class="summary-box">
            Stok Aman
            <strong>{{ $stokAman }}</strong>
        </div>

        <div class="summary-box">
            Stok Minimum
            <strong>{{ $stokMinimum }}</strong>
        </div>

        <div class="summary-box">
            Stok Rendah
            <strong>{{ $stokRendah }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Minimum</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($barang as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td class="text-center">{{ $item->satuan }}</td>
                    <td class="text-center">{{ $item->stok }}</td>
                    <td class="text-center">{{ $item->minimum_stok }}</td>
                    <td class="text-center">
                        @if($item->stok > $item->minimum_stok)
                            <span class="status-aman">Aman</span>
                        @elseif($item->stok == $item->minimum_stok)
                            <span class="status-minimum">Minimum</span>
                        @else
                            <span class="status-rendah">Stok Rendah</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Data barang belum tersedia.
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