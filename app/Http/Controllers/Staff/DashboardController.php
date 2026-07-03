<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\PermintaanBarang;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalPermintaan = PermintaanBarang::where('user_id', $userId)->count();

        $permintaanMenunggu = PermintaanBarang::where('user_id', $userId)
            ->where('status', 'Menunggu')
            ->count();

        $permintaanDisetujui = PermintaanBarang::where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->count();

        $permintaanDitolak = PermintaanBarang::where('user_id', $userId)
            ->where('status', 'Ditolak')
            ->count();

        $permintaanTerbaru = PermintaanBarang::where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('staff.dashboard.index', compact(
            'totalPermintaan',
            'permintaanMenunggu',
            'permintaanDisetujui',
            'permintaanDitolak',
            'permintaanTerbaru'
        ));
    }
}