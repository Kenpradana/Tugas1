<?php

namespace App\Exports;

use App\Models\JadwalPeriksa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JadwalPeriksaExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * HANYA mengambil jadwal milik dokter yang sedang login
     */
    public function collection()
    {
        // Ganti 'dokter_id' jika nama foreign key di tabel jadwal_periksa Anda berbeda (misal: 'id_dokter')
        return JadwalPeriksa::where('dokter_id', auth()->user()->id)->get();
    }

    public function headings(): array
    {
        return [
            'Nama Dokter', // Bisa juga ganti dengan nama dokter jika ingin lebih informatif
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
        ];
    }

    public function map($jadwal): array
    {
        return [
            $jadwal->dokter->nama ?? 'N/A', // Menampilkan nama dokter
            $jadwal->hari, // Pastikan kolom di DB Anda namanya 'hari'
            
            // Format jam biar rapi (misal: 08:00)
            // Ganti 'jam_mulai' sesuai nama kolom di database Anda
            substr($jadwal->jam_mulai, 0, 5), 
            
            // Ganti 'jam_selesai' sesuai nama kolom di database Anda
            substr($jadwal->jam_selesai, 0, 5), 
            
        ];
    }
}