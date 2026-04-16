<x-layouts.app title="Periksa Pasien">

    <div class="p-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-slate-800 mb-1">Periksa Pasien</h2>
        <p class="text-slate-500 mb-6">Nama: <span class="font-semibold text-slate-700">{{ $daftarPoli->pasien->nama }}</span> &mdash; Keluhan: {{ $daftarPoli->keluhan }}</p>

        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body">
                
                <form action="{{ route('dokter.periksa.store', $daftarPoli->id) }}" method="POST" id="formPeriksa">
                    @csrf

                    {{-- INPUT TERSEMBUNYI UNTUK MENGIRIM DATA OBAT KE SERVER --}}
                    <input type="hidden" name="obat_ids" id="obat_ids_input" value="">

                    {{-- DROPDOWN PILIH OBAT --}}
                    <div class="mb-4">
                        <label class="label font-semibold text-slate-700">Pilih Obat <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <select id="selectObat" class="select select-bordered flex-1">
                                <option value="" disabled selected>-- Pilih Obat --</option>
                                @foreach($obats as $obat)
                                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}" data-nama="{{ $obat->nama_obat }}">
                                        {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" id="btnTambah" class="btn bg-indigo-500 hover:bg-indigo-600 text-white border-none">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    {{-- DAFTAR OBAT TERPILIH --}}
                    <div id="containerObat" class="mb-4 space-y-2 min-h-[50px]">
                        <!-- Obat yang dipilih akan muncul di sini oleh JavaScript -->
                    </div>

                    {{-- TOTAL HARGA --}}
                    <div class="mb-6 p-4 bg-slate-50 rounded-lg border">
                        <p class="text-lg font-bold text-slate-800">
                            Total Harga: <span id="totalHarga" class="text-indigo-600">Rp 0</span>
                        </p>
                    </div>

                    {{-- CATATAN --}}
                    <div class="form-control w-full mb-6">
                        <label class="label font-semibold text-slate-700">Catatan (Optional)</label>
                        <textarea name="catatan" class="textarea textarea-bordered h-28 w-full" placeholder="Catatan hasil pemeriksaan dokter..."></textarea>
                    </div>

                    {{-- TOMBOL SIMPAN & BATAL --}}
                    <div class="card-actions justify-end">
                        <a href="{{ route('dokter.periksa.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn bg-green-500 hover:bg-green-600 text-white border-none px-8">
                            <i class="fas fa-check"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-layouts.app>


<script>
        let selectedObats = [];
        
        const selectEl = document.getElementById('selectObat');
        const containerEl = document.getElementById('containerObat');
        const totalEl = document.getElementById('totalHarga');
        const hiddenInput = document.getElementById('obat_ids_input');
        const formPeriksa = document.getElementById('formPeriksa');

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }

        function renderObat() {
            containerEl.innerHTML = ''; 
            let total = 0;

            selectedObats.forEach((obat, index) => {
                total += parseInt(obat.harga);
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between bg-white border rounded-lg p-3 shadow-sm';
                row.innerHTML = `
                    <span class="text-slate-700">${obat.nama} <span class="text-slate-400">- ${formatRupiah(obat.harga)}</span></span>
                    <button type="button" onclick="hapusObat(${index})" class="btn btn-sm btn-circle btn-ghost text-red-500 hover:bg-red-50">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                containerEl.appendChild(row);
            });

            totalEl.innerText = formatRupiah(total);
            hiddenInput.value = selectedObats.map(o => o.id).join(',');
        }

        function hapusObat(index) {
            selectedObats.splice(index, 1);
            renderObat();
        }

        document.getElementById('btnTambah').addEventListener('click', function() {
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            
            if (!selectedOption.value) {
                alert('Silakan pilih obat terlebih dahulu!');
                return;
            }

            const isExist = selectedObats.some(o => o.id === selectedOption.value);
            if (isExist) {
                alert('Obat ini sudah ditambahkan!');
                return;
            }

            selectedObats.push({
                id: selectedOption.value,
                nama: selectedOption.dataset.nama,
                harga: selectedOption.dataset.harga
            });

            renderObat();
            selectEl.selectedIndex = 0;
        });

        // VALIDASI YANG SUDAH DIPERBAIKI (Hanya cek jika obat kosong)
        formPeriksa.addEventListener('submit', function(e) {
            if (selectedObats.length === 0) {
                e.preventDefault();
                alert('Anda belum menambahkan obat!');
            }
        });
</script>
