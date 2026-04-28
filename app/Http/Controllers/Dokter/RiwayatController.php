<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua data periksa yang dilakukan oleh dokter yang sedang login
         $periksas = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa'])
                    ->whereHas('daftarPoli.jadwalPeriksa', function($query) {
                        $query->where('dokter_id', Auth::id());
                    })
                    ->orderBy('tanggal_periksa', 'desc')
                    ->paginate(10); // ← Yang ini saja yang diganti

        return view('dokter.riwayat.index', compact('periksas'));
    }

    public function detail($pasien_id)
    {
        // Cari data pasien
        $pasien = User::where('role', 'pasien')->findOrFail($pasien_id);

        // Ambil semua riwayat periksa untuk pasien ini, HANYA yang ditangani dokter yang login
        $riwayats = Periksa::with(['daftarPoli', 'detailPeriksas.obat'])
                    ->whereHas('daftarPoli', function($query) use ($pasien_id) {
                        $query->where('id_pasien', $pasien_id);
                    })
                    ->whereHas('daftarPoli.jadwalPeriksa', function($query) {
                        $query->where('dokter_id', Auth::id());
                    })
                    ->orderBy('tanggal_periksa', 'desc')
                    ->get();

        return view('dokter.riwayat.detail', compact('pasien', 'riwayats'));
    }
    
}