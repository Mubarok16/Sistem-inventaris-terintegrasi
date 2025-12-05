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
            Data Agenda</h3>
        <!-- Table -->

        <div class="@container pb-2">
            <div class="text-gray-600">
                @foreach ($DataAgenda as $DataAgenda)
                    <table>
                        <tr>
                            <td>Kode Agenda</td>
                            <td class="pl-4!">: {{ $DataAgenda->kode_agenda }}</td>
                        </tr>
                        <tr>
                            <td>Nama Agenda</td>
                            <td class="pl-4!">: {{ $DataAgenda->nama_agenda }}</td>
                        </tr>
                        <tr>
                            <td>tanggal mulai agenda</td>
                            <td class="pl-4!">: {{ date('d-m-Y', strtotime($DataAgenda->tgl_mulai_agenda)) }}</td>
                        </tr>
                        <tr>
                            <td>tanggal selesai agenda</td>
                            <td class="pl-4!">: {{ date('d-m-Y', strtotime($DataAgenda->tgl_selesai_agenda)) }}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td class="pl-4!">: {{ $DataAgenda->tipe_agenda }}</td>
                        </tr>
                    </table>
                    <div class="flex gap-2 mt-2">
                        <form method="POST" action="">
                            @csrf
                            <button
                                class="px-3 py-1.5 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-background-dark">
                                edit
                            </button>
                            <input type="text" name="kode_agenda" value="{{ $DataAgenda->kode_agenda }}"
                                class="hidden">
                        </form>
                        <form method="POST" action="{{ route('hapus-agenda') }}">
                            @csrf
                            <button
                                class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-background-dark">
                                hapus
                            </button>
                            <input type="text" name="kode_agenda" value="{{ $DataAgenda->kode_agenda }}"
                                class="hidden">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

{{-- data usage barang --}}
<div class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Daftar Barang yang digunakan</h5>

    <div class="relative overflow-x-auto bg-neutral-primary-soft">
        
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
                        tanggal mulai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal selesai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        jam mulai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        jam selesai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        status penggunaan barang
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($dataDetailUsageBarang->isEmpty())
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="7">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @else
                    @foreach ($dataDetailUsageBarang as $detailBarang)
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
                                {{ date('H : i', strtotime($detailBarang->tgl_pinjam_usage_item)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('H : i', strtotime($detailBarang->tgl_kembali_usage_item)) }}
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

{{-- data usage ruangan --}}
<div class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Daftar ruangan yang digunakan</h5>

    <div class="relative overflow-x-auto bg-neutral-primary-soft">
       
        <table class="w-full text-left table-striped text-sm">
            <thead class="sticky top-0 z-1 bg-primary">
                <tr class="text-white">
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nama Ruangan
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal mulai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tanggal selesai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        jam mulai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        jam selesai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        status penggunaan barang
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($dataDetailUsageRuangan->isEmpty())
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="6">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @else
                    @foreach ($dataDetailUsageRuangan as $detailRuangan)
                        <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                               {{ $detailRuangan->nama_tipe_room }} {{ $detailRuangan->nama_room }}
                            </th>
                            <td class="px-6 py-4">
                                {{ date('d-m-Y', strtotime($detailRuangan->tgl_pinjam_usage_room)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('d-m-Y', strtotime($detailRuangan->tgl_kembali_usage_room)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('H : i', strtotime($detailRuangan->tgl_pinjam_usage_room)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('H : i', strtotime($detailRuangan->tgl_kembali_usage_room)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $detailRuangan->status_usage_room }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
