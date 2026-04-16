<x-layouts.app title="Manajemen Dokter">
    <div class="p-6 bg-white min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Data Dokter</h2>
                <a href="{{ route('admin.export.dokter') }}" class="btn btn-success btn-sm gap-2" >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export Excel

                </a>
            <a href="{{ route('dokters.create') }}" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none rounded-lg px-5">
                <i class="fas fa-user-doctor"></i> Tambah Dokter
            </a>
        </div>

        <div class="card bg-base-100 shadow-sm border border-gray-100 rounded-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-4">No</th>
                                <th class="px-4 py-4">Nama Dokter</th>
                                <th class="px-4 py-4">No KTP</th>
                                <th class="px-4 py-4">No HP</th>
                                <th class="px-4 py-4">Alamat</th>
                                <th class="px-4 py-4">Poli</th>
                                <th class="px-4 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokters as $index => $dokter)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-4">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-slate-800">{{ $dokter->nama }}</div>
                                    <div class="text-xs text-slate-400">
                                        {{ $dokter->email }} 
                                        @if($dokter->poli) &bull; {{ $dokter->poli->nama_poli }} @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-600 font-mono text-sm">{{ $dokter->no_ktp }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $dokter->no_hp }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $dokter->alamat }}</td>
                                <td class="px-4 py-4 text-slate-600">
                                    @if($dokter->poli)
                                        <span class="badge bg-indigo-100 text-indigo-700 border-none font-medium px-3 py-1">
                                            {{ $dokter->poli->nama_poli }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Belum ada poli</span>
                                    @endif
                                <td class="px-4 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('dokters.edit', $dokter->id) }}" class="btn btn-sm !bg-amber-500 hover:!bg-amber-600 text-white border-none rounded-lg px-4">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('dokters.destroy', $dokter->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">
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
                                    <i class="fas fa-user-doctor text-3xl mb-3 block"></i>
                                    Belum ada data dokter
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