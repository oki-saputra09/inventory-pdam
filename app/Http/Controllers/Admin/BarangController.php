<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\BarangTemplateExport;
use App\Imports\BarangImport;
use App\Models\Aktivitas;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $barang = Barang::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_barang', 'like', '%' . $search . '%')
                        ->orWhere('nama_barang', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('satuan', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.barang.index', compact('barang', 'search'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('admin.barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'  => 'required|string|max:50|unique:barang,kode_barang',
            'nama_barang'  => 'required|string|max:255',
            'kategori'     => 'required|string|max:100|exists:kategori,nama_kategori',
            'satuan'       => 'required|string|max:50',
            'stok'         => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
        ]);

        $barang = Barang::create($validated);

        if (class_exists(Aktivitas::class)) {
            Aktivitas::create([
                'user_id'   => auth()->id(),
                'tipe'      => 'barang',
                'aktivitas' => 'Tambah Barang',
                'deskripsi' => 'Menambahkan barang baru: ' . $barang->nama_barang . ' dengan stok awal ' . $barang->stok . ' ' . $barang->satuan . '.',
            ]);
        }

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function templateExcel()
    {
        return Excel::download(new BarangTemplateExport, 'template-data-barang.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_excel.required' => 'File Excel wajib diupload.',
            'file_excel.file'     => 'File yang diupload tidak valid.',
            'file_excel.mimes'    => 'File harus berformat xlsx, xls, atau csv.',
            'file_excel.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $import = new BarangImport(auth()->id());

            Excel::import($import, $request->file('file_excel'));

            $message = 'Import selesai. Barang baru: ' . $import->inserted .
                ', diperbarui: ' . $import->updated .
                ', gagal: ' . $import->skipped . '.';

            if ($import->skipped > 0) {
                return redirect()
                    ->route('admin.barang.create')
                    ->with('success', $message)
                    ->with('import_errors', $import->errors);
            }

            return redirect()
                ->route('admin.barang.index')
                ->with('success', $message);
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.barang.create')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('admin.barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang'  => [
                'required',
                'string',
                'max:50',
                Rule::unique('barang', 'kode_barang')->ignore($barang->id),
            ],
            'nama_barang'  => 'required|string|max:255',
            'kategori'     => 'required|string|max:100|exists:kategori,nama_kategori',
            'satuan'       => 'required|string|max:50',
            'stok'         => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
        ]);

        $namaLama = $barang->nama_barang;
        $stokLama = $barang->stok;
        $satuanLama = $barang->satuan;

        $barang->update($validated);

        if (class_exists(Aktivitas::class)) {
            Aktivitas::create([
                'user_id'   => auth()->id(),
                'tipe'      => 'barang',
                'aktivitas' => 'Update Barang',
                'deskripsi' => 'Memperbarui barang: ' . $namaLama . ' menjadi ' . $barang->nama_barang . '. Stok dari ' . $stokLama . ' ' . $satuanLama . ' menjadi ' . $barang->stok . ' ' . $barang->satuan . '.',
            ]);
        }

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $namaBarang = $barang->nama_barang;
        $stokBarang = $barang->stok;
        $satuanBarang = $barang->satuan;

        $barang->delete();

        if (class_exists(Aktivitas::class)) {
            Aktivitas::create([
                'user_id'   => auth()->id(),
                'tipe'      => 'barang',
                'aktivitas' => 'Hapus Barang',
                'deskripsi' => 'Menghapus barang: ' . $namaBarang . ' dengan stok terakhir ' . $stokBarang . ' ' . $satuanBarang . '.',
            ]);
        }

        return redirect()
            ->route('admin.barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }
}