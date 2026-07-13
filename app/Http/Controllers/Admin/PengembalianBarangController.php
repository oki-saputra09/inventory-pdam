<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PengembalianBarang;
use Illuminate\Support\Facades\DB;

class PengembalianBarangController extends Controller
{
    public function index()
    {
        $pengembalianBarang = PengembalianBarang::with(['barang', 'user'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.pengembalian_barang.index', compact('pengembalianBarang'));
    }

    public function setuju(PengembalianBarang $pengembalianBarang)
    {
        if ($pengembalianBarang->status !== 'Menunggu') {
            return redirect()
                ->route('admin.pengembalian-barang.index')
                ->with('error', 'Pengembalian ini sudah diproses.');
        }

        DB::transaction(function () use ($pengembalianBarang) {
            $barang = Barang::lockForUpdate()->findOrFail($pengembalianBarang->barang_id);

            // Barang kembali ke gudang, stok bertambah
            $barang->stok += $pengembalianBarang->jumlah;
            $barang->save();

            $pengembalianBarang->update(['status' => 'Disetujui']);
        });

        if (class_exists(\App\Models\Aktivitas::class)) {
            $pengembalianBarang->load('barang');

            \App\Models\Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'pengembalian_barang',
                'aktivitas' => 'Setujui Pengembalian Barang',
                'deskripsi' => 'Admin menyetujui pengembalian barang: '
                    . ($pengembalianBarang->barang->nama_barang ?? '-')
                    . ' sebanyak ' . $pengembalianBarang->jumlah . ', stok bertambah.',
            ]);
        }

        return redirect()
            ->route('admin.pengembalian-barang.index')
            ->with('success', 'Pengembalian barang berhasil disetujui, stok telah diperbarui.');
    }

    public function tolak(PengembalianBarang $pengembalianBarang)
    {
        if ($pengembalianBarang->status !== 'Menunggu') {
            return redirect()
                ->route('admin.pengembalian-barang.index')
                ->with('error', 'Pengembalian ini sudah diproses.');
        }

        $pengembalianBarang->update(['status' => 'Ditolak']);

        return redirect()
            ->route('admin.pengembalian-barang.index')
            ->with('success', 'Pengembalian barang berhasil ditolak.');
    }

    public function destroy(PengembalianBarang $pengembalianBarang)
    {
        $pengembalianBarang->delete();

        return redirect()
            ->route('admin.pengembalian-barang.index')
            ->with('success', 'Data pengembalian berhasil dihapus.');
    }
}