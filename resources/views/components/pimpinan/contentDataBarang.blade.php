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

<main class="max-w-7xl mx-auto px-2 pb-10" x-data="{ activeTab: 'barang' }">
    {{-- barang --}}
    <div x-show="activeTab === 'barang'" x-transition x-data="{ AddDataBarang: false, EditDataBarang: false, selectedDataBarang: {}, DeleteDataBarang: false }">
        {{-- pencarian --}}
        <div
            class="bg-white p-4 rounded-xl border border-slate-200 mb-8 flex flex-wrap gap-4 items-center shadow-sm md:justify-between">
            <div class="relative flex-grow max-w-md">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <form action="{{ route('cari-data-barang') }}" method="post">
                    @csrf
                    <input name="cari_barang"
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                        placeholder="Cari nama barang" type="text" value="{{ $cari != 'null' ? $cari : '' }}" />
                </form>
            </div>
        </div>

        {{-- card data barang --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach ($DataBarang as $dataBarang)
                <div
                    class="item-card bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img alt="Laptop" class="w-full h-full object-cover"
                            src="{{ Storage::disk('s3')->url(str_replace('//', '/', $dataBarang->img_item)) }}" />
                       
                    </div>
                    <div class="p-6 flex-grow">
                        <div class="mb-3">
                            <span class="py-1 text-blue-700 text-[10px] font-bold rounded uppercase">
                                {{-- {{ $dataBarang->nama_tipe_item }} --}}
                                {{ $dataBarang->merek_model }}
                            </span>
                            <h5 class="text-xl font-bold text-slate-900">
                                {{ $dataBarang->nama_item }}</h5>
                            <span
                                class="px-2 py-1 bg-gray-50 text-gray-700 text-[10px] font-bold rounded border border-gray-100 uppercase">
                                {{ $dataBarang->id_item }}
                            </span>
                        </div>
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-slate-600 text-sm gap-2">
                                <i class="fa-solid fa-warehouse w-6 text-primary text-base"></i>
                                <span>Tempat simpan: <span class="font-semibold text-slate-900">Ruang
                                        {{ $dataBarang->nama_room }}</span>
                                </span>
                            </div>
                            <div class="flex items-center text-slate-600 text-sm gap-2">
                                <i class="fa-solid fa-university w-6 text-primary text-base"></i>
                                <span>Lingkup Pengelolaan: <span class="font-semibold text-slate-900">
                                        {{ $dataBarang->kepemilikan_pengelolaan != 'fakultas teknik' ? $dataBarang->kepemilikan_pengelolaan : $dataBarang->kepemilikan_pengelolaan }}</span>
                                </span>
                            </div>
                            <div class="flex items-center text-slate-600 text-sm gap-2">
                                <i class="fa-solid fa-boxes-stacked w-6 text-primary text-base"></i>
                                <span>Tersedia: <span class="font-semibold text-slate-900">{{ $dataBarang->qty_item }}
                                        Unit</span></span>
                            </div>
                            <div class="flex items-center text-red-600 text-sm gap-2">
                                <i class="fa-solid fa-boxes-stacked w-6 text-red text-base"></i>
                                <span>Rusak: <span class="font-semibold text-slate-900">{{ $dataBarang->qty_perawatan ?? '0' }}
                                        Unit</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- informasi menampilkan bnayaknya barang --}}
        <div class="flex items-center justify-between mb-12">
            <div class="text-sm text-slate-500 font-medium">
                Menampilkan
                <span class="text-slate-900 font-bold">{{ $DataBarang->count() }}</span>
                dari
                <span class="text-slate-900 font-bold">{{ $DataBarang->total() }}</span>
                barang
            </div>

            <div class="flex gap-2">
                {{-- Tombol ke Halaman Sebelumnya --}}
                @if ($DataBarang->onFirstPage())
                    <button
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-300 bg-gray-50 cursor-not-allowed"
                        disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $DataBarang->previousPageUrl() }}"
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($DataBarang->getUrlRange(1, $DataBarang->lastPage()) as $page => $url)
                    @if ($page == $DataBarang->currentPage())
                        {{-- Halaman Aktif --}}
                        <button
                            class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center text-sm font-bold">
                            {{ $page }}
                        </button>
                    @else
                        {{-- Halaman Lain --}}
                        <a href="{{ $url }}"
                            class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-sm font-medium hover:border-primary hover:text-primary transition-all bg-white">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Tombol ke Halaman Selanjutnya --}}
                @if ($DataBarang->hasMorePages())
                    <a href="{{ $DataBarang->nextPageUrl() }}"
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <button
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-300 bg-gray-50 cursor-not-allowed"
                        disabled>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>
</main>
