<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    protected $table = 'jadwal_periksa';

    protected $fillable = [
        'dokter_id', 
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // YANG INI YANG SANGAT PENTING: NAMA FUNCTION HARUS 'dokter' DAN FOREIGN KEY HARUS 'dokter_id'
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function daftarPolis()
    {
        return $this->hasMany(DaftarPoli::class, 'id_jadwal');
    }

    public function poli()
    {
        // Sesuaikan 'id_poli' jika nama kolom foreign key di database Anda berbeda
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}