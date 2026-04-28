<!-- Main Content Area -->
<main class="py-6 min-h-screen bg-surface-container-low">
    <div class="mx-auto space-y-8">
        <!-- Read-only Summary Card -->
        <section class="bg-white border border-slate-200 rounded-xl p-6 flex flex-wrap items-center gap-8 shadow-sm">
            <div class="flex items-center gap-4 border-r border-slate-100 pr-8">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    {{-- <span class="material-symbols-outlined text-2xl" data-icon="laptop_mac">laptop_mac</span> --}}
                    <i class="fa-solid fa-box text-2xl"></i>

                </div>
                <div>
                    <p class="text-label-xs font-label-xs text-slate-500 font-bold">Nama item</p>
                    <p class="text-heading-card font-heading-card text-slate-900">{{ $pengadaan->nama_item }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-1 border-r border-slate-100 pr-8">
                <p class="text-label-xs font-label-xs text-slate-500 font-bold">Total Qty</p>
                <div class="flex items-baseline gap-1">
                    <p class="text-heading-card font-heading-card text-slate-900">{{ $pengadaan->qty_item }}</p>
                    <span class="text-xs text-slate-500">Units</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <p class="text-label-xs font-label-xs text-slate-500 font-bold">Tahun Pengajuan</p>
                <div class="flex items-center gap-2">
                    <p class="text-body-md font-body-md text-slate-700">{{ $pengadaan->tahun_akademik }}</p>
                </div>
            </div>
            <div class="ml-auto">
                <div
                    class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-blue-100 uppercase tracking-wider">
                    menunggu dialokasikan
                </div>
            </div>
        </section>
        <!-- Main Allocation Section -->
        <section class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-heading-card font-heading-card text-slate-900">Distribusi Barang</h3>
                    <p class="text-xs text-slate-500 mt-0.5">masukkan data barang dan qty di ruangan yang spesifik</p>
                </div>
                <div class="text-right">
                    <p class="text-label-xs font-label-xs text-slate-500 uppercase mb-1 text-right">Alokasi
                        Progress</p>
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-900"></span>
                        <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-primary h-full rounded-full" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="p-6 space-y-4">
                <!-- Table Header -->
                <div
                    class="grid grid-cols-12 gap-4 px-4 py-2 bg-slate-50 rounded-lg text-table-header font-table-header text-slate-500 uppercase">
                    <div class="col-span-4">Pilih Ruangan Menyimpan</div>
                    <div class="col-span-3">jumlah barang</div>
                    <div class="col-span-4">Kondisi</div>
                    <div class="col-span-1 text-center">Aksi</div>
                </div>
                <!-- Row 1 -->
                <div class="grid grid-cols-12 gap-4 px-4 py-1 items-center">
                    <div class="col-span-4 relative">
                        <i
                            class="absolute left-3 top-1/2 -translate-y-1/2 fa-solid fa-door-open text-blue-600 text-lg"></i>

                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>Computer Lab A (Room 402)</option>
                            <option>Main Library (Floor 2)</option>
                            <option>Faculty Office (South)</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input
                            class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none"
                            type="number" value="5" />
                    </div>
                    <div class="col-span-4 relative">
                        <i
                            class="absolute left-3 top-1/2 -translate-y-1/2 fa-solid fa-circle-check text-blue-600 text-lg"></i>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>New</option>
                            <option>Good</option>
                            <option>Damaged</option>
                        </select>
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <button class="p-2 text-red-600 cursor-not-allowed">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex  justify-start">
                    <button
                        class="flex rounded-md! items-center gap-2 text-xs font-bold text-white bg-blue-600 hover:opacity-90 px-4 py-2 transition-colors">
                        <i class="fa-solid fa-circle-plus"></i>
                        + Tambah Ruangan lain
                    </button>
                </div>
            </div> --}}

            <form action="{{ route('simpan-distribusi', base64_encode($pengadaan->id_pengadaan)) }}" method="post">
                @csrf
                <!-- main Section -->
                <div id="allocation-container" class="p-6 space-y-4">
                    <div
                        class="grid grid-cols-12 gap-4 px-4 py-2 bg-slate-50 rounded-lg text-table-header font-table-header text-slate-500 uppercase">
                        <div class="col-span-4">Pilih Ruangan Menyimpan</div>
                        <div class="col-span-3">jumlah barang</div>
                        <div class="col-span-4">Kondisi</div>
                        <div class="col-span-1 text-center">Aksi</div>
                    </div>
    
                    <div class="allocation-row grid grid-cols-12 gap-4 px-4 py-1 items-center">
                        <div class="col-span-4 relative">
                            <i
                                class="absolute left-3 top-1/2 -translate-y-1/2 fa-solid fa-door-open text-blue-600 text-lg"></i>
                            <select name="ruangan[]"
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
    
                                @foreach ($AllRoom as $r)
                                    <option value="{{ $r->id_room }}">{{ $r->nama_room }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="col-span-3">
                            <input name="qty[]"
                                class="qty-input w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none"
                                type="number" value="1" min="1" />
                            <input name="nama_item" hidden
                                class="qty-input w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none"
                                type="text" value="{{ $pengadaan->nama_item }}" />
                            <input name="merk_model" hidden
                                class="qty-input w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none"
                                type="text" value="{{ $pengadaan->merek_model }}" />
                        </div>
    
                        <div class="col-span-4 relative">
                            <i
                                class="absolute left-3 top-1/2 -translate-y-1/2 fa-solid fa-circle-check text-blue-600 text-lg"></i>
                            <select name="kondisi[]"
                                class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                                {{-- <option value="New">New</option> --}}
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
    
                        <div class="col-span-1 flex justify-center">
                            <button type="button"
                                class="btn-remove p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                    <div class="pt-6 border-t border-slate-100 flex  justify-start">
                        <button id="btn-add-room" type="button"
                            class="flex rounded-md! items-center gap-2 text-xs font-bold text-white bg-blue-600 hover:opacity-90 px-4 py-2 transition-colors">
                            <i class="fa-solid fa-circle-plus"></i>
                            + Tambah Ruangan lain
                        </button>
                    </div>
                </div>

                <!-- Footer Section -->
                <div class="bg-slate-50 p-6 flex items-center justify-between mt-8">
                    <button
                        class="px-6 py-2 border border-slate-300 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 transition-all flex items-center gap-2">
                        {{-- <span class="material-symbols-outlined text-sm" data-icon="arrow_back">arrow_back</span> --}}
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                        Back
                    </button>
                    <div class="flex items-center gap-3">
                        {{-- <div class="text-right mr-4">
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-none mb-1">
                                Items To Confirm</p>
                            <p class="text-sm font-black text-slate-900">30 Units Allocated</p>
                        </div> --}}
                        <button
                            class="px-8 py-2.5 bg-blue-600 text-white rounded-lg! text-sm font-bold shadow-lg shadow-tertiary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2">
                            {{-- <span class="material-symbols-outlined text-lg" data-icon="check_circle">check_circle</span> --}}
                            <i class="fa-solid fa-circle-check text-lg"></i>
                            Confirm &amp; Distribute
                        </button>
                    </div>
                </div>
            </form>

        </section>
    </div>
</main>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('allocation-container');
        const btnAdd = document.getElementById('btn-add-room');
        const totalQtyNeeded = 20; // Ambil dari data backend Anda

        // Fungsi untuk menambah baris
        btnAdd.addEventListener('click', function() {
            // Ambil baris pertama sebagai template
            const firstRow = document.querySelector('.allocation-row');
            const newRow = firstRow.cloneNode(true);

            // Reset nilai input di baris baru
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            // Aktifkan tombol hapus di baris baru
            const removeBtn = newRow.querySelector('.btn-remove');
            removeBtn.classList.remove('cursor-not-allowed');

            // Masukkan baris baru sebelum tombol "Tambah Ruangan"
            container.insertBefore(newRow, btnAdd.parentElement);

            calculateProgress();
        });

        // Fungsi untuk menghapus baris (Event Delegation)
        container.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove')) {
                const rows = document.querySelectorAll('.allocation-row');
                if (rows.length > 1) {
                    e.target.closest('.allocation-row').remove();
                    calculateProgress();
                } else {
                    alert("Minimal harus ada satu ruangan penyimpanan.");
                }
            }
        });

        // Fungsi hitung progress alokasi
        function calculateProgress() {
            let allocated = 0;
            document.querySelectorAll('.qty-input').forEach(input => {
                allocated += parseInt(input.value) || 0;
            });

            const remaining = totalQtyNeeded - allocated;
            const percentage = Math.min((allocated / totalQtyNeeded) * 100, 100);

            // Update UI
            const progressLabel = document.querySelector('.text-slate-900.font-bold');
            const progressBar = document.querySelector('.bg-primary.h-full');

            if (progressLabel) progressLabel.innerText = `${remaining} dari ${totalQtyNeeded}`;
            if (progressBar) progressBar.style.width = `${percentage}%`;

            // Opsional: Beri warna merah jika overload
            if (remaining < 0) {
                progressLabel.classList.add('text-red-600');
                progressBar.classList.replace('bg-primary', 'bg-red-600');
            } else {
                progressLabel.classList.remove('text-red-600');
                progressBar.classList.replace('bg-red-600', 'bg-primary');
            }
        }

        // Pantau perubahan input qty
        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input')) {
                calculateProgress();
            }
        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('allocation-container');
        const btnAdd = document.getElementById('btn-add-room');

        // 1. Ambil data qty dari Laravel secara dinamis
        // Pastikan variabel $pengadaan dikirim dari controller
        const totalQtyNeeded = {{ $pengadaan->qty_item ?? 20 }};

        // Inisialisasi tampilan awal
        calculateProgress();

        // Fungsi untuk menambah baris
        btnAdd.addEventListener('click', function() {
            const rows = document.querySelectorAll('.allocation-row');
            const currentAllocated = getAllocatedTotal();
            const remaining = totalQtyNeeded - currentAllocated;

            // Jangan tambah baris jika kuantitas sudah habis dialokasikan
            if (remaining <= 0) {
                alert("Semua kuantitas sudah dialokasikan.");
                return;
            }

            const firstRow = document.querySelector('.allocation-row');
            const newRow = firstRow.cloneNode(true);

            // Reset nilai dan set maksimal input untuk baris baru
            const inputQty = newRow.querySelector('.qty-input');
            inputQty.value = remaining; // Default isi dengan sisa yang ada
            inputQty.setAttribute('max', remaining);

            newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            const removeBtn = newRow.querySelector('.btn-remove');
            removeBtn.classList.remove('cursor-not-allowed');

            container.insertBefore(newRow, btnAdd.parentElement);
            calculateProgress();
        });

        // Fungsi hapus baris
        container.addEventListener('click', function(e) {
            if (e.target.closest('.btn-remove')) {
                const rows = document.querySelectorAll('.allocation-row');
                if (rows.length > 1) {
                    e.target.closest('.allocation-row').remove();
                    calculateProgress();
                }
            }
        });

        // Fungsi menghitung total yang sudah diinput
        function getAllocatedTotal() {
            let total = 0;
            document.querySelectorAll('.qty-input').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            return total;
        }

        // Fungsi hitung progress alokasi & Validasi Maksimal
        function calculateProgress() {
            let allocated = 0;
            const inputs = document.querySelectorAll('.qty-input');

            inputs.forEach(input => {
                let val = parseInt(input.value) || 0;

                // Validasi agar tidak melebihi totalQty secara individu (opsional)
                if (val > totalQtyNeeded) {
                    input.value = totalQtyNeeded;
                    val = totalQtyNeeded;
                }

                allocated += val;
            });

            // Jika total semua input melebihi batas, reset input terakhir ke sisa yang benar
            if (allocated > totalQtyNeeded) {
                const activeInput = document.activeElement;
                if (activeInput && activeInput.classList.contains('qty-input')) {
                    const otherAllocated = allocated - parseInt(activeInput.value);
                    activeInput.value = totalQtyNeeded - otherAllocated;
                    allocated = totalQtyNeeded;
                }
            }

            const remaining = totalQtyNeeded - allocated;
            const percentage = (allocated / totalQtyNeeded) * 100;

            // Update UI
            const progressLabel = document.querySelector('.text-slate-900.font-bold');
            const progressBar = document.querySelector('.bg-primary.h-full');

            if (progressLabel) progressLabel.innerText = `${remaining} dari ${totalQtyNeeded} tersedia`;
            if (progressBar) progressBar.style.width = `${percentage}%`;

            // Ubah warna bar jika penuh (Sesuai progress)
            if (percentage >= 100) {
                progressBar.classList.add('bg-emerald-500');
            } else {
                progressBar.classList.remove('bg-emerald-500');
            }
        }

        // Pantau perubahan input qty
        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input')) {
                // Mencegah input angka negatif
                if (e.target.value < 0) e.target.value = 0;
                calculateProgress();
            }
        });
    });
</script>
