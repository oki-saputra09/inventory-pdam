<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PermintaanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PermintaanBarangApiController extends Controller
{
    private function roleName($user): string
    {
        $user->loadMissing('role');

        $roleName = optional($user->role)->name;

        if (!$roleName && isset($user->getAttributes()['role'])) {
            $roleName = $user->getAttributes()['role'];
        }

        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        return $roleName;
    }

    private function isAdmin($user): bool
    {
        return $this->roleName($user) === 'admin';
    }

    private function isStaf($user): bool
    {
        return in_array($this->roleName($user), ['staf', 'staff'], true);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $search = trim($request->input('search', ''));

        $query = PermintaanBarang::query();

        if (method_exists(new PermintaanBarang(), 'barang')) {
            $query->with('barang');
        }

        if (method_exists(new PermintaanBarang(), 'user')) {
            $query->with('user');
        }

        if (!$this->isAdmin($user)) {
            $query->where('user_id', $user->id);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                if (Schema::hasColumn('permintaan_barang', 'status')) {
                    $q->where('status', 'like', '%' . $search . '%');
                }

                if (Schema::hasColumn('permintaan_barang', 'keterangan')) {
                    $q->orWhere('keterangan', 'like', '%' . $search . '%');
                }

                if (method_exists(new PermintaanBarang(), 'barang')) {
                    $q->orWhereHas('barang', function ($barang) use ($search) {
                        $barang->where('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kode_barang', 'like', '%' . $search . '%');
                    });
                }
            });
        }

        $permintaan = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'message' => 'Data permintaan barang berhasil diambil.',
            'total' => $permintaan->count(),
            'data' => $permintaan,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $query = PermintaanBarang::query();

        if (method_exists(new PermintaanBarang(), 'barang')) {
            $query->with('barang');
        }

        if (method_exists(new PermintaanBarang(), 'user')) {
            $query->with('user');
        }

        $permintaan = $query->find($id);

        if (!$permintaan) {
            return response()->json([
                'message' => 'Data permintaan barang tidak ditemukan.',
            ], 404);
        }

        if (!$this->isAdmin($user) && (int) $permintaan->user_id !== (int) $user->id) {
            return response()->json([
                'message' => 'Kamu tidak punya akses ke data permintaan ini.',
            ], 403);
        }

        return response()->json([
            'message' => 'Detail permintaan barang berhasil diambil.',
            'data' => $permintaan,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$this->isStaf($user) && !$this->isAdmin($user)) {
            return response()->json([
                'message' => 'Hanya staf atau admin yang dapat membuat permintaan barang.',
            ], 403);
        }

        $validated = $request->validate([
            'barang_id'  => ['required', 'integer', 'exists:barang,id'],
            'jumlah'     => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $barang = Barang::find($validated['barang_id']);

        if (!$barang) {
            return response()->json([
                'message' => 'Barang tidak ditemukan.',
            ], 404);
        }

        $permintaan = new PermintaanBarang();
        $permintaan->user_id = $user->id;
        $permintaan->barang_id = $validated['barang_id'];
        $permintaan->jumlah = $validated['jumlah'];

        if (Schema::hasColumn('permintaan_barang', 'keterangan')) {
            $permintaan->keterangan = $validated['keterangan'] ?? null;
        }

        if (Schema::hasColumn('permintaan_barang', 'status')) {
            $permintaan->status = 'menunggu';
        }

        if (Schema::hasColumn('permintaan_barang', 'tanggal_permintaan')) {
            $permintaan->tanggal_permintaan = now()->toDateString();
        }

        $permintaan->save();

        if (method_exists($permintaan, 'barang')) {
            $permintaan->load('barang');
        }

        if (method_exists($permintaan, 'user')) {
            $permintaan->load('user');
        }

        return response()->json([
            'message' => 'Permintaan barang berhasil dibuat.',
            'data' => $permintaan,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();

        $permintaan = PermintaanBarang::find($id);

        if (!$permintaan) {
            return response()->json([
                'message' => 'Data permintaan barang tidak ditemukan.',
            ], 404);
        }

        if (!$this->isAdmin($user) && (int) $permintaan->user_id !== (int) $user->id) {
            return response()->json([
                'message' => 'Kamu tidak punya akses untuk mengubah permintaan ini.',
            ], 403);
        }

        if (($permintaan->status ?? 'menunggu') !== 'menunggu') {
            return response()->json([
                'message' => 'Permintaan yang sudah diproses tidak bisa diedit.',
            ], 422);
        }

        $validated = $request->validate([
            'barang_id'  => ['required', 'integer', 'exists:barang,id'],
            'jumlah'     => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $permintaan->barang_id = $validated['barang_id'];
        $permintaan->jumlah = $validated['jumlah'];

        if (Schema::hasColumn('permintaan_barang', 'keterangan')) {
            $permintaan->keterangan = $validated['keterangan'] ?? null;
        }

        $permintaan->save();

        return response()->json([
            'message' => 'Permintaan barang berhasil diperbarui.',
            'data' => $permintaan->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $permintaan = PermintaanBarang::find($id);

        if (!$permintaan) {
            return response()->json([
                'message' => 'Data permintaan barang tidak ditemukan.',
            ], 404);
        }

        if (!$this->isAdmin($user) && (int) $permintaan->user_id !== (int) $user->id) {
            return response()->json([
                'message' => 'Kamu tidak punya akses untuk menghapus permintaan ini.',
            ], 403);
        }

        if (!$this->isAdmin($user) && ($permintaan->status ?? 'menunggu') !== 'menunggu') {
            return response()->json([
                'message' => 'Permintaan yang sudah diproses tidak bisa dihapus.',
            ], 422);
        }

        $permintaan->delete();

        return response()->json([
            'message' => 'Permintaan barang berhasil dihapus.',
        ]);
    }

    public function setuju(Request $request, $id)
    {
        $user = $request->user();

        if (!$this->isAdmin($user)) {
            return response()->json([
                'message' => 'Hanya admin yang dapat menyetujui permintaan barang.',
            ], 403);
        }

        $permintaan = PermintaanBarang::find($id);

        if (!$permintaan) {
            return response()->json([
                'message' => 'Data permintaan barang tidak ditemukan.',
            ], 404);
        }

        if (($permintaan->status ?? 'menunggu') !== 'menunggu') {
            return response()->json([
                'message' => 'Permintaan ini sudah diproses sebelumnya.',
            ], 422);
        }

        $barang = Barang::find($permintaan->barang_id);

        if (!$barang) {
            return response()->json([
                'message' => 'Barang pada permintaan ini tidak ditemukan.',
            ], 404);
        }

        if ($barang->stok < $permintaan->jumlah) {
            return response()->json([
                'message' => 'Stok barang tidak mencukupi.',
                'stok_tersedia' => $barang->stok,
                'jumlah_diminta' => $permintaan->jumlah,
            ], 422);
        }

        $barang->stok = $barang->stok - $permintaan->jumlah;
        $barang->save();

        $dataUpdate = [
            'status' => 'disetujui',
        ];

        if (Schema::hasColumn('permintaan_barang', 'catatan_admin')) {
            $dataUpdate['catatan_admin'] = $request->input('catatan_admin');
        }

        if (Schema::hasColumn('permintaan_barang', 'diproses_oleh')) {
            $dataUpdate['diproses_oleh'] = $user->id;
        }

        if (Schema::hasColumn('permintaan_barang', 'tanggal_diproses')) {
            $dataUpdate['tanggal_diproses'] = now();
        }

        $permintaan->forceFill($dataUpdate)->save();

        return response()->json([
            'message' => 'Permintaan barang berhasil disetujui.',
            'data' => $permintaan->fresh(),
        ]);
    }

    public function tolak(Request $request, $id)
    {
        $user = $request->user();

        if (!$this->isAdmin($user)) {
            return response()->json([
                'message' => 'Hanya admin yang dapat menolak permintaan barang.',
            ], 403);
        }

        $permintaan = PermintaanBarang::find($id);

        if (!$permintaan) {
            return response()->json([
                'message' => 'Data permintaan barang tidak ditemukan.',
            ], 404);
        }

        if (($permintaan->status ?? 'menunggu') !== 'menunggu') {
            return response()->json([
                'message' => 'Permintaan ini sudah diproses sebelumnya.',
            ], 422);
        }

        $dataUpdate = [
            'status' => 'ditolak',
        ];

        if (Schema::hasColumn('permintaan_barang', 'catatan_admin')) {
            $dataUpdate['catatan_admin'] = $request->input('catatan_admin');
        }

        if (Schema::hasColumn('permintaan_barang', 'diproses_oleh')) {
            $dataUpdate['diproses_oleh'] = $user->id;
        }

        if (Schema::hasColumn('permintaan_barang', 'tanggal_diproses')) {
            $dataUpdate['tanggal_diproses'] = now();
        }

        $permintaan->forceFill($dataUpdate)->save();

        return response()->json([
            'message' => 'Permintaan barang berhasil ditolak.',
            'data' => $permintaan->fresh(),
        ]);
    }
}