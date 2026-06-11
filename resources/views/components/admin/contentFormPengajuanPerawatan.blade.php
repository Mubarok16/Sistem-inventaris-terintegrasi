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
    <!-- detail kerperluan -->

    <div class="w-full!">
        <!-- detail jdawal dan keperluan -->
        <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col gap-4">

            <!-- detail jdawal dan keperluan -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-primary"></i>
                    Form Pengajuan Perawatan Barang Atau Ruangan
                </h5>

            </div>

            <form action="{{ route('kunci-header-info-perawatan') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- LEFT -->
                    <div class="space-y-4">

                        <!-- NOMOR SURAT -->
                        <div>

                            <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Nomor Surat
                            </label>

                            <input type="text" name="nomor_surat" required
                                value="{{ $dataPerawatan->nomor_surat ?? '' }}"
                                class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 p-2">

                        </div>

                        <!-- NAMA PEMOHON -->
                        <div>

                            <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Nama Pemohon
                            </label>

                            <input type="text" readonly name="nama_pemohon" value="{{ $user }}"
                                class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 p-2">

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="space-y-4">

                        <!-- TAHUN AKADEMIK -->
                        <div>

                            <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Tahun Akademik
                            </label>

                            <input type="text" name="tahun_akademik" required
                                value="{{ $dataPerawatan->tahun_akademik ?? '' }}" placeholder="2025/2026"
                                class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 p-2">

                        </div>

                        <!-- KEBUTUHAN -->

                        @if (Auth::user()->hak_akses === 'kaprodi')
                            @php
                                $jabatan = DB::table('detail_dosen')
                                    ->where('id_user', Auth::user()->id_user)
                                    ->value('jabatan');
                            @endphp

                            @if ($jabatan === 'kaprodi teknik sipil')
                                <input type="hidden" name="kebutuhan_prodi" value="Teknik Sipil">
                            @elseif ($jabatan === 'kaprodi teknik komputer')
                                <input type="hidden" name="kebutuhan_prodi" value="Teknik Komputer">
                            @elseif ($jabatan === 'kaprodi teknik lingkungan')
                                <input type="hidden" name="kebutuhan_prodi" value="Teknik Lingkungan">
                            @endif
                        @else
                            <div>

                                <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Fakultas / Prodi
                                </label>

                                <select name="kebutuhan_prodi" required
                                    class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 p-2">

                                    <option value="">Pilih</option>

                                    <option value="Fakultas Teknik">
                                        Fakultas Teknik
                                    </option>

                                    <option value="Teknik Sipil">
                                        Teknik Sipil
                                    </option>

                                    <option value="Teknik Komputer">
                                        Teknik Komputer
                                    </option>

                                    <option value="Teknik Lingkungan">
                                        Teknik Lingkungan
                                    </option>

                                </select>

                            </div>
                        @endif

                    </div>

                </div>

                <!-- ========================================================= -->
                <!-- ALPINE -->
                <!-- ========================================================= -->

                <div class="mt-5" x-data="perawatanHandler()" x-init="init()">

                    <!-- HEADER -->
                    <div
                        class="flex flex-col md:flex-row items-center justify-between border-b border-slate-100 pb-4 gap-4">

                        <div>
                            <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-check text-primary"></i>
                                Detail Barang & Ruangan Yang Diajukan
                            </h5>

                            <p class="text-xs text-orange-500 mt-1">
                                Hanya dapat memilih satu barang atau ruangan
                            </p>
                        </div>

                        <button type="button" @click="showPicker = true"
                            class="flex items-center gap-2 px-4 py-2 bg-green-500 rounded-md! text-white hover:bg-green-700 transition">
                            <i class="fas fa-plus"></i>
                            <span>Pilih Barang / Ruangan</span>
                        </button>

                    </div>

                    <!-- ================================================= -->
                    <!-- show -->
                    <!-- ================================================= -->

                    <div x-show="showPicker" x-transition.opacity
                        class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-cloak>

                        <div @click.away="showPicker = false"
                            class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">

                            <!-- TOP -->
                            <div class="border-b">

                                <div class="flex items-center justify-between px-6 py-4">

                                    <h2 class="text-xl font-bold text-slate-800">
                                        Pilih Barang / Ruangan
                                    </h2>

                                    <button type="button" @click="showPicker = false"
                                        class="text-3xl text-slate-400 hover:text-red-500">
                                        &times;
                                    </button>

                                </div>

                                <!-- TAB -->
                                <div class="flex gap-6 px-6">

                                    <button type="button" @click="currentTab = 'barang'" class="pb-3 border-b-2"
                                        :class="currentTab === 'barang'
                                            ?
                                            'border-blue-500 text-blue-500' :
                                            'border-transparent text-slate-500'">

                                        Daftar Barang

                                    </button>

                                    <button type="button" @click="currentTab = 'ruangan'" class="pb-3 border-b-2"
                                        :class="currentTab === 'ruangan'
                                            ?
                                            'border-blue-500 text-blue-500' :
                                            'border-transparent text-slate-500'">

                                        Daftar Ruangan

                                    </button>

                                </div>

                            </div>

                            <!-- CONTENT -->
                            <div class="p-6 overflow-y-auto">

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                                    <template x-for="item in products.filter(i => i.category === currentTab)"
                                        :key="item.id">

                                        <article
                                            class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">

                                            <!-- IMAGE -->
                                            <div class="relative aspect-square overflow-hidden bg-gray-200">

                                                <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                                                    :style="`background-image: url('/storage/${item.img_item ?? item.gambar_room}')`">
                                                </div>

                                            </div>

                                            <!-- CONTENT -->
                                            <div class="px-3 py-3 flex flex-col gap-2">

                                                <div class="flex items-center justify-between">

                                                    <span
                                                        class="text-xs font-medium text-slate-400 uppercase tracking-wide"
                                                        x-text="currentTab === 'barang'
                                                        ? item.nama_item
                                                        : item.nama_tipe_item">
                                                    </span>

                                                    <div class="flex items-center gap-1 text-green-500">

                                                        Qty:

                                                        <span class="text-sm" x-text="item.qty_item">
                                                        </span>

                                                    </div>

                                                </div>

                                                <div class="flex items-center justify-between gap-3">

                                                    <h3 class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors"
                                                        x-text="currentTab === 'barang'
                                                        ? item.merek_model
                                                        : item.nama_item">
                                                    </h3>

                                                    <!-- INPUT QTY -->
                                                    {{-- <div x-show="currentTab === 'barang'" class="flex-shrink-0">

                                                        <input type="number" min="1" :max="item.qty_item"
                                                            x-model="item.qty_input"
                                                            class="w-20 border border-slate-300 rounded-md px-2 py-1 text-sm"
                                                            placeholder="Qty">

                                                    </div> --}}
                                                    <div x-show="currentTab === 'barang'" class="flex-shrink-0">
                                                        <input type="number" min="1" :max="item.qty_item"
                                                            x-model="item.qty_input"
                                                            :class="item.qty_input > item.qty_item ? 'border-red-500' :
                                                                'border-slate-300'"
                                                            class="w-20 border rounded-md px-2 py-1 text-sm"
                                                            placeholder="Qty">

                                                        <!-- Pesan Warning -->
                                                        <template x-if="item.qty_input > item.qty_item">
                                                            <p class="text-red-500 text-xs mt-1">Stok tidak cukup!</p>
                                                        </template>
                                                    </div>

                                                </div>

                                                <span
                                                    class="text-xs font-medium text-slate-400 uppercase tracking-wide"
                                                    x-text="currentTab === 'barang'
                                                        ? 'Lokasi: Ruang ' + item.nama_room : ''">
                                                </span>


                                                <!-- BUTTON -->
                                                <div class="flex items-center justify-between mt-auto pt-2">

                                                    <button type="button" @click="tambahItem(item)"
                                                        class="py-2 px-3 text-white bg-blue-500 hover:bg-blue-600 flex justify-center items-center text-center gap-1 w-full rounded">

                                                        Pilih
                                                        <span
                                                            x-text="currentTab === 'barang'
                                                            ? 'Barang'
                                                            : 'Ruangan'">
                                                        </span>

                                                    </button>

                                                </div>

                                            </div>

                                        </article>

                                    </template>

                                </div>

                                <!-- EMPTY -->
                                <div x-show="products.filter(i => i.category === currentTab).length === 0"
                                    class="text-center py-20 text-gray-400">

                                    Tidak ada data ditemukan.

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- ================================================= -->
                    <!-- DATA SEMENTARA -->
                    <!-- ================================================= -->

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8 mt-6">

                        <template x-for="(dataBarang,index) in selectedItems" :key="index">

                            <article
                                class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">

                                <!-- IMAGE -->
                                <div class="relative aspect-square overflow-hidden bg-gray-200">

                                    <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                                        :style="`background-image: url('/storage/${dataBarang.img_item ?? dataBarang.gambar_room}')`">
                                    </div>

                                    <!-- DELETE -->
                                    <div class="absolute top-2 right-2 z-[10] pointer-events-auto">

                                        <button type="button" @click="hapusItem(index)"
                                            class="flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-lg shadow-lg transition-all duration-200 hover:bg-red-700 hover:scale-110 active:scale-90">

                                            <i class="fas fa-times text-sm"></i>

                                        </button>

                                    </div>

                                </div>

                                <!-- CONTENT -->
                                <div class="px-3 py-3 flex flex-col gap-2">

                                    <div class="flex items-center justify-between">

                                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wide"
                                            x-text="dataBarang.nama_item ?? dataBarang.nama_tipe_room">
                                        </span>

                                        <span class="text-xs font-medium text-slate-700 uppercase tracking-wide">

                                            qty:
                                            <span x-text="dataBarang.qty_usage_item"></span>

                                        </span>

                                    </div>

                                    <div class="flex items-center justify-between">

                                        <h3 class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors"
                                            x-text="dataBarang.merek_model ?? dataBarang.nama_room">
                                        </h3>

                                    </div>

                                </div>

                            </article>

                        </template>

                    </div>

                    <!-- ================================================= -->
                    <!-- HIDDEN INPUT -->
                    <!-- ================================================= -->

                    <template x-for="item in selectedItems">

                        <div>

                            <input type="hidden" name="id_item_room" :value="item.id">

                            <input type="hidden" name="qty_usage" :value="item.qty_usage_item">

                            <input type="hidden" name="category" :value="item.category">

                        </div>

                    </template>
                </div>



                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-blue-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-blue-700 transition-colors shadow-sm w-full justify-center mt-3">
                    <i class="fas fa-check-circle text-white"></i>
                    <span class="text-white">Ajukan perawatan</span>
                </button>

            </form>
        </div>
    </div>
