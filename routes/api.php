<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\SupplierApiController;
use App\Http\Controllers\Api\PermintaanBarangApiController;

/*
|--------------------------------------------------------------------------
| API ROOT
|--------------------------------------------------------------------------
| Endpoint utama untuk mengecek informasi API INVENDAM.
| URL: http://127.0.0.1:8000/api
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Selamat datang di API INVENDAM.',
        'system' => 'Inventory PDAM Bengkayang',
        'version' => '1.0.0',
        'base_url' => url('/api'),
        'authentication' => 'Bearer Token Laravel Sanctum',
        'available_endpoints' => [
            'public' => [
                'GET /api' => 'Informasi API',
                'GET /api/test' => 'Cek status API',
                'POST /api/login' => 'Login API admin atau staf',
            ],
            'auth_required' => [
                'GET /api/me' => 'Cek user yang sedang login',
                'POST /api/logout' => 'Logout API',
                'GET /api/barang' => 'Menampilkan data barang',
                'GET /api/barang/{id}' => 'Detail data barang',
                'GET /api/kategori' => 'Menampilkan data kategori',
                'GET /api/kategori/{id}' => 'Detail data kategori',
                'GET /api/supplier' => 'Menampilkan data supplier',
                'GET /api/supplier/{id}' => 'Detail data supplier',
                'GET /api/permintaan-barang' => 'Menampilkan data permintaan barang',
                'POST /api/permintaan-barang' => 'Membuat permintaan barang',
                'GET /api/permintaan-barang/{id}' => 'Detail permintaan barang',
                'PUT /api/permintaan-barang/{id}' => 'Update permintaan barang',
                'DELETE /api/permintaan-barang/{id}' => 'Hapus permintaan barang',
                'PUT /api/admin/permintaan-barang/{id}/setuju' => 'Admin menyetujui permintaan barang',
                'PUT /api/admin/permintaan-barang/{id}/tolak' => 'Admin menolak permintaan barang',
            ],
        ],
    ], 200);
});

/*
|--------------------------------------------------------------------------
| API TEST
|--------------------------------------------------------------------------
*/
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API INVENDAM aktif.',
        'status' => 'online',
    ], 200);
});

/*
|--------------------------------------------------------------------------
| API AUTH PUBLIC
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| API YANG WAJIB LOGIN TOKEN
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | USER LOGIN
    |--------------------------------------------------------------------------
    */
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | DATA BARANG
    |--------------------------------------------------------------------------
    */
    Route::get('/barang', [BarangApiController::class, 'index']);
    Route::get('/barang/{id}', [BarangApiController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | DATA KATEGORI
    |--------------------------------------------------------------------------
    */
    Route::get('/kategori', [KategoriApiController::class, 'index']);
    Route::get('/kategori/{id}', [KategoriApiController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | DATA SUPPLIER
    |--------------------------------------------------------------------------
    */
    Route::get('/supplier', [SupplierApiController::class, 'index']);
    Route::get('/supplier/{id}', [SupplierApiController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | PERMINTAAN BARANG
    |--------------------------------------------------------------------------
    */
    Route::get('/permintaan-barang', [PermintaanBarangApiController::class, 'index']);
    Route::post('/permintaan-barang', [PermintaanBarangApiController::class, 'store']);
    Route::get('/permintaan-barang/{id}', [PermintaanBarangApiController::class, 'show']);
    Route::put('/permintaan-barang/{id}', [PermintaanBarangApiController::class, 'update']);
    Route::delete('/permintaan-barang/{id}', [PermintaanBarangApiController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN APPROVE / TOLAK PERMINTAAN BARANG
    |--------------------------------------------------------------------------
    */
    Route::put('/admin/permintaan-barang/{id}/setuju', [PermintaanBarangApiController::class, 'setuju']);
    Route::put('/admin/permintaan-barang/{id}/tolak', [PermintaanBarangApiController::class, 'tolak']);
});