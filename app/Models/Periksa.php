<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Periksa extends Model
{
    protected $table = 'periksa';

    protected $fillable = [
        'id_daftar_poli',
        'tanggal_periksa',
        'catatan',
        'biaya_periksa',
    ];

    // TAMBAHKAN BAGIAN INI:
    protected $casts = [
        'tanggal_periksa' => 'datetime', 
    ];

    public function daftarPoli()
    {
        return $this->belongsTo(DaftarPoli::class, 'id_daftar_poli');
    }

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function pembayaran()
{
    return $this->hasOne(Pembayaran::class, 'periksa_id'); // <-- UBAH JADI INI
}
}