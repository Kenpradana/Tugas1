<x-layouts.app title="Tambah Pasien">
    <div class="p-6 max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">
                    <i class="fas fa-user-plus text-indigo-500"></i>
                    Tambah Pasien Baru
                </h2>
                
                <!-- Pesan Error Validasi -->
                @if($errors->any())
                    <div class="alert alert-error mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pasiens.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Nama Pasien -->
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Nama Pasien <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" placeholder="Masukkan nama lengkap" class="input input-bordered w-full" value="{{ old('name') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" placeholder="contoh@email.com" class="input input-bordered w-full" value="{{ old('email') }}" required>
                        </div>

                        <!-- No KTP -->
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">No KTP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_ktp" placeholder="16 digit angka" class="input input-bordered w-full" value="{{ old('no_ktp') }}" maxlength="16" required>
                        </div>

                        <!-- No HP -->
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">No HP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="input input-bordered w-full" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="alamat" class="textarea textarea-bordered h-24 w-full" placeholder="Masukkan alamat lengkap (min. 10 karakter)" required>{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Password -->
                    <div class="form-control w-full mb-6">
                        <label class="label font-semibold text-slate-700">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="input input-bordered w-full" required>
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('pasiens.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn bg-[#2d4499] hover:bg-[#1e2d6b] text-white border-none">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>