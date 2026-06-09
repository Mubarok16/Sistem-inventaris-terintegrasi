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

<main class="flex-1 flex flex-col h-full min-w-0 overflow-hidden relative">
    <div class="flex flex-1 overflow-hidden">
        <div class="flex-1 flex flex-col overflow-hidden bg-background-light w-full">
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar h-full">
                <div class="flex flex-col gap-6 max-w-7xl mx-auto w-full">
                    {{-- display perhitungan data --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col">
                            <span class="text-sm text-slate-500 font-medium">Total
                                Peminjaman</span>
                            <div class="flex items-end justify-between mt-2">
                                <span class="text-2xl font-bold text-slate-900">{{ $totalPeminjaman }}</span>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col">
                            <span class="text-sm text-slate-500 font-medium">Menunggu
                                Persetujuan</span>
                            <div class="flex items-end justify-between mt-2">
                                <span class="text-2xl font-bold text-orange-600">{{ $totalDiajukan }}</span>
                                <span
                                    class="text-xs font-medium text-orange-600 bg-orange-50 px-2 py-1 rounded-full">Urgent</span>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col">
                            <span class="text-sm text-slate-500 font-medium">Sedang
                                Dipinjam</span>
                            <div class="flex items-end justify-between mt-2">
                                <span class="text-2xl font-bold text-primary">{{ $totalDipinjam }}</span>
                                <span
                                    class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Active</span>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col">
                            <span class="text-sm text-slate-500 font-medium">Terlambat</span>
                            <div class="flex items-end justify-between mt-2">
                                <span class="text-2xl font-bold text-red-600">{{ $totalTerlambat }}</span>
                                <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">
                                    Urgen!
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- menu sortir --}}
                    <form action="{{ route('pilih-data-pengelolaan-peminjaman-by-status') }}" method="post">
                        @csrf
                        <div
                            class="flex flex-col sm:flex-row justify-start gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
                            {{-- search --}}
                            <div class="relative flex-grow max-w-md">
                                <i
                                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input
                                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                                    placeholder="Cari nama peminjaman atau kode peminjaman" type="text" />
                            </div>

                            {{-- filter --}}
                            <div class="relative inline-block">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fa-solid fa-filter text-slate-400 text-xs"></i>
                                </div>

                                <select onchange="this.form.submit()" name="status"
                                    class="appearance-none bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold pl-9 pr-8 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700 outline-none">
                                    <option {{ $status_penggunaan == 'semua' ? 'selected' : '' }} value="semua">Semua
                                    </option>
                                    <option {{ $status_penggunaan == 'diajukan' ? 'selected' : '' }} value="diajukan">
                                        Menunggu</option>
                                    <option {{ $status_penggunaan == 'terjadwal' ? 'selected' : '' }} value="terjadwal">
                                        Terjadwal</option>
                                    <option {{ $status_penggunaan == 'dipinjam' ? 'selected' : '' }} value="dipinjam">
                                        Dipinjam</option>
                                    <option {{ $status_penggunaan == 'terlambat' ? 'selected' : '' }}
                                        value="terlambat">Terlambat</option>
                                    <option {{ $status_penggunaan == 'selesai' ? 'selected' : '' }} value="selesai">
                                        Selesai</option>
                                    <option {{ $status_penggunaan == 'ditolak' ? 'selected' : '' }} value="ditolak">
                                        Ditolak</option>
                                    <option {{ $status_penggunaan == 'dibatalkan' ? 'selected' : '' }}
                                        value="dibatalkan">
                                        Dibatalkan</option>
                                </select>

                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                                </div>
                            </div>

                            {{-- konfirmasi pengambilan barang atau kunci ruangan --}}
                            {{-- <div class="relative flex-grow max-w-md">
                                <i
                                    class="fa-solid fa-keyboard absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input
                                    class="w-full pl-10 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                                    placeholder="Konfirmasi pengambilan & pengembalian" type="text" />
                            </div> --}}

                        </div>
                    </form>
                    {{-- dispaly data peminjaman --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[800px]">
                                <thead>
                                    <tr
                                        class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500 font-semibold">
                                        <th class="px-6 py-4">Transaksi &amp; Peminjam</th>
                                        <th class="px-6 py-4">Nama kegiatan atau keterangan peminjaman</th>
                                        <th class="px-6 py-4">Jadwal Penggunaan</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 text-sm">
                                    @if ($dataPengajuanPeminjaman->isEmpty())
                                        <tr class="hover:bg-slate-50 transition-colors group cursor-pointer">
                                            <td colspan="5" class="text-center py-10 text-slate-500 italic">
                                                Data tidak ditemukan atau masih kosong.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataPengajuanPeminjaman as $dataPeminjaman)
                                            <tr class="hover:bg-slate-50 transition-colors group cursor-pointer">
                                                <td class="px-6 py-4 align-top">
                                                    <div class="flex items-center gap-3">
                                                        <div class="size-10 rounded-full bg-cover bg-center border border-slate-200 flex-shrink-0"
                                                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCAVNvYzzlNBudZcgQuPuSqlcr_RaNxDS0801snxn5Yhr-3zz1rpSZz3lbG328dBpsl58jDIRy-mHFkHFaYhECqM7vws4kU8mB0W3UedGhE_bVUpZxSCbDp8F36_qhrfSGnccRnVjbEX9eVjszRjxrWRTnsu0YIyM_RG3pZaZH5USkDDgr5aY9jSXbuYwpyyFjxDNiAdKKpHzekOu8xzPKkGgHHO9T5KfBh5RhWY4vQbdcYoEh2fnQ1t15z0f9pXf_NFwpqUIkjCQE");'>
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span class="font-bold text-slate-900">
                                                                {{ $dataPeminjaman->nama_peminjam }}
                                                            </span>
                                                            <span class="text-xs text-slate-500 font-mono mt-0.5">
                                                                {{ $dataPeminjaman->kode_peminjaman }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 align-top">
                                                    <div class="flex flex-col gap-1.5">
                                                        <div class="font-bold text-slate-900 flex items-center gap-2">
                                                            <i class="fa-solid fa-clipboard-list text-primary"></i>
                                                            {{ $dataPeminjaman->ket_peminjaman }}
                                                        </div>
                                                        <div
                                                            class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded inline-block w-fit">
                                                            transaksi at :
                                                            {{ date('d M Y, h:i', strtotime($dataPeminjaman->created_at)) }}
                                                            WIB
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 align-top">
                                                    <div class="flex flex-col">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <i class="fa-solid fa-calendar-day text-primary"></i>
                                                            <span class="text-slate-900 font-medium">
                                                                @if ($dataPeminjaman->tgl_pinjam_usage_room != null)
                                                                    @if (date('d M y', strtotime($dataPeminjaman->tgl_pinjam_usage_room)) ===
                                                                            date('d M y', strtotime($dataPeminjaman->tgl_kembali_usage_room)))
                                                                        {{ date('d M y', strtotime($dataPeminjaman->tgl_pinjam_usage_room)) }}
                                                                    @else
                                                                        {{ date('d M', strtotime($dataPeminjaman->tgl_pinjam_usage_room)) }}
                                                                        -
                                                                        {{ date('d M y', strtotime($dataPeminjaman->tgl_kembali_usage_room)) }}
                                                                    @endif
                                                                @else
                                                                    @if (date('d M y', strtotime($dataPeminjaman->tgl_pinjam_usage_item)) ===
                                                                            date('d M y', strtotime($dataPeminjaman->tgl_kembali_usage_item)))
                                                                        {{ date('d M y', strtotime($dataPeminjaman->tgl_pinjam_usage_item)) }}
                                                                    @else
                                                                        {{ date('d M', strtotime($dataPeminjaman->tgl_pinjam_usage_item)) }}
                                                                        -
                                                                        {{ date('d M y', strtotime($dataPeminjaman->tgl_kembali_usage_item)) }}
                                                                    @endif
                                                                @endif
                                                            </span>
                                                        </div>
                                                        {{-- <span class="text-xs text-slate-500 pl-6">
                                                        10:00 - 12:00 (2 Jam)
                                                    </span> --}}
                                                        @if ($dataPeminjaman->jam_mulai_usage_room != null || $dataPeminjaman->jam_mulai_usage_item != null)
                                                            <div class="flex items-center gap-2 mb-1 ">
                                                                <i class="fa-solid fa-clock text-gray-700 text-xs"></i>
                                                                <span class="text-xs text-slate-500">
                                                                    @if ($dataPeminjaman->jam_mulai_usage_room != null)
                                                                        {{ date('H : i', strtotime($dataPeminjaman->jam_mulai_usage_room)) }}
                                                                        -
                                                                        {{ date('H : i', strtotime($dataPeminjaman->jam_selesai_usage_room)) }}
                                                                        WIB
                                                                    @else
                                                                        {{ date('H : i', strtotime($dataPeminjaman->jam_mulai_usage_item)) }}
                                                                        -
                                                                        {{ date('H : i', strtotime($dataPeminjaman->jam_selesai_usage_item)) }}
                                                                        WIB
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="flex items-center gap-2 mb-1 ">
                                                                <i class="fa-solid fa-clock text-gray-700 text-xs"></i>
                                                                <span class="text-xs text-slate-500">Durasi
                                                                    Penuh</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 align-top">
                                                    @if ($dataPeminjaman->status_peminjaman === 'diajukan')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                                            <span
                                                                class="size-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                                            Menunggu
                                                        </span>
                                                    @elseif ($dataPeminjaman->status_peminjaman === 'terjadwal')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-orange-200">
                                                            <span
                                                                class="size-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                            Terjadwal
                                                        </span>
                                                    @elseif ($dataPeminjaman->status_peminjaman === 'digunakan')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-orange-200">
                                                            <span
                                                                class="size-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                            Digunakan
                                                        </span>
                                                    @elseif ($dataPeminjaman->status_peminjaman === 'dibatalkan')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-orange-200">
                                                            <span
                                                                class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                                            Dibatalkan
                                                        </span>
                                                    @elseif ($dataPeminjaman->status_peminjaman === 'ditolak')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-orange-200">
                                                            <span
                                                                class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                                            Ditolak
                                                        </span>
                                                    @elseif ($dataPeminjaman->status_peminjaman === 'selesai')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-orange-200">
                                                            <span
                                                                class="size-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                            selesai
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right align-middle">
                                                    <form method="GET"
                                                        action="/admin/pengajuan-peminjaman/detail/{{ $dataPeminjaman->kode_peminjaman }}">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-slate-400 hover:text-primary hover:bg-slate-100 transition-colors p-2 rounded-full">
                                                            <i class="fa-solid fa-chevron-right"></i>
                                                        </button>
                                                    </form>
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
                                    <span
                                        class="text-slate-900 font-bold">{{ $dataPengajuanPeminjaman->count() }}</span>
                                    dari
                                    <span
                                        class="text-slate-900 font-bold">{{ $dataPengajuanPeminjaman->total() }}</span>
                                    data
                                </div>

                                <div class="flex gap-2">
                                    {{-- Tombol ke Halaman Sebelumnya --}}
                                    @if ($dataPengajuanPeminjaman->onFirstPage())
                                        <button
                                            class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-300 bg-gray-50 cursor-not-allowed"
                                            disabled>
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </button>
                                    @else
                                        <a href="{{ $dataPengajuanPeminjaman->previousPageUrl() }}"
                                            class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </a>
                                    @endif

                                    {{-- Nomor Halaman --}}
                                    @foreach ($dataPengajuanPeminjaman->getUrlRange(1, $dataPengajuanPeminjaman->lastPage()) as $page => $url)
                                        @if ($page == $dataPengajuanPeminjaman->currentPage())
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
                                    @if ($dataPengajuanPeminjaman->hasMorePages())
                                        <a href="{{ $dataPengajuanPeminjaman->nextPageUrl() }}"
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
                </div>
            </div>
        </div>
    </div>
</main>
