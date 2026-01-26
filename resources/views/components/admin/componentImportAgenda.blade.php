<main x-data="{ activeTab: 'Mata Kuliah' }"  class="flex-1 flex flex-col h-full overflow-hidden bg-background-light mt-4">

    <div class="bg-white p-1 rounded-xl border border-slate-200 inline-flex shadow-sm mb-3 gap-2">
        <button @click="activeTab = 'Mata Kuliah'"
            :class="activeTab === 'Mata Kuliah' ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'"
            class="px-6 py-2.5 rounded-lg! text-sm font-medium transition-colors">
            Mata Kuliah
        </button>

        <button @click="activeTab = 'PTS'"
            :class="activeTab === 'PTS' ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'"
            class="px-6 py-2.5 rounded-lg! text-sm font-medium transition-colors">
            PTS / PAS
        </button>
    </div>

    {{-- show matkul --}}
    <div x-show="activeTab === 'Mata Kuliah'" x-transition>
        <div
            class="px-8 py-6 bg-white border rounded-xl border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4 shrink-0">
            <div>
                {{-- <h4 class="text-2xl font-bold text-slate-900">Impor Agenda Kegiatan</h4> --}}
                <p class="text-slate-500 text-sm mt-1">
                    Unggah file CSV atau Excel untuk menambahkan banyak jadwal Matakuliah.
                </p>
            </div>
            <div class="flex flex-col items-center gap-3 w-full justify-center md:justify-end md:flex-row">
                {{-- <button
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 rounded-lg! font-medium hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-file-lines text-slate-500 text-[20px]"></i>
                    Unduh Template CSV
                </button> --}}
                <button
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 rounded-lg! font-medium hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-table-list text-slate-500 text-[20px]"></i>
                    Unduh Template Excel
                </button>
            </div>
        </div>
    
        <form action="{{ route('tambah-agenda-import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                <div class="max-w-6xl mx-auto space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                                <div class="md:col-span-1">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                        Tanggal Mulai agenda
                                    </label>
                                    <input name="tgl_mulai" required
                                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                        type="date" />
                                </div>
                                <div class="md:col-span-1">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                        Tanggal Selesai Agenda
                                    </label>
                                    <input name="tgl_selesai" required
                                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                        type="date" />
                                </div>
                            </div>
                            <div id="dropArea"
                                class="bg-white border-2 border-dashed border-slate-200 rounded-xl p-12 flex flex-col items-center justify-center hover:bg-slate-50 hover:border-primary/50 transition-all cursor-pointer group">
                                <div
                                    class="size-20 rounded-full bg-primary/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-arrow-up text-blue-500 text-5xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Tarik dan lepas file di sini</h3>
                                <p class="text-sm text-slate-500 mb-6 text-center max-w-sm">Mendukung format .csv, .xls,
                                    dan .xlsx. Pastikan ukuran file tidak lebih dari 10MB.
                                </p>
                                <!-- Nama file -->
                                <p id="fileName" class="text-sm font-semibold text-primary hidden"></p>
                                <input name="fileAgenda" accept=".csv,.xls,.xlsx" class="hidden" id="fileInput"
                                    type="file" required />
                                <button type="button"
                                    class="px-4 py-2 bg-primary hover:bg-blue-600 text-white font-bold rounded-lg! shadow-lg shadow-blue-200 transition-all"
                                    onclick="document.getElementById('fileInput').click()">
                                    Pilih File dari Komputer
                                </button>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-3">
                            <h5 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-blue-500"></i>
                                Instruksi Format Data
                            </h5>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kolom
                                        Wajib</h4>
                                    <ul class="text-sm text-slate-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span><strong>Nama Matakuliah:</strong> 
                                                Nama Matakuliah 
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span>
                                                <strong>
                                                    Ruang:
                                                </strong>
                                                Berisi nama Ruangan yang digunakan untuk agenda
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span>
                                                <strong>Hari:</strong>
                                                Berisi nama hari untuk pengulangan agenda setiap hari atau setiap minggu.
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span><strong>Waktu:</strong> Format HH:mm (contoh: 08:00).</span>
                                        </li>
                                    </ul>
                                </div>
                                {{-- <div class="pt-4 border-t border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kolom
                                        Opsional</h4>
                                    <ul class="text-sm text-slate-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-slate-300 mt-1.5 shrink-0"></span>
                                            <span>Lokasi, Penanggung Jawab, Deskripsi.</span>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100 flex gap-3">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-600 shrink-0"></i>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        Pastikan baris pertama adalah header sesuai template. Sistem akan memvalidasi
                                        data secara otomatis setelah diunggah.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <h3 class="text-base font-bold text-slate-900">Pratinjau Data</h3>
                                <span
                                    class="px-2 py-0.5 bg-slate-200 text-slate-600 text-[10px] font-bold rounded uppercase">8
                                    Baris Terdeteksi</span>
                            </div>
                            <div class="flex items-center gap-4 text-xs">
                                <div class="flex items-center gap-1.5 text-emerald-600 font-medium">
                                    <span class="size-2 rounded-full bg-emerald-500"></span> 6 Valid
                                </div>
                                <div class="flex items-center gap-1.5 text-red-600 font-medium">
                                    <span class="size-2 rounded-full bg-red-500"></span> 2 Perlu Perbaikan
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th class="px-6 py-3 font-semibold text-slate-600">No</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Judul Agenda</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Tanggal</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Jam Mulai</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Lokasi</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Status</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">1</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Seminar Nasional AI</td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-15</td>
                                        <td class="px-6 py-4 text-slate-600">09:00</td>
                                        <td class="px-6 py-4 text-slate-600">Aula Utama</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                Valid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-red-50/30 hover:bg-red-50/50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">2</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Rapat Kerja Fakultas</td>
                                        <td class="px-6 py-4">
                                            <span class="text-red-600 font-bold border-b border-dotted border-red-600"
                                                title="Format tanggal salah">24/10/2023</span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">13:00</td>
                                        <td class="px-6 py-4 text-slate-600">R. Sidang 1</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-red-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">error</span>
                                                Format Salah
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button class="text-slate-400 hover:text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                                </button>
                                                <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">3</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Workshop Kurikulum</td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-16</td>
                                        <td class="px-6 py-4 text-slate-600">08:30</td>
                                        <td class="px-6 py-4 text-slate-600">Lab Komputer 3</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                Valid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-red-50/30 hover:bg-red-50/50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">4</td>
                                        <td class="px-6 py-4">
                                            <span class="text-red-600 font-bold border-b border-dotted border-red-600"
                                                title="Wajib diisi">-</span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-20</td>
                                        <td class="px-6 py-4 text-slate-600">10:00</td>
                                        <td class="px-6 py-4 text-slate-600">Auditorium</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-red-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">error</span>
                                                Judul Kosong
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button class="text-slate-400 hover:text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                                </button>
                                                <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">5</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Ujian Tengah Semester</td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-06</td>
                                        <td class="px-6 py-4 text-slate-600">07:30</td>
                                        <td class="px-6 py-4 text-slate-600">Seluruh Ruang Kelas</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                Valid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="px-6 py-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-500 flex justify-between items-center">
                            <p>Menampilkan 5 dari 8 baris data.</p>
                            <div class="flex items-center gap-1">
                                <button
                                    class="size-8 flex items-center justify-center border border-slate-200 rounded hover:bg-white disabled:opacity-50"
                                    disabled="">
                                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                </button>
                                <button
                                    class="size-8 flex items-center justify-center bg-primary text-white rounded font-bold">1</button>
                                <button
                                    class="size-8 flex items-center justify-center border border-slate-200 rounded hover:bg-white font-medium">2</button>
                                <button
                                    class="size-8 flex items-center justify-center border border-slate-200 rounded hover:bg-white">
                                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <footer class="px-8 py-5 bg-white border-t border-slate-200 flex items-center justify-end gap-3 shrink-0">
                <button type="submit" value="batal"
                    class="px-6 py-2.5 text-sm font-semibold text-slate-600 border-1 border-slate-200 hover:text-slate-900 hover:bg-slate-300 rounded-lg! transition-all">
                    Batal
                </button>
                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                <button type="submit" value="impor"
                    class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold rounded-lg! shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-white text-[20px]"></i>
                    Proses Impor
                </button>
            </footer>
        </form>
    </div>

    {{-- show pts / pas --}}
    <div x-show="activeTab === 'PTS'" x-transition>
        <div
            class="px-8 py-6 bg-white border rounded-xl border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4 shrink-0">
            <div>
                {{-- <h4 class="text-2xl font-bold text-slate-900">Impor Agenda Kegiatan</h4> --}}
                <p class="text-slate-500 text-sm mt-1">
                    Unggah file CSV atau Excel untuk menambahkan banyak jadwal PTS atau PAS.
                </p>
            </div>
            <div class="flex flex-col items-center gap-3 w-full justify-center md:justify-end md:flex-row">
                {{-- <button
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 rounded-lg! font-medium hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-file-lines text-slate-500 text-[20px]"></i>
                    Unduh Template CSV
                </button> --}}
                <button
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-600 rounded-lg! font-medium hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-table-list text-slate-500 text-[20px]"></i>
                    Unduh Template Excel
                </button>
            </div>
        </div>
    
        <form action="{{ route('tambah-agenda-import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                <div class="max-w-6xl mx-auto space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div id="dropAreaPTSPAS"
                                class="bg-white border-2 border-dashed border-slate-200 rounded-xl p-12 flex flex-col items-center justify-center hover:bg-slate-50 hover:border-primary/50 transition-all cursor-pointer group">
                                <div
                                    class="size-20 rounded-full bg-primary/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-arrow-up text-blue-500 text-5xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-2">Tarik dan lepas file di sini</h3>
                                <p class="text-sm text-slate-500 mb-6 text-center max-w-sm">Mendukung format .csv, .xls,
                                    dan .xlsx. Pastikan ukuran file tidak lebih dari 10MB.
                                </p>
                                <!-- Nama file -->
                                <p id="fileNamePTSPAS" class="text-sm font-semibold text-primary hidden"></p>
                                <input name="fileAgenda" accept=".csv,.xls,.xlsx" class="hidden" id="fileInputPTSPAS"
                                    type="file" required />
                                <button type="button"
                                    class="px-4 py-2 bg-primary hover:bg-blue-600 text-white font-bold rounded-lg! shadow-lg shadow-blue-200 transition-all"
                                    onclick="document.getElementById('fileInputPTSPAS').click()">
                                    Pilih File dari Komputer
                                </button>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-3">
                            <h5 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-blue-500"></i>
                                Instruksi Format Data
                            </h5>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kolom
                                        Wajib</h4>
                                    <ul class="text-sm text-slate-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span><strong>Nama Matakuliah:</strong>
                                                Nama Matakuliah 
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span>
                                                <strong>
                                                    Ruang:
                                                </strong>
                                                Berisi nama Ruangan yang digunakan untuk agenda
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span>
                                                <strong>Tanggal:</strong>
                                                Format Years-month-date (contoh: 2025-12-01).
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                            <span><strong>Waktu:</strong> Format HH:mm (contoh: 08:00).</span>
                                        </li>
                                    </ul>
                                </div>
                                {{-- <div class="pt-4 border-t border-slate-100">
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kolom
                                        Opsional</h4>
                                    <ul class="text-sm text-slate-600 space-y-2">
                                        <li class="flex items-start gap-2">
                                            <span class="size-1.5 rounded-full bg-slate-300 mt-1.5 shrink-0"></span>
                                            <span>Lokasi, Penanggung Jawab, Deskripsi.</span>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100 flex gap-3">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-600 shrink-0"></i>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        Pastikan baris pertama adalah header sesuai template. Sistem akan memvalidasi
                                        data secara otomatis setelah diunggah.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-3">
                                <h3 class="text-base font-bold text-slate-900">Pratinjau Data</h3>
                                <span
                                    class="px-2 py-0.5 bg-slate-200 text-slate-600 text-[10px] font-bold rounded uppercase">8
                                    Baris Terdeteksi</span>
                            </div>
                            <div class="flex items-center gap-4 text-xs">
                                <div class="flex items-center gap-1.5 text-emerald-600 font-medium">
                                    <span class="size-2 rounded-full bg-emerald-500"></span> 6 Valid
                                </div>
                                <div class="flex items-center gap-1.5 text-red-600 font-medium">
                                    <span class="size-2 rounded-full bg-red-500"></span> 2 Perlu Perbaikan
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th class="px-6 py-3 font-semibold text-slate-600">No</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Judul Agenda</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Tanggal</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Jam Mulai</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Lokasi</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Status</th>
                                        <th class="px-6 py-3 font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">1</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Seminar Nasional AI</td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-15</td>
                                        <td class="px-6 py-4 text-slate-600">09:00</td>
                                        <td class="px-6 py-4 text-slate-600">Aula Utama</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                Valid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-red-50/30 hover:bg-red-50/50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">2</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Rapat Kerja Fakultas</td>
                                        <td class="px-6 py-4">
                                            <span class="text-red-600 font-bold border-b border-dotted border-red-600"
                                                title="Format tanggal salah">24/10/2023</span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">13:00</td>
                                        <td class="px-6 py-4 text-slate-600">R. Sidang 1</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-red-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">error</span>
                                                Format Salah
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button class="text-slate-400 hover:text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                                </button>
                                                <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">3</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Workshop Kurikulum</td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-16</td>
                                        <td class="px-6 py-4 text-slate-600">08:30</td>
                                        <td class="px-6 py-4 text-slate-600">Lab Komputer 3</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                Valid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-red-50/30 hover:bg-red-50/50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">4</td>
                                        <td class="px-6 py-4">
                                            <span class="text-red-600 font-bold border-b border-dotted border-red-600"
                                                title="Wajib diisi">-</span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-20</td>
                                        <td class="px-6 py-4 text-slate-600">10:00</td>
                                        <td class="px-6 py-4 text-slate-600">Auditorium</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-red-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">error</span>
                                                Judul Kosong
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button class="text-slate-400 hover:text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                                </button>
                                                <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500">5</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">Ujian Tengah Semester</td>
                                        <td class="px-6 py-4 text-slate-600">2023-11-06</td>
                                        <td class="px-6 py-4 text-slate-600">07:30</td>
                                        <td class="px-6 py-4 text-slate-600">Seluruh Ruang Kelas</td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-1.5 text-emerald-600 text-xs font-semibold">
                                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                Valid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button class="text-slate-400 hover:text-red-600 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="px-6 py-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-500 flex justify-between items-center">
                            <p>Menampilkan 5 dari 8 baris data.</p>
                            <div class="flex items-center gap-1">
                                <button
                                    class="size-8 flex items-center justify-center border border-slate-200 rounded hover:bg-white disabled:opacity-50"
                                    disabled="">
                                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                </button>
                                <button
                                    class="size-8 flex items-center justify-center bg-primary text-white rounded font-bold">1</button>
                                <button
                                    class="size-8 flex items-center justify-center border border-slate-200 rounded hover:bg-white font-medium">2</button>
                                <button
                                    class="size-8 flex items-center justify-center border border-slate-200 rounded hover:bg-white">
                                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <footer class="px-8 py-5 bg-white border-t border-slate-200 flex items-center justify-end gap-3 shrink-0">
                <button type="submit" value="batal"
                    class="px-6 py-2.5 text-sm font-semibold text-slate-600 border-1 border-slate-200 hover:text-slate-900 hover:bg-slate-300 rounded-lg! transition-all">
                    Batal
                </button>
                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                <button type="submit" value="impor"
                    class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold rounded-lg! shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-white text-[20px]"></i>
                    Proses Impor
                </button>
            </footer>
        </form>
    </div>

</main>

{{-- matakuliah --}}
<script>
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    function showFileName(file) {
        fileName.textContent = `File dipilih: ${file.name}`;
        fileName.classList.remove('hidden');
    }

    // Klik pilih file
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) {
            showFileName(fileInput.files[0]);
        }
    });

    // Prevent default drag behavior
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Drop file
    dropArea.addEventListener('drop', e => {
        const files = e.dataTransfer.files;
        if (files.length) {
            fileInput.files = files;
            showFileName(files[0]);
        }
    });
</script>

{{-- PTS PAS --}}
<script>
    const dropAreaPTSPAS = document.getElementById('dropAreaPTSPAS');
    const fileInputPTSPAS = document.getElementById('fileInputPTSPAS');
    const fileNamePTSPAS = document.getElementById('fileNamePTSPAS');

    function showFileNamePTSPAS(file) {
        fileNamePTSPAS.textContent = `File dipilih: ${file.name}`;
        fileNamePTSPAS.classList.remove('hidden');
    }

    // Klik pilih file
    fileInputPTSPAS.addEventListener('change', () => {
        if (fileInputPTSPAS.files.length) {
            showFileNamePTSPAS(fileInputPTSPAS.files[0]);
        }
    });

    // Prevent default drag behavior
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropAreaPTSPAS.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Drop file
    dropAreaPTSPAS.addEventListener('drop', e => {
        const files = e.dataTransfer.files;
        if (files.length) {
            fileInputPTSPAS.files = files;
            showFileNamePTSPAS(files[0]);
        }
    });
</script>
