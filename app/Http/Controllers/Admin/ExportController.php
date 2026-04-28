<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\DokterExport; // Sesuaikan dengan lokasi file DokterExport Anda
use App\Exports\PasienExport; // Sesuaikan dengan lokasi file PasienExport Anda
use App\Exports\ObatExport; // Sesuaikan dengan lokasi file ObatExport Anda
use App\Exports\RiwayatExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportDokter()
    {
        // 'dokter.xlsx' adalah nama file yang akan didownload
        return Excel::download(new DokterExport, 'dokter.xlsx');
    }

    public function exportPasien()
    {
        return Excel::download(new PasienExport, 'pasien.xlsx');
    }

    public function exportObat()
    {
        return Excel::download(new ObatExport, 'data-obat.xlsx');
    }
}