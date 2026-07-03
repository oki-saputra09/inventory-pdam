<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;

class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = Aktivitas::with('user')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.aktivitas.index', compact('aktivitas'));
    }

    public function destroy(Aktivitas $aktivitas)
    {
        $aktivitas->delete();

        return redirect()
            ->back()
            ->with('success', 'Aktivitas berhasil dihapus.');
    }

    public function destroyAll()
    {
        Aktivitas::truncate();

        return redirect()
            ->back()
            ->with('success', 'Semua aktivitas berhasil dihapus.');
    }
}