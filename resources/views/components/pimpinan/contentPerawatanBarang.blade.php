<!-- Pengadaan Barang Section -->
<section class="bg-surface-light dark:bg-surface-dark px-0 py-6 rounded-lg mb-8" x-data="{ openformpengadaanbarang: false }">

    <!-- filter -->
    <div
        class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm mb-3">
        <div class="relative inline-block">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
            </div>

            <form action="{{ route('sortir_status_perawatan') }}" method="post">
                @csrf
                <select onchange="this.form.submit()" name="status_perawatan"
                    class="appearance-none bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold pl-9 pr-8 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700 outline-none">
                    <option {{ $status_perawatan == 'semua' ? 'selected' : '' }} value="semua">Semua Status Pengadaan
                        Barang
                    </option>
                    <option {{ $status_perawatan == 'pendding' ? 'selected' : '' }} value="pendding">
                        pending</option>
                    <option {{ $status_perawatan == 'diterima' ? 'selected' : '' }} value="diterima">
                        Diajukan ke rektorat</option>
                    {{-- <option {{ $status_perawatan == 'ditolak' ? 'selected' : '' }} value="ditolak">
                        Ditolak</option> --}}
                    {{-- <option {{ $status_perawatan == 'dibatalkan' ? 'selected' : '' }} value="dibatalkan">
                        Dibatalkan</option> --}}
                    <option {{ $status_perawatan == 'selesai' ? 'selected' : '' }} value="selesai">
                        Selesai</option>
                </select>
            </form>

            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
            </div>
        </div>
    </div>

    {{-- tabel riwayat pengadaan barang --}}
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
                    @if ($perawatanBarang->isEmpty())
                        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer">
                            <td colspan="7" class="text-center py-10 text-slate-500 italic">
                                Data tidak ditemukan atau masih kosong.
                            </td>
                        </tr>
                    @else
                        @foreach ($perawatanBarang as $perawatan)
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
                                            {{ $perawatan->nama_item == null ? 'Ruang ' . $perawatan->nama_room : $perawatan->nama_item . ' ' . $perawatan->merek_model }}
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
                                {{-- <td class="px-6 py-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-bold text-slate-500 flex items-center gap-2">
                                            <i class="fa-solid fa-clipboard-list text-primary"></i>
                                            {{ $perawatan->merek_model == null ? '-' : $perawatan->merek_model }}
                                        </div>
                                    </div>
                                </td> --}}
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
                                            Disetujui
                                        </span>
                                    @elseif ($perawatan->status_perawatan === 'selesai')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            {{ $perawatan->status_perawatan }}
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
                                        <form method="POST"
                                            action="{{ route('sign-surat-perawatan', base64_encode($perawatan->id_perawatan)) }}">
                                            @csrf
                                            <button type="submit" @disabled(strtolower($perawatan->status_perawatan) != 'pendding')
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4  text-white text-sm font-semibold leading-normal {{ $perawatan->status_perawatan == 'pendding' ? 'bg-green-500 hover:bg-green-400 hover:' : 'bg-gray-500 hover:bg-gray-400 hover:' }} ">
                                                Acc
                                            </button>
                                        </form>
                                        {{-- <form method="POST"
                                            action="{{ route('tolak-surat-perawatan', base64_encode($perawatan->id_perawatan)) }}">
                                            @csrf
                                            <button type="submit" @disabled(strtolower($perawatan->status_perawatan) != 'pendding')
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4  text-white text-sm font-semibold leading-normal {{ $perawatan->status_perawatan == 'pendding' ? 'bg-red-500 hover:bg-red-400 hover:' : 'bg-gray-500 hover:bg-gray-400 hover:' }} ">
                                                Reject
                                            </button>
                                        </form> --}}
                                        <form method="POST"
                                            action="{{ route('download-surat-perawatan', base64_encode($perawatan->id_perawatan)) }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4 bg-blue-500 text-white text-sm font-semibold leading-normal hover:bg-blue-400 hover:">
                                                {{-- <i class="fa-solid fa-chevron-right"></i> --}}
                                                <i class="fa-solid fa-download"></i>

                                                {{-- download --}}
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

            <div class="text-sm text-slate-500 font-medium">
                Menampilkan
                <span class="text-slate-900 font-bold">{{ $perawatanBarang->count() }}</span>
                dari
                <span class="text-slate-900 font-bold">{{ $perawatanBarang->total() }}</span>
                data
            </div>

            <div class="flex gap-2">
                {{-- Tombol ke Halaman Sebelumnya --}}
                @if ($perawatanBarang->onFirstPage())
                    <button
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-300 bg-gray-50 cursor-not-allowed"
                        disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $perawatanBarang->previousPageUrl() }}"
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($perawatanBarang->getUrlRange(1, $perawatanBarang->lastPage()) as $page => $url)
                    @if ($page == $perawatanBarang->currentPage())
                        {{-- Halaman Aktif --}}
                        <button
                            class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center text-sm font-bold">
                            {{ $page }}
                        </button>
                    @else
                        {{-- Halaman Lain --}}
                        <a href="{{ $url }}"
                            class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-sm font-medium hover:border-primary hover:text-primary transition-all bg-white">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Tombol ke Halaman Selanjutnya --}}
                @if ($perawatanBarang->hasMorePages())
                    <a href="{{ $perawatanBarang->nextPageUrl() }}"
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <button
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-300 bg-gray-50 cursor-not-allowed"
                        disabled>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

</section>
