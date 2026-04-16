<x-layouts.app title="Jadwal Periksa">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Jadwal Periksa Saya</h2>
            <a href="{{ route('dokter.jadwal.export') }}" class="btn btn-success btn-sm gap-2" >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export Excel

                </a>
            <a href="{{ route('dokter.jadwal.create') }}" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none rounded-lg px-5">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>

        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4">Hari</th>
                                <th class="px-6 py-4">Dokter</th>
                                <th class="px-6 py-4">Jam Mulai</th>
                                <th class="px-6 py-4">Jam Selesai</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $jadwal)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-4">{{ $jadwal->dokter->nama }}</td>
                                <td class="px-6 py-4">{{ $jadwal->jam_mulai }}</td>
                                <td class="px-6 py-4">{{ $jadwal->jam_selesai }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('dokter.jadwal.edit', $jadwal->id) }}" class="btn btn-sm !bg-amber-500 hover:!bg-amber-600 text-white border-none rounded-lg px-4">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm !bg-red-500 hover:!bg-red-600 text-white border-none rounded-lg px-4">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-14 text-slate-400">
                                    Belum ada jadwal periksa.
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