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
                        <div
                            class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
                            @csrf
                            <div class="flex! gap-1 bg-slate-100 p-1 rounded-lg w-full sm:w-auto overflow-x-auto">
                                <button value="semua" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'semua' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Semua
                                </button>
                                <button value="diajukan" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'diajukan' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Menunggu
                                </button>
                                <button value="ditolak" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'ditolak' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Ditolak
                                </button>
                                <button value="terjadwal" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'terjadwal' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Terjadwal
                                </button>
                                <button value="dipinjam" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'dipinjam' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Dipinjam
                                </button>
                                <button value="terlambat" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'terlambat' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Terlambat
                                </button>
                                <button value="selesai" name="status"
                                    class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan == 'selesai' ? 'bg-white rounded shadow-sm' : 'hover:text-slate-700' }} transition-all whitespace-nowrap">
                                    Selesai
                                </button>
                            </div>

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
                                                                <span class="text-xs text-slate-500">Durasi Penuh</span>
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
                            <span class="text-xs text-slate-500">Menampilkan 1-4 dari 128
                                data</span>
                            <div class="flex items-center gap-2">
                                <button
                                    class="p-1 rounded text-slate-400 hover:text-slate-600 hover:bg-slate-200 disabled:opacity-50"
                                    disabled="">
                                    <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                                </button>
                                <button class="p-1 rounded text-slate-600 hover:bg-slate-200">
                                    <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


