<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class LaporanController extends Controller
{
    public function stok()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        $totalBarang = $barang->count();

        $stokAman = $barang->filter(function ($item) {
            return (int) $item->stok > (int) $item->minimum_stok;
        })->count();

        $stokMinimum = $barang->filter(function ($item) {
            return (int) $item->stok === (int) $item->minimum_stok;
        })->count();

        $stokRendah = $barang->filter(function ($item) {
            return (int) $item->stok < (int) $item->minimum_stok;
        })->count();

        return view('admin.laporan_stok.index', compact(
            'barang',
            'totalBarang',
            'stokAman',
            'stokMinimum',
            'stokRendah'
        ));
    }

    public function cetakStok()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        $totalBarang = $barang->count();

        $stokAman = $barang->filter(function ($item) {
            return (int) $item->stok > (int) $item->minimum_stok;
        })->count();

        $stokMinimum = $barang->filter(function ($item) {
            return (int) $item->stok === (int) $item->minimum_stok;
        })->count();

        $stokRendah = $barang->filter(function ($item) {
            return (int) $item->stok < (int) $item->minimum_stok;
        })->count();

        return view('admin.laporan_stok.cetak', compact(
            'barang',
            'totalBarang',
            'stokAman',
            'stokMinimum',
            'stokRendah'
        ));
    }

    public function exportExcelStok()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        $totalBarang = $barang->count();

        $stokAman = $barang->filter(function ($item) {
            return (int) $item->stok > (int) $item->minimum_stok;
        })->count();

        $stokMinimum = $barang->filter(function ($item) {
            return (int) $item->stok === (int) $item->minimum_stok;
        })->count();

        $stokRendah = $barang->filter(function ($item) {
            return (int) $item->stok < (int) $item->minimum_stok;
        })->count();

        $fileName = 'laporan-stok-' . now()->format('Y-m-d-H-i-s') . '.xls';

        return response()
            ->view('admin.laporan_stok.excel', compact(
                'barang',
                'totalBarang',
                'stokAman',
                'stokMinimum',
                'stokRendah'
            ))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function transaksi()
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier'])
            ->orderBy('id', 'desc')
            ->get();

        $barangKeluar = BarangKeluar::with('barang')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.laporan_transaksi.index', compact(
            'barangMasuk',
            'barangKeluar'
        ));
    }

    public function cetakTransaksi()
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier'])
            ->orderBy('id', 'desc')
            ->get();

        $barangKeluar = BarangKeluar::with('barang')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.laporan_transaksi.cetak', compact(
            'barangMasuk',
            'barangKeluar'
        ));
    }

    public function exportExcelTransaksi()
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier'])
            ->orderBy('id', 'desc')
            ->get();

        $barangKeluar = BarangKeluar::with('barang')
            ->orderBy('id', 'desc')
            ->get();

        $totalMasuk = $barangMasuk->count();
        $totalKeluar = $barangKeluar->count();
        $jumlahMasuk = $barangMasuk->sum('jumlah');
        $jumlahKeluar = $barangKeluar->sum('jumlah');

        $fileName = 'laporan-transaksi-' . now()->format('Y-m-d-H-i-s') . '.xls';

        return response()
            ->view('admin.laporan_transaksi.excel', compact(
                'barangMasuk',
                'barangKeluar',
                'totalMasuk',
                'totalKeluar',
                'jumlahMasuk',
                'jumlahKeluar'
            ))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function notifikasiStok()
    {
        $barang = Barang::whereColumn('stok', '<=', 'minimum_stok')
            ->orderBy('stok', 'asc')
            ->get();

        return view('admin.notifikasi_stok.index', compact('barang'));
    }
}