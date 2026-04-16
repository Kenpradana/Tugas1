<x-layouts.app title="Verifikasi Pembayaran">
    <div class="container mt-4">
        <h2>Verifikasi Pembayaran</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Poli</th>
                    <th>Tanggal Periksa</th>
                    <th>Bukti Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayarans as $bayar)
                <tr>
                    <td>{{ $bayar->periksa->daftarPoli->pasien->nama ?? 'N/A' }}</td>
                    
                    {{-- DITAMBAHKAN DOKTER --}}
                    <td>{{ $bayar->periksa->daftarPoli->jadwalPeriksa->dokter->nama ?? 'N/A' }}</td>
                    
                    {{-- DIPERBAIKI: DITAMBAHKAN jadwalPeriksa --}}
                    <td>{{ $bayar->periksa->daftarPoli->jadwalPeriksa->poli->nama_poli ?? 'N/A' }}</td>
                    
                    <td>{{ $bayar->periksa->tanggal_periksa->format('d-m-Y') }}</td>
                    <td>
                        @if($bayar->bukti_bayar)
                            <a href="{{ route('admin.pembayaran.show', $bayar->id) }}" class="btn btn-sm btn-info">Lihat Bukti</a>
                        @else
                            <span class="text-danger">Belum upload</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.pembayaran.konfirmasi', $bayar->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran ini?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Konfirmasi Lunas</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>