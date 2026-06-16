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

{{-- isi kontent --}}
<div x-data="{ AddTipeRuangan: false, EditTipeRuangan: false, selectedTipeRuangan: {}, DeleteTipeRuangan: false }">
    {{-- button tipe ruangan --}}
    <div class="flex flex-col md:flex-row md:items-center justify-end gap-6 mb-8">
        <button @click="AddTipeRuangan = true"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-500 hover:bg-blue-700 text-white font-semibold rounded-lg! transition-all shadow-sm">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah Prodi</span>
        </button>
    </div>

    {{-- data tipe ruangan --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700 w-20">No</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Nama prodi</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($prodi as $dataprodi)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5 text-sm text-slate-500 font-medium">{{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-slate-900">{{ $dataprodi->nama_prodi }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-3">
                                    {{-- <button
                                        class="w-9 h-9 flex items-center justify-center text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button> --}}
                                    <form action="{{ route('hps-prodi', ['id' => $dataprodi->id_prodi]) }}" method="post">
                                        @csrf
                                        <button
                                            class="w-9 h-9 flex items-center justify-center text-rose-500 hover:bg-rose-50 rounded-lg transition-colors"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fa-solid fa-graduation-cap text-4xl text-slate-300"></i>
                                    <p class="text-sm font-medium text-slate-500">
                                        Belum ada data program studi
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
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
        </div> --}}
    </div>

    {{-- shwo add tipe ruangan --}}
    <div x-show="AddTipeRuangan"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50" x-transition
        x-cloak>
        <div @click.outside="AddTipeRuangan = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="AddTipeRuangan = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">tambah program studi</h2>

            <form method="POST" action="{{ route('tambah-prodi') }}">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama_prodi" placeholder=" " required>
                            <label class="form-label">Nama Prodi</label>
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

    {{-- show edit tipe ruangan
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
    </div> --}}

</div>
