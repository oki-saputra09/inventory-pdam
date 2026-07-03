<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BarangMasukController extends Controller
{
    public function index(Request $request)
{
    $search = trim($request->input('search', ''));

    $barangMasuk = BarangMasuk::with(['barang', 'supplier'])
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal_masuk', 'like', '%' . $search . '%')
                    ->orWhere('jumlah', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhereHas('barang', function ($barangQuery) use ($search) {
                        $barangQuery->where('kode_barang', 'like', '%' . $search . '%')
                            ->orWhere('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kategori', 'like', '%' . $search . '%')
                            ->orWhere('satuan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                        $supplierQuery->where('nama_supplier', 'like', '%' . $search . '%')
                            ->orWhere('alamat', 'like', '%' . $search . '%')
                            ->orWhere('telepon', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('admin.barang_masuk.index', compact('barangMasuk', 'search'));
}

    public function create()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();
        $supplier = Supplier::orderBy('nama_supplier', 'asc')->get();

        return view('admin.barang_masuk.create', compact('barang', 'supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'     => 'required|exists:barang,id',
            'supplier_id'   => 'nullable|exists:supplier,id',
            'tanggal_masuk' => 'required|date',
            'jumlah'        => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

            $barang->stok += $validated['jumlah'];
            $barang->save();

            $barangMasuk = BarangMasuk::create($validated);

            Aktivitas::create([
                'user_id'   => auth()->id(),
                'tipe'      => 'barang_masuk',
                'aktivitas' => 'Barang Masuk',
                'deskripsi' => 'Menambahkan barang masuk: ' . $barang->nama_barang . ' sebanyak ' . $barangMasuk->jumlah . ' ' . $barang->satuan . '.',
            ]);
        });

        return redirect()
            ->route('admin.barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();
        $supplier = Supplier::orderBy('nama_supplier', 'asc')->get();

        return view('admin.barang_masuk.edit', compact('barangMasuk', 'barang', 'supplier'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $validated = $request->validate([
            'barang_id'     => 'required|exists:barang,id',
            'supplier_id'   => 'nullable|exists:supplier,id',
            'tanggal_masuk' => 'required|date',
            'jumlah'        => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $barangMasuk) {
            $jumlahLama = $barangMasuk->jumlah;
            $barangLama = Barang::lockForUpdate()->findOrFail($barangMasuk->barang_id);

            if ($validated['barang_id'] == $barangMasuk->barang_id) {
                $stokBaru = $barangLama->stok - $barangMasuk->jumlah + $validated['jumlah'];

                if ($stokBaru < 0) {
                    throw ValidationException::withMessages([
                        'jumlah' => 'Perubahan jumlah membuat stok barang menjadi tidak valid.',
                    ]);
                }

                $barangLama->stok = $stokBaru;
                $barangLama->save();

                $namaBarangAktivitas = $barangLama->nama_barang;
                $satuanBarangAktivitas = $barangLama->satuan;
            } else {
                $stokBarangLama = $barangLama->stok - $barangMasuk->jumlah;

                if ($stokBarangLama < 0) {
                    throw ValidationException::withMessages([
                        'jumlah' => 'Stok barang lama menjadi tidak valid.',
                    ]);
                }

                $barangLama->stok = $stokBarangLama;
                $barangLama->save();

                $barangBaru = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

                $barangBaru->stok += $validated['jumlah'];
                $barangBaru->save();

                $namaBarangAktivitas = $barangBaru->nama_barang;
                $satuanBarangAktivitas = $barangBaru->satuan;
            }

            $barangMasuk->update($validated);

            Aktivitas::create([
                'user_id'   => auth()->id(),
                'tipe'      => 'barang_masuk',
                'aktivitas' => 'Update Barang Masuk',
                'deskripsi' => 'Memperbarui barang masuk: ' . $namaBarangAktivitas . ' dari ' . $jumlahLama . ' menjadi ' . $validated['jumlah'] . ' ' . $satuanBarangAktivitas . '.',
            ]);
        });

        return redirect()
            ->route('admin.barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            $barang = Barang::lockForUpdate()->findOrFail($barangMasuk->barang_id);

            $namaBarang = $barang->nama_barang;
            $jumlah = $barangMasuk->jumlah;
            $satuan = $barang->satuan;

            $stokBaru = $barang->stok - $barangMasuk->jumlah;

            if ($stokBaru < 0) {
                throw ValidationException::withMessages([
                    'stok' => 'Data tidak bisa dihapus karena stok barang akan menjadi minus.',
                ]);
            }

            $barang->stok = $stokBaru;
            $barang->save();

            $barangMasuk->delete();

            Aktivitas::create([
                'user_id'   => auth()->id(),
                'tipe'      => 'barang_masuk',
                'aktivitas' => 'Hapus Barang Masuk',
                'deskripsi' => 'Menghapus data barang masuk: ' . $namaBarang . ' sebanyak ' . $jumlah . ' ' . $satuan . '.',
            ]);
        });

        return redirect()
            ->route('admin.barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }
}