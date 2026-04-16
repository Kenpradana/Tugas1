<x-layouts.app title="Edit Pasien">
    <div class="p-6 max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">
                    <i class="fas fa-pen text-indigo-500"></i>
                    Edit Data Pasien
                </h2>
                
                @if($errors->any())
                    <div class="alert alert-error mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pasiens.update', $pasien->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Nama Pasien <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" class="input input-bordered w-full" value="{{ old('nama', $pasien->nama) }}" required>
                        </div>

                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" class="input input-bordered w-full" value="{{ old('email', $pasien->email) }}" required>
                        </div>

                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">No KTP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_ktp" class="input input-bordered w-full" value="{{ old('no_ktp', $pasien->no_ktp) }}" maxlength="16" required>
                        </div>

                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">No HP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" class="input input-bordered w-full" value="{{ old('no_hp', $pasien->no_hp) }}" required>
                        </div>
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="alamat" class="textarea textarea-bordered h-24 w-full" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                    </div>

                    <div class="form-control w-full mb-6">
                        <label class="label font-semibold text-slate-700">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="input input-bordered w-full">
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('pasiens.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn bg-[#2d4499] hover:bg-[#1e2d6b] text-white border-none">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>