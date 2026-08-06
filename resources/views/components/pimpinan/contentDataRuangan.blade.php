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

<main class="max-w-7xl mx-auto px-2 pb-5" x-data="{ activeTab: 'ruangan' }">

    {{-- ruangan --}}
    <div x-show="activeTab === 'ruangan'" x-transition>
        {{-- pencarian --}}
        <div class="bg-white p-4 rounded-xl border border-slate-200 mb-8 flex flex-wrap gap-4 items-center shadow-sm">
            <div class="relative flex-grow max-w-md">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <form action="{{ route('cari-data-ruang') }}" method="post">
                    @csrf
                    <input name="cari_ruang"
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                        placeholder="Cari nama ruangan" type="text" value="{{ $cari != 'null' ? $cari : '' }}" />
                </form>
            </div>
        </div>

        {{-- data ruangan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ AddDataRuangan: false, EditDataRuangan: false, selectedDataRuangan: {}, DeleteDataRuangan: false, OpenImgRuangan: false }">
            {{-- menampilkan data ruangan --}}
            @foreach ($DataRuangan as $ruang)
                <div
                    class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col group hover:shadow-md transition-shadow">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span
                                    class="inline-block py-0.5 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider rounded mb-2">
                                    {{ $ruang->nama_tipe_room }}
                                </span>
                                <h5 class="text-xl font-bold text-slate-900">{{ $ruang->nama_room }}</h5>
                            </div>
                            <div class="flex gap-2">
                                @if ($ruang->kondisi_room === 'Baik')
                                    <span
                                        class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-sm">
                                        Baik
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-sm">
                                        Rusak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center text-slate-600 text-sm gap-2 mb-4">
                            <i class="fa-solid fa-university w-6 text-primary text-base"></i>
                            <span>Lingkup Pengelolaan: 
                                <span class="font-semibold text-slate-900">
                                    {{ $ruang->kepemilikan_pengelolaan != 'fakultas teknik' ? $ruang->kepemilikan_pengelolaan : $ruang->kepemilikan_pengelolaan }}
                                </span>
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Daftar Barang
                                </h4>
                            </div>
                            <ul class="space-y-2 p-0!">
                                @forelse($ruang->items as $items)
                                    <li
                                        class="flex items-center justify-between group/item p-2 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <i class="fa-solid fa-box text-blue-400"></i>
                                            <span class="text-sm font-medium">{{ $items->nama_item }}
                                                ({{ $items->qty_item }} Unit)
                                            </span>
                                        </div>
                                    </li>
                                @empty
                                    <li
                                        class="flex items-center justify-between group/item p-2 rounded-lg bg-slate-50 hover:bg-slate-100 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <i class="fa-solid fa-circle-xmark text-red-400"></i>
                                            <span class="text-sm font-medium text-red-500">Tidak ada barang</span>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                            @if ($ruang->total_items_count > 3)
                                <div class="items-center flex justify-center">
                                    <a href="{{ route('edit-ruangan', ['id' => $ruang->id_room]) }}" class="text-sm">
                                        lebih banyak
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 border-t border-slate-100 mt-auto flex gap-2">

                        <button
                            class="w-full px-4 py-3 bg-white hover:bg-primary hover:text-white text-primary border border-danger/20 rounded-lg! transition-all flex items-center justify-center shadow-sm"
                            @click="OpenImgRuangan = true; true; selectedDataRuangan = {
                                            img: '{{ $ruang->gambar_room }}',
                                        }">
                            <i class="fa-solid fa-images"></i>
                        </button>

                    </div>
                </div>
            @endforeach

            {{-- shwo img ruangan --}}
            <div x-show="OpenImgRuangan"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition x-cloak>
                <div class="flex justify-center rounded-2xl w-full max-w-xl relative"
                    @click.outside="OpenImgRuangan = false">
                    <img :src="`${bucketUrl}/${selectedDataRuangan.img}`" alt="Foto Peminjam" class="container">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-2 mb-12">
            <div class="text-sm text-slate-500 font-medium">
                Menampilkan
                <span class="text-slate-900 font-bold">{{ $DataRuangan->count() }}</span>
                dari
                <span class="text-slate-900 font-bold">{{ $DataRuangan->total() }}</span>
                ruangan terdaftar
            </div>

            <div class="flex gap-2">
                {{-- Tombol ke Halaman Sebelumnya --}}
                @if ($DataRuangan->onFirstPage())
                    <button
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-300 bg-gray-50 cursor-not-allowed"
                        disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $DataRuangan->previousPageUrl() }}"
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($DataRuangan->getUrlRange(1, $DataRuangan->lastPage()) as $page => $url)
                    @if ($page == $DataRuangan->currentPage())
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
                @if ($DataRuangan->hasMorePages())
                    <a href="{{ $DataRuangan->nextPageUrl() }}"
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
    </div>
</main>
<script>
    const bucketUrl = "{{ rtrim(Storage::disk('s3')->url(''), '/') }}";
</script>