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

<!-- menampilkan data barang -->
<div x-data="{ AddDataBarang: false, EditDataBarang: false, selectedDataBarang: {}, DeleteDataBarang: false }" class="bg-white py-4 px-3 rounded-sm shadow-md">
    <!-- PageHeading & Actions -->
    <!-- ToolBar -->
    <div class="flex justify-between items-center gap-4 mb-4">
        <div class="flex-1 max-w-md">
            <label class="flex flex-col w-full">
                <div class="relative w-full md:w-72">
                    <i
                        class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                        placeholder="Search" type="text" />
                </div>
            </label>
        </div>
        <button @click="AddDataBarang = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Barang</span>
        </button>
    </div>
    <!-- Table barang -->
    <div class="@container">
        <div class="flex overflow-hidden border-gray-200 bg-white">
            <table class="w-full text-left">
                <thead class="sticky top-0 z-1">
                    <tr class="bg-primary text-white ">
                        <th class="px-4 py-3 text-left text-white w-20 text-xs font-medium uppercase tracking-wider">
                            ID</th>
                        <th class="px-4 py-3 text-left text-white w-16 text-xs font-medium uppercase tracking-wider">
                            Image</th>
                        <th class="px-4 py-3 text-left text-white w-1/4 text-xs font-medium uppercase tracking-wider">
                            Nama Barang
                        </th>
                        <th class="px-4 py-3 text-left text-white text-xs font-medium uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-4 py-3 text-left text-white text-xs font-medium uppercase tracking-wider">
                            Tempat Menyimpan
                        </th>
                        <th class="px-4 py-3 text-left text-white w-20 text-xs font-medium uppercase tracking-wider">
                            Qty
                        </th>
                        <th class="px-4 py-3 text-left text-white w-40 text-xs font-medium uppercase tracking-wider">
                            Kondisi
                        </th>
                        <th class="px-4 py-3 text-left text-white w-32 text-xs font-medium uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($DataBarang->isEmpty())
                        <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                            <td class="px-4 py-3 text-sm font-normal text-center" colspan="8">
                                <span class="text-gray-700 font-semibold">Data kosong!</span>
                            </td>
                        </tr>
                    @else
                        @foreach ($DataBarang as $dataBarang)
                            <tr class="border-b border-slate-200 odd:bg-gray-100 even:bg-white">
                                <td class="h-[72px] px-4 py-2 text-[#60758a] text-sm font-normal leading-normal">
                                    {{ $dataBarang->id_item }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal">
                                    <img src="/storage/{{ $dataBarang->img_item }}" 
                                        class=" text-slate-900 hover:text-blue-500 text-center max-w-15 hover:scale-120 hover:grayscale cursor-pointer rounded-sm"
                                        @click="OpenImgRuangan = true; true; selectedDataBarang = {
                                        img: '{{ $dataBarang->img_item }}',
                                    }">
                                    {{-- <span class="material-symbols-outlined text-sm fa-solid fa-image"></span> --}}
                                    {{-- </button> --}}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-slate-900 text-sm font-normal leading-normal">
                                    {{ $dataBarang->nama_item }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-slate-900 text-sm font-normal leading-normal">
                                    {{ $dataBarang->nama_tipe_item }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-slate-900 text-sm font-normal leading-normal">
                                    {{ $dataBarang->nama_room }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-slate-900 text-sm font-normal leading-normal">
                                    {{ $dataBarang->qty_item }}
                                </td>
                                <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal items-center">
                                    <span
                                        class="inline-flex items-center rounded-full h-6 px-3 bg-green-600 text-white text-xs font-medium hover:bg-green-400">
                                        {{ $dataBarang->kondisi_item }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center flex gap-1">
                                    <form method="GET" action="/admin/data-ruangan/detail/">
                                        @csrf
                                        <button
                                            class="py-1 px-2 text-slate-900 bg-blue-500 hover:bg-blue-300 flex items-center gap-1">
                                            <i class="material-symbols-outlined text-xs fa-solid fa-eye"></i>
                                            <span>Detail</span>
                                        </button>
                                    </form>
                                    <button
                                        class="py-1 px-2 text-slate-900 bg-red-500 hover:bg-red-400 flex items-center gap-1"
                                        @click="DeleteDataBarang = true; selectedDataBarang = {
                                        id_item: '{{ $dataBarang->id_item }}',
                                    }">
                                        <i class="material-symbols-outlined text-xs fa-solid fa-trash-can"></i>
                                        <span>Hapus</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- ====================================== show ============================================================= --}}

    {{-- shwo add tipe ruangan --}}
    <div x-show="AddDataBarang"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50" x-transition
        x-cloak>
        <div @click.outside="AddDataBarang = false" class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

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

            <button @click="DeleteTipeBarang = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

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

{{-- menampilkan data tipe barang --}}
<div x-data="{ AddTipeBarang: false, EditTipeBarang: false, selectedTipeBarang: {}, DeleteTipeBarang: false }" class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Data Tipe Barang</h5>
    <!-- ToolBar -->
    <div class="flex justify-between items-center gap-4 mb-4">
        <div class="flex-1 max-w-md">
            <label class="flex flex-col w-full">
                <div class="relative w-full md:w-72">
                    <i
                        class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                        placeholder="Search" type="text" />
                </div>
            </label>
        </div>
        <button @click="AddTipeBarang = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Tipe Barang</span>
        </button>
    </div>

    <!-- Data Table tipe ruangan -->
    <div class="overflow-x-auto max-h-70 overflow-y-auto">
        <table class="w-full text-left">
            <thead class="sticky top-0 z-10 bg-slate-200">
                <tr class="bg-primary text-white ">
                    <th class="px-4 py-3 text-sm font-medium ">
                        id tipe
                    </th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Nama tipe
                    </th>
                    <th class="px-4 py-3 text-sm font-medium text-center ">
                        Aksi
                    </th>

                </tr>
            </thead>
            <tbody>
                @if ($DataTipeBarang->isEmpty())
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="3">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @else
                    @foreach ($DataTipeBarang as $dataBarang)
                        <tr class=" odd:bg-gray-100 even:bg-white">
                            <td class="px-4 py-3 text-sm font-normal  ">
                                {{ $dataBarang->id_tipe_item }}
                            </td>
                            <td class="px-4 py-3 text-sm font-normal">
                                {{ $dataBarang->nama_tipe_item }}
                            </td>
                            <td class="px-4 py-3 text-center flex gap-1 justify-center">
                                <button
                                    class="px-2 py-1 text-slate-900 bg-green-500 hover:bg-green-400 flex items-center gap-1"
                                    @click="EditTipeBarang = true; selectedTipeBarang = {
                                                id_tipe: '{{ $dataBarang->id_tipe_item }}',
                                                nama_tipe: '{{ $dataBarang->nama_tipe_item }}',
                                            }">
                                    <span class="material-symbols-outlined text-xs fa-solid fa-pen-to-square"></span>
                                    <span>Edit</span>
                                </button>
                                <button
                                    class="px-2 py-1 text-slate-900 bg-red-500 hover:bg-red-400 flex items-center gap-1"
                                    @click="DeleteTipeBarang = true; selectedTipeBarang = {
                                                id_tipe: '{{ $dataBarang->id_tipe_item }}',
                                        }">
                                    <span class="material-symbols-outlined text-xs fa-solid fa-trash-can"></span>
                                    <span>Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
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
                            <input type="text" class="form-control" name="nama_tipe" placeholder=" " required>
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
