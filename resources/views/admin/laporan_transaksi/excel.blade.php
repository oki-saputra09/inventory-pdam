<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="application/vnd.ms-excel; charset=utf-8">
    <title>Laporan Transaksi Excel</title>
</head>

<body>
<?php
    $totalMasuk = $totalMasuk ?? $barangMasuk->count();
    $totalKeluar = $totalKeluar ?? $barangKeluar->count();
    $jumlahMasuk = $jumlahMasuk ?? $barangMasuk->sum('jumlah');
    $jumlahKeluar = $jumlahKeluar ?? $barangKeluar->sum('jumlah');
?>

<table style="border-collapse: collapse; font-family: Calibri, Arial, sans-serif; font-size: 11pt; width: 100%;">
    <colgroup>
        <col width="45">
        <col width="120">
        <col width="140">
        <col width="220">
        <col width="180">
        <col width="90">
        <col width="260">
    </colgroup>

    <tr style="height: 26px;">
        <td colspan="7"
            style="font-size: 14pt; font-weight: bold; text-align: center; vertical-align: middle;">
            INVENDAM - SISTEM INVENTORY PDAM BENGKAYANG
        </td>
    </tr>

    <tr style="height: 24px;">
        <td colspan="7"
            style="font-size: 12pt; font-weight: bold; text-align: center; vertical-align: middle;">
            LAPORAN TRANSAKSI BARANG
        </td>
    </tr>

    <tr style="height: 12px;">
        <td colspan="7"></td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="2" style="font-weight: bold;">Tanggal Export</td>
        <td colspan="5">: {{ now()->format('d-m-Y H:i') }}</td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="2" style="font-weight: bold;">Dicetak Oleh</td>
        <td colspan="5">: {{ auth()->user()->name ?? 'Admin' }}</td>
    </tr>

    <tr style="height: 12px;">
        <td colspan="7"></td>
    </tr>

    <tr style="height: 23px;">
        <td colspan="2"
            style="background: #D9EAF7; font-weight: bold; text-align: center; border: 1px solid #000;">
            Total Barang Masuk
        </td>

        <td colspan="2"
            style="background: #D9EAF7; font-weight: bold; text-align: center; border: 1px solid #000;">
            Total Barang Keluar
        </td>

        <td
            style="background: #D9EAF7; font-weight: bold; text-align: center; border: 1px solid #000;">
            Jumlah Masuk
        </td>

        <td colspan="2"
            style="background: #D9EAF7; font-weight: bold; text-align: center; border: 1px solid #000;">
            Jumlah Keluar
        </td>
    </tr>

    <tr style="height: 23px;">
        <td colspan="2"
            style="font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $totalMasuk }}
        </td>

        <td colspan="2"
            style="font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $totalKeluar }}
        </td>

        <td
            style="font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $jumlahMasuk }}
        </td>

        <td colspan="2"
            style="font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $jumlahKeluar }}
        </td>
    </tr>

    <tr style="height: 16px;">
        <td colspan="7"></td>
    </tr>

    <tr style="height: 25px;">
        <td colspan="7"
            style="background: #D9EAD3; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            A. BARANG MASUK
        </td>
    </tr>

    <tr style="height: 24px;">
        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            No
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Tanggal
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Kode Barang
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Nama Barang
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Supplier
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Jumlah
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Keterangan
        </td>
    </tr>

    @forelse ($barangMasuk as $item)
        <tr style="height: 22px;">
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $loop->iteration }}
            </td>

            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') : '-' }}
            </td>

            <td style="border: 1px solid #000; text-align: center; vertical-align: middle; mso-number-format:'\@';">
                {{ $item->barang->kode_barang ?? '-' }}
            </td>

            <td style="border: 1px solid #000; vertical-align: middle;">
                {{ $item->barang->nama_barang ?? '-' }}
            </td>

            <td style="border: 1px solid #000; vertical-align: middle;">
                {{ $item->supplier->nama_supplier ?? '-' }}
            </td>

            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->jumlah }}
            </td>

            <td style="border: 1px solid #000; vertical-align: middle;">
                {{ $item->keterangan ?: '-' }}
            </td>
        </tr>
    @empty
        <tr style="height: 24px;">
            <td colspan="7"
                style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                Belum ada data barang masuk.
            </td>
        </tr>
    @endforelse

    <tr style="height: 16px;">
        <td colspan="7"></td>
    </tr>

    <tr style="height: 25px;">
        <td colspan="7"
            style="background: #F4CCCC; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            B. BARANG KELUAR
        </td>
    </tr>

    <tr style="height: 24px;">
        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            No
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Tanggal
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Kode Barang
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Nama Barang
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Jumlah
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Tujuan
        </td>

        <td style="background: #86B6F6; font-weight: bold; text-align: center; border: 1px solid #000;">
            Keterangan
        </td>
    </tr>

    @forelse ($barangKeluar as $item)
        <tr style="height: 22px;">
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $loop->iteration }}
            </td>

            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->tanggal_keluar ? \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') : '-' }}
            </td>

            <td style="border: 1px solid #000; text-align: center; vertical-align: middle; mso-number-format:'\@';">
                {{ $item->barang->kode_barang ?? '-' }}
            </td>

            <td style="border: 1px solid #000; vertical-align: middle;">
                {{ $item->barang->nama_barang ?? '-' }}
            </td>

            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->jumlah }}
            </td>

            <td style="border: 1px solid #000; vertical-align: middle;">
                {{ $item->tujuan ?: '-' }}
            </td>

            <td style="border: 1px solid #000; vertical-align: middle;">
                {{ $item->keterangan ?: '-' }}
            </td>
        </tr>
    @empty
        <tr style="height: 24px;">
            <td colspan="7"
                style="border: 1px solid #000; text-align: center; vertical-align: middle;">
                Belum ada data barang keluar.
            </td>
        </tr>
    @endforelse

    <tr style="height: 22px;">
        <td colspan="7"></td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="4"></td>
        <td colspan="3" style="text-align: center;">
            Bengkayang, {{ now()->format('d-m-Y') }}
        </td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="4"></td>
        <td colspan="3" style="text-align: center;">
            Admin Inventory
        </td>
    </tr>

    <tr style="height: 55px;">
        <td colspan="7"></td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="4"></td>
        <td colspan="3"
            style="text-align: center; font-weight: bold; text-decoration: underline;">
            {{ auth()->user()->name ?? 'Admin' }}
        </td>
    </tr>
</table>
</body>
</html>