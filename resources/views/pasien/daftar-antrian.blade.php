<x-layouts.app title="Daftar Poli">

    <div class="p-6 max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-md rounded-2xl border border-gray-100">
            <div classankan class="card-body">
                <h2 class="card-title text-slate-800 mb-6">
                    <i class="fas fa-clipboard-list text-indigo-500"></i>
                    Formulir Pendaftaran Poli
                </h2>

                @if(session('error'))
                    <div class="alert alert-error mb-4"><span>{{ session('error') }}</span></div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-error mb-4">
                        <ul class="list-disc list-inside text-sm font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pasien.antrian.store') }}" method="POST" id="formDaftar">
                    @csrf
                    
                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">No Rekam Medis</label>
                        <input type="text" name="no_rekam_medis" value="{{ $noRekamMedis }}" class="input input-bordered w-full bg-slate-50 text-slate-500 font-mono" readonly>
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label font-semibold text-slate-700">Pilih Poli <span class="text-red-500">*</span></label>
                        <select name="poli_dummy" id="selectPoli" class="select select-bordered w-full" required>
                            <option value="" disabled selected>-- Pilih Poli --</option>
                            @foreach($polis as $poli)
                                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control w-full mb-4" id="containerJadwal" >
                        <label class="label font-semibold text-slate-700">Pilih Jadwal Periksa <span class="text-red-500">*</span></label>
                        <select name="id_jadwal" id="selectJadwal" class="select select-bordered w-full" required>
                            <option value="" disabled selected>-- Pilih Jadwal --</option>
                        </select>
                    </div>

                    <!-- KONTAINER UNTUK OBAT YANG DIPILIH -->
                    <div id="containerObat" style="display:none;" class="mb-4 space-y-2 min-h-[50px]"></div>

                    
                    <div class="mb-4 p-4 bg-slate-50 rounded-lg border" style="display:none;" id="containerTotalHarga">
                        <p class="text-lg font-bold text-slate-800">
                            Total Harga: <span id="totalHarga" class="text-indigo-600">Rp 0</span>
                        </p>
                    </div>

                    <div class="form-control w-full mb-6">
                        <label class="label font-semibold text-slate-700">Keluhan Anda <span class="text-red-500">*</span></label>
                        <textarea name="keluhan" class="textarea textarea-bordered h-24 w-full" placeholder="Jelaskan keluhan Anda..." required></textarea>
                    </div>

                    <!-- HIDDEN INPUT UNTUK MENGIRIM ID OBAT -->
                    <input type="hidden" name="obat_ids_input" id="obat_ids_input" value="">

                    <div class="card-actions justify-end">
                        <a href="{{ route('pasien.dashboard') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn bg-[#2d4499] hover:!bg-[#1e2d6b] text-white border-none px-8">
                            <i class="fas fa-paper-plane"></i> Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.app>

<!-- SCRIPT LANGSUNG TANPA  -->
<script>
    // 1. AMBIL ELEMEN BERDASARKAN ID
    const selectPoli = document.getElementById('selectPoli');
    const selectJadwal = document.getElementById('selectJadwal');
    const containerObat = document.getElementById('containerObat');
    const totalHarga = document.getElementById('totalHarga');
    const obatInput = document.getElementById('obat_ids_input');

    // 2. LOGI DROPDOWN POLI
    selectPoli.addEventListener('change', function() {
        const idPoli = this.value;
        
        selectJadwal.innerHTML = '<option value="" disabled selected>-- Memuat jadwal... --</option>';
        containerObat.innerHTML = '';
        obatInput.value = '';
        totalHarga.innerText = 'Rp 0';

        if (idPoli) {
            fetch(`/pasien/api/jadwal-by-poli/${idPoli}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    selectJadwal.innerHTML = '<option value="" disabled selected>-- Pilih Jadwal --</option>';
                    
                    if (data.length > 0) {
                        data.forEach(jadwal => {
                            const option = document.createElement('option');
                            option.value = jadwal.id;
                            option.textContent = 'Dr. ' + jadwal.dokter.nama + ' (' + jadwal.hari + ', Jam: ' + jadwal.jam_mulai + ' - ' + jadwal.jam_selesai + ')';
                            selectJadwal.appendChild(option);
                        });
                    } else {
                        selectJadwal.innerHTML = '<option value="" disabled selected>-- Tidak ada jadwal hari ini --</option>';
                    }
                })
                .catch(error => console.error('Gagal mengambil data jadwal:', error));
        }
    });

    // 3. LOGI TOMBOL TAMBAH OBAT
    document.addEventListener('DOMContentLoaded', function() {
        // Cari tombol "+ Tambah" secara manual agar tidak error
        const btnTambah = event.target.closest('form')?.querySelector('#btnTambah') || document.querySelector('#btnTambah');
        
        if (btnTambah) {
            btnTambah.addEventListener('click', function() {
                const selectedOption = selectJadwal.options[selectJadwal.selectedIndex];
                
                if (!selectedOption.value) {
                    alert('Silakan pilih jadwal periksa terlebih dahulu!');
                    return;
                }

                const isExist = Array.from(containerObat.children).some(child => child.dataset.obtId === selectedOption.value);
                if (isExist) {
                    alert('Obat ini sudah ditambahkan!');
                    return;
                }

                const row = document.createElement('div');
                row.className = 'flex items-center justify-between bg-white border rounded-lg p-3 shadow-sm';
                row.dataset.obtId = selectedOption.value;
                row.innerHTML = `
                    <span class="text-slate-700">${selectedOption.dataset.nama} <span class="text-slate-400">- Rp ${parseInt(selectedOption.dataset.harga).toLocaleString('id-ID')}</span></span>
                    <button type="button" class="btn btn-sm btn-circle btn-ghost text-red-500 hover:bg-red-50" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                containerObat.appendChild(row);

                // Hitung ulang total harga
                let total = 0;
                const rows = containerObat.querySelectorAll('div[data-obt-id]');
                const ids = [];
                rows.forEach(r => {
                    const hargaText = r.querySelector('span.text-slate-400').textContent;
                    const harga = parseInt(hargaText.replace(/[^\d]/g, ''));
                    total += harga;
                    ids.push(r.dataset.obtId);
                });

                totalHarga.innerText = 'Rp ' + total.toLocaleString('id-ID');
                obatInput.value = ids.join(',');
            });
        }
    });
</script>