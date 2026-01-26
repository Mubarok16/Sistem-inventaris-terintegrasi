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
<hr class="border-1 border-gray-100 my-4">
<main class="flex-1 overflow-y-auto bg-background-light my-4 py-4 px-2">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Page Heading -->
        @foreach ($dataDetailPengajuanPeminjaman as $dataPeminjaman)
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h5 class="text-md! font-bold text-slate-900 tracking-tight">
                            Peminjaman : {{ $dataPeminjaman->kode_peminjaman }}
                        </h5>
                        @if ($dataPeminjaman->status_peminjaman === 'diajukan')
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                Menunggu Persetujuan
                            </span>
                        @elseif($dataPeminjaman->status_peminjaman === 'terjadwal')
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                Terjadwal
                            </span>
                        @elseif($dataPeminjaman->status_peminjaman === 'digunakan')
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                Sedang Digunakan
                            </span>
                        @elseif($dataPeminjaman->status_peminjaman === 'terlambat')
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700 border border-red-200">
                                Terlambat
                            </span>
                        @elseif($dataPeminjaman->status_peminjaman === 'ditolak')
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700 border border-red-200">
                                Ditolak
                            </span>
                        @elseif($dataPeminjaman->status_peminjaman === 'selesai')
                            <span
                                class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700 border border-green-200">
                                Selesai
                            </span>
                        @endif
                    </div>
                    <span class="text-slate-500">Diajukan pada
                        {{ date('d F Y, h:i', strtotime($dataPeminjaman->tgl_tansaksi)) }} WIB</span>
                </div>
            </div>
            <!-- Info Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Borrower Card -->
                <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm flex flex-col gap-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-user text-primary"></i>
                            Informasi Peminjam
                        </h5>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="size-14 rounded-full bg-slate-100 overflow-hidden flex-shrink-0"
                            data-alt="Foto profil peminjam"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB2wVH5Oe0MPu9I_JUUYthNseKoKM0-WHbb1pkPPSmOAXJa-VUwQvYCfwDdXdkIkqJD4uW6ex0iIP8jZQWWldz1mvra-DSvK7aO9VbCCPjVQn3d9cqDxxSk2JedMdyBsi0LAMkDxAbxHK5JJuVdNqCAMACxFxLy1NvAkXLi4bNNub71XFs3WhNAsveHOO27QjkSAcDLiRdkR41hp9_QPhWgPn3ZzpfSQZKHuCpq9zknby5YwdKDByuOQtwIm6z2yGbPCTjKrnAqzu0')">
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-lg">
                                {{ $dataPeminjaman->nama_peminjam }}
                            </p>
                            <p class="text-sm text-slate-500">
                                NPM:
                                {{ $dataPeminjaman->no_identitas }}
                            </p>
                            <div class="mt-2 flex flex-col gap-1">
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <i class="fa-solid fa-university text-base"></i>
                                    <span>Fakultas {{ $dataPeminjaman->fakultas }},
                                        {{ $dataPeminjaman->prodi }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Timeline & Purpose Card -->
                <div
                    class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row items-center justify-between border-b border-slate-100 pb-4">
                        <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-primary"></i>
                            Detail Jadwal &amp; Keperluan
                        </h5>
                        <button
                            class="flex items-center gap-2 px-2 py-2 w-full md:w-auto bg-blue-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-blue-700 transition-colors shadow-sm">
                            <i class="fa-solid fa-print text-md text-white"></i>
                            <span class="text-white text-md">Lampiran file</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal
                                    Peminjaman</span>
                                <div class="flex items-center gap-2 text-slate-900 font-medium">
                                    <i class="fa-solid fa-right-to-bracket text-green-600"></i>
                                    {{ date('d F Y', strtotime($tglPinjam)) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Rencana
                                    Pengembalian</span>
                                <div class="flex items-center gap-2 text-slate-900 font-medium">
                                    <i class="fa-solid fa-right-from-bracket text-red-500"></i>
                                    {{ date('d F Y', strtotime($tglKembali)) }}
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Keterangan
                                Peminjaman atau nama kegiatan</span>
                            <p
                                class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-2 rounded-lg border border-slate-100">
                                {{ $dataPeminjaman->ket_peminjaman }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Items & room List -->
        <div x-data="{ open: true }" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div @click="open = !open"
                class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-white cursor-pointer">
                <h5 class="font-semibold text-slate-900">Daftar Penggunaan Barang &amp; Ruangan</h5>
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
                        @foreach ($DetailRiwayatPerHari as $detail)
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
                                                            <i class="fa-solid fa-door-open"></i>
                                                        @else
                                                            <i class="fa-solid fa-box"></i>
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
            <div class="bg-yellow-50 border-l-4 border-yellow-400 px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center"> <i class="fa-solid fa-triangle-exclamation text-yellow-500 mr-3"></i>
                    <span class="text-sm text-yellow-800 leading-none">
                        Pastikan menunjukkan QR CODE dibawah saat melakukan pengambilan barang dan pengembalian
                    </span>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('QR-dan-batal-peminjaman') }}">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-100">
                        @foreach ($dataDetailPengajuanPeminjaman as $dataPeminjaman)
                            <div class="items-center gap-4 mb-2">
                                <button type="submit" name="aksi" value="QR"
                                    class="px-3 py-1.5 text-sm font-medium border rounded-md! text-white bg-blue-500 hover:bg-blue-600">
                                    <i class="fas fa-qrcode"></i>
                                    QR Code
                                </button>
                                @if (
                                    $dataPeminjaman->status_peminjaman === 'dipinjam' ||
                                        $dataPeminjaman->status_peminjaman === 'selesai' ||
                                        $dataPeminjaman->status_peminjaman === 'terlambat' ||
                                        $dataPeminjaman->status_peminjaman === 'dibatalkan' ||
                                        $dataPeminjaman->status_peminjaman === 'ditolak')
                                @else
                                    <button type="submit" name="aksi" value="batal"
                                        class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 border rounded-md! hover:bg-red-600">
                                        batal meminjam
                                    </button>
                                @endif

                                <input type="text" name="kode_peminjaman"
                                    value="{{ $dataPeminjaman->kode_peminjaman }}" class="hidden">
                                <input type="text" name="status_peminjaman"
                                    value="{{ $dataPeminjaman->status_peminjaman }}" class="hidden">
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
