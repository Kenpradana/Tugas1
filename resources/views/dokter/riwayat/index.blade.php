<x-layouts.app title="Riwayat Pasien">
    <div class="p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Riwayat Pasien</h2>
            <p class="text-slate-500 mt-1">Menampilkan seluruh pasien yang telah Anda periksa.</p>
            <a href="{{ route('dokter.riwayat.export') }}" class="btn btn-success btn-sm gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export Riwayat Excel
            </a>
        </div>

        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">No Antrian</th>
                                <th class="px-6 py-4">Nama Pasien</th>
                                <th class="px-6 py-4">Keluhan</th>
                                <th class="px-6 py-4">Tanggal Periksa</th>
                                <th class="px-6 py-4">Biaya</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($periksas as $periksa)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-bold text-indigo-600">
                                    {{ $periksa->daftarPoli->no_antrian }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $periksa->daftarPoli->pasien->nama }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs">
                                    {{ Str::limit($periksa->daftarPoli->keluhan, 50) }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $periksa->tanggal_periksa->format('d M Y') }}  
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    {{-- Tombol Detail menuju riwayat lengkap si pasien --}}
                                    <a href="{{ route('dokter.riwayat.detail', $periksa->daftarPoli->pasien->id) }}" 
                                       class="btn btn-sm !bg-indigo-500 hover:!bg-indigo-600 text-white border-none rounded-lg px-4">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-14 text-slate-400">
                                    <i class="fas fa-clipboard-list text-3xl mb-3 block"></i>
                                    Belum ada riwayat pemeriksaan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>