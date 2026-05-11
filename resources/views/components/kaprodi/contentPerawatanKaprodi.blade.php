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
                <option value="semua">Semua Status Perawatan Barang
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
            {{-- page-pengajuan-perawatan-barang --}}
            <a href="{{ route('form-pengajuan-perawatan-barang-kaprodi') }}"
                class="inline-flex items-center gap-2 min-w-[84px] cursor-pointer justify-center rounded-lg h-10 px-4 bg-blue-500 text-white text-sm font-semibold leading-normal hover:bg-blue-400 no-underline!">
                <span class="truncate">Ajukan Perawatan</span>
            </a>

            {{-- <button @click="openformpengadaanbarang = !openformpengadaanbarang"
                class="flex items-center gap-2 min-w-[84px] cursor-pointer justify-end rounded-lg! h-10 px-4 bg-blue-500 text-white text-sm font-semibold leading-normal hover:bg-blue-400">
                <span class="truncate">Ajukan Perawatan</span>
            </button> --}}
        </div>
    </div>

    {{-- tabel riwayat Perawatan barang --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-800 font-semibold">
                        <th class="px-6 py-4">Nomor Surat</th>
                        <th class="px-6 py-4">Nama Barang / Ruangan</th>
                        <th class="px-6 py-4">Nama Pemohon</th>
                        {{-- <th class="px-6 py-4">Merk</th> --}}
                        <th class="px-6 py-4">Qty</th>
                        <th class="px-6 py-4">status</th>
                        <th class="px-6 py-4 text-right">file Pengajuan</th>
                        <th class="px-6 py-4 text-right">aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    @if ($perawatan->isEmpty())
                        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer">
                            <td colspan="7" class="text-center py-10 text-slate-500 italic">
                                Data tidak ditemukan atau masih kosong.
                            </td>
                        </tr>
                    @else
                        @foreach ($perawatan as $perawatan)
                            {{-- <tr class="hover:bg-slate-50 transition-colors group cursor-pointer"> --}}
                            <tr>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-500">
                                                {{ $perawatan->id_perawatan }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            {{-- <i class="fa-solid fa-clipboard-list text-primary"></i> --}}
                                            {{ $perawatan->nama_item == null ? 'Ruang '.$perawatan->nama_room : $perawatan->nama_item }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            {{-- <i class="fa-solid fa-clipboard-list text-primary"></i> --}}
                                            {{ $perawatan->nama_pemohon }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            {{-- <i class="fa-solid fa-clipboard-list text-primary"></i> --}}
                                            {{ $perawatan->qty_perawatan == null ? '-' : $perawatan->qty_perawatan }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    @if ($perawatan->status_perawatan === 'pendding')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    @elseif ($perawatan->status_perawatan === 'disetujui')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                            Diajukan
                                        </span>
                                    @elseif ($perawatan->status_perawatan === 'selesai')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            selesai
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            {{ $perawatan->status_perawatan }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-centar align-middle">
                                    <a href="{{ route('preview_surat_perawatan', base64_encode($perawatan->id_perawatan)) }}"
                                        target="_blank" class="text-blue-600">
                                        Lihat surat
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-right align-middle">
                                    <div class="flex gap-2">
                                        <form method="get"
                                            action="{{ route('pageCheckInPerawatan', base64_encode($perawatan->id_perawatan)) }}">

                                            @csrf
                                            <button type="submit" @disabled(strtolower($perawatan->status_perawatan) != 'disetujui')
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4  text-white text-sm font-semibold leading-normal {{ $perawatan->status_perawatan == 'disetujui' ? 'bg-green-500 hover:bg-green-400 hover:' : 'bg-gray-500 hover:bg-gray-400 hover:' }} ">
                                                selesai
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('download-surat-perawatan', base64_encode($perawatan->id_perawatan)) }}">
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
                </div>
            </div>
        </div>
    </div>

</section>
