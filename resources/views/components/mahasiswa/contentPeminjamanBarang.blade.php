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


<div x-data="{ selectedBarang: {} }" class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
    <!-- Left Column: Data Barang -->
    <div class="lg:col-span-2 bg-white shadow-sm rounded-xl p-6">
        <h2 class="text-gray-900 text-lg font-bold leading-tight tracking-[-0.015em] mb-4">
            Data Ruangan</h2>
        <!-- SearchBar -->
        <div class="mb-4">
            <label class="flex flex-col w-full">
                <div class="relative w-full md:w-72">
                    <i
                        class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                        placeholder="Search" type="text" />
                </div>
            </label>
        </div>
        <!-- Table -->
        <div class="shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="sticky top-0 z-1">
                        <tr class="bg-primary text-white">
                            <th
                                class="px-4 py-3 text-center text-white w-16 text-xs font-medium uppercase tracking-wider">
                                Gambar
                            </th>
                            <th
                                class="px-4 py-3 text-center text-white w-1/4 text-xs font-medium uppercase tracking-wider">
                                Nama Barang
                            </th>
                            <th class="px-4 py-3 text-center text-white text-xs font-medium uppercase tracking-wider">
                                Type
                            </th>
                            <th
                                class="px-4 py-3 text-center text-white w-40 text-xs font-medium uppercase tracking-wider">
                                Kondisi
                            </th>
                            <th
                                class="px-4 py-3 text-center text-white w-40 text-xs font-medium uppercase tracking-wider">
                                Cek ketersediaan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataTablePengajuanPeminjaman->isEmpty())
                            <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                                <td class="px-4 py-3 text-sm font-normal text-center" colspan="8">
                                    <span class="text-gray-700 font-semibold">Data kosong!</span>
                                </td>
                            </tr>
                        @else
                            @foreach ($dataTablePengajuanPeminjaman as $dataBarang)
                                <tr class="border-b border-slate-200 ">
                                    <td class="px-4 py-3 text-sm font-normal">
                                        <img src="/storage/{{ $dataBarang->img_item }}"
                                            class=" text-slate-900 hover:text-blue-500 text-center max-w-15 hover:scale-120 hover:grayscale cursor-pointer rounded-sm">
                                    </td>
                                    <td
                                        class="h-[72px] px-4 py-2 text-slate-900 text-sm font-normal leading-normal text-center">
                                        {{ $dataBarang->nama_item }}
                                    </td>
                                    <td
                                        class="h-[72px] px-4 py-2 text-slate-900 text-sm font-normal leading-normal text-center">
                                        {{ $dataBarang->nama_tipe_item }}
                                    </td>
                                    <td
                                        class="h-[72px] px-4 py-2 text-sm font-normal leading-normal items-center text-center">
                                        <span
                                            class="inline-flex items-center rounded-full h-6 px-3 bg-green-600 text-white text-xs font-medium">
                                            {{ $dataBarang->kondisi_item }}
                                        </span>
                                    </td>
                                    <td
                                        class="h-[72px] px-4 py-2 text-sm font-semibold leading-normal items-center! text-center">
                                        <form method="POST" action="{{ route('cek_ketersediaan-barang') }}">
                                            @csrf
                                            <input type="text" name="id_item" class="hidden"
                                                value="{{ $dataBarang->id_item }}">
                                            <button
                                                class="py-1 px-2 text-white bg-blue-500 hover:bg-blue-300 flex items-center gap-1">
                                                <i class="material-symbols-outlined text-xs fa-solid fa-eye"></i>
                                                <span>cek</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Right Column: Data Ketersediaan -->
    <div id="ketersediaan" class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6 flex flex-col gap-2 h-fit">
        <div>
            <h2 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] mb-2">
                Data Ketersediaan</h2>
            <div class="flex items-center justify-between text-gray-600">
                <button class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <p class="text-sm font-medium">01 Jan 2025</p>
                <button class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <table class="w-full text-sm">
                <thead class="bg-background-light">
                    <tr class="bg-primary text-white">
                        <th class="px-4 py-2 text-left font-medium ">
                            nama barang</th>
                        <th class="px-4 py-2 text-right font-medium ">
                            jam digunakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <tr>
                        <td class="px-4 py-2 text-[#111418] ">Infocus</td>
                        <td class="px-4 py-2 text-right text-[#60758a] ">07:00 - 08:00</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 text-[#111418] ">Infocus</td>
                        <td class="px-4 py-2 text-right text-[#60758a] ">07:00 - 08:00</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full text-sm">
                <thead class="bg-background-light">
                    <tr class="bg-primary text-white">
                        <th class="px-4 py-2 text-left font-medium ">
                            nama barang</th>
                        <th class="px-4 py-2 text-right font-medium ">
                            tersedia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <tr>
                        <td class="px-4 py-2 text-[#111418] ">Infocus</td>
                        <td class="px-4 py-2 text-right text-[#60758a] ">2</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
            <h3 class="text-lg font-semibold text-[#111418] dark:text-white">Form Pengajuan</h3>
            <form class="flex flex-col gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-[#60758a] dark:text-slate-400 mb-1"
                        for="qty">Jumlah Pinjam</label>
                    <input
                        class="form-input w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-[#111418] dark:text-white placeholder:text-slate-400 focus:ring-primary focus:border-primary"
                        id="qty" name="qty" placeholder="e.g., 1" type="number" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#60758a] dark:text-slate-400 mb-1"
                        for="return_date">Tanggal Kembali</label>
                    <input
                        class="form-input w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-[#111418] dark:text-white focus:ring-primary focus:border-primary"
                        id="return_date" name="return_date" type="date" />
                </div>
                <button
                    class="w-full flex items-center justify-center gap-2 h-10 px-4 mt-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-slate-900"
                    type="submit">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Add to Cart</span>
                </button>
            </form>
        </div>
    </div>
</div>
