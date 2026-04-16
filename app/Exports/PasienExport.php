<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PasienExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Mengambil data dari database
     */
    public function collection()
    {
        return User::where('role', 'pasien')->get();
    }

    /**
     * Membuat nama-nama kolom di baris paling atas Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pasien',
            'Email',
            'NIK / KTP',
            'No. Telepon',
            'Alamat',
        ];
    }

    // TAMBAHKAN METHOD INI UNTUK SETTING FORMAT KOLOM
    public function columnFormats(): array
    {
        return [
            // 'D' artinya kolom ke-4 (Urutan: A=id, B=nama, C=email, D=NIK)
            'D' => NumberFormat::FORMAT_TEXT, 
        ];
    }

    public function map($user): array
    {

        // Ambil NIK
        $nik = $user->nik ?? $user->no_ktp ?? '-';

        return [
            $user->id,
            $user->nama,           
            $user->email,
            
            // TAMBAHKAN . '' (titik dua kutip kosong) DI BELAKANG NIK
            // Ini trik PHP untuk memastikan yang dikirim ke Excel adalah Teks, bukan Angka
            $nik . '-', 
            $user->no_hp ?? '-', 
            $user->alamat ?? '-',
        ];
    }
}