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
        $today = now()->locale('id')->dayName; 
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
        $request->validate([
            'catatan'   => 'nullable|string',
            'obat_ids'  => 'required|string', 
        ]);

        $obatIds = array_filter(explode(',', $request->obat_ids));

        if (count($obatIds) === 0) {
            return back()->withErrors(['obat' => 'Anda harus menambahkan minimal 1 obat.'])->withInput();
        }

        // ==========================================
        // MULAI TRANSAKSI DATABASE
        // ==========================================
        \DB::beginTransaction();
        try {
            $daftarPoli = DaftarPoli::findOrFail($id);

            if ($daftarPoli->jadwalPeriksa->dokter_id != Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke pasien ini.');
            }

            // 1. CEK STOK OBAT DULU
            foreach ($obatIds as $obatId) {
                $obat = \App\Models\Obat::lockForUpdate()->find($obatId);
                
                if (!$obat || $obat->stok <= 0) {
                    throw new \Exception("Gagal menyimpan! Stok obat '{$obat->nama_obat}' habis.");
                }
            }

            // 2. Hitung Total Biaya
            $totalBiaya = \App\Models\Obat::whereIn('id', $obatIds)->sum('harga');

            // 3. Simpan Data Periksa
            $periksa = \App\Models\Periksa::create([
                'id_daftar_poli'  => $daftarPoli->id,
                'tanggal_periksa' => now(),
                'catatan'         => $request->catatan,
                'biaya_periksa'   => $totalBiaya,
            ]);

            // 4. Simpan Detail Periksa + KURANGI STOK
            foreach ($obatIds as $obatId) {
                \App\Models\DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat'    => $obatId,
                    'jumlah'     => 1, // Karena form kamu mengirim ID, dianggap jumlahnya 1
                ]);

                // --- INI YANG MEMBUAT STOK BERKURANG ---
                \App\Models\Obat::where('id', $obatId)->decrement('stok', 1);
            }

            // 5. Buat Data Pembayaran
            \App\Models\Pembayaran::create([
                'periksa_id' => $periksa->id, 
                'status'     => 'menunggu'
            ]);

            // COMMIT: Simpan semuanya ke database
            \DB::commit();

        } catch (\Exception $e) {
            // ROLLBACK: Batalkan semua jika ada obat yang stoknya habis
            \DB::rollBack();
            return back()->withErrors(['obat' => $e->getMessage()])->withInput();
        }

        // Broadcast WebSocket (di luar transaction)
        broadcast(new AntrianUpdate($daftarPoli->id_jadwal, $daftarPoli->no_antrian));

        return redirect()->route('dokter.periksa.index')->with('success', 'Data pemeriksaan berhasil disimpan dan stok obat dikurangi!');

        
    }
}