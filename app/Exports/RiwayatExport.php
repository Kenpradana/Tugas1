<?php

namespace App\Exports;

use App\Models\Periksa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Kita gunakan whereHas untuk menyaring melalui relasi
        return Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($query) {
                // Filter berdasarkan ID dokter yang sedang login
                $query->where('dokter_id', auth()->user()->id);
            })
            // Menggunakan tanggal_periksa sesuai model Anda
            ->orderBy('tanggal_periksa', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal Periksa',
            'Nama Pasien',
            'Keluhan',
            'Diagnosa / Catatan Dokter',
            'Biaya',
            'Obat yang Diberikan',
        ];
    }

    public function map($periksa): array
    {
        // Ambil nama pasien
        $namaPasien = '-';
        if ($periksa->daftarPoli && $periksa->daftarPoli->pasien) {
            $namaPasien = $periksa->daftarPoli->pasien->nama;
        }

        // Gabungkan semua obat yang diresepkan (menggunakan relasi detailPeriksas)
        $daftarObat = '-';
        if ($periksa->detailPeriksas->count() > 0) {
            $daftarObat = $periksa->detailPeriksas->map(function ($detail) {
                // Sesuaikan 'nama_obat' dan 'aturan_pakai' dengan kolom di tabel Anda
                return $detail->obat->nama_obat;
            })->implode(', ');
        }

        return [
            // tanggal_periksa sesuai fillable model Anda
            \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('d-m-Y'),
            
            $namaPasien,
            $periksa->daftarPoli->keluhan ?? '-',
            $periksa->catatan ?? '-',
            // Format biaya ke Rupiah
            'Rp ' . number_format($periksa->biaya_periksa, 0, ',', '.'),
            $daftarObat,
        ];
    }
}