<x-layouts.app title="Tambah Jadwal">
    <div class="p-6 max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">Tambah Jadwal Baru</h2>
                <form action="{{ route('dokter.jadwal.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Hari</label>
                        <select name="hari" class="select select-bordered w-full" required>
                            <option value="" disabled selected>-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="input input-bordered w-full" required>
                        </div>
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="input input-bordered w-full" required>
                        </div>
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>