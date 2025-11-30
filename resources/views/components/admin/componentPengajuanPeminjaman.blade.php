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

<div class="flex flex-col gap-8 mt-4">
    <!-- Section 1: Permohonan Peminjaman -->
    <section class="bg-white rounded-md p-6 shadow-sm">
        <!-- SectionHeader -->
        <h3 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] pb-4">
            Data permohonan peminjaman</h3>
        <!-- Table -->
        <div class="@container">
            <div class="max-h-70 overflow-y-auto overflow-x-auto">
                <table class="w-full text-left table-striped ">
                    <thead class="sticky top-0 z-1 bg-primary">
                        <tr class="text-white">
                            <th class="px-4 py-3 text-left text-white text-sm font-semibold">
                                Kode Peminjaman
                            </th>
                            <th class="px-4 py-3 text-left text-white text-sm font-semibold">
                                Nama Peminjam</th>
                            <th class="px-4 py-3 text-left text-white text-sm font-semibold">
                                Tgl transaksi</th>
                            {{-- <th class="px-4 py-3 text-left text-white text-sm font-semibold">
                                Tgl kembali</th> --}}
                            <th class="px-4 py-3 text-left text-white text-sm font-semibold">
                                Keterangan</th>
                            <th class="px-4 py-3 text-left text-white text-sm font-semibold">
                                status</th>
                            <th class="px-4 py-3 text-center text-white text-sm font-semibold">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 ">
                        @if ($dataPengajuanPeminjaman->isEmpty())
                            <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                                <td class="px-4 py-3 text-sm font-normal text-center" colspan="6">
                                    <span class="text-gray-700 font-semibold">Data kosong!</span>
                                </td>
                            </tr>
                        @else
                            @foreach ($dataPengajuanPeminjaman as $dataPeminjaman)
                                <tr class="text-gray-600">
                                    <td class="h-[72px] px-4 py-2 text-sm font-normal">
                                        {{ $dataPeminjaman->kode_peminjaman }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-sm font-normal">
                                        {{ $dataPeminjaman->nama_peminjam }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-sm font-normal">
                                        {{ date('d-m-Y', strtotime($dataPeminjaman->tgl_tansaksi)) }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-sm font-normal">
                                        {{ $dataPeminjaman->ket_peminjaman }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-sm font-normal">
                                        {{ $dataPeminjaman->status_peminjaman }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            <form method="GET"
                                                action="/admin/pengajuan-peminjaman/detail/{{ $dataPeminjaman->kode_peminjaman }}">
                                                @csrf
                                                <button
                                                    class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-background-dark">
                                                    Detail
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
        </div>
    </section>

    <!-- Section 2: Inventaris Dipinjam -->
    <section class="bg-white dark:bg-gray-900/50 rounded-md p-6 shadow-sm mb-4">
        <!-- SectionHeader -->
        <h3 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] pb-4">
            Data inventaris yang sedang di pinjam</h3>
        <!-- Table -->
        <div class="@container">
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-left table-striped ">
                    <thead class="sticky top-0 z-1 bg-primary">
                        <tr class="text-white">
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Kode transaksi</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Nama Peminjam</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Tgl pinjam</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Tgl kembali</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Keterangan</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- {{ $dataPeminjaman->isEmpty() }} --}}
                        @if ($dataPeminjamanDisetujui->isEmpty())
                            <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                                <td class="px-4 py-3 text-sm font-normal text-center" colspan="7">
                                    <span class="text-gray-700 font-semibold">Data kosong!</span>
                                </td>
                            </tr>
                        @else
                            @foreach ($dataPeminjamanDisetujui as $dataApprove)
                                <tr>
                                    <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-normal">
                                        {{ $dataApprove->kode_peminjaman }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-normal">
                                        {{ $dataApprove->nama_peminjam }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-normal">
                                        {{ $dataApprove->tgl_tansaksi }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-normal">
                                        {{ $dataApprove->updated_at }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-normal">
                                        {{ $dataApprove->ket_peminjaman }}
                                    </td>
                                    <td class="h-[72px] px-4 py-2">
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-300 px-2.5 py-0.5 text-xs font-medium text-green-800 ">
                                            {{ $dataApprove->status_peminjaman }}
                                        </span>
                                    </td>
                                    <td class="h-[72px] px-4 py-2">
                                        <button
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-background-dark">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
