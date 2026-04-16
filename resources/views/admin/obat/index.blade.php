<x-layouts.app title="Manajemen Obat">
    <div class="p-6 bg-white min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen Obat</h2>
                <p class="text-slate-500 text-sm mt-1">Indikator merah muncul jika stok di bawah {{ $batasStok }}.</p>
            </div>
            <a href="{{ route('admin.export.obat') }}" class="btn btn-success btn-sm gap-2" >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export Excel

                </a>
            <a href="{{ route('obats.create') }}" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none rounded-lg px-5">
                <i class="fas fa-plus"></i> Tambah Obat
            </a>
        </div>

        <div class="card bg-base-100 shadow-sm border border-gray-100 rounded-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4">Nama Obat</th>
                                <th class="px-6 py-4">Kemasan</th>
                                <th class="px-6 py-4">Harga</th>
                                <th class="px-6 py-4">Stok</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($obats as $obat)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $obat->nama_obat }}</td>
                                <td class="px-6 py-4 text-slate-500">
                                    <span class="badge bg-indigo-100 text-indigo-700 border-none font-medium px-3 py-1">
                                        {{ $obat->kemasan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                
                                {{-- INDIKATOR STOK --}}
                                <td class="px-6 py-4">
                                    @if($obat->stok <= $batasStok)
                                        <span class="badge bg-red-100 text-red-700 border-none font-bold px-3 py-1">
                                            <i class="fas fa-triangle-exclamation mr-1"></i> {{ $obat->stok }} (Menipis!)
                                        </span>
                                    @else
                                        <span class="badge bg-green-100 text-green-700 border-none font-bold px-3 py-1">
                                            {{ $obat->stok }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('obats.edit', $obat->id) }}" class="btn btn-sm !bg-amber-500 hover:!bg-amber-600 text-white border-none rounded-lg px-4">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('obats.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
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
                                    <i class="fas fa-pills text-3xl mb-3 block"></i>
                                    Belum ada data obat.
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