<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierApiController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $supplier = Supplier::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_supplier', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%')
                        ->orWhere('telepon', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'message' => 'Data supplier berhasil diambil.',
            'total' => $supplier->count(),
            'data' => $supplier,
        ]);
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Data supplier tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail supplier berhasil diambil.',
            'data' => $supplier,
        ]);
    }
}