<x-layouts.app title="Dokter Dashboard">

    <div class="p-6 space-y-6">

        {{-- Header Selamat Datang --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, Dokter 👋</h1>
            <p class="text-slate-500 mt-1">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Total Jadwal -->
            <div class="card bg-base-100 shadow-md border-l-4 border-l-blue-500">
                <div class="card-body flex-row items-center justify-between p-5">
                    <div>
                        <p class="text-slate-500 text-sm">Total Jadwal</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalJadwal }}</h2>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-500 text-2xl">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <!-- Pasien Menunggu -->
            <div class="card bg-base-100 shadow-md border-l-4 border-l-yellow-500">
                <div class="card-body flex-row items-center justify-between p-5">
                    <div>
                        <p class="text-slate-500 text-sm">Pasien Menunggu</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $pasienMenunggu }}</h2>
                    </div>
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-500 text-2xl">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <!-- Total Riwayat -->
            <div class="card bg-base-100 shadow-md border-l-4 border-l-green-500">
                <div class="card-body flex-row items-center justify-between p-5">
                    <div>
                        <p class="text-slate-500 text-sm">Total Riwayat</p>
                        <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalRiwayat }}</h2>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center text-green-500 text-2xl">
                        <i class="fas fa-file-medical"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- Grid Bawah: Jadwal & Akses Cepat --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tabel Jadwal (Lebar) -->
            <div class="lg:col-span-2 card bg-base-100 shadow-md border">
                <div class="card-body">
                    <h2 class="card-title text-slate-800 mb-4">
                        <i class="fas fa-stethoscope text-indigo-500"></i> Jadwal Periksa
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwals as $jadwal)
                                <tr>
                                    <td class="font-semibold">{{ $jadwal->hari }}</td>
                                    <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center text-slate-400 py-6">Belum ada jadwal.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="card bg-base-100 shadow-md border">
                <div class="card-body">
                    <h2 class="card-title text-slate-800 mb-4">
                        <i class="fas fa-bolt text-amber-500"></i> Akses Cepat
                    </h2>
                    <div class="space-y-3">
                        {{-- Tombol-tombol akses cepat bisa ditambahkan nanti saat fitur lain jadi --}}
                        <button class="btn btn-block btn-outline btn-sm justify-start">
                            <i class="fas fa-user-clock text-blue-500 w-5"></i> Lihat Antrian Hari Ini
                        </button>
                        <button class="btn btn-block btn-outline btn-sm justify-start">
                            <i class="fas fa-notes-medical text-green-500 w-5"></i> Input Rekam Medis
                        </button>
                        <button class="btn btn-block btn-outline btn-sm justify-start">
                            <i class="fas fa-capsules text-purple-500 w-5"></i> Stok Obat
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- TAMBAHAN PENTING: Tabel Antrian Pasien Hari Ini --}}
        <div class="card bg-base-100 shadow-md border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">
                    <i class="fas fa-list-ol text-indigo-500"></i> Antrian Pasien Hari Ini ({{ now()->locale('id')->dayName }})
                </h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th>No</th>
                                <th>No Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrians as $index => $antrian)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-bold text-indigo-600">{{ $antrian->no_antrian }}</td>
                                <td class="font-semibold">{{ $antrian->pasien->nama }}</td>
                                <td>{{ $antrian->keluhan }}</td>
                                <td>
                                    @if($antrian->periksas->count() > 0)
                                        <span class="badge bg-green-100 text-green-700 border-none">Selesai</span>
                                    @else
                                        <span class="badge bg-yellow-100 text-yellow-700 border-none">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-slate-400 py-10">
                                    Tidak ada pasien yang mendaftar hari ini.
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