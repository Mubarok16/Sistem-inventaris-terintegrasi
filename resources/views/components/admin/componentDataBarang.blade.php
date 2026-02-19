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
        <div class="bg-white p-4 rounded-xl border border-slate-200 mb-8 flex flex-wrap gap-4 items-center shadow-sm">
            <div class="relative flex-grow max-w-md">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm outline-none transition-all"
                    placeholder="Cari nama ruangan atau lokasi..." type="text" />
            </div>
            <div class="flex items-center gap-2 ml-auto">
                <button @click="activeTab = 'barang'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-blue-700 transition-colors text-white bg-blue-500">
                    {{-- <i class="fa-solid fa-filter text-xs"></i> --}}
                    Data Baranga
                </button>
                <button @click="activeTab = 'tipe'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-slate-50 transition-colors text-slate-600">
                    {{-- <i class="fa-solid fa-sort-amount-down text-xs"></i> --}}
                    Tipe Barang
                </button>
            </div>
        </div>
        {{-- tambah barang --}}
        <div class="flex flex-col md:flex-row md:items-center justify-end gap-6 mb-10">
            <button @click="AddDataBarang = true"
                class="bg-primary hover:bg-blue-700 text-white px-6 py-3 rounded-xl! flex items-center justify-center gap-3 font-semibold transition-all shadow-lg shadow-primary/20">
                <i class="fa-solid fa-plus-circle"></i>
                Tambah Barang Baru
            </button>
        </div>

        {{-- card data barang --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach ($DataBarang as $dataBarang)
                <div
                    class="item-card bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img alt="Laptop" class="w-full h-full object-cover"
                            src="/storage/{{ $dataBarang->img_item }}" />
                        <div class="absolute top-3 right-3">
                            <span
                                class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-sm">Tersedia</span>
                        </div>
                    </div>
                    <div class="p-6 flex-grow">
                        <div class="mb-3">
                            <span class="py-1 text-blue-700 text-[10px] font-bold rounded uppercase">
                                {{ $dataBarang->nama_tipe_item }}
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
                                <i class="fa-solid fa-boxes-stacked w-6 text-primary text-base"></i>
                                <span>Stok: <span class="font-semibold text-slate-900">{{ $dataBarang->qty_item }}
                                        Unit</span></span>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-2 tracking-widest">
                                Kondisi
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded border border-blue-100 uppercase">
                                    {{ $dataBarang->kondisi_item }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex gap-3">
                        <a href="{{ route('edit-barang', ['id' => $dataBarang->id_item]) }}"
                            class="flex-1 bg-white hover:bg-blue-500! hover:text-white! border border-slate-200 hover:border-blue-500 text-slate-700 px-4 py-2 rounded-lg! text-sm font-bold transition-all flex items-center justify-center gap-2 no-underline!">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <button
                            @click="DeleteDataBarang = true; selectedDataBarang = {
                                        id_item: '{{ $dataBarang->id_item }}',
                                    }"
                            class="flex-1 bg-white hover:bg-red-500! hover:text-white border border-slate-200 hover:border-red-500 text-slate-700 px-4 py-2 rounded-lg! text-sm font-bold transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- informasi menampilkan bnayaknya barang --}}
        <div class="flex items-center justify-between mb-12">
            <div class="text-sm text-slate-500 font-medium">
                Menampilkan <span class="text-slate-900 font-bold">3</span> dari <span
                    class="text-slate-900 font-bold">45</span> barang
            </div>
            <div class="flex gap-2">
                <button
                    class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button
                    class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center text-sm font-bold">1</button>
                <button
                    class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-sm font-medium hover:border-primary hover:text-primary transition-all bg-white">2</button>
                <button
                    class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
        {{-- summary ketersediaan dan stok --}}
        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-3xl">inventory_2</span>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Barang</div>
                    <div class="text-3xl font-extrabold text-slate-900">124</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-3xl">check_box</span>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tersedia</div>
                    <div class="text-3xl font-extrabold text-slate-900">98</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-3xl">shopping_cart_checkout</span>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Sedang Dipinjam</div>
                    <div class="text-3xl font-extrabold text-slate-900">26</div>
                </div>
            </div>
        </div> --}}

        {{-- ====================================== show ============================================================= --}}

        {{-- shwo add tipe ruangan --}}
        <div x-show="AddDataBarang"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
            x-transition x-cloak>
            <div @click.outside="AddDataBarang = false"
                class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                <button @click="AddDataBarang = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Add Tipe Barang</h2>

                <form method="POST" action="{{ route('addBarang') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-2 overflow-hidden">
                        <div class="col-12 m-0">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="nama_item" placeholder=" " required>
                                <label class="form-label">Nama Barang</label>
                            </div>
                        </div>
                        <div class="col-12 m-0">
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-home"></i>
                                </span>
                                <select name="tipe" class="form-select" required>
                                    <option value="">--- Pilih Tipe Barang ---</option>
                                    @foreach ($DataTipeBarang as $dataTipeBarang)
                                        <option value="{{ $dataTipeBarang->id_tipe_item }}">
                                            {{ $dataTipeBarang->nama_tipe_item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 m-0">
                            <div class="input-group mb-2">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-home"></i>
                                </span>
                                <select name="tempat_menyimpan" class="form-select" required>
                                    <option value="">--- Pilih Tempat Menyinpan ---</option>
                                    @foreach ($DataRuangan as $dataRuangan)
                                        <option value="{{ $dataRuangan->id_room }}">{{ $dataRuangan->nama_room }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 m-0">
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control" name="qty" placeholder=" " required>
                                <label class="form-label">Qty Barang</label>
                            </div>
                        </div>
                        <div class="col-12 m-0">
                            <div class="mb-2">
                                <label>Kondisi Barang:</label><br>
                                <input type="radio" name="kondisi" value="Baik">
                                <label for="pria">Baik</label>
                                <input type="radio" name="kondisi" value="Rusak">
                                <label for="pria">Rusak</label>
                            </div>
                        </div>
                        <div class="col-12 m-0">
                            <div class="mb-2">
                                <label for="foto" class="form-label">Masukkan gambar Barang</label>
                                <input type="file" name="gambar_item" class="form-control"
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

        {{-- show hps tipe ruangan --}}
        <div x-show="DeleteDataBarang" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
            x-transition>
            <div @click.outside="DeleteDataBarang = false"
                class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                {{-- <button @click="DeleteTipeBarang = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button> --}}

                <h4 class="text-lg font-semibold mb-4 text-center text-gray-700">Yakin ingin menghapus data ?</h4>

                <form method="POST" :action="'/admin/delete-barang/' + selectedDataBarang.id_item">
                    @csrf
                    @method('DELETE')
                    <div class="row gy-2 overflow-hidden">
                        <div class="col-12">
                            {{-- <input type="text" class="hidden" name="id_tipe" x-model="selectedTipeRuangan.id_tipe"> --}}
                            <div class="d-grid">
                                <button class="btn btn-primary w-100" type="submit">Hapus</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- tipe --}}
    <div x-show="activeTab === 'tipe'" x-transition x-data="{ AddTipeBarang: false, EditTipeBarang: false, selectedTipeBarang: {}, DeleteTipeBarang: false }">
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
                <button @click="activeTab = 'barang'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-slate-50 transition-colors text-slate-600">
                    {{-- <i class="fa-solid fa-filter text-xs"></i> --}}
                    Data Ruangan
                </button>
                <button @click="activeTab = 'tipe'"
                    class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg! text-sm font-medium hover:bg-blue-700 transition-colors text-white bg-blue-500">
                    {{-- <i class="fa-solid fa-sort-amount-down text-xs"></i> --}}
                    Tipe Ruangan
                </button>
            </div>
        </div>

        {{-- tambah barang --}}
        <div class="flex flex-col md:flex-row md:items-center justify-end gap-6 mb-10">
            <button @click="AddTipeBarang = true"
                class="bg-primary hover:bg-blue-700 text-white px-6 py-3 rounded-xl! flex items-center justify-center gap-3 font-semibold transition-all shadow-lg shadow-primary/20">
                <i class="fa-solid fa-plus-circle"></i>
                Tambah tipe
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
                        @foreach ($DataTipeBarang as $dataRuangan)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5 text-sm text-slate-500 font-medium">{{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="text-sm font-bold text-slate-900">{{ $dataRuangan->id_tipe_item }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="text-sm font-bold text-slate-900">{{ $dataRuangan->nama_tipe_item }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-3">
                                        <button
                                            @click="EditTipeBarang = true; selectedTipeBarang = {
                                                    id_tipe: '{{ $dataRuangan->id_tipe_item }}',
                                                    nama_tipe: '{{ $dataRuangan->nama_tipe_item }}',
                                                }"
                                            class="w-9 h-9 flex items-center justify-center text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                            title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button
                                            @click="DeleteTipeBarang = true; selectedTipeBarang = {
                                                        id_tipe: '{{ $dataRuangan->id_tipe_item }}',
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

        {{-- ====================================== show ============================================================= --}}

        {{-- shwo add tipe ruangan --}}
        <div x-show="AddTipeBarang"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
            x-transition x-cloak>
            <div @click.outside="AddTipeBarang = false"
                class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                <button @click="AddTipeBarang = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Add Tipe Barang</h2>

                <form method="POST" action="{{ route('addTipeBarang') }}">
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
        <div x-show="EditTipeBarang" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
            x-transition>
            <div @click.outside="EditTipeBarang = false"
                class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                <button @click="EditTipeBarang = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                <h4 class="text-xl font-semibold mb-4 text-center text-gray-700">Edit Tipe Barang</h4>

                <form method="POST" :action="'/admin/edit-tipe-barang/' + selectedTipeBarang.id_tipe">
                    @csrf
                    <div class="row gy-2 overflow-hidden">
                        <div class="col-12 m-0">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="nama_tipe"
                                    x-model="selectedTipeBarang.nama_tipe" required>
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
        <div x-show="DeleteTipeBarang" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
            x-transition>
            <div @click.outside="DeleteTipeBarang = false"
                class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

                <button @click="DeleteTipeBarang = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                <h4 class="text-lg font-semibold mb-4 text-center text-gray-700">Yakin ingin menghapus tipe?</h4>

                <form method="POST" :action="'/admin/delete-tipe-barang/' + selectedTipeBarang.id_tipe">
                    @csrf
                    @method('DELETE')
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
</main>

