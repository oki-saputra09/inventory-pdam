<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'kode_barang',
            'nama_barang',
            'kategori',
            'satuan',
            'stok',
            'minimum_stok',
        ];
    }

    public function array(): array
    {
        return [];
    }
}