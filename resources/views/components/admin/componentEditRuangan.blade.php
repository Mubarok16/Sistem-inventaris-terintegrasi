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
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Nama Ruangan</label>
                                <input
                                    class="w-full px-2 py-2.5 rounded-lg! bg-slate-100 border-slate-500! focus:ring-primary focus:border-primary text-slate-900"
                                    placeholder="Contoh: Lab Komputer 1" type="text"
                                    value="{{ $ruang->nama_room }}" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Tipe Ruangan</label>
                                <select
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

                                <p class="text-slate-400 text-sm mb-8 max-w-[240px] mx-auto">
                                    <span x-show="!imageUrl">Seret gambar baru untuk mengganti gambar lama.</span>
                                    <span x-show="imageUrl">Gunakan tombol di bawah untuk memperbarui data.</span>
                                </p>

                                <input type="file" name="gambar_room" id="fileInput" class="hidden" accept="image/*"
                                    @change="handleFileSelect">

                                <div class="flex gap-3">
                                    <button type="button" @click="document.getElementById('fileInput').click()"
                                        class="bg-blue-500 text-white px-8 py-3 rounded-xl! font-bold text-sm shadow-lg shadow-primary/20 hover:bg-blue-600 transition-all flex items-center gap-2">
                                        Ganti Gambar
                                    </button>

                                </div>
                            </div>
                            <button type="submit"
                                class="bg-green-500 text-white px-8 py-2.5 rounded-xl! font-bold text-sm shadow-lg shadow-primary/20 hover:bg-green-600 transition-all flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-key"></i>
                                Simpan Perubahan sementara
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- barang yg ada di raungannya --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-primary"></i>
                        Daftar Barang &amp; Fasilitas
                    </h2>
                    <button class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-plus-circle"></i> Tambah Barang
                    </button>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-slate-100">
                                    <th class="pb-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">
                                        Nama Barang</th>
                                    <th class="pb-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">
                                        Jumlah</th>
                                    <th
                                        class="pb-4 font-semibold text-slate-400 text-xs uppercase tracking-wider text-right">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                <i class="fa-solid fa-snowflake text-xs"></i>
                                            </div>
                                            <span class="font-medium text-slate-700">AC Panasonic 2PK</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-slate-600">2 Unit</td>
                                    <td class="py-4 text-right">
                                        <button class="text-slate-300 hover:text-danger p-2 transition-colors"
                                            title="Hapus Barang">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                <i class="fa-solid fa-video text-xs"></i>
                                            </div>
                                            <span class="font-medium text-slate-700">Proyektor Epson EB-X500</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-slate-600">1 Unit</td>
                                    <td class="py-4 text-right">
                                        <button class="text-slate-300 hover:text-danger p-2 transition-colors"
                                            title="Hapus Barang">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                                <i class="fa-solid fa-desktop text-xs"></i>
                                            </div>
                                            <span class="font-medium text-slate-700">Smart TV 55 Inch</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-slate-600">1 Unit</td>
                                    <td class="py-4 text-right">
                                        <button class="text-slate-300 hover:text-danger p-2 transition-colors"
                                            title="Hapus Barang">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 mb-4">Status &amp; Visibilitas</h3>
                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between p-3 rounded-xl bg-green-50 text-green-700 border border-green-100">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i>
                            <span class="text-sm font-semibold">Tersedia</span>
                        </div>
                        <button class="text-[10px] font-bold uppercase underline">Ubah</button>
                    </div>
                    <div class="text-xs text-slate-400 leading-relaxed">
                        Terakhir diupdate oleh <b>Admin Pusat</b> pada 24 Okt 2023, 14:20 WIB.
                    </div>
                </div>
            </div>
            <div class="mb-4 flex items-center justify-end">
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
            </div>
        </div>
    </div>
</main>

<script>
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
