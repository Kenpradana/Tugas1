    <x-layouts.app title="Periksa Pasien">

    <div class="p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Daftar Pasien Menunggu Periksa</h2>
            <p class="text-slate-500 mt-1">Menampilkan pasien yang mendaftar hari ini ({{ now()->locale('id')->dayName }})</p>
        </div>

        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Pasien</th>
                                <th class="px-6 py-4">Keluhan</th>
                                <th class="px-6 py-4">No Antrian</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrians as $antrian)
                            <tr class="hover:bg-slate-50 transition">
                                <!-- ID -->
                                <td class="px-6 py-4 font-mono text-sm text-slate-400">
                                    #{{ $antrian->id }}
                                </td>

                                <!-- Pasien -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">{{ $antrian->pasien->nama }}</div>
                                </td>

                                <!-- Keluhan -->
                                <td class="px-6 py-4 text-slate-500 max-w-xs">
                                    {{ $antrian->keluhan }}
                                </td>

                                <!-- No Antrian -->
                                <td class="px-6 py-4">
                                    <span class="badge badge-lg bg-indigo-100 text-indigo-700 border-none font-bold">
                                        {{ $antrian->no_antrian }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-right">
                                    {{-- Tombol ini nanti akan kita hubungkan ke form input rekam medis & resep obat --}}
                                    <!-- Ganti href="#" menjadi ini -->
                                    <a href="{{ route('dokter.periksa.create', $antrian->id) }}" class="btn btn-sm !bg-green-500 hover:!bg-green-600 text-white border-none rounded-lg px-4">
                                        <i class="fas fa-notes-medical"></i>
                                        Periksa
                                    </a>    
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-14 text-slate-400">
                                    <i class="fas fa-check-circle text-3xl mb-3 block text-green-300"></i>
                                    Tidak ada pasien yang menunggu untuk diperiksa.
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