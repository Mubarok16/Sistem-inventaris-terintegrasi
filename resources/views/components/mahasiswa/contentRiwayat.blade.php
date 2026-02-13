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

<div class="relative flex min-h-screen flex-col">
    <main class="flex-1 flex flex-col items-center py-1 px-1 md:px-10 lg:px-20">
        <div class="w-full max-w-[1024px] flex flex-col gap-6">
            <!-- Controls: Search & Filter -->

            <!-- Filters -->
            <form action="{{ route('simpan-riwayat-session') }}" method="post">
                <div
                    class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
                    @csrf
                    <div class="flex! gap-1 bg-slate-100 p-1 rounded-lg w-full sm:w-auto overflow-x-auto">
                        <button value="semua" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'semua' ? 'bg-white rounded shadow-sm' : '' }}  transition-all whitespace-nowrap">
                            Semua
                        </button>
                        <button value="diajukan" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'diajukan' ? 'bg-white rounded shadow-sm' : '' }}  transition-all whitespace-nowrap">
                            Menunggu
                        </button>
                        <button value="ditolak" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'ditolak' ? 'bg-white rounded shadow-sm' : '' }} transition-all whitespace-nowrap">
                            Ditolak
                        </button>
                        <button value="terjadwal" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'terjadwal' ? 'bg-white rounded shadow-sm' : '' }} transition-all whitespace-nowrap">
                            Disetujui
                        </button>
                        <button value="dipinjam" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'dipinjam' ? 'bg-white rounded shadow-sm' : '' }} transition-all whitespace-nowrap">
                            Digunakan
                        </button>
                        <button value="terlambat" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'terlambat' ? 'bg-white rounded shadow-sm' : '' }} transition-all whitespace-nowrap">
                            Terlambat
                        </button>
                        <button value="dibatalkan" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'dibatalkan' ? 'bg-white rounded shadow-sm' : '' }} transition-all whitespace-nowrap">
                            Dibatalkan
                        </button>
                        <button value="selesai" name="status"
                            class="px-4 py-2 text-sm font-medium text-slate-500 {{ $status_penggunaan === 'selesai' ? 'bg-white rounded shadow-sm' : '' }} transition-all whitespace-nowrap">
                            Selesai
                        </button>
                    </div>

                </div>
            </form>

            <!-- Content List -->
            <div class="flex flex-col gap-3 mb-6">

                <!-- Item -->
                @if ($dataPeminjamanByPeminjam->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 px-4 py-3 mb-2 rounded-lg">
                        <div class="flex items-center"> <i
                                class="fa-solid fa-triangle-exclamation text-yellow-500 mr-3"></i>
                            <span class="text-sm text-yellow-700 leading-none"> Belum ada data riwayat peminjaman untuk
                                kategori ini.
                            </span>
                        </div>
                    </div>
                @else
                    @foreach ($dataPeminjamanByPeminjam as $riwayat)
                        <div
                            class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden ring-1 ring-primary/20">
                            <div
                                class="px-4 py-3 flex flex-col md:flex-row gap-2 justify-between items-start md:items-center border-b border-slate-100 bg-slate-50/50 cursor-pointer">
                                <div class="flex flex-col gap-1.5 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-bold text-slate-900 text-md tracking-tight uppercase">
                                            {{ $riwayat->ket_peminjaman }}
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium md:ml-0! tracking-tight">
                                            {{ $riwayat->kode_peminjaman }}
                                        </span>

                                        @if ($riwayat->status_peminjaman === 'diajukan')
                                            <span
                                                class="bg-amber-100 text-amber-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-amber-200">
                                                menunggu persetujuan
                                            </span>
                                        @elseif ($riwayat->status_peminjaman === 'ditolak')
                                            <span
                                                class="bg-red-100 text-red-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-red-200">
                                                ditolak
                                            </span>
                                        @elseif ($riwayat->status_peminjaman === 'terjadwal')
                                            <span
                                                class="bg-blue-100 text-blue-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-blue-200">
                                                disetujui (terjadwal)
                                            </span>
                                        @elseif ($riwayat->status_peminjaman === 'dipinjam')
                                            <span
                                                class="bg-blue-100 text-blue-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-blue-200">
                                                digunakan
                                            </span>
                                        @elseif ($riwayat->status_peminjaman === 'terlambat')
                                            <span
                                                class="bg-red-100 text-red-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-red-200">
                                                terlambat dikembalikan!
                                            </span>
                                        @elseif ($riwayat->status_peminjaman === 'dibatalkan')
                                            <span
                                                class="bg-gray-100 text-gray-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-gray-200">
                                                dibatalkan
                                            </span>
                                        @elseif ($riwayat->status_peminjaman === 'selesai')
                                            <span
                                                class="bg-green-100 text-green-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-green-200">
                                                selesai
                                            </span>
                                        @endif


                                    </div>
                                    <div
                                        class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-600 mt-1">

                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-calendar"></i>
                                            <span class="text-xs">
                                                {{ date('d M Y', strtotime($riwayat->tgl_pinjam_usage_item != null ? $riwayat->tgl_pinjam_usage_item : $riwayat->tgl_pinjam_usage_room)) }}
                                                -
                                                <span class="text-orange-600 font-medium">
                                                    {{ date('d M Y', strtotime($riwayat->tgl_kembali_usage_item != null ? $riwayat->tgl_kembali_usage_item : $riwayat->tgl_kembali_usage_room)) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-clock text-slate-400"></i>
                                            <span class="text-xs">
                                                @if ($riwayat->jam_mulai_usage_item != null)
                                                    {{ date('H:i', strtotime($riwayat->jam_mulai_usage_item)) }}
                                                    -
                                                    {{ date('H:i', strtotime($riwayat->jam_selesai_usage_item)) }}
                                                @elseif($riwayat->jam_mulai_usage_room != null)
                                                    {{ date('H:i', strtotime($riwayat->jam_mulai_usage_room)) }}
                                                    -
                                                    {{ date('H:i', strtotime($riwayat->jam_selesai_usage_room)) }}
                                                @else
                                                    Full day
                                                @endif
                                                
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 self-end md:self-center">
                                    <form
                                        action="{{ route('mhs-riwayat-detail', ['id' => $riwayat->kode_peminjaman]) }}"
                                        method="get">
                                        @csrf
                                        <button value=""
                                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-100! text-slate-700 rounded-lg! text-sm font-medium transition-colors ">
                                            <span>Detail</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
          
        </div>
    </main>
</div>
