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

<hr class="border-1 border-gray-100 my-3">
<main class="flex-1 overflow-y-auto bg-background-light my-4 py-4 px-2">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Page Heading -->
        @foreach ($dataDetailPengajuanPeminjaman as $dataPeminjaman)
            <div class="w-full!">
                <!-- Timeline & Purpose Card -->
                <div
                    class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col gap-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-primary"></i>
                            Detail Jadwal &amp; Keperluan
                        </h5>
                        <div class="flex gap-2">
                            <form action="{{ route('edit-agenda-admin', ['id' => urlencode($dataPeminjaman->kode_agenda)]) }}"
                                method="get">
                                @csrf
                                <button
                                    class="flex items-center gap-2 px-4 py-2 bg-green-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-green-700 transition-colors shadow-sm">
                                    <i class="fas fa-edit text-white"></i>
                                    <span class="text-white">Edit</span>
                                </button>
                            </form>
                            <form action="{{ route('hapus-agenda') }}"
                                method="post">
                                @csrf
                                <input type="text" name="kode_agenda" class="hidden" value="{{ $dataPeminjaman->kode_agenda }}">
                                <button
                                    class="flex items-center gap-2 px-4 py-2 bg-red-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-red-700 transition-colors shadow-sm">
                                    <i class="fas fa-trash text-white"></i>
                                    <span class="text-white">hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal
                                    Peminjaman</span>
                                <div class="flex items-center gap-2 text-slate-900 font-medium">
                                    <i class="fa-solid fa-right-to-bracket text-green-600"></i>
                                    {{ date('d F Y', strtotime($dataPeminjaman->tgl_mulai_agenda)) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Rencana
                                    Pengembalian</span>
                                <div class="flex items-center gap-2 text-slate-900 font-medium">
                                    <i class="fa-solid fa-right-from-bracket text-red-500"></i>
                                    {{ date('d F Y', strtotime($dataPeminjaman->tgl_selesai_agenda)) }}
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Nama Agenda</span>
                            <p
                                class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-2 rounded-lg border border-slate-100">
                                {{ $dataPeminjaman->nama_agenda }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- bentrok -->
        @if (!$itemBentrok->isEmpty() || !$roomBentrok->isEmpty())

            <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex flex-col sm:flex-row gap-3 items-start">
                <div class="p-3.5 bg-red-100 rounded-lg shrink-0 text-red-600">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-base font-bold text-red-800">Terdeteksi Bentrokan Jadwal</h4>
                        <span
                            class="text-xs font-bold px-2.5 py-1 bg-red-100 text-red-700 rounded border border-red-200">Perlu
                            Peninjauan</span>
                    </div>
                    <p class="text-sm text-red-700 mb-2 leading-relaxed">
                        Sistem mendeteksi adanya tumpang tindih jadwal penggunaan dalam
                        transaksi ini. Mohon verifikasi atau hubungi peminjam untuk penjadwalan ulang sebelum
                        menyetujui.
                    </p>
                    @foreach ($itemBentrok as $item)
                        <div class="bg-white rounded-lg border border-red-100 overflow-hidden shadow-sm mb-2">
                            <div class="py-2 px-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start sm:items-center gap-3">
                                    <div
                                        class="size-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden flex-shrink-0">
                                        <div class="size-full bg-cover bg-center"
                                            style="background-image: url('{{ asset('storage/' . $item['img_item']) }}')">
                                        </div>
                                    </div>
                                    <div>
                                        <span
                                            class="text-sm font-semibold text-slate-900">{{ $item['nama_item'] }}</span>
                                        <p class="text-xs text-red-600 flex flex-wrap items-center gap-1 mt-0.5">
                                            <i class="fa-solid fa-calendar-xmark text-[14px]"></i>
                                            Bentrok dengan
                                            @if ($item['tipe_agenda'] != null)
                                                @if ($item['tipe_agenda'] === 'kegiatan belajar mengajar')
                                                    KBM
                                                @elseif ($item['tipe_agenda'] === 'seminar')
                                                    seminar
                                                @elseif ($item['tipe_agenda'] === 'rapat pimpinan')
                                                    rapat pimpinan
                                                @endif
                                            @endif
                                            :
                                            <span
                                                class="font-bold">{{ $item['nama_agenda'] === null ? $item['ket_peminjaman'] : $item['nama_agenda'] }}</span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    @foreach ($roomBentrok as $room)
                        <div class="bg-white rounded-lg border border-red-100 overflow-hidden mb-2 shadow-sm">
                            <div class="py-2 px-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start sm:items-center gap-3">
                                    <div
                                        class="size-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden flex-shrink-0">
                                        <div class="size-full bg-cover bg-center"
                                            style="background-image: url('{{ asset('storage/' . $room['gambar_room']) }}')">
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-900">Ruang
                                            {{ $room['nama_room'] }}</span>
                                        <p class="text-xs text-red-600 flex flex-wrap items-center gap-1 mt-0.5">
                                            <i class="fa-solid fa-calendar-xmark text-[14px]"></i>
                                            Bentrok dengan
                                            @if ($room['tipe_agenda'] != null)
                                                @if ($room['tipe_agenda'] === 'kegiatan belajar mengajar')
                                                    KBM
                                                @elseif ($room['tipe_agenda'] === 'seminar')
                                                    seminar
                                                @elseif ($room['tipe_agenda'] === 'rapat pimpinan')
                                                    rapat pimpinan
                                                @endif
                                            @endif
                                            :
                                            <span class="font-bold">
                                                {{ $room['nama_agenda'] === null ? $room['ket_peminjaman'] : $room['nama_agenda'] }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @else
        @endif

        <!-- Items & room List -->
        <div x-data="{ open: true }" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div @click="open = !open"
                class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50/50 cursor-pointer">
                <h5 class="font-semibold text-slate-900">Daftar Barang &amp; Ruangan</h5>
                <div class="flex items-center text-slate-500">
                    <i class="fa-solid fa-chevron-down transition-transform duration-300 text-sm"
                        :class="open ? 'rotate-180' : 'rotate-0'"></i>
                </div>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="overflow-x-auto">

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-semibold tracking-wider">
                            {{-- <th class="px-6 py-3">Detail Item</th> --}}
                            <th class="px-6 py-3">Jadwal Penggunaan</th>
                            {{-- <th class="px-6 py-3 text-center">Jumlah</th> --}}
                            <th class="px-6 py-3">Kondisi</th>
                            <th class="px-6 py-3">Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" x-data="{ selected: null }">

                        {{-- barang dan ruangan --}}
                        @foreach ($dataAgendaPerhari as $detail)
                            @php $rowId = $loop->index; @endphp
                            <tr @click="selected !== {{ $rowId }} ? selected = {{ $rowId }} : selected = null"
                                class="group cursor-pointer hover:bg-slate-50 transition-colors"
                                :class="selected === {{ $rowId }} ? 'bg-slate-50' : ''">
                                <td class="px-6 py-4">
                                    @if ($detail['jam_mulai'] != null && $detail['jam_selesai'] != null)
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                                <i class="fa-solid fa-calendar-days text-base text-primary"></i>
                                                <span>
                                                    {{ date('d M Y', strtotime($detail['tanggal'])) }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                                <i class="fa-solid fa-clock text-base"></i>
                                                <span>{{ date('H:i', strtotime($detail['jam_mulai'])) }}
                                                    -
                                                    {{ date('H:i', strtotime($detail['jam_selesai'])) }}
                                                    WIB</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-sm text-slate-600">
                                            <i class="fa-solid fa-calendar-days text-base text-primary"></i>
                                            <span>
                                                {{ date('d F Y', strtotime($detail['tanggal'])) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-slate-600">
                                            <i class="fa-solid fa-clock text-base"></i>
                                            <span>Full day</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-green-600 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-base"></i>
                                        {{ $detail['kondisi'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    {{-- {{ $detail['status'] }} --}}
                                    @if ($detail['status'] === 'diajukan')
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif($detail['status'] === 'terjadwal')
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                            Terjadwal
                                        </span>
                                    @elseif($detail['status'] === 'digunakan')
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                            Sedang Digunakan
                                        </span>
                                    @elseif($detail['status'] === 'terlambat')
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700 border border-red-200">
                                            Terlambat
                                        </span>
                                    @elseif($detail['status'] === 'ditolak')
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700 border border-red-200">
                                            Ditolak
                                        </span>
                                    @elseif($detail['status'] === 'selesai')
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700 border border-green-200">
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                            </tr>

                            <tr x-show="selected === {{ $rowId }}" x-cloak x-transition>
                                <td colspan="3" class="px-6 py-0 bg-slate-50/50">
                                    <div class="flex flex-col border-x border-slate-100">
                                        @foreach ($detail['barang_ruang'] as $item)
                                            <div
                                                class="flex items-center justify-between px-10 py-3 border-b border-slate-100 last:border-none">
                                                <div class="flex items-center gap-4">
                                                    <div
                                                        class="w-10 h-10 flex items-center justify-center rounded-full {{ isset($item['nama_room']) ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600' }}">
                                                        @if (isset($item['nama_room']))
                                                            <div
                                                                class="size-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden flex-shrink-0">
                                                                <div class="size-full bg-cover bg-center"
                                                                    style="background-image: url('{{ asset('storage/' . $item['gambar_room']) }}')">
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div
                                                                class="size-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden flex-shrink-0">
                                                                <div class="size-full bg-cover bg-center"
                                                                    style="background-image: url('{{ asset('storage/' . $item['img_item'] ) }}')">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-semibold text-slate-700">
                                                            {{ $item['nama_room'] ?? $item['nama_item'] }}
                                                        </span>
                                                        <span class="text-xs text-slate-500">
                                                            {{ $item['nama_tipe_room'] ?? $item['nama_tipe_item'] }}
                                                        </span>
                                                    </div>
                                                </div>

                                                @if (isset($item['qty']))
                                                    <div
                                                        class="text-sm font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-full">
                                                        Jumlah: <span class="text-primary">{{ $item['qty'] }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Area -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
            <h5 class="font-semibold text-slate-900 mb-4">Catatan Staff &amp; Aksi</h5>
            <div class="flex flex-col gap-6">
                <form method="POST" action="{{ route('persetujuanPeminjaman') }}">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2" for="notes">Catatan Tambahan
                            (Opsional)</label>
                        <textarea name="catatan"
                            class="w-full rounded-lg border-1 border-slate-300 bg-white text-slate-900! focus:outline-none focus:ring-primary sm:text-sm p-3"
                            placeholder="Tambahkan catatan untuk peminjam..." rows="3"></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-100">

                        @foreach ($dataDetailPengajuanPeminjaman as $dataPeminjaman)
                            <div class="items-center gap-4 mb-2">
                                <button type="submit" name="aksi" value="approve"
                                    class="px-3 py-1.5 text-sm font-medium border rounded-md! text-white bg-blue-500 hover:bg-blue-600">
                                    Approve
                                </button>
                                <button type="submit" name="aksi" value="reject"
                                    class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 border rounded-md! hover:bg-red-600">
                                    Reject
                                </button>
                                <input type="text" name="kode_agenda" value="{{ $dataPeminjaman->kode_agenda }}"
                                    class="hidden">
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
