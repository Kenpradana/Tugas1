<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DokterExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return User::where('role', 'dokter')
            ->with('poli')
            ->get()
            ->map(function ($dokter, $index) {
                return [
                    'no'     => $index + 1,
                    'nama'   => $dokter->nama,
                    'email'  => $dokter->email,
                    'no_ktp' => "'" . $dokter->no_ktp, // Tanda ' biar No KTP tidak berubah jadi angka aneh di Excel
                    'no_hp'  => "'" . $dokter->no_hp,
                    'poli'   => $dokter->poli->nama_poli ?? 'Belum ditugaskan',
                    'alamat' => $dokter->alamat,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dokter',
            'Email',
            'No KTP',
            'No HP',
            'Poli',
            'Alamat',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama
            'C' => 30,  // Email
            'D' => 20,  // No KTP
            'E' => 18,  // No HP
            'F' => 20,  // Poli
            'G' => 40,  // Alamat
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 12]],
            'A'  => ['alignment' => ['horizontal' => 'center']],
            'D'  => ['alignment' => ['horizontal' => 'center']],
            'E'  => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}