<x-layouts.app title="Edit Obat">
    <div class="p-6 max-w-2xl mx-auto bg-white min-h-screen">
        <div class="card bg-base-100 shadow-md rounded-2xl border border-gray-100">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">Edit Obat</h2>
                <form action="{{ route('obats.update', $obat->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- ← Yang ini penting -->

                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Nama Obat</label>
                        <input type="text" name="nama_obat" placeholder="Contoh: Paracetamol" class="input input-bordered w-full" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Kemasan</label>
                        <input type="text" name="kemasan" placeholder="Contoh: Tablet 500mg" class="input input-bordered w-full" value="{{ old('kemasan', $obat->kemasan) }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Harga</label>
                            <input type="number" name="harga" placeholder="0" class="input input-bordered w-full" value="{{ old('harga', $obat->harga) }}" required>
                        </div>
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Stok</label>
                            <input type="number" name="stok" placeholder="0" class="input input-bordered w-full" value="{{ old('stok', $obat->stok ?? 0) }}" required>
                        </div>
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('obats.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>