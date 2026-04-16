<x-layouts.app title="Pembayaran Saya">
    <div class="container mt-4">
        <h2>Tagihan Pemeriksaan</h2>
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Tanggal Periksa</th>
                    <th>Poli</th>
                    <th>Dokter</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarPolis as $dp)
                    @foreach($dp->periksas as $periksa)
                    <tr>
                        <td>{{ $periksa->tanggal_periksa->format('d-m-Y') }}</td>
                        
                        {{-- PERHATIKAN BAGIAN INI: jadwalPeriksa->poli --}}
                        <td>{{ $dp->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</td>
                        <td>{{ $dp->jadwalPeriksa->dokter->nama ?? '-' }}</td>
                        
                        {{-- PERHATIKAN BAGIAN INI: jadwalPeriksa->dokter --}}
                        <td>{{ $dp->jadwalPeriksa->dokter->nama }}</td>
                        
                        <td>Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
                        <td>
                            @if($periksa->pembayaran && $periksa->pembayaran->status == 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                            @endif
                        </td>
                        <td>
                            @if($periksa->pembayaran && $periksa->pembayaran->status == 'menunggu' && !$periksa->pembayaran->bukti_bayar)
                                <form action="{{ route('pasien.pembayaran.upload', $periksa->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="bukti_bayar" accept="image/*" required class="form-control form-control-sm mb-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Upload Bukti</button>
                                </form>
                            @elseif($periksa->pembayaran && $periksa->pembayaran->bukti_bayar && $periksa->pembayaran->status == 'menunggu')
                                <span class="text-info"><i>Menunggu konfirmasi Admin</i></span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>