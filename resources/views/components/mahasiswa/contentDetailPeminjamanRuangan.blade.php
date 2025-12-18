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




<!-- Main Content -->
<div class="layout-content-container flex flex-col max-w-[1200px] flex-1 mb-6">
    @foreach ($detailRuangan as $item)
        <!-- Product Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 mt-4">
            <!-- Left Column: Gallery -->
            <div class="flex flex-col gap-4">
                <!-- Main Image -->
                <div class="w-full aspect-[4/3] bg-gray-100 rounded-xl overflow-hidden relative group">
                    <div class="w-full h-full bg-center bg-no-repeat bg-cover hover:scale-105 transition-transform duration-500 cursor-zoom-in"
                        data-alt="Close up of modern blue running shoes on a clean background"
                        style='background-image: url("/storage/{{ $item->gambar_room }}");'>
                    </div>
                </div>

            </div>
            <!-- Right Column: Info & Actions -->
            <div class="flex flex-col gap-3">
                <div>
                    <h5 class="text-[#111418] tracking-tight text-[32px] md:text-4xl font-bold leading-tight">
                        {{ $item->nama_tipe_room }}
                    </h5>
                    <h1 class="text-[#111418] tracking-tight text-[32px] md:text-4xl font-bold leading-tight">
                        {{ $item->nama_room }}
                    </h1>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex text-gray-600">
                            <span class="material-symbols-outlined text-md fill-current"
                                style="font-variation-settings: 'FILL' 1">kondisi
                            </span>
                        </div>
                        <span
                            class="text-green-500  text-md font-medium leading-normal">({{ $item->kondisi_room }})</span>
                    </div>
                </div>
                <div class="items-baseline">
                    {{-- <span class="text-xl font-bold text-gray-600">Jumlah Barang : {{ $item->qty_room }} Unit</span> --}}
                </div>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2" role="alert">
                    <div class="flex items-center">
                        <div class="py-1 mr-3">
                            <i class="fas fa-exclamation-triangle fa-lg"></i> {{-- Icon Peringatan --}}
                        </div>
                        <div>
                            <p class="font-bold">Peringatan!</p>
                            <p class="text-sm">
                                Pastikan sebelum menambahkan barang dalam keranjang lihat table jadwal penggunaan barang
                                yang tertera pada table dibawah! <br>
                                Pastiakan juga memasukkan jumlah barang pinjam tidak lebih dari qty barang!.
                            </p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('mahasiswa-add-cart-ruangan') }}" method="post">
                    @csrf
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        {{-- <!-- Quantity -->
                        <div class="flex items-center border border-gray-200 rounded-lg h-12 w-32 bg-white"
                            x-data="{ qty: 0 }">
                            <button type="button"
                                class="w-10 h-full flex items-center justify-center text-gray-500 hover:text-primary"
                                @click="qty = Math.max(0, qty - 1)" :disabled="qty <= 0">
                                <span class="material-symbols-outlined text-[18px]"></span>
                                &minus;
                            </button>
                            <input name="qty_pinjam" x-model="qty" min="0"
                                class="w-full h-full text-center border-none bg-transparent focus:outline-none text-[#111418] font-medium p-0"
                                type="number" value="1" />
                            <button type="button"
                                class="w-10 h-full flex items-center justify-center text-gray-500 hover:text-primary"
                                @click="qty = Math.min(qty + 1)">
                                <span class="material-symbols-outlined text-[18px]"></span>
                                &plus;
                            </button>
                        </div> --}}
                        <!-- Add to Cart -->
                        <input type="text" name="id_room" class="hidden" value="{{ $item->id_room }}">
                        <button type="submit"
                             class="bg-blue-600 text-white px-4 w-full py-2 rounded-md! hover:bg-blue-700 transition-colors">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Tambahkan ke Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Details Tabs Section -->
    <div class="mt-6 lg:mt-8">
        <div class="border-b border-gray-200">
            <nav aria-label="Tabs" class="-mb-px flex gap-8 overflow-x-auto hide-scrollbar no-underline!">
                <a aria-current="page"
                    class="border-b-2 border-primary py-2 px-1 text-sm font-bold text-primary whitespace-nowrap cursor-pointer no-underline!"
                    href="#">
                    {{ date('l, d F Y', strtotime($tglForTblUsageRuang)) }}
                </a>
            </nav>
        </div>
        <div class="my-4 flex gap-4 justify-between flex-col sm:flex-row">
            <h3 class="text-lg font-bold text-[#111418]">
                Jadwal Penggunaan Barang
            </h3>
            <div>
                <form action="{{ route('ganti-tgl-chosed-barang') }}" method="POST" class="flex gap-0 max-w-md">
                    @csrf
                    <div class="relative flex-grow">
                        <i class="fa-solid fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="date" name="ganti_tgl" value="{{ $tglForTblUsageRuang }}"
                            class="w-full pl-10 pr-2 py-2 border border-slate-300 rounded-l-lg! focus:ring-0 focus:outline-none focus:border-blue-500">
                        <input type="text" name="id" class="hidden" value="{{ $id_room }}">
                    </div>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 border-r border-y border-0 rounded-r-lg! hover:bg-blue-700 transition-colors">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 text-[#111418] font-semibold border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 w-32">Waktu</th>
                            <th class="px-6 py-4">Aktivitas</th>
                            <th class="px-6 py-4">Jumlah Digunakan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @if ($dataUsageRooms->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-700">
                                    Tidak ada jadwal penggunaan ruangan tersebut untuk tanggal {{ date('d F Y', strtotime($tglForTblUsageRuang)) }} !
                                </td>
                            </tr>
                        @else
                            @foreach ($dataUsageRooms as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#111418]">
                                        {{ date('H:i', strtotime($item->tgl_pinjam_usage_room)) }} -
                                        {{ date('H:i', strtotime($item->tgl_kembali_usage_room)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-[#111418]">
                                            @if ($item->nama_agenda != null)
                                                Matakuliah {{ $item->nama_agenda }}
                                            @else
                                                {{ $item->ket_peminjaman }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-[#111418]">
                                            {{ $item->qty_usage_room }} Unit
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                            @if ($item->nama_agenda != null)
                                                Agenda Wajib
                                            @else
                                                Agenda Non Wajib
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-green-600 font-medium text-xs flex items-center gap-1 bg-green-50 px-2 py-1 rounded-full w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                            {{ $item->status_usage_room }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Main Content -->
