<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    protected $table = 'aktivitas';

    protected $fillable = [
        'user_id',
        'tipe',
        'aktivitas',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function catat($tipe, $aktivitas, $deskripsi = null): void
    {
        self::create([
            'user_id' => auth()->id(),
            'tipe' => $tipe,
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
        ]);
    }
}