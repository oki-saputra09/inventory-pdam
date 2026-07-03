<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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

        return view('admin.supplier.index', compact('supplier', 'search'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat'        => 'nullable|string|max:255',
            'telepon'       => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:255',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max'      => 'Nama supplier maksimal 255 karakter.',
            'alamat.max'             => 'Alamat maksimal 255 karakter.',
            'telepon.max'            => 'Nomor telepon maksimal 50 karakter.',
            'email.email'            => 'Format email tidak valid.',
            'email.max'              => 'Email maksimal 255 karakter.',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Data supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat'        => 'nullable|string|max:255',
            'telepon'       => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:255',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max'      => 'Nama supplier maksimal 255 karakter.',
            'alamat.max'             => 'Alamat maksimal 255 karakter.',
            'telepon.max'            => 'Nomor telepon maksimal 50 karakter.',
            'email.email'            => 'Format email tidak valid.',
            'email.max'              => 'Email maksimal 255 karakter.',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Data supplier berhasil dihapus.');
    }
}