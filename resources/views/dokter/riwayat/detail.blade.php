<x-layouts.app title="Detail Riwayat Pasien">
    <div class="p-6 max-w-4xl mx-auto">
        {{-- Header Kembali & Nama Pasien --}}
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('dokter.riwayat.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Detail Riwayat Medis</h2>
                <p class="text-slate-500">Pasien: <span class="font-semibold text-slate-700">{{ $pasien->nama }}</span> &mdash; {{ $pasien->no_hp }}</p>
            </div>
        </div>

        {{-- List Riwayat --}}
        <div class="space-y-6">
            @forelse($riwayats as $index => $riwayat)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

                {{-- === BAGIAN ATAS: No Registrasi === --}}
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-file-medical text-white text-lg"></i>
                        </div>
                        <div>
                            <p class="text-indigo-100 text-xs font-medium uppercase tracking-wider">Kunjungan Ke-{{ count($riwayats) - $index }}</p>
                            <p class="text-white font-bold text-lg">No. Registrasi: {{ $riwayat->daftarPoli->id ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-indigo-100 text-xs">{{ $riwayat->tanggal_periksa->format('d/m/Y') }}</p>
                        <p class="text-white font-semibold text-sm">{{ $riwayat->tanggal_periksa->format('H:i') }}</p>
                    </div>
                </div>

                {{-- === BAGIAN INFO UTAMA === --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">

                        {{-- Keluhan --}}
                        <div class="py-4 md:py-0 md:pr-5 first:md:pl-0 md:px-5">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 bg-amber-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-comment-medical text-amber-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Keluhan</p>
                            </div>
                            <p class="text-slate-800 font-medium text-sm leading-relaxed">
                                {{ $riwayat->daftarPoli->keluhan ?? '-' }}
                            </p>
                        </div>

                        {{-- Poli --}}
                        <div class="py-4 md:py-0 md:px-5">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hospital text-blue-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Poli</p>
                            </div>
                            <p class="text-slate-800 font-medium text-sm">
                                {{ $riwayat->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                dr. {{ $riwayat->daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }} 
                                &bull; Antrian No. {{ $riwayat->daftarPoli->no_antrian ?? '-' }}
                            </p>
                        </div>

                        {{-- Waktu Periksa --}}
                        <div class="py-4 md:py-0 md:pl-5 last:md:pr-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 bg-green-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-green-500 text-xs"></i>
                                </div>
                                <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Waktu Periksa</p>
                            </div>
                            <p class="text-slate-800 font-medium text-sm">
                                {{ $riwayat->tanggal_periksa->format('d/m/Y') }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">{{ $riwayat->tanggal_periksa->format('H:i') }} WIB</p>
                        </div>

                    </div>
                </div>

                {{-- === GARIS PEMISAH === --}}
                <div class="mx-6 border-t border-dashed border-gray-200"></div>

                {{-- === CATATAN DOKTER === --}}
                <div class="px-6 py-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-purple-500 text-xs"></i>
                        </div>
                        <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Catatan Dokter</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        @if($riwayat->catatan)
                            <p class="text-slate-700 text-sm leading-relaxed">{{ $riwayat->catatan }}</p>
                        @else
                            <p class="text-slate-400 text-sm italic">Tidak ada catatan.</p>
                        @endif
                    </div>
                </div>

                {{-- === GARIS PEMISAH === --}}
                <div class="mx-6 border-t border-dashed border-gray-200"></div>

                {{-- === RESEP OBAT === --}}
                <div class="px-6 py-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 bg-rose-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-rose-500 text-xs"></i>
                        </div>
                        <p class="text-xs text-slate-400 uppercase font-semibold tracking-wide">Resep Obat</p>
                    </div>

                    @if($riwayat->detailPeriksas->count() > 0)
                        <div class="space-y-2">
                            @foreach($riwayat->detailPeriksas as $detail)
                            <div class="flex items-center justify-between bg-indigo-50/50 rounded-xl px-4 py-3 border border-indigo-100/60">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-capsules text-indigo-500 text-sm"></i>
                                    </div>
                                    <span class="text-slate-800 font-medium text-sm">
                                        {{ $detail->obat->nama_obat ?? 'Obat Dihapus' }}
                                    </span>
                                </div>
                                <span class="text-slate-600 font-semibold text-sm">
                                    Rp {{ number_format($detail->obat->harga ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 italic pl-11">Tidak diberikan resep obat.</p>
                    @endif
                </div>

                {{-- === TOTAL BIAYA === --}}
                <div class="bg-slate-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-slate-500 font-semibold text-sm">
                        <i class="fas fa-receipt mr-2 text-slate-400"></i>Total Biaya Periksa
                    </span>
                    <span class="text-indigo-600 font-extrabold text-xl">
                        Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}
                    </span>
                </div>

            </div>
            @empty
                <div class="text-center py-20 text-slate-400">
                    <i class="fas fa-notes-medical text-4xl mb-3 block"></i>
                    <p class="text-lg">Belum ada riwayat pemeriksaan untuk pasien ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>