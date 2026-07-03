<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangApiController extends Controller
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

        return response()->json([
            'message' => 'Data barang berhasil diambil.',
            'total' => $barang->count(),
            'data' => $barang,
        ]);
    }

    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'message' => 'Data barang tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail barang berhasil diambil.',
            'data' => $barang,
        ]);
    }
}