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

<div x-data="{ selectedBarang: {} }" class=" mb-4">
    <div class="mb-4 bg-white flex">
        <label class="flex flex-col w-full flex-grow">
            <div class="relative w-full">
                <i
                    class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    class="w-full! pl-10 pr-4 py-2 bg-background-light border-l border-y border-slate-200 rounded-l-lg focus:ring-0 focus:outline-none text-black"
                    placeholder="Search" type="text" />
            </div>
        </label>
        <button type="submit"
            class="py-1 px-2 text-white bg-blue-500 hover:bg-blue-300 flex justify-center items-center text-center gap-1 border-r border-y border-slate-200!  rounded-r-lg!">
            <i class="fa-solid fa-search"></i>
            <span>cari</span>
        </button>
    </div>

    <main class="layout-container flex grow flex-col items-center justify-center mb-4 px-0 sm:px-8 lg:px-20">
        <div class="w-full max-w-[1200px] flex flex-col gap-10">
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
                @foreach ($dataTablePengajuanPeminjaman as $dataBarang)
                    <!-- Product Card 1 -->
                    <article
                        class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">
                        <!-- Image Container -->
                        <div class="relative aspect-square overflow-hidden bg-gray-200 ">
                            <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                                data-alt="Modern high-end sneakers with white and grey accents floating in a studio setting"
                                style='background-image: url("/storage/{{ $dataBarang->img_item }}");'>
                            </div>
                            <!-- Quick Action Overlay -->
                            <div
                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <button
                                    class="bg-white text-slate-900 hover:bg-primary hover:text-white transition-colors p-3 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                    <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                                </button>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="px-3 py-3 flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs font-medium text-slate-400 uppercase tracking-wide">{{ $dataBarang->nama_tipe_item }}</span>
                                <div class="flex items-center gap-1 text-green-500">
                                    <span
                                        class="material-symbols-outlined text-[16px] leading-none">{{ $dataBarang->kondisi_item }}</span>
                                    {{-- <span class="text-xs font-semibold text-slate-600 ">5.0</span> --}}
                                </div>
                            </div>
                            <h3
                                class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors">
                                {{ $dataBarang->nama_item }}
                            </h3>
                            <div class="flex items-center justify-between mt-auto pt-2">
                                <div class="flex gap-2 w-full">
                                    <form action="{{ route('mhs-detail-peminjaman-barang', $dataBarang->id_item) }}"
                                        method="get" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="py-1 px-2 text-white bg-blue-500 hover:bg-blue-300 flex justify-center items-center text-center gap-1 w-full rounded ">
                                            {{-- <i class="fa-solid fa-eye"></i> --}}
                                            <span>lihat</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </main>


    <!-- Table -->
    {{-- <div class="shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="sticky top-0 z-1">
                    <tr class="bg-primary text-white">
                        <th class="px-4 py-3 text-center text-white w-16 text-xs font-medium uppercase tracking-wider">
                            Gambar
                        </th>
                        <th class="px-4 py-3 text-center text-white w-1/4 text-xs font-medium uppercase tracking-wider">
                            Nama Barang
                        </th>
                        <th class="px-4 py-3 text-center text-white text-xs font-medium uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-4 py-3 text-center text-white w-40 text-xs font-medium uppercase tracking-wider">
                            Kondisi
                        </th>
                        <th class="px-4 py-3 text-center text-white w-40 text-xs font-medium uppercase tracking-wider">
                            qty pinjam
                        </th>
                        <th class="px-4 py-3 text-center text-white w-40 text-xs font-medium uppercase tracking-wider">
                            Aksi
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
                            <tr class="border-b border-slate-200">
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
                                <form method="POST" action="{{ route('mahasiswa-add-cart-barang') }}">
                                    @csrf
                                    <td
                                        class="h-[72px] px-4 py-2 text-sm font-semibold leading-normal items-center! text-center">
                                        <div x-data="{ qty: 0 }"
                                            class="flex items-center justify-center space-x-0.5">

                                            <button type="button" @click="qty = Math.max(0, qty - 1)"
                                                :disabled="qty <= 0"
                                                class="p-1 w-8 h-8 flex items-center justify-center text-sm text-white font-semibold rounded-xl bg-blue-500 hover:bg-blue-300 transition duration-150">
                                                &minus;
                                            </button>

                                            <input type="number" name="qty_pinjam" x-model="qty" min="0"
                                                class="w-12 h-8 text-center border-gray-300 text-sm focus:ring-0 focus:border-gray-300 p-0">

                                            <button type="button" @click="qty = Math.min(qty + 1)"
                                                class="p-1 w-8 h-8 flex items-center justify-center text-white text-sm font-semibold rounded-r bg-blue-500 hover:bg-blue-300 transition duration-150">
                                                &plus;
                                            </button>
                                        </div>
                                    </td>
                                    <td
                                        class="h-[72px] px-4 py-2 text-sm font-semibold leading-normal items-center! text-center">


                                        <input type="text" name="id_item" class="hidden"
                                            value="{{ $dataBarang->id_item }}">
                                        
                                        <button type="submit"
                                            class="py-1 px-2 text-white bg-blue-500 hover:bg-blue-300 flex items-center gap-1">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            <span>add cart</span>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div> --}}
</div>
