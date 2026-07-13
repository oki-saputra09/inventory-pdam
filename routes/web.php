<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Models untuk Dashboard Awal
|--------------------------------------------------------------------------
*/
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

/*
|--------------------------------------------------------------------------
| Profile Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AccountProfileController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\BarangMasukController as AdminBarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController as AdminBarangKeluarController;
use App\Http\Controllers\Admin\PermintaanBarangController as AdminPermintaanBarangController;
use App\Http\Controllers\Admin\PengembalianBarangController as AdminPengembalianBarangController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\AktivitasController as AdminAktivitasController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Staff Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\PermintaanBarangController as StaffPermintaanBarangController;
use App\Http\Controllers\Staff\PengembalianBarangController as StaffPengembalianBarangController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL / DASHBOARD AWAL
|--------------------------------------------------------------------------
| Data di halaman welcome akan otomatis mengikuti database:
| - Total Barang
| - Barang Masuk
| - Barang Keluar
| - Stok Menipis
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    try {
        $totalBarang = Barang::count();

        // Menghitung total jumlah barang masuk dari kolom jumlah
        $totalBarangMasuk = BarangMasuk::sum('jumlah');

        // Menghitung total jumlah barang keluar dari kolom jumlah
        $totalBarangKeluar = BarangKeluar::sum('jumlah');

        // Menghitung barang yang stoknya kurang dari / sama dengan minimum stok
        $stokMenipis = Barang::whereColumn('stok', '<=', 'minimum_stok')->count();
    } catch (\Throwable $e) {
        $totalBarang = 0;
        $totalBarangMasuk = 0;
        $totalBarangKeluar = 0;
        $stokMenipis = 0;
    }

    return view('welcome', compact(
        'totalBarang',
        'totalBarangMasuk',
        'totalBarangKeluar',
        'stokMenipis'
    ));
})->name('home');

/*
|--------------------------------------------------------------------------
| LOGOUT PAKSA
|--------------------------------------------------------------------------
*/
Route::get('/logout-paksa', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout.paksa');

/*
|--------------------------------------------------------------------------
| ROUTE SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | FOTO PROFIL ADMIN / STAFF
    |--------------------------------------------------------------------------
    */
    Route::post('/profile/foto', [ProfileController::class, 'updateFoto'])
        ->name('profile.foto.update');

    Route::delete('/profile/foto', [ProfileController::class, 'hapusFoto'])
        ->name('profile.foto.destroy');

    /*
    |--------------------------------------------------------------------------
    | PROFILE GLOBAL
    |--------------------------------------------------------------------------
    | Route ini dipakai oleh halaman resources/views/profile/edit.blade.php
    |--------------------------------------------------------------------------
    */
    Route::get('/profile/edit', [AccountProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::match(['put', 'patch'], '/profile/update', [AccountProfileController::class, 'update'])
        ->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | CEK ROLE
    |--------------------------------------------------------------------------
    */
    Route::get('/cek-role', function () {
        $user = auth()->user();

        $user->loadMissing('role');

        $roleRelasi = optional($user->role)->name;

        $roleKolom = null;
        if (isset($user->getAttributes()['role'])) {
            $roleKolom = $user->getAttributes()['role'];
        }

        $roleName = $roleRelasi ?: $roleKolom;
        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        return [
            'user_id'     => $user->id,
            'name'        => $user->name ?? null,
            'email'       => $user->email ?? null,
            'username'    => $user->username ?? null,
            'role_id'     => $user->role_id ?? null,
            'role_relasi' => $roleRelasi,
            'role_kolom'  => $roleKolom,
            'role_final'  => $roleName,
        ];
    })->name('cek-role');

    /*
    |--------------------------------------------------------------------------
    | REDIRECT DASHBOARD SESUAI ROLE
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        $user->loadMissing('role');

        $roleRelasi = optional($user->role)->name;

        $roleKolom = null;
        if (isset($user->getAttributes()['role'])) {
            $roleKolom = $user->getAttributes()['role'];
        }

        $roleName = $roleRelasi ?: $roleKolom;
        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        if ($roleName === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($roleName === 'staf') {
            return redirect()->route('staff.dashboard');
        }

        abort(403, 'Role tidak dikenali. Pastikan akun ini memiliki role_id yang benar.');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['role:admin'])
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Profile Admin
            |--------------------------------------------------------------------------
            */
            Route::get('/profile/edit', [AccountProfileController::class, 'edit'])
                ->name('profile.edit');

            Route::match(['put', 'patch'], '/profile/update', [AccountProfileController::class, 'update'])
                ->name('profile.update');

            /*
            |--------------------------------------------------------------------------
            | Data Barang
            |--------------------------------------------------------------------------
            */
            Route::get('/barang', [AdminBarangController::class, 'index'])
                ->name('barang.index');

            Route::get('/barang/create', [AdminBarangController::class, 'create'])
                ->name('barang.create');

            Route::post('/barang', [AdminBarangController::class, 'store'])
                ->name('barang.store');

            Route::get('/barang/template-excel', [AdminBarangController::class, 'templateExcel'])
                ->name('barang.template-excel');

            Route::post('/barang/import-excel', [AdminBarangController::class, 'importExcel'])
                ->name('barang.import-excel');

            Route::get('/barang/{barang}/edit', [AdminBarangController::class, 'edit'])
                ->name('barang.edit');

            Route::put('/barang/{barang}', [AdminBarangController::class, 'update'])
                ->name('barang.update');

            Route::delete('/barang/{barang}', [AdminBarangController::class, 'destroy'])
                ->name('barang.destroy');

            /*
            |--------------------------------------------------------------------------
            | Kategori
            |--------------------------------------------------------------------------
            */
            Route::get('/kategori', [AdminKategoriController::class, 'index'])
                ->name('kategori.index');

            Route::get('/kategori/create', [AdminKategoriController::class, 'create'])
                ->name('kategori.create');

            Route::post('/kategori', [AdminKategoriController::class, 'store'])
                ->name('kategori.store');

            Route::get('/kategori/{kategori}/edit', [AdminKategoriController::class, 'edit'])
                ->name('kategori.edit');

            Route::put('/kategori/{kategori}', [AdminKategoriController::class, 'update'])
                ->name('kategori.update');

            Route::delete('/kategori/{kategori}', [AdminKategoriController::class, 'destroy'])
                ->name('kategori.destroy');

            /*
            |--------------------------------------------------------------------------
            | Supplier
            |--------------------------------------------------------------------------
            */
            Route::get('/supplier', [AdminSupplierController::class, 'index'])
                ->name('supplier.index');

            Route::get('/supplier/create', [AdminSupplierController::class, 'create'])
                ->name('supplier.create');

            Route::post('/supplier', [AdminSupplierController::class, 'store'])
                ->name('supplier.store');

            Route::get('/supplier/{supplier}/edit', [AdminSupplierController::class, 'edit'])
                ->name('supplier.edit');

            Route::put('/supplier/{supplier}', [AdminSupplierController::class, 'update'])
                ->name('supplier.update');

            Route::delete('/supplier/{supplier}', [AdminSupplierController::class, 'destroy'])
                ->name('supplier.destroy');

            /*
            |--------------------------------------------------------------------------
            | User / Staf
            |--------------------------------------------------------------------------
            */
            Route::get('/user', [AdminUserController::class, 'index'])
                ->name('user.index');

            Route::get('/user/create', [AdminUserController::class, 'create'])
                ->name('user.create');

            Route::post('/user', [AdminUserController::class, 'store'])
                ->name('user.store');

            Route::get('/user/{user}/edit', [AdminUserController::class, 'edit'])
                ->name('user.edit');

            Route::put('/user/{user}', [AdminUserController::class, 'update'])
                ->name('user.update');

            Route::delete('/user/{user}', [AdminUserController::class, 'destroy'])
                ->name('user.destroy');

            /*
            |--------------------------------------------------------------------------
            | Barang Masuk
            |--------------------------------------------------------------------------
            */
            Route::get('/barang-masuk', [AdminBarangMasukController::class, 'index'])
                ->name('barang-masuk.index');

            Route::get('/barang-masuk/create', [AdminBarangMasukController::class, 'create'])
                ->name('barang-masuk.create');

            Route::post('/barang-masuk', [AdminBarangMasukController::class, 'store'])
                ->name('barang-masuk.store');

            Route::get('/barang-masuk/{barangMasuk}/edit', [AdminBarangMasukController::class, 'edit'])
                ->name('barang-masuk.edit');

            Route::put('/barang-masuk/{barangMasuk}', [AdminBarangMasukController::class, 'update'])
                ->name('barang-masuk.update');

            Route::delete('/barang-masuk/{barangMasuk}', [AdminBarangMasukController::class, 'destroy'])
                ->name('barang-masuk.destroy');

            /*
            |--------------------------------------------------------------------------
            | Barang Keluar
            |--------------------------------------------------------------------------
            */
            Route::get('/barang-keluar', [AdminBarangKeluarController::class, 'index'])
                ->name('barang-keluar.index');

            Route::get('/barang-keluar/create', [AdminBarangKeluarController::class, 'create'])
                ->name('barang-keluar.create');

            Route::post('/barang-keluar', [AdminBarangKeluarController::class, 'store'])
                ->name('barang-keluar.store');

            Route::get('/barang-keluar/{barangKeluar}/edit', [AdminBarangKeluarController::class, 'edit'])
                ->name('barang-keluar.edit');

            Route::put('/barang-keluar/{barangKeluar}', [AdminBarangKeluarController::class, 'update'])
                ->name('barang-keluar.update');

            Route::delete('/barang-keluar/{barangKeluar}', [AdminBarangKeluarController::class, 'destroy'])
                ->name('barang-keluar.destroy');

            /*
            |--------------------------------------------------------------------------
            | Permintaan Barang Admin
            |--------------------------------------------------------------------------
            */
            Route::get('/permintaan-barang', [AdminPermintaanBarangController::class, 'index'])
                ->name('permintaan-barang.index');

            Route::put('/permintaan-barang/{permintaanBarang}/setuju', [AdminPermintaanBarangController::class, 'setuju'])
                ->name('permintaan-barang.setuju');

            Route::put('/permintaan-barang/{permintaanBarang}/tolak', [AdminPermintaanBarangController::class, 'tolak'])
                ->name('permintaan-barang.tolak');

            Route::delete('/permintaan-barang/{permintaanBarang}', [AdminPermintaanBarangController::class, 'destroy'])
                ->name('permintaan-barang.destroy');

            /*
            |--------------------------------------------------------------------------
            | Pengembalian Barang Admin
            |--------------------------------------------------------------------------
            */
            Route::get('/pengembalian-barang', [AdminPengembalianBarangController::class, 'index'])
                ->name('pengembalian-barang.index');

            Route::put('/pengembalian-barang/{pengembalianBarang}/setuju', [AdminPengembalianBarangController::class, 'setuju'])
                ->name('pengembalian-barang.setuju');

            Route::put('/pengembalian-barang/{pengembalianBarang}/tolak', [AdminPengembalianBarangController::class, 'tolak'])
                ->name('pengembalian-barang.tolak');

            Route::delete('/pengembalian-barang/{pengembalianBarang}', [AdminPengembalianBarangController::class, 'destroy'])
                ->name('pengembalian-barang.destroy');

            /*
            |--------------------------------------------------------------------------
            | Laporan dan Notifikasi Stok
            |--------------------------------------------------------------------------
            */
            Route::get('/laporan-stok', [AdminLaporanController::class, 'stok'])
                ->name('laporan-stok.index');

            Route::get('/laporan-stok/cetak', [AdminLaporanController::class, 'cetakStok'])
                ->name('laporan-stok.cetak');

            Route::get('/laporan-stok/excel', [AdminLaporanController::class, 'exportExcelStok'])
                ->name('laporan-stok.excel');

            Route::get('/laporan-transaksi', [AdminLaporanController::class, 'transaksi'])
                ->name('laporan-transaksi.index');

            Route::get('/laporan-transaksi/cetak', [AdminLaporanController::class, 'cetakTransaksi'])
                ->name('laporan-transaksi.cetak');

            Route::get('/laporan-transaksi/excel', [AdminLaporanController::class, 'exportExcelTransaksi'])
                ->name('laporan-transaksi.excel');

            Route::get('/notifikasi-stok', [AdminLaporanController::class, 'notifikasiStok'])
                ->name('notifikasi-stok.index');

            /*
            |--------------------------------------------------------------------------
            | Aktivitas
            |--------------------------------------------------------------------------
            */
            Route::get('/aktivitas', [AdminAktivitasController::class, 'index'])
                ->name('aktivitas.index');

            Route::delete('/aktivitas/{aktivitas}', [AdminAktivitasController::class, 'destroy'])
                ->name('aktivitas.destroy');

            Route::delete('/aktivitas', [AdminAktivitasController::class, 'destroyAll'])
                ->name('aktivitas.destroy-all');
        });

    /*
    |--------------------------------------------------------------------------
    | STAFF ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('staff')
        ->name('staff.')
        ->middleware(['role:staf,staff'])
        ->group(function () {

            Route::get('/dashboard', [StaffDashboardController::class, 'index'])
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Profile Staff
            |--------------------------------------------------------------------------
            */
            Route::get('/profile/edit', [AccountProfileController::class, 'edit'])
                ->name('profile.edit');

            Route::match(['put', 'patch'], '/profile/update', [AccountProfileController::class, 'update'])
                ->name('profile.update');

            /*
            |--------------------------------------------------------------------------
            | Permintaan Barang Staff
            |--------------------------------------------------------------------------
            */
            Route::get('/permintaan-barang', [StaffPermintaanBarangController::class, 'index'])
                ->name('permintaan-barang.index');

            Route::get('/permintaan-barang/create', [StaffPermintaanBarangController::class, 'create'])
                ->name('permintaan-barang.create');

            Route::post('/permintaan-barang', [StaffPermintaanBarangController::class, 'store'])
                ->name('permintaan-barang.store');

            Route::get('/permintaan-barang/{permintaanBarang}/edit', [StaffPermintaanBarangController::class, 'edit'])
                ->name('permintaan-barang.edit');

            Route::put('/permintaan-barang/{permintaanBarang}', [StaffPermintaanBarangController::class, 'update'])
                ->name('permintaan-barang.update');

            Route::delete('/permintaan-barang/{permintaanBarang}', [StaffPermintaanBarangController::class, 'destroy'])
                ->name('permintaan-barang.destroy');

            /*
            |--------------------------------------------------------------------------
            | Pengembalian Barang Staff
            |--------------------------------------------------------------------------
            */
            Route::get('/pengembalian-barang', [StaffPengembalianBarangController::class, 'index'])
                ->name('pengembalian-barang.index');

            Route::get('/pengembalian-barang/create', [StaffPengembalianBarangController::class, 'create'])
                ->name('pengembalian-barang.create');

            Route::post('/pengembalian-barang', [StaffPengembalianBarangController::class, 'store'])
                ->name('pengembalian-barang.store');

            Route::get('/pengembalian-barang/{pengembalianBarang}/edit', [StaffPengembalianBarangController::class, 'edit'])
                ->name('pengembalian-barang.edit');

            Route::put('/pengembalian-barang/{pengembalianBarang}', [StaffPengembalianBarangController::class, 'update'])
                ->name('pengembalian-barang.update');

            Route::delete('/pengembalian-barang/{pengembalianBarang}', [StaffPengembalianBarangController::class, 'destroy'])
                ->name('pengembalian-barang.destroy');
        });
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';