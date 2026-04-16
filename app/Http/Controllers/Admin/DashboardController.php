<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total untuk Kartu Statistik
        $totalPoli = Poli::count();
        $totalDokter = User::where('role', 'dokter')->count();
        $totalPasien = User::where('role', 'pasien')->count();
        $totalObat = Obat::count(); // Pastikan Model Obat sudah ada

        // 2. Ambil Data Poli Terbaru untuk Tabel Ringkas (misal limit 5)
        $polis = Poli::with('dokters')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPoli', 'totalDokter', 'totalPasien', 'totalObat', 'polis'
        ));
    }
}