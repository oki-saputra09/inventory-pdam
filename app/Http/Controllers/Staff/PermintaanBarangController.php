<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PermintaanBarang;
use Illuminate\Http\Request;

class PermintaanBarangController extends Controller
{
    private function isMenunggu(?string $status): bool
    {
        return strtolower(trim($status ?? '')) === 'menunggu';
    }

    public function index()
    {
        $permintaanBarang = PermintaanBarang::with(['barang', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('staff.permintaan-barang.index', compact('permintaanBarang'));
    }

    public function create()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        return view('staff.permintaan-barang.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'tanggal_permintaan' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'tanggal_permintaan.required' => 'Tanggal permintaan wajib diisi.',
            'tanggal_permintaan.date' => 'Format tanggal tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'Menunggu';

        $permintaanBarang = PermintaanBarang::create($validated);
        $permintaanBarang->load('barang');

        if (class_exists(\App\Models\Aktivitas::class)) {
            \App\Models\Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'permintaan_barang',
                'aktivitas' => 'Ajukan Permintaan Barang',
                'deskripsi' => 'Staf mengajukan permintaan barang: '
                    . ($permintaanBarang->barang->nama_barang ?? '-')
                    . ' sebanyak '
                    . $permintaanBarang->jumlah
                    . '.',
            ]);
        }

        return redirect()
            ->route('staff.permintaan-barang.index')
            ->with('success', 'Permintaan barang berhasil diajukan.');
    }

    public function edit(PermintaanBarang $permintaanBarang)
    {
        if ((int) $permintaanBarang->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }

        if (!$this->isMenunggu($permintaanBarang->status)) {
            return redirect()
                ->route('staff.permintaan-barang.index')
                ->with('error', 'Permintaan yang sudah diproses tidak bisa diedit.');
        }

        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        return view('staff.permintaan-barang.edit', compact('permintaanBarang', 'barang'));
    }

    public function update(Request $request, PermintaanBarang $permintaanBarang)
    {
        if ((int) $permintaanBarang->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }

        if (!$this->isMenunggu($permintaanBarang->status)) {
            return redirect()
                ->route('staff.permintaan-barang.index')
                ->with('error', 'Permintaan yang sudah diproses tidak bisa diubah.');
        }

        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'tanggal_permintaan' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'tanggal_permintaan.required' => 'Tanggal permintaan wajib diisi.',
            'tanggal_permintaan.date' => 'Format tanggal tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ]);

        $permintaanBarang->update($validated);
        $permintaanBarang->refresh()->load('barang');

        if (class_exists(\App\Models\Aktivitas::class)) {
            \App\Models\Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'permintaan_barang',
                'aktivitas' => 'Update Permintaan Barang',
                'deskripsi' => 'Staf memperbarui permintaan barang: '
                    . ($permintaanBarang->barang->nama_barang ?? '-')
                    . ' sebanyak '
                    . $permintaanBarang->jumlah
                    . '.',
            ]);
        }

        return redirect()
            ->route('staff.permintaan-barang.index')
            ->with('success', 'Permintaan barang berhasil diperbarui.');
    }

    public function destroy(PermintaanBarang $permintaanBarang)
    {
        if ((int) $permintaanBarang->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }

        if (!$this->isMenunggu($permintaanBarang->status)) {
            return redirect()
                ->route('staff.permintaan-barang.index')
                ->with('error', 'Permintaan yang sudah diproses tidak bisa dihapus.');
        }

        $permintaanBarang->load('barang');

        $namaBarang = $permintaanBarang->barang->nama_barang ?? '-';
        $jumlah = $permintaanBarang->jumlah;

        $permintaanBarang->delete();

        if (class_exists(\App\Models\Aktivitas::class)) {
            \App\Models\Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'permintaan_barang',
                'aktivitas' => 'Hapus Permintaan Barang',
                'deskripsi' => 'Staf menghapus permintaan barang: '
                    . $namaBarang
                    . ' sebanyak '
                    . $jumlah
                    . '.',
            ]);
        }

        return redirect()
            ->route('staff.permintaan-barang.index')
            ->with('success', 'Permintaan barang berhasil dihapus.');
    }
}