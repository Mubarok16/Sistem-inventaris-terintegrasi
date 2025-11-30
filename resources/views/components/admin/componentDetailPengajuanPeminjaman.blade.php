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

{{-- data peminjam --}}
<div class="flex flex-col gap-8 mt-4">
    <!-- Section 1: Permohonan Peminjaman -->
    <section class="bg-white rounded-md p-6 shadow-sm">
        <!-- SectionHeader -->
        <h3 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] pb-2">
            Data peminjam</h3>
        <!-- Table -->

        <div class="@container pb-4">
            <div class="text-gray-600">
                @foreach ($dataDetailPengajuanPeminjaman as $dataPeminjaman)
                    <table>
                        <tr>
                            <td>Kode Transaksi</td>
                            <td class="pl-4!">: {{ $dataPeminjaman->kode_peminjaman }}</td>
                        </tr>
                        <tr>
                            <td>Nama Peminjam</td>
                            <td class="pl-4!">: {{ $dataPeminjaman->nama_peminjam }}</td>
                        </tr>
                        <tr>
                            <td>tanggal transaksi</td>
                            <td class="pl-4!">: {{ date('d-m-Y', strtotime($dataPeminjaman->tgl_tansaksi)) }}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td class="pl-4!">: {{ $dataPeminjaman->ket_peminjaman }}</td>
                        </tr>
                        <tr>
                            <td>status peminjaman</td>
                            <td class="pl-4!">: {{ $dataPeminjaman->status_peminjaman }}</td>
                        </tr>
                        <tr>
                            <td>File lampiran</td>
                            <td class="pl-4!">
                                <form method="GET"
                                    action="/admin/pengajuan-peminjaman/detail/{{ $dataPeminjaman->kode_peminjaman }}">
                                    @csrf
                                    :
                                    <button
                                        class="px-2 py-1.5 text-sm font-sm text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-background-dark">
                                        download file
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </table>
                @endforeach
            </div>
        </div>
        <form method="POST" action="{{ route('persetujuanPeminjaman') }}">
            @csrf
            @foreach ($dataDetailPengajuanPeminjaman as $dataPeminjaman)
                <div class="items-center gap-4 mb-2">
                    <button
                        class="px-3 py-1.5 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-background-dark">
                        Approve
                    </button>
                    <button
                        class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-background-dark">
                        Reject
                    </button>
                    <input type="text" name="kode_peminjaman" value="{{ $dataPeminjaman->kode_peminjaman }}"
                        class="hidden">
                </div>
            @endforeach
        </form>
    </section>
</div>

{{-- list barang --}}
<div class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Daftar barang yang diajukan</h5>

    <div class="relative overflow-x-auto bg-neutral-primary-soft">
        {{-- table detail barang --}}
        <table class="w-full text-left table-striped text-sm">
            <thead class="sticky top-0 z-1 bg-primary">
                <tr class="text-white">
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nama Barang
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        qty pinjam
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal pinjam
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal kembali
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        status penggunaan barang
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($dataDetailPengajuanPeminjamanBarang->isEmpty())
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="4">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @else
                    @foreach ($dataDetailPengajuanPeminjamanBarang as $detailBarang)
                        <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">

                            <th scope="row" class="px-6 py-4 font-normal!">
                                {{ $detailBarang->nama_item }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $detailBarang->qty_usage_item }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('d-m-Y', strtotime($detailBarang->tgl_pinjam_usage_item)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('d-m-Y', strtotime($detailBarang->tgl_kembali_usage_item)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $detailBarang->status_usage_item }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- list ruangan --}}
<div class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Daftar ruangan yang diajukan</h5>

    <div class="relative overflow-x-auto bg-neutral-primary-soft">
        {{-- table detail barang --}}
        <table class="w-full text-left table-striped text-sm">
            <thead class="sticky top-0 z-1 bg-primary">
                <tr class="text-white">
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nama Ruangan
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        qty pinjam
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal pinjam
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal kembali
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        status penggunaan barang
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($dataDetailPengajuanPeminjamanRuangan->isEmpty())
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="5">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @else
                    @foreach ($dataDetailPengajuanPeminjamanRuangan as $detailRuangan)
                        <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                {{ $detailRuangan->nama_item }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $detailRuangan->qty_usage_item }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('d-m-Y', strtotime($detailRuangan->tgl_pinjam_usage_item)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('d-m-Y', strtotime($detailRuangan->tgl_kembali_usage_item)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $detailRuangan->status_usage_item }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
