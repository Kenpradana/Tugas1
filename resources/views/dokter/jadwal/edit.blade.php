<x-layouts.app title="Edit Jadwal">
    <div class="p-6 max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                <h2 class="card-title text-slate-800 mb-4">Edit Jadwal</h2>
                <form action="{{ route('dokter.jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Hari</label>
                        <select name="hari" class="select select-bordered w-full" required>
                            @php $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                            @foreach($hari as $h)
                                <option value="{{ $h }}" {{ $h == $jadwal->hari ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="input input-bordered w-full" value="{{ $jadwal->jam_mulai }}" required>
                        </div>
                        <div class="form-control w-full">
                            <label class="label font-semibold text-slate-700">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="input input-bordered w-full" value="{{ $jadwal->jam_selesai }}" required>
                        </div>
                    </div>

                    <div class="card-actions justify-end">
                        <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn !bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>