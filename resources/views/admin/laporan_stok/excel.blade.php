<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="application/vnd.ms-excel; charset=utf-8">
    <title>Laporan Stok Excel</title>
</head>

<body>
<table style="border-collapse: collapse; font-family: Calibri, Arial, sans-serif; font-size: 11pt; width: 100%;">
    <colgroup>
        <col width="45">
        <col width="115">
        <col width="190">
        <col width="165">
        <col width="90">
        <col width="75">
        <col width="110">
        <col width="120">
    </colgroup>

    <tr style="height: 24px;">
        <td colspan="8"
            style="font-size: 14pt; font-weight: bold; text-align: center; vertical-align: middle;">
            INVENDAM - SISTEM INVENTORY PDAM BENGKAYANG
        </td>
    </tr>

    <tr style="height: 22px;">
        <td colspan="8"
            style="font-size: 12pt; font-weight: bold; text-align: center; vertical-align: middle;">
            LAPORAN STOK BARANG
        </td>
    </tr>

    <tr style="height: 12px;">
        <td colspan="8"></td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="2" style="font-size: 11pt; font-weight: bold;">Tanggal Export</td>
        <td colspan="6" style="font-size: 11pt;">: {{ now()->format('d-m-Y H:i') }}</td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="2" style="font-size: 11pt; font-weight: bold;">Dicetak Oleh</td>
        <td colspan="6" style="font-size: 11pt;">: {{ auth()->user()->name ?? 'Admin' }}</td>
    </tr>

    <tr style="height: 12px;">
        <td colspan="8"></td>
    </tr>

    <tr style="height: 22px;">
        <td colspan="2"
            style="background: #D9EAF7; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            Total Barang
        </td>

        <td colspan="2"
            style="background: #D9EAF7; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            Stok Aman
        </td>

        <td colspan="2"
            style="background: #D9EAF7; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            Stok Minimum
        </td>

        <td colspan="2"
            style="background: #D9EAF7; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            Stok Rendah
        </td>
    </tr>

    <tr style="height: 22px;">
        <td colspan="2"
            style="font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $totalBarang ?? 0 }}
        </td>

        <td colspan="2"
            style="font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $stokAman ?? 0 }}
        </td>

        <td colspan="2"
            style="font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $stokMinimum ?? 0 }}
        </td>

        <td colspan="2"
            style="font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000;">
            {{ $stokRendah ?? 0 }}
        </td>
    </tr>

    <tr style="height: 14px;">
        <td colspan="8"></td>
    </tr>

    <tr style="height: 24px;">
        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            No
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Kode Barang
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Nama Barang
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Kategori
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Satuan
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Stok
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Minimum Stok
        </td>

        <td style="background: #86B6F6; color: #000; font-size: 11pt; font-weight: bold; text-align: center; border: 1px solid #000; vertical-align: middle;">
            Status
        </td>
    </tr>

    @forelse($barang as $item)
        @php
            if ($item->stok > $item->minimum_stok) {
                $status = 'Aman';
                $statusBg = '#D9EAD3';
                $statusColor = '#198754';
            } elseif ($item->stok == $item->minimum_stok) {
                $status = 'Minimum';
                $statusBg = '#FFF2CC';
                $statusColor = '#B7791F';
            } else {
                $status = 'Stok Rendah';
                $statusBg = '#F4CCCC';
                $statusColor = '#DC3545';
            }
        @endphp

        <tr style="height: 22px;">
            <td style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $loop->iteration }}
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle; mso-number-format:'\@';">
                ="{{ $item->kode_barang }}"
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; vertical-align: middle;">
                {{ $item->nama_barang }}
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; vertical-align: middle;">
                {{ $item->kategori }}
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->satuan }}
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->stok }}
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle;">
                {{ $item->minimum_stok }}
            </td>

            <td style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle; background: {{ $statusBg }}; color: {{ $statusColor }}; font-weight: bold;">
                {{ $status }}
            </td>
        </tr>
    @empty
        <tr style="height: 24px;">
            <td colspan="8"
                style="font-size: 11pt; border: 1px solid #000; text-align: center; vertical-align: middle;">
                Data barang belum tersedia.
            </td>
        </tr>
    @endforelse

    <tr style="height: 18px;">
        <td colspan="8"></td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="5"></td>
        <td colspan="3" style="font-size: 11pt; text-align: center;">
            Bengkayang, {{ now()->format('d-m-Y') }}
        </td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="5"></td>
        <td colspan="3" style="font-size: 11pt; text-align: center;">
            Admin Inventory
        </td>
    </tr>

    <tr style="height: 55px;">
        <td colspan="8"></td>
    </tr>

    <tr style="height: 20px;">
        <td colspan="5"></td>
        <td colspan="3"
            style="font-size: 11pt; text-align: center; font-weight: bold; text-decoration: underline;">
            {{ auth()->user()->name ?? 'Admin' }}
        </td>
    </tr>
</table>
</body>
</html>