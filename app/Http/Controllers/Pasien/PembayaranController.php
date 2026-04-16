<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarPoli;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $daftarPolis = DaftarPoli::where('id_pasien', auth()->user()->id)
            ->whereHas('periksas') 
            ->with([
                'periksas.pembayaran', 
                'jadwalPeriksa.poli',       // PERHATIKAN: ADA jadwalPeriksa DI DEPANNYA
                'jadwalPeriksa.dokter'       // PERHATIKAN: ADA jadwalPeriksa DI DEPANNYA
            ]) 
            ->get();

        return view('pasien.pembayaran.index', compact('daftarPolis'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $pembayaran = Pembayaran::where('periksa_id', $id)->firstOrFail();

        // Upload foto ke folder storage/app/public/bukti_bayar
        if ($request->hasFile('bukti_bayar')) {
        $file = $request->file('bukti_bayar');
        $namaFile = time() . '_' . auth()->user()->id . '.' . $file->getClientOriginalExtension();
        
        // TAMBAHKAN KATA 'public' DI AKHIR SINI:
        $file->storeAs('bukti_bayar', $namaFile, 'public'); 

        $pembayaran->update([
            'bukti_bayar' => $namaFile,
        ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}