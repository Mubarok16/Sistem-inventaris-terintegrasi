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
                <input
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                    placeholder="Cari nama ruangan atau lokasi..." type="text" />
            </div>
            <div class="flex items-center gap-2 ml-auto">
                <button @click="activeTab = 'ruangan'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-blue-400 transition-colors text-white bg-blue-600">
                    {{-- <i class="fa-solid fa-filter text-xs"></i> --}}
                    Data Ruangan
                </button>
                <button @click="activeTab = 'tipe'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-slate-50 transition-colors text-slate-600">
                    {{-- <i class="fa-solid fa-sort-amount-down text-xs"></i> --}}
                    Tipe Ruangan
                </button>
            </div>
        </div>

        {{-- data ruangan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ AddDataRuangan: false, EditDataRuangan: false, selectedDataRuangan: {}, DeleteDataRuangan: false, OpenImgRuangan: false }">
            {{-- add raungan baru --}}
            <div
                class="border-2 border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center p-8 bg-white/50 text-center min-h-[400px] hover:border-primary/40 hover:bg-white transition-all group">
                <div
                    class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mb-6 text-primary group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-door-open text-4xl"></i>
                </div>
                <h5 class="text-xl font-bold text-slate-800">Tambah Ruangan Baru</h5>
                <p class="text-slate-400 text-sm mb-8 max-w-[240px] mx-auto">Sistem siap untuk penambahan data baru.
                    Klik tombol di bawah untuk mulai mengelola ruangan lainnya.</p>
                <button @click="AddDataRuangan = true"
                    class="bg-blue-500 text-white px-8 py-3 rounded-xl! font-bold text-sm shadow-lg shadow-primary/20 hover:bg-blue-600 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus"></i>
                    Ruangan Baru
                </button>
            </div>

            {{-- menampilkan data ruangan --}}
            @foreach ($DataRuangan as $ruang)
                <div
                    class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col group hover:shadow-md transition-shadow">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span
                                    class="inline-block py-0.5 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider rounded mb-2">
                                    {{ $ruang->nama_tipe_room }}
                                </span>
                                <h5 class="text-xl font-bold text-slate-900">{{ $ruang->nama_room }}</h5>
                            </div>
                            <span
                                class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-sm">
                                Tersedia
                            </span>
                        </div>
                        {{-- <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                            <i class="fa-solid fa-location-dot text-slate-400"></i>
                            <span>Lantai 2, Sayap Kanan</span>
                        </div> --}}
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Daftar Barang
                                </h4>
                                {{-- <button
                                class="text-primary text-[10px] font-bold uppercase hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-plus text-[8px]"></i> Tambah
                            </button> --}}
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
                                        {{-- <button class="text-slate-300 hover:text-danger transition-colors" title="Hapus Barang">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button> --}}
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
                                    <a href="/admin/data-ruangan/detail/{{ $ruang->id_room }}" class="text-sm">lebih
                                        banyak</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 border-t border-slate-100 mt-auto flex gap-2">
                        <a href="{{ route('edit-ruangan', ['id' => $ruang->id_room ]) }}"
                            class="flex-grow bg-white hover:bg-primary hover:text-white text-primary py-2.5 rounded-lg font-semibold text-sm transition-all flex items-center justify-center gap-2 border border-primary/20 shadow-sm no-underline!">
                            <i class="fa-solid fa-pen-to-square"></i>
                            edit
                        </a>
                        <button
                            class="px-4 bg-white hover:bg-primary hover:text-white text-primary border border-danger/20 rounded-lg! transition-all flex items-center justify-center shadow-sm"
                            @click="OpenImgRuangan = true; true; selectedDataRuangan = {
                                            img: '{{ $ruang->gambar_room }}',
                                        }">
                            <i class="fa-solid fa-images"></i>
                        </button>
                        <button
                            class="px-4 bg-white hover:bg-danger hover:text-white text-danger border border-danger/20 rounded-lg! transition-all flex items-center justify-center shadow-sm"
                            title="Hapus Ruangan"
                            @click="DeleteDataRuangan = true; selectedDataRuangan = {
                                            id_room: '{{ $ruang->id_room }}',
                                        }">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            @endforeach

            {{-- shwo add data ruangan --}}
            <div x-show="AddDataRuangan"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition x-cloak>
                <div @click.outside="AddDataRuangan = false"
                    class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                    <button @click="AddDataRuangan = false"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                    <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Add Data Ruangan</h2>

                    <form method="POST" action="{{ route('addRuangan') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12 m-0">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="nama_room" placeholder=" "
                                        required>
                                    <label class="form-label">Nama Ruangan</label>
                                </div>
                            </div>
                            <div class="col-12 m-0">
                                <div class="input-group mb-2">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-home"></i>
                                    </span>
                                    <select name="tipe" class="form-select" required>
                                        <option value="">--- Pilih Tipe Ruangan ---</option>
                                        @foreach ($DataTipeRuangan as $dataTipe)
                                            <option value="{{ $dataTipe->id_tipe_room }}">
                                                {{ $dataTipe->nama_tipe_room }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 m-0">
                                <div class="mb-2">
                                    <label>Kondisi Ruangan:</label><br>
                                    <input type="radio" name="kondisi" value="Baik">
                                    <label for="pria">Baik</label>
                                    <input type="radio" name="kondisi" value="Rusak">
                                    <label for="pria">Rusak</label>
                                </div>
                            </div>
                            <div class="col-12 m-0">
                                <div class="mb-2">
                                    <label for="foto" class="form-label">Masukkan gambar ruangan</label>
                                    <input type="file" name="gambar_room" class="form-control"
                                        accept="image/jpeg, image/png,.doc" capture="environment" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- shwo img ruangan --}}
            <div x-show="OpenImgRuangan"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition x-cloak>
                <div class="flex justify-center rounded-2xl w-full max-w-xl relative"
                    @click.outside="OpenImgRuangan = false">
                    <img :src="`/storage/${selectedDataRuangan.img}`" alt="Foto Peminjam" class="container">
                </div>
            </div>

            {{-- show hapus ruangan --}}
            <div x-show="DeleteDataRuangan" x-cloak
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition>
                <div @click.outside="DeleteDataRuangan = false"
                    class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                    <button @click="DeleteDataRuangan = false"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                    <h4 class="text-lg font-semibold mb-4 text-center text-gray-700">Yakin ingin menghapus ruangan?
                    </h4>

                    <form method="POST" :action="'/admin/delete-ruangan/' + selectedDataRuangan.id_room"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12">
                                {{-- <input type="text" class="hidden" name="id_tipe" x-model="selectedTipeRuangan.id_tipe"> --}}
                                <div class="d-grid">
                                    <button class="btn btn-primary w-100" type="submit">Hapus Ruangan</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- footer menampilkan info banyaknya data --}}
        <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-slate-200 pt-8">
            <div class="text-sm text-slate-500">
                Menampilkan <span class="font-bold text-slate-800">3</span> dari <span
                    class="font-bold text-slate-800">12</span> ruangan terdaftar
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="p-2 border border-slate-200 rounded-lg text-slate-400 hover:text-primary transition-colors hover:border-primary">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold">1</button>
                <button
                    class="px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium hover:border-primary hover:text-primary transition-all">2</button>
                <button
                    class="px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium hover:border-primary hover:text-primary transition-all">3</button>
                <button
                    class="p-2 border border-slate-200 rounded-lg text-slate-400 hover:text-primary transition-colors hover:border-primary">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- tipe ruangan --}}
    <div x-show="activeTab === 'tipe'" x-transition>
        {{-- pencarian tipe --}}
        <div class="bg-white p-4 rounded-xl border border-slate-200 mb-8 flex flex-wrap gap-4 items-center shadow-sm">
            <div class="relative flex-grow max-w-md">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                    placeholder="Cari nama ruangan atau lokasi..." type="text" />
            </div>
            <div class="flex items-center gap-2 ml-auto">
                <button @click="activeTab = 'ruangan'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-slate-50 transition-colors text-slate-600">
                    {{-- <i class="fa-solid fa-filter text-xs"></i> --}}
                    Data Ruangan
                </button>
                <button @click="activeTab = 'tipe'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-blue-400 transition-colors text-white bg-blue-600">
                    {{-- <i class="fa-solid fa-sort-amount-down text-xs"></i> --}}
                    Tipe Ruangan
                </button>
            </div>
        </div>

        {{-- kategori --}}
        {{-- <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
                <div class="bg-primary/10 p-3 rounded-lg text-primary">
                    <span class="material-symbols-outlined">category</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Tipe</p>
                    <p class="text-xl font-bold text-slate-900">4 Kategori</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
                <div class="bg-emerald-100 p-3 rounded-lg text-emerald-600">
                    <span class="material-symbols-outlined">meeting_room</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Ruangan Terkait</p>
                    <p class="text-xl font-bold text-slate-900">24 Ruangan</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
                <div class="bg-amber-100 p-3 rounded-lg text-amber-600">
                    <span class="material-symbols-outlined">update</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Terakhir Diperbarui</p>
                    <p class="text-xl font-bold text-slate-900">Hari ini</p>
                </div>
            </div>
        </div> --}}

        {{-- data tipe ruangan --}}
        <div x-data="{ AddTipeRuangan: false, EditTipeRuangan: false, selectedTipeRuangan: {}, DeleteTipeRuangan: false }">
            {{-- button tipe ruangan --}}
            <div class="flex flex-col md:flex-row md:items-center justify-end gap-6 mb-8">
                <button @click="AddTipeRuangan = true"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-500 hover:bg-blue-700 text-white font-semibold rounded-lg! transition-all shadow-sm">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>Tambah Tipe Ruangan</span>
                </button>
            </div>

            {{-- data tipe ruangan --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-sm font-semibold text-slate-700 w-20">No</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-700">Kode Tipe</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-700">Nama Tipe</th>
                                <th class="px-6 py-4 text-sm font-semibold text-slate-700 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($DataTipeRuangan as $dataRuangan)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5 text-sm text-slate-500 font-medium">{{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="text-sm font-bold text-slate-900">{{ $dataRuangan->id_tipe_room }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="text-sm font-bold text-slate-900">{{ $dataRuangan->nama_tipe_room }}</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-3">
                                            <button
                                                @click="EditTipeRuangan = true; selectedTipeRuangan = {
                                                    id_tipe: '{{ $dataRuangan->id_tipe_room }}',
                                                    nama_tipe: '{{ $dataRuangan->nama_tipe_room }}',
                                                }"
                                                class="w-9 h-9 flex items-center justify-center text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button
                                                @click="DeleteTipeRuangan = true; selectedTipeRuangan = {
                                                        id_tipe: '{{ $dataRuangan->id_tipe_room }}',
                                                }"
                                                class="w-9 h-9 flex items-center justify-center text-rose-500 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                    <p class="text-sm text-slate-500">Menampilkan <span class="font-medium">4</span> dari <span
                            class="font-medium">4</span> tipe</p>
                    <div class="flex items-center gap-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-slate-300 bg-white text-slate-400 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-primary bg-primary text-white text-sm font-medium">1</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded border border-slate-300 bg-white text-slate-600 hover:bg-slate-50">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <footer class="mt-12 pt-8 border-t border-slate-200 text-center text-slate-400 text-sm">
                <p>© 2024 Sistem Peminjaman Fakultas. Administrasi Tipe Ruangan v1.3</p>
            </footer>

            {{-- shwo add tipe ruangan --}}
            <div x-show="AddTipeRuangan"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition x-cloak>
                <div @click.outside="AddTipeRuangan = false"
                    class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                    <button @click="AddTipeRuangan = false"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                    <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Add Tipe Ruangan</h2>

                    <form method="POST" action="{{ route('addTipeRuangan') }}">
                        @csrf
                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12 m-0">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="nama_tipe" placeholder=" "
                                        required>
                                    <label class="form-label">Nama Tipe</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary w-100" type="submit">Simpan Tipe</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- show edit tipe ruangan --}}
            <div x-show="EditTipeRuangan" x-cloak
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition>
                <div @click.outside="EditTipeRuangan = false"
                    class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                    <button @click="EditTipeRuangan = false"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                    <h4 class="text-xl font-semibold mb-4 text-center text-gray-700">Edit Akun Peminjam</h4>

                    <form method="POST" :action="'/admin/edit-tipe-ruangan/' + selectedTipeRuangan.id_tipe"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12 m-0">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" name="nama_tipe"
                                        x-model="selectedTipeRuangan.nama_tipe" required>
                                    <label class="form-label">Nama tipe</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary w-100" type="submit">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            {{-- show hps tipe ruangan --}}
            <div x-show="DeleteTipeRuangan" x-cloak
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
                x-transition>
                <div @click.outside="DeleteTipeRuangan = false"
                    class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                    <button @click="DeleteTipeRuangan = false"
                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                    <h4 class="text-lg font-semibold mb-4 text-center text-gray-700">Yakin ingin menghapus tipe?</h4>

                    <form method="POST" :action="'/admin/delete-tipe-ruangan/' + selectedTipeRuangan.id_tipe"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12">
                                {{-- <input type="text" class="hidden" name="id_tipe" x-model="selectedTipeRuangan.id_tipe"> --}}
                                <div class="d-grid">
                                    <button class="btn btn-primary w-100" type="submit">Hapus tipe</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
