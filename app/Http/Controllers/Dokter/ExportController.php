<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Exports\RiwayatExport;
use App\Exports\JadwalPeriksaExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportRiwayat()
    {
        return Excel::download(new RiwayatExport, 'riwayat-periksa.xlsx');
    }
    public function exportJadwal()
    {
        return Excel::download(new JadwalPeriksaExport, 'jadwal-periksa-saya.xlsx');
    }

}