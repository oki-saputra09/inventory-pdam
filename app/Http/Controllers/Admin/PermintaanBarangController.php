<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PermintaanBarang;
use Illuminate\Support\Facades\DB;

class PermintaanBarangController extends Controller
{
    public function index()
    {
        $permintaanBarang = PermintaanBarang::with(['barang', 'user'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.permintaan_barang.index', compact('permintaanBarang'));
    }

    public function setuju(PermintaanBarang $permintaanBarang)
    {
        if ($permintaanBarang->status !== 'Menunggu') {
            return redirect()
                ->route('admin.permintaan-barang.index')
                ->with('error', 'Permintaan ini sudah diproses.');
        }

        DB::transaction(function () use ($permintaanBarang) {
            $barang = Barang::lockForUpdate()->findOrFail($permintaanBarang->barang_id);

            if ($barang->stok < $permintaanBarang->jumlah) {
                return redirect()
                    ->route('admin.permintaan-barang.index')
                    ->with('error', 'Stok barang tidak mencukupi.');
            }

            $barang->stok -= $permintaanBarang->jumlah;
            $barang->save();

            $permintaanBarang->update([
                'status' => 'Disetujui',
            ]);
        });

        return redirect()
            ->route('admin.permintaan-barang.index')
            ->with('success', 'Permintaan barang berhasil disetujui.');
    }

    public function tolak(PermintaanBarang $permintaanBarang)
    {
        if ($permintaanBarang->status !== 'Menunggu') {
            return redirect()
                ->route('admin.permintaan-barang.index')
                ->with('error', 'Permintaan ini sudah diproses.');
        }

        $permintaanBarang->update([
            'status' => 'Ditolak',
        ]);

        return redirect()
            ->route('admin.permintaan-barang.index')
            ->with('success', 'Permintaan barang berhasil ditolak.');
    }

    public function destroy(PermintaanBarang $permintaanBarang)
    {
        $permintaanBarang->delete();

        return redirect()
            ->route('admin.permintaan-barang.index')
            ->with('success', 'Data permintaan berhasil dihapus.');
    }
}