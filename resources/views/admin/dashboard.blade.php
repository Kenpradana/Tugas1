<x-layouts.app title="Admin Dashboard">

    {{-- TAMBAHAN: Paksa background area konten jadi putih/terang --}}
    <div class="p-6 bg-white min-h-screen">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, Admin 👋</h1>
            {{-- Gunakan format Bahasa Inggris sesuai foto --}}
            <p class="text-slate-500 mt-1 text-sm">{{ now()->format('l, d F Y') }}</p>
        </div>

                {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Poli (Biru) -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-hospital"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <span class="text-3xl font-bold text-slate-800">{{ $totalPoli }}</span>
                        <a href="{{ route('polis.index') }}" class="text-xs text-indigo-500 font-semibold hover:underline">Lihat</a>
                    </div>
                    <p class="text-slate-600 text-sm font-medium mt-1">Total Poli</p>
                    <div class="w-8 h-1 bg-blue-500 rounded-full mt-2"></div>
                </div>
            </div>

            <!-- Total Dokter (Hijau) -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 text-green-500 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-user-doctor"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <span class="text-3xl font-bold text-slate-800">{{ $totalDokter }}</span>
                        <a href="#" class="text-xs text-indigo-500 font-semibold hover:underline">Lihat</a>
                    </div>
                    <p class="text-slate-600 text-sm font-medium mt-1">Total Dokter</p>
                    <div class="w-8 h-1 bg-green-500 rounded-full mt-2"></div>
                </div>
            </div>

            <!-- Total Pasien (Oranye) -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-briefcase-medical"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <span class="text-3xl font-bold text-slate-800">{{ $totalPasien }}</span>
                        <a href="{{ route('pasiens.index') }}" class="text-xs text-indigo-500 font-semibold hover:underline">Lihat</a>
                    </div>
                    <p class="text-slate-600 text-sm font-medium mt-1">Total Pasien</p>
                    <div class="w-8 h-1 bg-orange-500 rounded-full mt-2"></div>
                </div>
            </div>

            <!-- Total Obat (Pink) -->
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-pink-50 text-pink-500 rounded-lg flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fas fa-pills"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <span class="text-3xl font-bold text-slate-800">{{ $totalObat }}</span>
                        <a href="#" class="text-xs text-indigo-500 font-semibold hover:underline">Lihat</a>
                    </div>
                    <p class="text-slate-600 text-sm font-medium mt-1">Total Obat</p>
                    <div class="w-8 h-1 bg-pink-500 rounded-full mt-2"></div>
                </div>
            </div>

        </div>

        {{-- Grid Bawah: Tabel & Akses Cepat --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tabel Daftar Poli -->
            <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-800">Daftar Poli</h2>
                    <a href="{{ route('polis.index') }}" class="text-sm text-indigo-600 font-medium hover:underline">Lihat Semua</a>
                </div>
                <div class="p-6">
                    <table class="table w-full">
                        <thead>
                            <tr class="text-slate-500 text-sm">
                                <th class="pb-3 text-left font-medium">Nama Poli</th>
                                <th class="pb-3 text-left font-medium">Keterangan</th>
                                <th class="pb-3 text-left font-medium">Dokter</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-700 text-sm">
                            @forelse($polis as $poli)
                            <tr class="border-t border-gray-50">
                                <td class="py-4 font-semibold">{{ $poli->nama_poli }}</td>
                                <td class="py-4 text-slate-500">{{ $poli->keterangan ?? '-' }}</td>
                                
                                {{-- TAMPILKAN DOKTER --}}
                                <td class="py-4 text-slate-500">
                                    @if($poli->dokters->count() > 0)
                                        {{ $poli->dokters->pluck('nama')->join(', ') }}
                                    @else
                                        <span class="text-slate-400 italic">Belum ada dokter</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400">Belum ada data poli.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

             <!-- Akses Cepat -->
            <div class="card bg-base-100 shadow-md border">
                <div class="card-body">
                    <h2 class="card-title text-slate-800 mb-4">
                        <i class="fas fa-bolt text-amber-500"></i> Akses Cepat
                    </h2>
                     <div class="p-4 space-y-1">
                        <a href="{{ route('polis.create') }}" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition duration-200 cursor-pointer">
                            <i class="fas fa-plus-circle w-5 text-center text-slate-400 group-hover:text-indigo-500"></i>
                            <span class="text-sm font-medium">Tambah Poli Baru</span>
                        </a>
                        <a href="{{ route('pasiens.create') }}" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition duration-200 cursor-pointer">
                            <i class="fas fa-user-plus w-5 text-center text-slate-400"></i>
                            <span class="text-sm font-medium">Tambah Pasien Baru</span>
                        </a>
                        <a href="{{ route('dokters.index') }}" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition duration-200 cursor-pointer">
                        <i class="fas fa-user-doctor w-5 text-center text-slate-400"></i>
                        <span class="text-sm font-medium">Manajemen Dokter</span>
                        </a>
                        <a href="{{ route('obats.index') }}" class="flex items-center gap-3 p-3 rounded-lg text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition duration-200 cursor-pointer">
                        <i class="fas fa-capsules w-5 text-center text-slate-400"></i>
                        <span class="text-sm font-medium">Manajemen Obat</span>
                    </a>
                </div>
                </div>
            </div>

        </div>

    </div>

</x-layouts.app>