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
    </div>

    {{-- tabel riwayat pengadaan barang --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-800 font-semibold">
                        <th class="px-6 py-4">Nomor Surat</th>
                        <th class="px-6 py-4">Nama Barang</th>
                        <th class="px-6 py-4">Nama Pemohon</th>
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
                                            {{ $pengadaan->nama_pemohon }}
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
                                            Disetujui
                                        </span>
                                    @elseif ($pengadaan->status_pengadaan === 'selesai')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-orange-200">
                                            <span class="size-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            {{ $pengadaan->status_pengadaan }}
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
                                            action="{{ route('sign-surat', base64_encode($pengadaan->id_pengadaan)) }}">
                                            @csrf
                                            <button type="submit" @disabled(strtolower($pengadaan->status_pengadaan) != 'pendding')
                                                class="flex items-center gap-2 cursor-pointer justify-center rounded-lg! h-10 px-4  text-white text-sm font-semibold leading-normal {{ $pengadaan->status_pengadaan == 'pendding' ? 'bg-green-500 hover:bg-green-400 hover:' : 'bg-gray-500 hover:bg-gray-400 hover:' }} ">
                                                approve
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('download-surat-pengadaan', base64_encode($pengadaan->id_pengadaan)) }}">
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

</section>
