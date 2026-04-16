<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
{
    $pembayarans = Pembayaran::where('status', 'menunggu')
        ->with([
            'periksa.daftarPoli.pasien', 
            'periksa.daftarPoli.jadwalPeriksa.poli', // <-- DITAMBAHKAN jadwalPeriksa
            'periksa.daftarPoli.jadwalPeriksa.dokter' // <-- DITAMBAHKAN jadwalPeriksa
        ])
        ->get();

    return view('admin.pembayaran.index', compact('pembayarans'));
}

    public function show($id)
    {
        $pembayaran = Pembayaran::with('periksa.daftarPoli.pasien')->findOrFail($id);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status' => 'lunas'
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}