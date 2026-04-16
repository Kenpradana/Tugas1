<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

// Nama Class HARUS DokterController
class DokterController extends Controller
{
    // Nama Function HARUS index
    public function index()
    {
        $dokterId = Auth::id();
        $today = now()->locale('id')->dayName; // Contoh: Senin

        // 1. Hitung Data untuk Kartu Statistik
        $totalJadwal = \App\Models\JadwalPeriksa::where('dokter_id', $dokterId)->count();
        
        $pasienMenunggu = DaftarPoli::whereHas('jadwalPeriksa', function($q) use ($dokterId, $today) {
                                $q->where('dokter_id', $dokterId)->where('hari', $today);
                            })->doesntHave('periksas')->count();

        $totalRiwayat = DaftarPoli::whereHas('jadwalPeriksa', function($q) use ($dokterId) {
                                $q->where('dokter_id', $dokterId);
                            })->has('periksas')->count();

        // 2. Ambil Jadwal Milik Dokter yang Login
         $jadwals = \App\Models\JadwalPeriksa::with('dokter')
                    ->where('dokter_id', Auth::id())
                    ->get();
        // 3. Ambil Antrian Pasien Hari Ini
        $antrians = DaftarPoli::with(['pasien'])
                    ->whereHas('jadwalPeriksa', function($query) use ($today) {
                        $query->where('dokter_id', Auth::id())
                              ->where('hari', $today);
                    })
                    ->doesntHave('periksas')
                    ->orderBy('no_antrian', 'asc')
                    ->get();

        return view('dokter.dashboard', compact('totalJadwal', 'pasienMenunggu', 'totalRiwayat', 'jadwals', 'antrians'));
    }
}