</div>

<script>
    // DATA DARI LARAVEL
    const productsData = @json($allBarangRuang);

    function perawatanHandler() {

        return {

            showPicker: false,

            currentTab: 'barang',

            products: [],

            // hanya 1 item
            selectedItems: @json($semuaData ?? []),

            init() {

                this.products = productsData.map(item => ({
                    ...item,
                    qty_input: 1
                }));

            },

            tambahItem(item) {
                // 1. Tentukan jumlah yang akan dimasukkan
                let finalQty = item.qty_input;

                if (item.category === 'barang') {
                    // 2. Validasi: Jika input lebih besar dari stok, paksa ke nilai maksimal stok
                    if (parseInt(item.qty_input) > parseInt(item.qty_item)) {
                        finalQty = item.qty_item;
                    }
                    // 3. Validasi: Jika input kurang dari 1 atau kosong
                    if (parseInt(item.qty_input) < 1 || !item.qty_input) {
                        finalQty = 1;
                    }
                } else {
                    finalQty = '-';
                }

                const newItem = {
                    id: item.id,
                    category: item.category,
                    nama_item: item.nama_item ?? null,
                    nama_room: item.nama_room ?? null,
                    nama_tipe_room: item.nama_tipe_room ?? null,
                    merek_model: item.merek_model ?? null,
                    img_item: item.img_item ?? item.gambar_room,
                    gambar_room: item.gambar_room ?? null,
                    // Gunakan hasil validasi tadi
                    qty_usage_item: finalQty
                };

                // REPLACE ITEM LAMA
                this.selectedItems = [newItem];

                // CLOSE MODAL
                this.showPicker = false;

            },

            hapusItem(index) {

                this.selectedItems.splice(index, 1);

            }

        }

    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
