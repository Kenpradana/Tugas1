<x-layouts.app title="Verifikasi Pembayaran">
    <div class="container mt-4 text-center">
        <h3>Bukti Pembayaran dari {{ $pembayaran->periksa->daftarPoli->pasien->nama ?? 'N/A' }}</h3>
        <hr>
        
        <!-- Gambar Bukti Bayar -->
        <img src="{{ asset('storage/bukti_bayar/' . $pembayaran->bukti_bayar) }}" class="img-fluid rounded border p-2" style="max-width: 500px;" alt="Bukti Bayar">

        <div class="mt-4">
            <form action="{{ route('admin.pembayaran.konfirmasi', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                @csrf
                <button type="submit" class="btn btn-success btn-lg">Konfirmasi Lunas</button>
            </form>
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary btn-lg mt-2">Kembali</a>
        </div>
    </div>
</x-layouts.app>