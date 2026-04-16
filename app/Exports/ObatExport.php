<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ObatExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Obat::all();
    }

    public function headings(): array
    {
        return [
            'ID Obat',
            'Nama Obat',
            'Kemasan',
            'Harga',
            'Stok',
        ];
    }

    public function map($obat): array
    {
        return [
            $obat->id,
            $obat->nama_obat,         // SESUAIKAN DENGAN KOLOM DB ANDA
            $obat->kemasan,           // SESUAIKAN DENGAN KOLOM DB ANDA
            
            // Format Harga menjadi Rupiah (misal: "Rp 15.000")
            'Rp ' . number_format($obat->harga, 0, ',', '.'), 
            
            $obat->stok . ' ' . ($obat->kemasan ?? ''), // Contoh: "10 Tablet"

        ];
    }
}