<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
{
    $search = trim($request->input('search', ''));

    $barangKeluar = BarangKeluar::with('barang')
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal_keluar', 'like', '%' . $search . '%')
                    ->orWhere('jumlah', 'like', '%' . $search . '%')
                    ->orWhere('tujuan', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhereHas('barang', function ($barangQuery) use ($search) {
                        $barangQuery->where('kode_barang', 'like', '%' . $search . '%')
                            ->orWhere('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kategori', 'like', '%' . $search . '%')
                            ->orWhere('satuan', 'like', '%' . $search . '%');
                    });
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('admin.barang_keluar.index', compact('barangKeluar', 'search'));
}
    public function create()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        return view('admin.barang_keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'      => 'required|exists:barang,id',
            'tanggal_keluar' => 'required|date',
            'jumlah'         => 'required|integer|min:1',
            'tujuan'         => 'nullable|string|max:255',
            'keterangan'     => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $barang = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

            if ($barang->stok < $validated['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok barang tidak mencukupi.',
                ]);
            }

            $barang->stok -= $validated['jumlah'];
            $barang->save();

            BarangKeluar::create($validated);
        });

        return redirect()
            ->route('admin.barang-keluar.index')
            ->with('success', 'Data barang keluar berhasil ditambahkan.');
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        return view('admin.barang_keluar.edit', compact('barangKeluar', 'barang'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $validated = $request->validate([
            'barang_id'      => 'required|exists:barang,id',
            'tanggal_keluar' => 'required|date',
            'jumlah'         => 'required|integer|min:1',
            'tujuan'         => 'nullable|string|max:255',
            'keterangan'     => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $barangKeluar) {
            $barangLama = Barang::lockForUpdate()->findOrFail($barangKeluar->barang_id);

            if ($validated['barang_id'] == $barangKeluar->barang_id) {
                $stokBaru = $barangLama->stok + $barangKeluar->jumlah - $validated['jumlah'];

                if ($stokBaru < 0) {
                    throw ValidationException::withMessages([
                        'jumlah' => 'Stok barang tidak mencukupi untuk perubahan ini.',
                    ]);
                }

                $barangLama->stok = $stokBaru;
                $barangLama->save();
            } else {
                $barangLama->stok += $barangKeluar->jumlah;
                $barangLama->save();

                $barangBaru = Barang::lockForUpdate()->findOrFail($validated['barang_id']);

                if ($barangBaru->stok < $validated['jumlah']) {
                    throw ValidationException::withMessages([
                        'jumlah' => 'Stok barang baru tidak mencukupi.',
                    ]);
                }

                $barangBaru->stok -= $validated['jumlah'];
                $barangBaru->save();
            }

            $barangKeluar->update($validated);
        });

        return redirect()
            ->route('admin.barang-keluar.index')
            ->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {
            $barang = Barang::lockForUpdate()->findOrFail($barangKeluar->barang_id);

            $barang->stok += $barangKeluar->jumlah;
            $barang->save();

            $barangKeluar->delete();
        });

        return redirect()
            ->route('admin.barang-keluar.index')
            ->with('success', 'Data barang keluar berhasil dihapus.');
    }
}