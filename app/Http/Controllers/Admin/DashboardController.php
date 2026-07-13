<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PermintaanBarang;
use App\Models\PengembalianBarang;
use App\Models\Supplier;
use App\Models\Aktivitas;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();

        $totalSupplier = Supplier::count();

        $jumlahNotifikasiStok = Barang::whereColumn('stok', '<=', 'minimum_stok')->count();

        $jumlahPermintaanMenunggu = PermintaanBarang::where('status', 'Menunggu')->count();

        $jumlahPengembalianMenunggu = PengembalianBarang::where('status', 'Menunggu')->count();

        $barangStokMinimum = Barang::whereColumn('stok', '<=', 'minimum_stok')
            ->orderBy('stok', 'asc')
            ->limit(4)
            ->get();

        $aktivitasHariIni = Aktivitas::with('user')
            ->whereDate('created_at', today())
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalBarang',
            'totalSupplier',
            'jumlahNotifikasiStok',
            'jumlahPermintaanMenunggu',
            'jumlahPengembalianMenunggu',
            'barangStokMinimum',
            'aktivitasHariIni'
        ));
    }
}