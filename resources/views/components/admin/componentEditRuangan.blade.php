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


<main class="mx-2 py-3">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            {{-- informasi ruangan --}}
            @foreach ($DataRuangan as $ruang)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-primary"></i>
                            Informasi Dasar
                        </h2>
                    </div>
                    <form action="{{ route('edit-ruangan-informasi-dasar') }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        <div class="p-6 space-y-5">
                            <div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">ID Ruangan</label>
                                    <input name="id_room"
                                        class="w-full px-2 py-2.5 rounded-lg! bg-slate-100 border-slate-500! focus:ring-primary focus:border-primary text-slate-500"
                                        placeholder="Contoh: Lab Komputer 1" type="text"
                                        value="{{ $ruang->id_room }}" disabled />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Nama Ruangan</label>
                                    <input name="nama_room"
                                        class="w-full px-2 py-2.5 rounded-lg! bg-slate-100 border-slate-500! focus:ring-primary focus:border-primary text-slate-900"
                                        placeholder="Contoh: Lab Komputer 1" type="text"
                                        value="{{ $ruang->nama_room }}" />
                                    <input type="text" name="id_room" value="{{ $ruang->id_room }}" hidden>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Tipe Ruangan</label>
                                    <select name="tipe_room"
                                        class="w-full px-2 py-2.5 rounded-lg! bg-slate-100 border-slate-500! focus:ring-primary focus:border-primary text-slate-900">
                                        @foreach ($tipeRuangan as $tipe)
                                            <option value="{{ $tipe->id_tipe_room }}"
                                                {{ $ruang->id_tipe_room == $tipe->id_tipe_room ? 'selected' : '' }}>
                                                {{ $tipe->nama_tipe_room }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-5" x-data="imageUploader('{{ asset('storage/' . $ruang->gambar_room) }}')">
                                <div class="border-2 border-dashed rounded-xl flex flex-col items-center justify-center p-8 transition-all group min-h-[400px]"
                                    :class="isDragging ? 'border-blue-500 bg-blue-50' :
                                        'border-slate-200 bg-white/50 hover:border-primary/40 hover:bg-white'"
                                    @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                                    @drop.prevent="handleDrop($event)">
                                    <div class="relative w-32 h-32 mb-6 flex items-center justify-center">

                                        <template x-if="!imageUrl">
                                            <div
                                                class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                                <i class="fa-solid fa-door-open text-4xl"></i>
                                            </div>
                                        </template>

                                        <template x-if="imageUrl">
                                            <div class="relative w-full h-full">
                                                <img :src="imageUrl"
                                                    class="w-full h-full object-cover rounded-xl shadow-md border-2 border-white">

                                                <button type="button" @click="imageUrl = null"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                    <h5 class="text-xl font-bold text-slate-800"
                                        x-text="imageUrl ? 'Gambar Ruangan' : 'Tambah Gambar'"></h5>

                                    <p class="text-slate-400 text-sm mb-8 max-w-[240px] mx-auto text-center">
                                        <span x-show="!imageUrl">Seret gambar baru untuk mengganti gambar lama.</span>
                                        <span x-show="imageUrl">Gunakan tombol di bawah untuk memperbarui data.</span>
                                    </p>

                                    <input type="file" name="gambar_room" id="fileInput" class="hidden"
                                        accept="image/*" @change="handleFileSelect">

                                    <div class="flex gap-3">
                                        <button type="button" @click="document.getElementById('fileInput').click()"
                                            class="bg-blue-500 text-white px-8 py-3 rounded-xl! font-bold text-sm shadow-lg shadow-primary/20 hover:bg-blue-600 transition-all flex items-center gap-2">
                                            Ganti Gambar
                                        </button>

                                    </div>
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-8 py-2.5 rounded-xl! font-bold text-sm shadow-lg shadow-primary/20 hover:bg-blue-600 transition-all flex items-center gap-2 justify-center">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach

            {{-- barang yg ada di raungannya --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                {{-- tombol tambah --}}
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center"
                    x-data="{
                        showPicker: false,
                        currentTab: 'barang',
                        products: [],
                        init() { this.products = productsData }
                    }" x-init="init()">

                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-primary"></i>
                        Daftar Barang Yang Tersimpan
                    </h2>
                    @foreach ($DataRuangan as $ruang)
                        <input type="text" name="id_room" value="{{ $ruang->id_room }}" hidden>
                        <button @click="showPicker = true"
                            class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-plus-circle"></i> Tambah Barang Ke Ruangan
                        </button>
                    @endforeach

                    {{-- all ruangan --}}
                    <div x-show="showPicker" x-transition.opacity
                        class="fixed inset-0 bg-black/60 z-50 backdrop-blur-sm flex items-center justify-center p-4 md:p-10"
                        x-cloak>

                        <div @click.away="showPicker = false"
                            class="bg-gray-50 w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">

                            <div class="bg-white border-b border-gray-300">
                                <div class="py-3 px-6 flex justify-between items-center">
                                    <h5 class="text-xl font-bold text-gray-800">
                                        <i class="fa-solid fa-box text-primary"></i>
                                        Pilih Barang atau Ruangan Yang ingin dipindahkan ke rungan ini
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
                                                    <span
                                                        class="text-xs font-medium text-slate-400 uppercase tracking-wide"
                                                        x-text="item.nama_tipe_item"></span>
                                                    <div class="flex items-center gap-1 text-green-500">
                                                        stok:
                                                        <span
                                                            class="material-symbols-outlined text-[16px] leading-none"
                                                            x-text="item.qty_item">
                                                        </span>
                                                    </div>
                                                </div>
                                                <form action="{{ route('edit-ruangan-pindah-barang') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="flex justify-between">
                                                        <h3 class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors"
                                                            x-text="item.nama_item">
                                                        </h3>
                                                        <input name="qty_item" type="text" :value="item.qty_item"
                                                            hidden>
                                                    </div>
                                                    <div class="flex items-center justify-between mt-auto pt-2">
                                                        <div class="flex gap-2 w-full">
                                                            <input name="id_item_room" type="text"
                                                                :value="item.id" hidden>
                                                            <input name="id_room_sekarang" type="text"
                                                                value="{{ $id }}" hidden>
                                                            <button type="submit" id="pilih_barangruang" :disabled="item.id_room === '{{ $id }}'"
                                                                :class="item.id_room == '{{ $id ?? '' }}' ? 'bg-gray-400 opacity-50 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-300'"
                                                                class="py-1 px-2 text-white flex justify-center items-center text-center gap-1 w-full rounded ">
                                                                Pindahkan <span
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
                        </div>
                    </div>
                </div>

                {{-- list barang --}}
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-slate-100">
                                    <th class="pb-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">
                                        Nama Barang</th>
                                    <th class="pb-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">
                                        Jumlah Unit</th>
                                    {{-- <th
                                        class="pb-4 font-semibold text-slate-400 text-xs uppercase tracking-wider text-right">
                                        Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($dataBarangYgDruangan as $item)
                                    <tr class="group hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                    {{-- <i class="fa-solid fa-snowflake text-xs"></i> --}}
                                                    <img src="{{ asset('storage/' . $item->img_item) }}"
                                                        class="w-full h-full object-cover border-0 rounded-lg!">
                                                </div>
                                                <span class="font-medium text-slate-700">{{ $item->nama_tipe_item }}
                                                    {{ $item->nama_item }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-slate-600">{{ $item->qty_item }} Unit</td>
                                        {{-- <td class="py-4 text-right">
                                        <button class="text-slate-300 hover:text-danger p-2 transition-colors"
                                            title="Hapus Barang">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- visibilitas dan kondisi --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4">Kondisi &amp; Visibilitas</h3>
                <div class="space-y-4">
                    {{-- <div
                        class="flex items-center justify-between p-3 rounded-xl bg-green-50 text-green-700 border border-green-100">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i>
                            <span class="text-sm font-semibold">Tersedia</span>
                        </div>
                        <button class="text-[10px] font-bold uppercase underline">Ubah</button>
                    </div> --}}
                    @foreach ($DataRuangan as $ruang)
                        <form action="{{ route('edit-ruangan-kondisi') }}" method="post">
                            @csrf
                            <input type="text" name="id_room" value="{{ $ruang->id_room }}" hidden>
                            {{-- kondisi --}}
                            <label class="text-sm font-semibold text-slate-500">Kondisi</label>
                            <div x-data="{ tersedia: {{ $ruang->kondisi_room === 'Baik' ? 'true' : 'false' }} }"
                                :class="tersedia ? 'bg-green-50 text-green-700 border-green-100' :
                                    'bg-red-50 text-red-700 border-red-100'"
                                class="flex items-center justify-between p-3 rounded-xl border transition-all">

                                <div class="flex items-center gap-2">
                                    <i class="fa-solid" :class="tersedia ? 'fa-circle-check' : 'fa-circle-xmark'"></i>
                                    <span class="text-sm font-semibold" x-text="tersedia ? 'Baik' : 'Rusak'"></span>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" x-model="tersedia" name="kondisi"
                                        onchange="this.form.submit()">
                                    <div
                                        class="w-9 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>
                        </form>

                        <form action="{{ route('edit-ruangan-visibility') }}" method="post">
                            @csrf
                            <input type="text" name="id_room" value="{{ $ruang->id_room }}" hidden>
                            {{-- visibility --}}
                            <label class="text-sm font-semibold text-slate-500">Visibilitas</label>
                            <div x-data="{ tersedia: {{ $ruang->visibility_room === '1' ? 'true' : 'false' }} }"
                                :class="tersedia ? 'bg-green-50 text-green-700 border-green-100' :
                                    'bg-red-50 text-red-700 border-red-100'"
                                class="flex items-center justify-between p-3 rounded-xl border transition-all">

                                <div class="flex items-center gap-2">
                                    <i class="fa-solid" :class="tersedia ? 'fa-circle-check' : 'fa-circle-xmark'"></i>
                                    <span class="text-sm font-semibold"
                                        x-text="tersedia ? 'Bisa Dipinjam' : 'Tidak Diperbolehkan'"></span>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" x-model="tersedia" name="visibility"
                                        onchange="this.form.submit()">
                                    <div
                                        class="w-9 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>
                        </form>
                        <div class="text-xs text-slate-400 leading-relaxed">
                            Terakhir diupdate oleh <b>Admin </b> pada {{ $ruang->updated_at->format('d M Y, H:i') }}.
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <div class="mb-4 flex items-center justify-end">
                <div class="flex gap-3">
                    <button
                        class="px-6 py-2.5 rounded-xl! border border-slate-200 text-slate-600 font-semibold hover:bg-slate-100 transition-all">
                        Batal
                    </button>
                    <button
                        class="px-6 py-2.5 rounded-xl! bg-blue-600 text-white font-bold shadow-lg shadow-primary/20 hover:bg-blue-700 transition-all transform">
                        Simpan Perubahan
                    </button>
                </div>
            </div> --}}
        </div>
    </div>
</main>

<script>

    const productsData = @json($allBarangRuang);

    function imageUploader(existingUrl = null) {
        return {
            isDragging: false,
            imageUrl: existingUrl, // Mengisi imageUrl dengan data dari database saat load

            handleDrop(e) {
                this.isDragging = false;
                const file = e.dataTransfer.files[0];
                this.processFile(file);
            },

            handleFileSelect(e) {
                const file = e.target.files[0];
                this.processFile(file);
            },

            processFile(file) {
                if (file && file.type.startsWith('image/')) {
                    // Masukkan file ke dalam input file agar bisa dikirim via form
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('fileInput').files = dataTransfer.files;

                    // Update Preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            saveData() {
                // Jika Anda menggunakan form submit manual:
                // document.querySelector('form').submit();
                alert('Mengirim data ke server...');
            }
        }
    }
</script>
