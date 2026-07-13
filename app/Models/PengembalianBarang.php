<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianBarang extends Model
{
    protected $table = 'pengembalian_barang';

    protected $fillable = [
        'barang_id',
        'user_id',
        'permintaan_id',
        'tanggal_pengembalian',
        'jumlah',
        'status',
        'keterangan',
        'foto_bukti',
    ];

    public $timestamps = false;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function permintaan()
    {
        return $this->belongsTo(PermintaanBarang::class, 'permintaan_id');
    }
}