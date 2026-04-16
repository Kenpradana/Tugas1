<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'periksa_id',
        'bukti_bayar',
        'status',
    ];

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'periksa_id'); // <-- UBAH JADI INI
    }

    public function periksa()
    {
        // Harus 'periksa_id' (sesuai nama kolom di database tabel pembayarans)
        return $this->belongsTo(Periksa::class, 'periksa_id');
    }
}