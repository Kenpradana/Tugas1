<x-layouts.app title="Tambah Dokter">
    <div class="p-6 max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">Tambah Dokter Baru</h2>
                @if($errors->any())
                    <div class="alert alert-error mb-4"><ul class="list-disc list-inside text-sm">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <form action="{{ route('dokters.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Nama Dokter <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" placeholder="Masukkan nama lengkap" class="input input-bordered w-full" value="{{ old('nama') }}" required>
                        </div>
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" placeholder="contoh@email.com" class="input input-bordered w-full" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">No KTP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_ktp" placeholder="16 digit angka" class="input input-bordered w-full" value="{{ old('no_ktp') }}" maxlength="16" required>
                        </div>
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">No HP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="input input-bordered w-full" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>
                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="alamat" class="textarea textarea-bordered h-24 w-full" placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                    </div>
                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Poli <span class="text-red-500">*</span></label>
                        <select name="id_poli" class="select select-bordered w-full" required>
                            <option value="" disabled selected>-- Pilih Poli --</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control w-full mb-6">
                        <label class="label font-semibold text-slate-700">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="input input-bordered w-full" required>
                    </div>
                    <div class="card-actions justify-end">
                        <a href="{{ route('dokters.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>