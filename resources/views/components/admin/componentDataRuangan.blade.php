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

{{-- tabel data ruangan --}}
<div class="bg-white rounded-xl shadow-sm p-6 mt-4">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4">Data Ruangan</h5>

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
        <button @click="AddRuangan = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Ruangan</span>
        </button>
    </div>
    <!-- Data Table -->
    <div class="max-h-70 overflow-y-auto overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-primary text-white ">
                    <th class="px-4 py-3 text-sm font-medium ">
                        Id Ruangan
                    </th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Nama</th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Tipe</th>
                    <th class="px-4 py-3 text-sm font-medium">
                        List Barang</th>
                    <th class="px-4 py-3 text-sm font-medium">
                        Kondisi</th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Gambar</th>
                    <th class="px-4 py-3 text-sm font-medium  text-center">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($AkunUsers as $akunUser) --}}
                <tr class="border-b border-slate-200 ">
                    <td class="px-4 py-3 text-sm font-normal  ">
                        R001
                    </td>
                    <td class="px-4 py-3 text-sm font-normal ">
                        Lab Komputer
                    </td>
                    <td class="px-4 py-3 text-sm font-normal">
                        Laboratorium
                    </td>
                    <td class="px-4 py-3">
                        <a href="">Lihat</a>
                    </td>
                    <td class="px-4 py-3">
                        baik
                    </td>
                    <td class="px-4 py-3 text-sm font-normal">
                        <button class="p-2 text-slate-900 hover:text-blue-500 text-center"
                            @click="OpenImgRuangan = true;">
                            <span class="material-symbols-outlined text-sm fa-solid fa-image"></span>
                        </button>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button @click="EditRuangan = true;" class="p-2 text-slate-900 hover:text-blue-500">
                            <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                        </button>
                        <button class="p-2 text-slate-900 hover:text-red-500" @click="DeleteRuangan = true;">
                            <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                        </button>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>

{{-- ================================================================================================================ --}}

{{-- tabel tipe ruangan --}}
<div x-data="{ AddTipeRuangan: false, EditTipeRuangan: false, selectedTipeRuangan: {}, DeleteTipeRuangan: false }" class="bg-white rounded-xl shadow-sm p-6 my-4">
    <h5 class="text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Data Tipe Ruangan</h5>
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
        <button @click="AddTipeRuangan = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Tipe Ruangan</span>
        </button>
    </div>
    <!-- Data Table tipe ruangan -->
    <div class="max-h-70 overflow-y-auto overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-primary text-white ">
                    <th class="px-4 py-3 text-sm font-medium ">
                        id tipe Ruangan
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
                @foreach ($DataRuangan as $dataRuangan)
                    <tr class="border-b border-slate-200 ">
                        <td class="px-4 py-3 text-sm font-normal  ">
                            {{ $dataRuangan->id_tipe_room }}
                        </td>
                        <td class="px-4 py-3 text-sm font-normal">
                            {{ $dataRuangan->nama_tipe_room }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="p-2 text-slate-900 hover:text-blue-500"
                                @click="EditTipeRuangan = true; selectedTipeRuangan = {
                                        id_tipe: '{{ $dataRuangan->id_tipe_room }}',
                                        nama_tipe: '{{ $dataRuangan->nama_tipe_room }}',
                                    }">
                                <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                            </button>
                            <button class="p-2 text-slate-900 hover:text-red-500"
                                @click="DeleteTipeRuangan = true; selectedTipeRuangan = {
                                        id_tipe: '{{ $dataRuangan->id_tipe_room }}',
                                }">
                                <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ====================================== show ============================================================= --}}

    {{-- shwo add tipe ruangan --}}
    <div x-show="AddTipeRuangan"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50" x-transition
        x-cloak>
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
                        <input type="text" class="hidden" name="id_tipe" x-model="selectedTipeRuangan.id_tipe">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Hapus tipe</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
