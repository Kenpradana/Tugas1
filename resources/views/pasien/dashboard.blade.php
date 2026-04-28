<x-layouts.app title="Dashboard Pasien">

    <div class="p-6 space-y-6">

        {{-- ================= BANNER ANTRIAN AKTIF PASIEN ================= --}}
        @if($myQueue)
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
            <h2 class="text-lg opacity-80 mb-2">Anda Sedang Dalam Antrian</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">Poli {{ $myQueue->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</p>
                    <p class="text-md mt-1">Dokter: {{ $myQueue->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                    <p class="text-sm mt-2 opacity-80">Keluhan: {{ $myQueue->keluhan }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm opacity-80">Nomor Antrian Anda</p>
                    <p class="text-6xl font-black">{{ $myQueue->no_antrian }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="bg-slate-100 border border-slate-200 rounded-2xl p-6 text-center text-slate-500">
            <i class="fas fa-calendar-xmark text-3xl mb-2 block"></i>
            Anda belum memiliki antrian aktif hari ini.

            <div class="mt-4">
                <a href="{{ route('pasien.antrian.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white border-none">
                    <i class="fas fa-plus"></i> Daftar Poli Sekarang
                </a>
            </div>
        </div>
        @endif

        {{-- ================= TABEL ANTRIAN SEMUA POLI ================= --}}
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">
                    <i class="fas fa-hospital text-indigo-500"></i>
                    Jadwal & Antrian Poli Hari Ini
                </h2>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-slate-500 text-xs uppercase">
                            <tr>
                                <th>No</th>
                                <th>Nama Poli</th>
                                <th>Dokter</th>
                                <th>Jam Periksa</th>
                                <th>Nomor Dilayani</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $index => $jadwal)
                            <tr class="hover">
                                <td>{{ $index + 1 }}</td>
                                <td class="font-semibold text-slate-800">{{ $jadwal->dokter->poli->nama_poli ?? '-' }}</td>
                                <td>{{ $jadwal->dokter->nama ?? '-' }}</td>
                                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                
                                <td>
                                    @php
                                        $nomorSekarang = \App\Models\DaftarPoli::where('id_jadwal', $jadwal->id)
                                                            ->whereHas('periksas')
                                                            ->max('no_antrian');
                                    @endphp
                                    
                                    <span class="badge badge-lg bg-green-500 text-white border-none font-bold" id="serving-{{ $jadwal->id }}">
                                        {{ $nomorSekarang ?? 'Belum Mulai' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-14 text-slate-400">
                                    <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                    Tidak ada jadwal poli hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

                {{-- POP UP NOTIFIKASI --}}
    <div id="popup-giliran-saya" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden" style="backdrop-filter: blur(4px);">
        <div class="bg-white p-10 rounded-3xl shadow-2xl text-center border-t-8 border-green-500 max-w-sm mx-4">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-bell text-green-500 text-3xl animate-bounce"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-2">Sudah Giliran Anda!</h2>
            <p class="text-slate-500 mb-1">Silakan segera menuju ruang poli</p>
            <p class="text-xl font-bold text-indigo-600 mt-4" id="popup-isi-poli"></p>
            <button onclick="document.getElementById('popup-giliran-saya').classList.add('hidden')" class="btn btn-success mt-8 w-full text-white border-none">Baik, Saya Menuju Poli</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0-rc2/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
        // TAMBAHKAN INI: Variable penanda bahwa halaman sudah aman (lebih dari 2 detik)
        let halamanSudahSiap = false;
        setTimeout(function() {
            halamanSudahSiap = true;
        }, 2000); // 2000 milidetik = 2 detik

        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ config("broadcasting.connections.reverb.key") }}',
            wsHost: '127.0.0.1', 
            wsPort: 8080,
            wssPort: 443,
            forceTLS: false,
            enabledTransports: ['ws'],
        });

        window.Echo.channel('antrian-poliklinik')
            .listen('.antrian-update', function(e) {
                
                // 1. UPDATE TABEL: Ini boleh langsung berubah kapanpun (aman)
                const badge = document.getElementById('serving-' + e.jadwalId);
                if (badge) {
                    badge.innerText = e.nomorSekarang;
                    badge.classList.remove('bg-green-500');
                    badge.classList.add('bg-yellow-500', 'animate-pulse');
                    setTimeout(() => {
                        badge.classList.remove('bg-yellow-500', 'animate-pulse');
                        badge.classList.add('bg-green-500');
                    }, 3000);
                }

                // 2. POP UP: WAJIB cek apakah halaman sudah siap (anti bug saat pertama kali buka)
                if (halamanSudahSiap) {
                    const myJadwalId = "{{ $myQueue?->id_jadwal ?? '' }}";
                    const myNomorAntrian = "{{ $myQueue?->no_antrian ?? '' }}";
                    const myNamaPoli = "{{ $myQueue?->jadwalPeriksa?->dokter?->poli?->nama_poli ?? '' }}";

                    if (myJadwalId && e.jadwalId == myJadwalId && e.nomorSekarang == myNomorAntrian) {
                        document.getElementById('popup-isi-poli').innerText = 'Poli ' + myNamaPoli;
                        document.getElementById('popup-giliran-saya').classList.remove('hidden');
                    }
                }
            });
    </script>

</x-layouts.app>