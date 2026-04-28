<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\PasienController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\ExportController as AdminExportController; 
use App\Http\Controllers\Dokter\ExportController as DokterExportController;
use App\Http\Controllers\Pasien\DashboardController; // Ini untuk Pasien
use App\Http\Controllers\Dokter\DokterController; // Ini untuk Dokter (Sesuai nama file yang tadi Anda buat)
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Dokter\RiwayatController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; // Ini untuk Admin (Sesuai nama file yang tadi Anda buat)
use App\Http\Controllers\Admin\DokterController as AdminDokterController; // Ini untuk Dokter di admin (Sesuai nama file yang tadi Anda buat)   

Route::get('/', [LandingController::class, 'index']);

route::get('/login', [AuthController::class, 'showLogin'])->name('login');
route::post('/login', [AuthController::class, 'login']);
route::get('/register', [AuthController::class, 'showRegister'])->name('register');
route::post('/register', [AuthController::class, 'register']);
route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/test-broadcast', [App\Http\Controllers\Pasien\DashboardController::class, 'testBroadcast']);
Route::get('/test-ws', function () {
    return view('test_echo');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('polis', PoliController::class);
    Route::resource('pasiens', PasienController::class);
    Route::resource('dokters', AdminDokterController::class);
    Route::resource('obats', ObatController::class); 
    Route::get('/export/dokter', [AdminExportController::class, 'exportDokter'])->name('admin.export.dokter');
    Route::get('/export/pasien', [AdminExportController::class, 'exportPasien'])->name('admin.export.pasien');
    Route::get('/export/obat', [AdminExportController::class, 'exportObat'])->name('admin.export.obat'); 
    Route::get('/pembayaran', [App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::get('/pembayaran/{id}', [App\Http\Controllers\Admin\PembayaranController::class, 'show'])->name('admin.pembayaran.show');
    Route::post('/pembayaran/{id}/konfirmasi', [App\Http\Controllers\Admin\PembayaranController::class, 'konfirmasi'])->name('admin.pembayaran.konfirmasi');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');

    // Tambahkan ini:
    Route::resource('jadwal', JadwalPeriksaController::class)
    ->except(['show']) // <-- MENGHAPUS ROUTE SHOW OTOMATIS
    ->names([
        'index' => 'dokter.jadwal.index',
        'create' => 'dokter.jadwal.create',
        'store' => 'dokter.jadwal.store',
        'edit' => 'dokter.jadwal.edit',
        'update' => 'dokter.jadwal.update',
        'destroy' => 'dokter.jadwal.destroy',
    ]);

    Route::get('/periksa-pasien', [PeriksaController::class, 'index'])->name('dokter.periksa.index');
    Route::get('/periksa-pasien/{id}/periksa', [PeriksaController::class, 'create'])->name('dokter.periksa.create');
    Route::post('/periksa-pasien/{id}/periksa', [PeriksaController::class, 'store'])->name('dokter.periksa.store'); 
    // Export Riwayat (Dokter) - PINDAH KE SINI
    Route::get('/riwayat/export', [DokterExportController::class, 'exportRiwayat'])
        ->name('dokter.riwayat.export');
    Route::get('/jadwal/export', [DokterExportController::class, 'exportJadwal'])->name('dokter.jadwal.export');

    Route::get('/riwayat-pasien', [RiwayatController::class, 'index'])->name('dokter.riwayat.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatController::class, 'detail'])->name('dokter.riwayat.detail');    

});


Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('pasien.dashboard');
    Route::get('/daftar-poli', [DashboardController::class, 'createAntrian'])->name('pasien.antrian.create');
    Route::post('/daftar-poli', [DashboardController::class, 'storeAntrian'])->name('pasien.antrian.store');
    Route::get('/api/jadwal-by-poli/{id_poli}', [DashboardController::class, 'getJadwalByPoli']);
    Route::get('/pembayaran', [App\Http\Controllers\Pasien\PembayaranController::class, 'index'])->name('pasien.pembayaran.index');
    Route::post('/pembayaran/{id}/upload', [App\Http\Controllers\Pasien\PembayaranController::class, 'uploadBukti'])->name('pasien.pembayaran.upload');
});

