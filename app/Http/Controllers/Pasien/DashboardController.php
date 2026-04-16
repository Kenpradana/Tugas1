<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;
use App\Models\Poli;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        $today = now()->locale('id')->dayName; // Mengambil nama hari ini (Senin, Selasa, dll)

        // 1. Hanya ambil jadwal yang HARI INI
        $jadwals = JadwalPeriksa::with(['dokter.poli', 'daftarPolis' => function($query) {
            $query->whereDate('created_at', today());
        }])->where('hari', $today)->get(); // <-- TAMBAHKAN FILTER HARI INI

        $myQueue = DaftarPoli::where('id_pasien', Auth::id()) 
                ->whereDoesntHave('periksas')
                ->whereDate('created_at', today())
                ->first();

        return view('pasien.dashboard', compact('jadwals', 'myQueue'));
    }
    
    public function createAntrian()
    {
        $sudahDaftar = DaftarPoli::where('id_pasien', Auth::id())
                        ->doesntHave('periksas')
                        ->exists();

        if ($sudahDaftar) {
            return redirect()->route('pasien.dashboard')->with('error', 'Anda sudah memiliki antrian aktif!');
        }

        // GANTI LOGI INI:
        $now = date('Ym'); 
        $prefix = $now . " - ";
        
        $lastRecord = DaftarPoli::where('no_rekam_medis', 'like', $prefix . '%')
                         ->orderBy('no_rekam_medis', 'desc')
                         ->first();
        
        if ($lastRecord) {
            // Kita pecah berdasarkan " - "
            $parts = explode(' - ', $lastRecord->no_rekam_medis);
            $lastNum = intval(end($parts)); // Ambil bagian terakhir
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }
        
        $noRekamMedis = $prefix . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $polis = Poli::all();

        return view('pasien.daftar-antrian', compact('polis', 'noRekamMedis'));
    }

        public function getJadwalByPoli($id_poli)
    {
        // KEMBALIKAN FILTER HARI INI:
        $today = now()->locale('id')->dayName; // Contoh: Selasa

        $dokterIds = \App\Models\User::where('role', 'dokter')
                    ->where('id_poli', $id_poli)
                    ->pluck('id');

        $jadwals = \App\Models\JadwalPeriksa::whereIn('dokter_id', $dokterIds)
                ->where('hari', $today) // <-- FILTER AKTIF KEMBALI (Hanya jadwal hari ini)
                ->with('dokter')
                ->get();

        return response()->json($jadwals);
    }

    public function storeAntrian(Request $request)
    {
        $request->validate([
            'id_jadwal'      => 'required|exists:jadwal_periksa,id',
            'no_rekam_medis' => 'required|unique:daftar_poli,no_rekam_medis',
            'keluhan'        => 'required|string|min:5',
        ]);

        $nomorTerakhir = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian') ?? 0;
        $nomorAntrianBaru = $nomorTerakhir + 1;

        DaftarPoli::create([
            'id_jadwal'      => $request->id_jadwal,
            'id_pasien'      => Auth::id(),
            'no_rekam_medis' => $request->no_rekam_medis,
            'keluhan'        => $request->keluhan,
            'no_antrian'     => $nomorAntrianBaru,
        ]);

        return redirect()->route('pasien.dashboard')->with('success', 'Berhasil mendaftar!');
    }
}