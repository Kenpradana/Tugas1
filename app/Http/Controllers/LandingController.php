<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JadwalPeriksa;
use App\Models\Poli;

class LandingController extends Controller
{
    public function index()
    {
        $hariIni = now()->locale('id')->dayName; // Output: "Senin", "Selasa", dst.
        
        // Dokter (role = dokter) + relasi poli & jadwal
        $dokters = User::where('role', 'dokter')
            ->with([
                'poli',
                'jadwalPeriksa' => function ($q) {
                    $q->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
                      ->orderBy('jam_mulai');
                }
            ])
            ->has('jadwalPeriksa')
            ->get();

        // 2 jadwal terdekat untuk hero card
        $jadwalTerdekat = JadwalPeriksa::with('dokter.poli')
            ->where('hari', $hariIni) // Filter hanya hari ini
            ->orderBy('jam_mulai')
            ->limit(5)
            ->get();
        // Stats
        $totalDokter  = User::where('role', 'dokter')->count();
        $totalPoli    = Poli::count();
        $totalPasien  = User::where('role', 'pasien')->count();

        return view('welcome', compact(
            'dokters',
            'jadwalTerdekat',
            'hariIni',
            'totalDokter',
            'totalPoli',
            'totalPasien'
        ));
    }
}