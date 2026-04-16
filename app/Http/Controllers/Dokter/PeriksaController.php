<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Obat;
use App\Events\AntrianUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PeriksaController extends Controller
{
    public function index()
    {
        $today = now()->locale('id')->dayName; // Contoh: Senin

        // Ambil antrian milik dokter yang login, HARI INI, dan BELUM DIPERIKSA
        $antrians = DaftarPoli::with('pasien')
                    ->whereHas('jadwalPeriksa', function($query) use ($today) {
                        $query->where('dokter_id', Auth::id())
                              ->where('hari', $today);
                    })
                    ->doesntHave('periksas') // Hanya yang belum ada di tabel periksa
                    ->orderBy('no_antrian', 'asc')
                    ->get();

        return view('dokter.periksa.index', compact('antrians'));
    }

    public function create($id)
    {
        // Ambil data pasien yang akan diperiksa
        $daftarPoli = DaftarPoli::findOrFail($id);
        
        // Keamanan: Pastikan pasien ini terdaftar ke dokter yang sedang login
        // (Biar dokter A tidak bisa ngacak data pasien dokter B lewat URL)
        if ($daftarPoli->jadwalPeriksa->dokter_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pasien ini.');
        }

        // Ambil semua data obat untuk dropdown
        $obats = Obat::all();

        return view('dokter.periksa.form', compact('daftarPoli', 'obats'));
    }

        public function store(Request $request, $id)
    {
        $daftarPoli = DaftarPoli::findOrFail($id);

        $request->validate([
            'catatan'   => 'nullable|string',
            'obat_ids' => 'required|string', // <-- UBAH INI (HAPUS _input)
        ]);

        // UBAH JUGA DI SINI
        $obatIds = array_filter(explode(',', $request->obat_ids));

        if (count($obatIds) === 0) {
            return back()->withErrors(['obat' => 'Anda harus menambahkan minimal 1 obat.'])->withInput();
        }

        $totalBiaya = \App\Models\Obat::whereIn('id', $obatIds)->sum('harga');

        $periksa = \App\Models\Periksa::create([
            'id_daftar_poli'  => $daftarPoli->id,
            'tanggal_periksa' => now(),
            'catatan'         => $request->catatan,
            'biaya_periksa'  => $totalBiaya,
        ]);

        $jadwalId = $daftarPoli->id_jadwal; // Sesuaikan nama kolom foreign key jadwal kamu
        $nomorSekarang = $daftarPoli->no_antrian;

        broadcast(new AntrianUpdate($jadwalId, $nomorSekarang));

        foreach ($obatIds as $obatId) {
            \App\Models\DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat'    => $obatId,
            ]);
        }

        \App\Models\Pembayaran::create([
        'periksa_id' => $periksa->id, // Pastikan variabelnya $periksa
        'status' => 'menunggu'
        ]);
        
        return redirect()->route('dokter.periksa.index')->with('success', 'Data pemeriksaan berhasil disimpan!');

        
    }
}