@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-success">
        <ul style="margin-bottom: 0;">
            {{ session('success') }}
        </ul>
    </div>
@endif

@if (session('gagal'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-danger">
        <ul style="margin-bottom: 0;">
            {{ session('gagal') }}
        </ul>
    </div>
@endif

<!-- Pengadaan Barang Section -->
<section class="bg-surface-light dark:bg-surface-dark px-0 py-6 rounded-lg mb-8" x-data="{ openformpengadaanbarang: false }">
    <!-- filter -->
    <div
        class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm mb-3">
        <div class="relative inline-block">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
            </div>

            <select onchange="this.form.submit()" name="status"
                class="appearance-none bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold pl-9 pr-8 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700 outline-none">
                <option value="semua">Semua Status Pengadaan Barang
                </option>
                <option value="pending">
                    pending</option>
                <option value="diterima">
                    Diajukan ke rektorat</option>
                <option value="ditolak">
                    Ditolak</option>
                <option value="dibatalkan">
                    Dibatalkan</option>
                <option value="selesai">
                    Selesai</option>
            </select>

            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
            </div>
        </div>
        <div class="justify-end">
            <button @click="openformpengadaanbarang = !openformpengadaanbarang"
                class="flex items-center gap-2 min-w-[84px] cursor-pointer justify-end rounded-lg! h-10 px-4 bg-blue-500 text-white text-sm font-semibold leading-normal hover:bg-blue-400">
                {{-- <span class="material-symbols-outlined text-base">add</span> --}}
                <span class="truncate">Ajukan Pengadaan</span>
            </button>
        </div>
    </div>

    {{-- tabel riwayat pengadaan barang --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-800 font-semibold">
                        <th class="px-6 py-4">Nomor Surat</th>
                        <th class="px-6 py-4">Nama Barang</th>
                        <th class="px-6 py-4">Merk</th>
                        <th class="px-6 py-4">Qty</th>
                        <th class="px-6 py-4">status</th>
                        <th class="px-6 py-4 text-right">file Pengajuan</th>
                        <th class="px-6 py-4 text-right">aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @if ($pengadaan->isEmpty())
                        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer">
                            <td colspan="7" class="text-center py-10 text-slate-500 italic">
                                Data tidak ditemukan atau masih kosong.
                            </td>
                        </tr>
                    @else
                        @foreach ($pengadaan as $pengadaan)
                            {{-- <tr class="hover:bg-slate-50 transition-colors group cursor-pointer"> --}}
                            <tr>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-500">
                                                {{ $pengadaan->id_pengadaan }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            {{-- <i class="fa-solid fa-clipboard-list text-primary"></i> --}}
                                            {{ $pengadaan->nama_item }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            {{-- <i class="fa-solid fa-clipboard-list text-primary"></i> --}}
                                            {{ $pengadaan->merek_model }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            {{-- <i class="fa-solid fa-clipboard-list text-primary"></i> --}}
                                            {{ $pengadaan->qty_item }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    @if ($pengadaan->status_pengadaan === 'pendding')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    @elseif ($pengadaan->status_pengadaan === 'disetujui')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                            Diajukan
                                        </span>
                                    @elseif ($pengadaan->status_pengadaan === 'selesai')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            {{ $pengadaan->status_pengadaan }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-centar align-middle">
                                    <a href="{{ route('preview_surat_pengadaan', base64_encode($pengadaan->id_pengadaan)) }}"
                                        target="_blank" class="text-blue-600">
                                        Lihat surat
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-right align-middle">
                                    <div class="flex gap-2">
                                        <form method="POST"
                                            action="{{ route('pageCheckInBarang', base64_encode($pengadaan->id_pengadaan)) }}">
                                            
                                            @csrf
                                            <button type="submit"
                                                @disabled(strtolower($pengadaan->status_pengadaan) != 'disetujui')
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4  text-white text-sm font-semibold leading-normal {{ $pengadaan->status_pengadaan == 'disetujui' ? 'bg-green-500 hover:bg-green-400 hover:' : 'bg-gray-500 hover:bg-gray-400 hover:' }} ">
                                                Barang diterima
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('download-surat-pengadaan', base64_encode($pengadaan->id_pengadaan)) }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4 bg-blue-500 text-white text-sm font-semibold leading-normal hover:bg-blue-400 hover:">
                                                <i class="fa-solid fa-download"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex items-center justify-between">
            <span class="text-xs text-slate-500">Menampilkan 1-4 dari 128
                data</span>
            <div class="flex items-center gap-2">
                <button class="p-1 rounded text-slate-600 hover:bg-slate-200" disabled="">
                    <i class="fa-solid fa-chevron-left text-[20px]"></i>
                </button>
                <button class="p-1 rounded text-slate-600 hover:bg-slate-200">
                    <i class="fa-solid fa-chevron-right text-[20px]"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- form input pengadaan barang --}}
    <div x-show="openformpengadaanbarang"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50" x-transition
        x-cloak>
        <div @click.outside="openformpengadaanbarang = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="openformpengadaanbarang = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Formulir Permhonan sarana dan prasarana
            </h2>

            <!-- content form -->
            <div class=" ">
                <div class="max-w-3xl mx-auto">
                    {{-- <header class="mb-10 text-center">
                        <h2 class="font-display-h1 text-display-h1 text-on-background mb-2">Formulir Pengajuan Pengadaan Barang
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Silakan isi detail barang yang ingin
                            diajukan.
                        </p>
                    </header> --}}
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-card-padding p-4">

                        <form class="space-y-3" method="POST" action="{{ route('simpan-pengadaan') }}">
                            @csrf
                            <!-- Item Name -->
                            <div>
                                <label class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">
                                    Nomor surat
                                </label>
                                <div class="relative">
                                    {{-- <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        data-icon="inventory">inventory</span> --}}
                                    <input name="nomor_surat"
                                        class="w-full pl-3 pr-4 py-2 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                        placeholder="cth : /Pr/Sr/FT.UW/IV/2026" type="text" />
                                </div>
                            </div>
                            <div>
                                <label class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">
                                    Nama Barang / jenis Barang
                                </label>
                                <div class="relative">
                                    {{-- <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        data-icon="inventory">inventory</span> --}}
                                    <input name="nama_item"
                                        class="w-full pl-3 pr-4 py-2 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                        placeholder="cth: Laptop Core i7" type="text" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <!-- Category -->
                                <div>
                                    <label
                                        class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">Merk
                                        / Model</label>
                                    <input name="merk"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                        placeholder="cth : dell latitude" type="text" />
                                </div>
                                <!-- Amount -->
                                <div>
                                    <label
                                        class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">Jumlah</label>
                                    <input name="qty"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                        min="1" placeholder="0" type="number" />
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">Keperluan
                                    Untuk Prodi/Fakultas</label>
                                <div class="relative">
                                    <select name="keperluan_prodi"
                                        class="w-full px-3 py-2  border border-slate-200 rounded-xl font-body-md text-body-md appearance-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                                        <option>pilih untuk keperluan prodi atau fakultas</option>
                                        <option value="Fakultas Teknik">Fakultas Teknik</option>
                                        <option value="Program Studi Teknik Sipil">Teknik Sipil</option>
                                        <option value="Program Studi Teknik Komputer">Teknik Komputer</option>
                                        <option value="Program Studi Teknik Lingkungan">Teknik Lingkungan</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">
                                    Tahun akademik
                                </label>
                                <div class="relative">
                                    {{-- <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                        data-icon="inventory">inventory</span> --}}
                                    <input name="tahun_akademik"
                                        class="w-full pl-3 pr-4 py-2 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                        placeholder="cth : 2025/2026" type="text" />
                                </div>
                            </div>
                            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Unit Price -->
                                <div>
                                    <label
                                        class="block font-label-xs text-label-xs text-on-surface-variant uppercase mb-2">Estimasi
                                        Harga Satuan</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 font-bold text-slate-400 text-xs">Rp</span>
                                        <input
                                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                            placeholder="0" type="number" />
                                    </div>
                                </div>
                                <!-- Priority -->
                                <div>
                                    <label
                                        class="block font-label-xs text-label-xs text-on-surface-variant uppercase mb-2">Prioritas</label>
                                    <div class="relative">
                                        <select
                                            class="w-full px-4 py-3 border border-slate-200 rounded-xl font-body-md text-body-md appearance-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                                            <option>Rendah</option>
                                            <option>Sedang</option>
                                            <option>Tinggi</option>
                                        </select>
                                        <span
                                            class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 pointer-events-none"
                                            data-icon="priority_high">priority_high</span>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- Reason -->
                            {{-- <div>
                                <label class="block font-semibold text-xs text-on-surface-variant uppercase mb-2">Alasan
                                    Pengadaan</label>
                                <textarea
                                    class="w-full px-3 py-2 border border-slate-200 rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                    placeholder="Jelaskan urgensi dan kegunaan barang ini..." rows="4"></textarea>
                            </div> --}}
                            <!-- Footer Actions -->
                            <div class="pt-6 flex items-center justify-center gap-4 border-t border-slate-100">

                                <button
                                    class="w-full px-8 py-2.5 rounded-xl! justify-center font-body-md text-body-md text-white bg-primary hover:bg-primary/90 shadow-md shadow-primary/10 transition-all duration-200 flex items-center gap-2"
                                    type="submit">
                                    <span>Kirim Pengajuan</span>
                                    {{-- <span class="material-symbols-outlined text-sm" data-icon="send">send</span> --}}
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Contextual Info Card -->
                    {{-- <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-6 bg-blue-50 border border-blue-100 rounded-xl flex items-start gap-4">
                        <span class="material-symbols-outlined text-blue-600 mt-1" data-icon="info">info</span>
                        <div>
                            <h4 class="font-heading-card text-heading-card text-blue-900 mb-1">Informasi Anggaran</h4>
                            <p class="text-xs text-blue-700 leading-relaxed">Sisa pagu anggaran Fakultas Teknik tahun 2024
                                saat ini adalah Rp 45.000.000.</p>
                        </div>
                    </div>
                    <div
                        class="p-6 bg-tertiary-fixed-dim/20 border border-tertiary-fixed-dim/30 rounded-xl flex items-start gap-4">
                        <span class="material-symbols-outlined text-tertiary mt-1" data-icon="history">history</span>
                        <div>
                            <h4 class="font-heading-card text-heading-card text-tertiary mb-1">Status Pengajuan</h4>
                            <p class="text-xs text-tertiary leading-relaxed">Pengajuan ini akan diverifikasi oleh Bagian
                                Keuangan dalam 2-3 hari kerja.</p>
                        </div>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Perawatan Barang Section -->
{{-- <section class="bg-surface-light dark:bg-surface-dark p-6 rounded-lg">
    <!-- SectionHeader -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-text-light dark:text-text-dark text-xl font-bold leading-tight">Perawatan
            barang</h2>
    </div>
    <!-- ToolBar -->
    <div class="flex justify-start gap-2 py-3">
        <div class="relative w-full max-w-xs">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-light dark:text-muted-dark">search</span>
            <input
                class="w-full pl-10 pr-4 py-2 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-DEFAULT focus:ring-2 focus:ring-primary focus:border-transparent text-sm"
                placeholder="Cari nama barang..." type="text" />
        </div>
    </div>
    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead
                class="text-xs text-muted-light dark:text-muted-dark uppercase bg-background-light dark:bg-background-dark">
                <tr>
                    <th class="px-6 py-3" scope="col">ID Barang</th>
                    <th class="px-6 py-3" scope="col">Image</th>
                    <th class="px-6 py-3" scope="col">Nama Barang</th>
                    <th class="px-6 py-3" scope="col">Qty</th>
                    <th class="px-6 py-3" scope="col">Status</th>
                    <th class="px-6 py-3 text-center" scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-surface-light dark:bg-surface-dark border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium">#1089</td>
                    <td class="px-6 py-4">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-DEFAULT size-10"
                            data-alt="Laptop"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAOg8zi12idgWEZpuk9YdiFcyNqGSjPtL2Yz9kAL7TBgtrRODvzfSTHMuCh13kwCsiCVcqHswV9yreEH2sLD1sOfm6QJK3k8-VpyPNzorQfhE_IsgaxJ5NB6P7CaV019RVLXtJDXU7bM4d6rGGCDMmRbtxSEgXmfNxp-EzHJBDGg1N9lRbV6xg0iXa60pBlps5eK_ZkOrXY1975aAaDsNJCuJJO-LpgjNZHhiYg7-Hj-_L-RHGKz2n5r9ahZsZLWLOBJwBrbXxzlVjy");'>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold">Laptop Lenovo ThinkPad T480</td>
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Belum diajukan
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <button
                                class="flex items-center gap-1.5 min-w-[84px] cursor-pointer justify-center rounded-DEFAULT h-9 px-3 bg-primary/20 text-primary text-xs font-bold leading-normal hover:bg-primary/30">
                                <span class="truncate">Ajukan</span>
                            </button>
                            <button
                                class="flex items-center gap-1.5 min-w-[84px] cursor-pointer justify-center rounded-DEFAULT h-9 px-3 bg-red-500/20 text-red-500 text-xs font-bold leading-normal hover:bg-red-500/30">
                                <span class="truncate">Batal</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-surface-light dark:bg-surface-dark border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium">#2145</td>
                    <td class="px-6 py-4">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-DEFAULT size-10"
                            data-alt="Air Conditioner"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBpLnMtrUlLxgDbZesnrzRVSdEFYCokgyRF1wax3MCMuKgl6jGcZEkUITXYHcJ2TJXcTHZRDcwurZSLtY9NqxJNh-TNjtD4Zubrj76MRpB0Dn-4ZOg8wtFkMS3jknPQ2fJBue0T8ZtZ0YN9b5VgWGinEMcOjfBYu80FCkPWoAngyt0vFz-abNN0RRRSIg_tZEaO--6ypy3bGjxC7JneVjVKhILM5hSs-enwAevHfiXmmv0Qjrp_zcT4XEH4JhT9ipnO1blM26hiOUuY");'>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold">AC Sharp 1/2 PK</td>
                    <td class="px-6 py-4">3</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Belum disetujui
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <button
                                class="flex items-center gap-1.5 min-w-[84px] cursor-pointer justify-center rounded-DEFAULT h-9 px-3 bg-red-500/20 text-red-500 text-xs font-bold leading-normal hover:bg-red-500/30">
                                <span class="truncate">Batal</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-surface-light dark:bg-surface-dark border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium">#3012</td>
                    <td class="px-6 py-4">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-DEFAULT size-10"
                            data-alt="Personal Computer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJEIG6Y9h5goTUltJpl3LL12SFepnKqtX4ku7m5-5LNHUjrQBeo8_N0cYCyokvrwInJSEFquA8aNjZdANOtOfIREBzl5CNZ4Z_7w7BKfWXIguw-iZ7ocpgstKzJBSq-CQmaDqBWWSr-0jYak03qjQeFcRdy0saAsmoNmRKzb3Td6Ey5CECd5iQ6-1gMSicsA9FtJMPyquQgWMZbtwZQlf27rx-hiCbRkgh2cjMZAulp3LAuVEp5YPJ8hvdNx6gqRPr58ffSydIPq13");'>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold">PC Rakitan Lab Komputer</td>
                    <td class="px-6 py-4">5</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Disetujui
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <span class="text-xs text-muted-light dark:text-muted-dark">-</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section> --}}
