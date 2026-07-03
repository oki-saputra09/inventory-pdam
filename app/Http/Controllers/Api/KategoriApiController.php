<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriApiController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $kategori = Kategori::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_kategori', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'message' => 'Data kategori berhasil diambil.',
            'total' => $kategori->count(),
            'data' => $kategori,
        ]);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Data kategori tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail kategori berhasil diambil.',
            'data' => $kategori,
        ]);
    }
}