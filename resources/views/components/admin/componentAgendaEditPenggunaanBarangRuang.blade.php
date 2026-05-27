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

{{-- <hr class="border-1 border-gray-100 my-2"> --}}
<main class="flex-1 overflow-y-auto bg-background-light px-2 mb-5">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Page Heading -->
        @foreach ($headerAgenda as $agenda)
            <!-- Info Cards Grid -->
            <div class="">

                <!-- Timeline & Purpose Card -->
                <div
                    class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row items-center justify-between border-b border-slate-100 pb-4">
                        <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-primary"></i>
                            Detail Tanggal Penggunaan &amp; Nama Agenda

                            {{-- {{ $date }} --}}
                        </h5>

                        <button
                            class="flex items-center gap-2 px-2 py-2 w-full md:w-auto bg-blue-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-blue-700 transition-colors shadow-sm">
                            <i class="fa-solid fa-pen-to-square text-md text-white"></i>
                            <span class="text-white text-md">Simpan Daftar Penggunaan</span>
                        </button>

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal
                                    Penggunaan</span>
                                <div class="flex items-center gap-2 text-slate-900 font-medium">
                                    <i class="fa-solid fa-right-to-bracket text-green-600"></i>
                                    {{ date('d F Y', strtotime($tglPinjam)) }}
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama
                                Agenda</span>
                            <p
                                class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-2 rounded-lg border border-slate-100">
                                @if (!isset($agenda->ket_peminjaman))
                                    @if ($agenda->tipe_agenda === 'kegiatan belajar mengajar')
                                        {{ 'matakuliah ' . $agenda->nama_agenda }}
                                    @elseif ($agenda->tipe_agenda === 'Seminar')
                                        {{ 'seminar ' . $agenda->nama_agenda }}
                                    @elseif ($agenda->tipe_agenda === 'Rapat Pimpinan')
                                        {{ 'Rapat Pimpinan ' . $agenda->nama_agenda }}
                                    @else
                                        {{ 'PTS/PAS ' . $agenda->nama_agenda }}
                                    @endif
                                @else
                                    {{ $agenda->ket_peminjaman }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- tampilan add barang dan ruang --}}
        <div>
            <div x-data="{
                showPicker: false,
                currentTab: 'barang',
                products: [],
                init() { this.products = productsData }
            }" x-init="init()">

                <div
                    class="flex flex-col md:flex-row items-center justify-start md:justify-between border-b border-slate-100 pb-4 gap-4">
                    <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-primary"></i>
                        Detail Barang &amp; Ruangan yang Digunakan
                    </h5>
                    <button @click="showPicker = true"
                        class="flex items-center gap-2 px-4 py-2 bg-green-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-green-700 transition-colors shadow-sm">
                        {{-- <i class="fa-solid fa-print text-lg text-white"></i> --}}
                        <i class="fas fa-plus text-white"></i>
                        <span class="text-white">add barang atau ruangan</span>
                    </button>
                </div>

                <div x-show="showPicker" x-transition.opacity
                    class="fixed inset-0 bg-black/60 z-50 backdrop-blur-sm flex items-center justify-center p-4 md:p-10"
                    x-cloak>

                    <div @click.away="showPicker = false"
                        class="bg-gray-50 w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">

                        <div class="bg-white border-b border-gray-300">
                            <div class="py-3 px-6 flex justify-between items-center">
                                <h5 class="text-xl font-bold text-gray-800">
                                    <i class="fa-solid fa-box text-primary"></i>
                                    Pilih Barang atau Ruangan Yang ingin ditambahkan
                                </h5>

                                <button @click="showPicker = false"
                                    class="text-gray-400 hover:text-red-500 text-3xl font-light">
                                    &times;
                                </button>
                            </div>

                            <div class="flex px-5 space-x-6 gap-3">
                                <button @click="currentTab = 'barang'"
                                    :class="currentTab === 'barang' ? 'text-indigo-600 border-indigo-600' :
                                        'text-gray-500 border-transparent hover:text-gray-700'"
                                    class="pb-3 border-b-1 font-normal transition">
                                    Daftar Barang
                                </button>
                                <button @click="currentTab = 'ruangan'"
                                    :class="currentTab === 'ruangan' ? 'text-indigo-600 border-indigo-600' :
                                        'text-gray-500 border-transparent hover:text-gray-700'"
                                    class="pb-3 border-b-1 font-normal transition">
                                    Daftar Ruangan
                                </button>
                            </div>
                        </div>

                        <div class="p-6 overflow-y-auto">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                                <template x-for="item in products.filter(i => i.category === currentTab)"
                                    :key="item.id">

                                    <!-- Product Card 1 -->
                                    <article
                                        class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">
                                        <!-- Image Container -->
                                        <div class="relative aspect-square overflow-hidden bg-gray-200 ">
                                            <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                                                data-alt="Modern high-end sneakers with white and grey accents floating in a studio setting"
                                                :style="`background-image: url('{{ asset('storage') }}/${item.img_item}')`">
                                            </div>
                                            <!-- Quick Action Overlay -->
                                            <div
                                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                <button
                                                    class="bg-white text-slate-900 hover:bg-primary hover:text-white transition-colors p-3 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                                    <span class="material-symbols-outlined text-[20px]"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Content -->
                                        <div class="px-3 py-3 flex flex-col gap-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-medium text-slate-400 uppercase tracking-wide"
                                                    x-text="item.nama_tipe_item"></span>
                                                <div class="flex items-center gap-1 text-green-500">
                                                    stok:
                                                    <span class="material-symbols-outlined text-[16px] leading-none"
                                                        x-text="item.qty_item">
                                                    </span>
                                                </div>
                                            </div>
                                            <form action="{{ route('tambah-barang-agenda') }}" method="post">
                                                @csrf
                                                <div class="flex justify-between">
                                                    <h3 class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors"
                                                        x-text="item.nama_item">
                                                    </h3>
                                                    <input x-show="currentTab === 'barang'" type="number"
                                                        name="qty_usage"
                                                        class="w-10 border-1 border-slate-300 rounded-md px-1"
                                                        value="0">
                                                    <input name="qty_item" type="text" :value="item.qty_item" hidden>
                                                </div>
                                                <div class="flex items-center justify-between mt-auto pt-2">
                                                    <div class="flex gap-2 w-full">
                                                        <input name="id_agenda" type="text"
                                                            value="{{ $id }}" hidden>
                                                        <input name="id_item_room" type="text" :value="item.id"
                                                            hidden>
                                                        <button type="submit" id="pilih_barangruang"
                                                            class="py-1 px-2 text-white bg-blue-500 hover:bg-blue-300 flex justify-center items-center text-center gap-1 w-full rounded ">
                                                            Pilih <span
                                                                x-text="currentTab === 'barang' ? 'Barang' : 'Ruangan'"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </article>
                                </template>

                            </div>

                            <div x-show="products.filter(i => i.category === currentTab).length === 0"
                                class="text-center py-20 text-gray-400">
                                Tidak ada data ditemukan.
                            </div>
                        </div>

                        {{-- <div class="bg-white p-4 border-t text-right">
                        <button @click="showPicker = false"
                            class="px-6 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-gray-200 transition">
                            Selesai
                        </button>
                    </div> --}}
                    </div>
                </div>
            </div>

            <style>
                [x-cloak] {
                    display: none !important;
                }

                .overflow-y-auto::-webkit-scrollbar {
                    width: 6px;
                }

                .overflow-y-auto::-webkit-scrollbar-thumb {
                    background: #d1d5db;
                    border-radius: 10px;
                }
            </style>
        </div>


        <!-- tampilan barang dan runagan sementara -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            @foreach ($semuaData as $dataBarang)
                <!-- Product Card 1 -->
                <article
                    class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">
                    <!-- Image Container -->
                    <div class="relative aspect-square overflow-hidden bg-gray-200 ">
                        <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                            data-alt="Modern high-end sneakers with white and grey accents floating in a studio setting"
                            style='background-image: url("/storage/{{ $dataBarang->img_item ?? $dataBarang->gambar_room }}");'>
                        </div>
                        <!-- Quick Action Overlay -->
                        <div class="absolute top-2 right-2 z-[10] pointer-events-auto">
                            <form action="{{ route('hapus-barang-agenda') }}" method="post">
                                @csrf

                                <input name="id_item_room" type="text"
                                    value="{{ $dataBarang->id_room ?? $dataBarang->id_item }}" hidden>

                                <button type="submit"
                                    class="flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-lg! shadow-lg transition-all duration-200 opacity-100 md:opacity-0 md:group-hover:opacity-100 hover:bg-red-700 hover:scale-110 active:scale-90">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="px-3 py-3 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                {{ $dataBarang->nama_tipe_item ?? $dataBarang->nama_tipe_room }}
                            </span>
                            <div class="flex items-center gap-1 text-green-500">
                                <span
                                    class="material-symbols-outlined text-[16px] leading-none">{{ $dataBarang->kondisi_item ?? $dataBarang->kondisi_room }}</span>
                                {{-- <span class="text-xs font-semibold text-slate-600 ">5.0</span> --}}
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3
                                class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors">
                                {{ $dataBarang->nama_item ?? $dataBarang->nama_room }}
                            </h3>
                            <span class="text-xs font-medium text-slate-700 uppercase tracking-wide">
                                qty: {{ $dataBarang->qty_usage_item ?? '-' }}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</main>


<script>
    // Render data collection sebagai JSON
    const productsData = @json($allBarangRuang);


    function toggleJam() {
        const tipeWaktu = document.getElementById('tipe_waktu').value;
        const containerJam = document.getElementById('input_jam_container');
        const Jam_mulai = document.getElementById('jam_mulai');
        const Jam_selesai = document.getElementById('jam_selesai');

        if (tipeWaktu === 'spesifik') {
            containerJam.style.display = 'block';
        } else {
            containerJam.style.display = 'none';
        }
    }
</script>
