<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PengembalianBarang;
use Illuminate\Http\Request;

class PengembalianBarangController extends Controller
{
    private function isMenunggu(?string $status): bool
    {
        return strtolower(trim($status ?? '')) === 'menunggu';
    }

    private function simpanFotoBukti($file): string
    {
        $folder = public_path('uploads/bukti-pengembalian');

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $namaFile = 'bukti_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $namaFile);

        return 'uploads/bukti-pengembalian/' . $namaFile;
    }

    private function hapusFotoBukti(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
    }

    public function index()
    {
        $pengembalianBarang = PengembalianBarang::with(['barang', 'user'])
            ->where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('staff.pengembalian-barang.index', compact('pengembalianBarang'));
    }

    public function create()
    {
        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        return view('staff.pengembalian-barang.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'tanggal_pengembalian' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'foto_bukti' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'tanggal_pengembalian.required' => 'Tanggal pengembalian wajib diisi.',
            'tanggal_pengembalian.date' => 'Format tanggal tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
            'foto_bukti.required' => 'Foto bukti pengembalian wajib diunggah.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.mimes' => 'Format foto harus JPG atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 4 MB.',
        ]);

        $validated['foto_bukti'] = $this->simpanFotoBukti($request->file('foto_bukti'));
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'Menunggu';

        $pengembalianBarang = PengembalianBarang::create($validated);
        $pengembalianBarang->load('barang');

        if (class_exists(\App\Models\Aktivitas::class)) {
            \App\Models\Aktivitas::create([
                'user_id' => auth()->id(),
                'tipe' => 'pengembalian_barang',
                'aktivitas' => 'Ajukan Pengembalian Barang',
                'deskripsi' => 'Staf mengajukan pengembalian barang: '
                    . ($pengembalianBarang->barang->nama_barang ?? '-')
                    . ' sebanyak ' . $pengembalianBarang->jumlah . ' dengan foto bukti.',
            ]);
        }

        return redirect()
            ->route('staff.pengembalian-barang.index')
            ->with('success', 'Pengembalian barang berhasil diajukan.');
    }

    public function edit(PengembalianBarang $pengembalianBarang)
    {
        if ((int) $pengembalianBarang->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }

        if (!$this->isMenunggu($pengembalianBarang->status)) {
            return redirect()
                ->route('staff.pengembalian-barang.index')
                ->with('error', 'Pengembalian yang sudah diproses tidak bisa diedit.');
        }

        $barang = Barang::orderBy('nama_barang', 'asc')->get();

        return view('staff.pengembalian-barang.edit', compact('pengembalianBarang', 'barang'));
    }

    public function update(Request $request, PengembalianBarang $pengembalianBarang)
    {
        if ((int) $pengembalianBarang->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }

        if (!$this->isMenunggu($pengembalianBarang->status)) {
            return redirect()
                ->route('staff.pengembalian-barang.index')
                ->with('error', 'Pengembalian yang sudah diproses tidak bisa diubah.');
        }

        $validated = $request->validate([
            'barang_id' => ['required', 'exists:barang,id'],
            'tanggal_pengembalian' => ['required', 'date'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'foto_bukti' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists' => 'Barang yang dipilih tidak valid.',
            'tanggal_pengembalian.required' => 'Tanggal pengembalian wajib diisi.',
            'tanggal_pengembalian.date' => 'Format tanggal tidak valid.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.mimes' => 'Format foto harus JPG atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 4 MB.',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $this->hapusFotoBukti($pengembalianBarang->foto_bukti);
            $validated['foto_bukti'] = $this->simpanFotoBukti($request->file('foto_bukti'));
        }

        $pengembalianBarang->update($validated);

        return redirect()
            ->route('staff.pengembalian-barang.index')
            ->with('success', 'Pengembalian barang berhasil diperbarui.');
    }

    public function destroy(PengembalianBarang $pengembalianBarang)
    {
        if ((int) $pengembalianBarang->user_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak punya akses ke data ini.');
        }

        if (!$this->isMenunggu($pengembalianBarang->status)) {
            return redirect()
                ->route('staff.pengembalian-barang.index')
                ->with('error', 'Pengembalian yang sudah diproses tidak bisa dihapus.');
        }

        $this->hapusFotoBukti($pengembalianBarang->foto_bukti);

        $pengembalianBarang->delete();

        return redirect()
            ->route('staff.pengembalian-barang.index')
            ->with('success', 'Pengembalian barang berhasil dihapus.');
    }
}