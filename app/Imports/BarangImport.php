<?php

namespace App\Imports;

use App\Models\Aktivitas;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public int $inserted = 0;
    public int $updated = 0;
    public int $skipped = 0;
    public array $errors = [];

    protected ?int $userId;

    public function __construct(?int $userId = null)
    {
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            $data = [
                'kode_barang'  => trim((string) ($row['kode_barang'] ?? '')),
                'nama_barang'  => trim((string) ($row['nama_barang'] ?? '')),
                'kategori'     => trim((string) ($row['kategori'] ?? '')),
                'satuan'       => trim((string) ($row['satuan'] ?? '')),
                'stok'         => $this->normalizeInteger($row['stok'] ?? null),
                'minimum_stok' => $this->normalizeInteger($row['minimum_stok'] ?? null),
            ];

            $validator = Validator::make($data, [
                'kode_barang'  => 'required|string|max:50',
                'nama_barang'  => 'required|string|max:255',
                'kategori'     => 'required|string|max:100',
                'satuan'       => 'required|string|max:50',
                'stok'         => 'required|integer|min:0',
                'minimum_stok' => 'required|integer|min:0',
            ], [
                'kode_barang.required'  => 'Kode barang wajib diisi.',
                'nama_barang.required'  => 'Nama barang wajib diisi.',
                'kategori.required'     => 'Kategori wajib diisi.',
                'satuan.required'       => 'Satuan wajib diisi.',
                'stok.required'         => 'Stok wajib diisi.',
                'stok.integer'          => 'Stok harus angka bulat.',
                'minimum_stok.required' => 'Minimum stok wajib diisi.',
                'minimum_stok.integer'  => 'Minimum stok harus angka bulat.',
            ]);

            if ($validator->fails()) {
                $this->skipped++;
                $this->errors[] = 'Baris ' . $rowNumber . ': ' . implode(', ', $validator->errors()->all());
                continue;
            }

            try {
                Kategori::firstOrCreate([
                    'nama_kategori' => $data['kategori'],
                ]);

                $barang = Barang::where('kode_barang', $data['kode_barang'])->first();

                if ($barang) {
                    $barang->update($data);
                    $this->updated++;
                } else {
                    Barang::create($data);
                    $this->inserted++;
                }
            } catch (\Throwable $e) {
                $this->skipped++;
                $this->errors[] = 'Baris ' . $rowNumber . ': ' . $e->getMessage();
            }
        }

        if (($this->inserted + $this->updated) > 0 && class_exists(Aktivitas::class)) {
            Aktivitas::create([
                'user_id'   => $this->userId,
                'tipe'      => 'barang',
                'aktivitas' => 'Import Barang Excel',
                'deskripsi' => 'Import Excel berhasil: ' . $this->inserted . ' barang baru, ' . $this->updated . ' barang diperbarui, ' . $this->skipped . ' baris gagal.',
            ]);
        }
    }

    private function normalizeInteger($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value) && floor((float) $value) == (float) $value) {
            return (int) $value;
        }

        return $value;
    }
}