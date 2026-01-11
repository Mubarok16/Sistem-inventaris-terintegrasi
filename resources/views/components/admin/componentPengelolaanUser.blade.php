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


<main class="flex-1 min-w-0 overflow-auto bg-slate-50/50" x-data="{ OpenImgIdentitas: false, selectedPeminjam: {} }">
    <div class="py-8 px-2 max-w-7xl mx-auto space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pengguna</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">1,284</span>
                    <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded text-xs font-bold flex items-center">
                        <span class="material-icons text-sm mr-1">trending_up</span>+12%
                    </span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mahasiswa</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-primary tracking-tight">942</span>
                    <span
                        class="text-slate-500 text-[10px] font-bold uppercase tracking-widest bg-slate-100 px-2 py-1 rounded">Aktif</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Dosen</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">156</span>
                    <span
                        class="text-slate-500 text-[10px] font-bold uppercase tracking-widest bg-slate-100 px-2 py-1 rounded">Terverifikasi</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Staff Administrasi</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">186</span>
                    <span
                        class="text-emerald-600 text-[10px] font-bold uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded">Online</span>
                </div>
            </div>
        </div>
        <div
            class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="flex flex-1 flex-wrap items-center gap-4">

                <select
                    class="bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700">
                    <option>Semua Peran</option>
                    <option>Mahasiswa</option>
                    <option>Dosen</option>
                    <option>Staff</option>
                </select>
                <select
                    class="bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700">
                    <option>Status: Semua</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
            <button
                class="bg-primary hover:bg-blue-700 text-white px-6 border-0 py-2.5 rounded-md! font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
                <i class="fas fa-user-plus text-lg"></i>
                Tambah Pengguna
            </button>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200">
                            <th class="px-6 py-4 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">
                                Nama Lengkap</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">
                                Foto Identias</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">
                                Peran</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">
                                Departemen</th>
                            <th class="px-6 py-4 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">
                                Status</th>
                            <th
                                class="px-6 py-4 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @if ($AkunUsers->IsEmpty() || $AkunPeminjams->IsEmpty())
                        @endif
                        {{-- pimpinan dan staff --}}
                        @foreach ($AkunUsers as $akunUser)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[13px] border border-blue-200">
                                            <i class="fa-solid fa-user text-sky-400 text-[20px]"></i>
                                        </div>
                                        <span class="font-bold text-slate-800 text-sm">{{ $akunUser->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    -
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($akunUser->hak_akses === 'kaprodi')
                                        <span
                                            class="px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wide">
                                            {{ $akunUser->hak_akses }}
                                        </span>
                                    @elseif ($akunUser->hak_akses === 'pimpinan')
                                        <span
                                            class="px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wide">
                                            {{ $akunUser->hak_akses }}
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full text-[11px] font-bold bg-green-50 text-green-600 border border-green-100 uppercase tracking-wide">
                                            {{ $akunUser->hak_akses }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">
                                    Fakultas Teknik
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($akunUser->status === 'active')
                                        <span class="flex items-center gap-1.5 text-[12px] font-bold text-emerald-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5 text-[12px] font-bold text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                            None Active
                                        </span>
                                    @endif

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-1">
                                        <form
                                            action="{{ route('page-edit-akun', ['id' => $akunUser->id_user]) }}"
                                            method="get">
                                            @csrf
                                            <button
                                                class="p-2 text-slate-400 hover:text-primary hover:bg-blue-50 rounded-lg transition-all"
                                                title="Edit Detail">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </form>
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-red-50 rounded-lg transition-all"
                                            title="Nonaktifkan">
                                            <i class="fa-solid fa-ban text-gray-600"></i>
                                        </button>
                                        <button
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                            title="hapus">
                                            <i class="fa-solid fa-trash text-red-500"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        {{-- mahasiswa --}}
                        @foreach ($AkunPeminjams as $akunPeminjam)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[13px] border border-blue-200">
                                            <i class="fa-solid fa-user text-sky-400 text-[20px]"></i>

                                        </div>
                                        <span
                                            class="font-bold text-slate-800 text-sm">{{ $akunPeminjam->nama_peminjam }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    <button class="p-2 text-slate-900 hover:text-blue-500"
                                        @click="OpenImgIdentitas = true; selectedPeminjam = {
                                        no_identitas: '{{ $akunPeminjam->no_identitas }}',
                                        img: '{{ $akunPeminjam->img_identitas }}',
                                    }">
                                        <span class="material-symbols-outlined text-sm fa-solid fa-image"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-600 border border-purple-100 uppercase tracking-wide">Mahasiswa
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700 capitalize">
                                    {{ $akunPeminjam->prodi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($akunPeminjam->status === 'active')
                                        <span class="flex items-center gap-1.5 text-[12px] font-bold text-emerald-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5 text-[12px] font-bold text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                            None Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-1">

                                        <form
                                            action="{{ route('page-edit-akun', ['id' => $akunPeminjam->no_identitas]) }}"
                                            method="get">
                                            @csrf
                                            <button
                                                class="p-2 text-slate-400 hover:text-primary hover:bg-blue-50 rounded-lg transition-all"
                                                title="Edit Detail">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </form>
                                        <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-red-50 rounded-lg transition-all"
                                            title="Nonaktifkan">
                                            <i class="fa-solid fa-ban text-gray-600"></i>
                                        </button>

                                        <form action="{{ route('hapus-akun-mhs') }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                                title="hapus"
                                                onclick="return confirm('Menghapus akun akan menghapus semua item terkait seperti riwayat peminjaman yang akun ini anda yakin?')">
                                                <i class="fa-solid fa-trash text-red-500"></i>
                                                <input type="text" class="hidden" name="no_identitas"
                                                    value="{{ $akunPeminjam->no_identitas }}">
                                            </button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Menampilkan <span class="text-slate-900 font-bold">1 -
                        5</span> dari <span class="text-slate-900 font-bold">1,284</span> pengguna</p>
                <div class="flex items-center gap-2">
                    <button
                        class="p-2 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 hover:border-slate-300 disabled:opacity-40 transition-colors"
                        disabled="">
                        <span class="material-icons text-[20px]">chevron_left</span>
                    </button>
                    <button
                        class="w-10 h-10 rounded-lg bg-primary text-white font-bold text-sm shadow-md shadow-primary/20 transition-all">1</button>
                    <button
                        class="w-10 h-10 rounded-lg bg-white border border-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:border-slate-200 transition-colors">2</button>
                    <button
                        class="w-10 h-10 rounded-lg bg-white border border-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:border-slate-200 transition-colors">3</button>
                    <span class="px-2 text-slate-300 font-bold tracking-widest">...</span>
                    <button
                        class="w-10 h-10 rounded-lg bg-white border border-slate-100 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:border-slate-200 transition-colors">257</button>
                    <button
                        class="p-2 bg-white border border-slate-200 rounded-lg text-slate-400 hover:text-slate-600 hover:border-slate-300 transition-colors">
                        <span class="material-icons text-[20px]">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
        <div
            class="bg-blue-50/50 border border-blue-100 p-5 rounded-2xl flex gap-4 items-start shadow-sm shadow-blue-900/5">
            <div class="bg-blue-100 p-2 rounded-lg">
                <span class="material-icons text-blue-600">info</span>
            </div>
            <div class="text-sm text-blue-900/80">
                <p class="font-bold text-blue-900">Tips Admin</p>
                <p class="mt-1 leading-relaxed font-medium">Anda dapat mengatur ulang kata sandi pengguna
                    secara massal dengan memilih beberapa kotak centang di sebelah nama pengguna (fitur ini
                    sedang dalam pengembangan). Hubungi dukungan IT jika Anda membutuhkan bantuan lebih lanjut.
                </p>
            </div>
        </div>
    </div>

    {{-- show image identitas --}}
    <div x-show="OpenImgIdentitas" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-opacity-10 backdrop-blur-sm z-50" x-transition>

        <div class="flex justify-center rounded-2xl w-full max-w-xl relative"
            @click.outside="OpenImgIdentitas = false">
            <img :src="`/storage/${selectedPeminjam.img}`" alt="Foto Peminjam" class="container">
        </div>
    </div>
</main>


<!-- Pengelolaan User pegawai (admin dan pimpinan) -->
<div x-data="{ AddAkunStaff: false, EditAkunStaff: false, selectedUser: {}, DeleteAkunStaff: false }" class="">
    <!-- Section 1: Pengelolaan Pegawai -->
    <section class="bg-white dark:bg-background-dark rounded-xl shadow-sm p-6 mb-8">
        <h5 class=" dark:text-white text-xl font-bold leading-tight tracking-tight">Data Akun
            staff dan pimpinan fakultas</h5>
        <!-- Toolbar Pegawai -->
        <div class="flex flex-col md:flex-row justify-between gap-4 py-4">
            <div class="relative w-full md:w-72">
                <i
                    class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                    placeholder="Search" type="text" />
            </div>
            <button @click="AddAkunStaff = true"
                class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
                <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
                <span>Add Akun</span>
            </button>
        </div>
        <!-- Table Pegawai -->
        <div class="max-h-70 overflow-y-auto overflow-x-auto">
            <table class="w-full text-left">
                <thead class="sticky top-0 z-1">
                    <tr class="bg-primary text-white ">
                        <th class="px-4 py-3 text-sm font-medium ">
                            Nama
                        </th>
                        <th class="px-4 py-3 text-sm font-medium ">
                            Username</th>
                        <th class="px-4 py-3 text-sm font-medium ">
                            Password</th>
                        <th class="px-4 py-3 text-sm font-medium ">
                            Hak-Akses</th>
                        <th class="px-4 py-3 text-sm font-medium  text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($AkunUsers->isEmpty())
                        <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                            <td class="px-4 py-3 text-sm font-normal text-center" colspan="3">
                                <span class="text-red-600 font-semibold">Data kosong!</span>
                            </td>
                        </tr>
                    @else
                        @foreach ($AkunUsers as $akunUser)
                            <tr class="border-b border-slate-200 dark:border-slate-800 odd:bg-gray-200 even:bg-white">
                                <td class="p-2 text-sm font-normal text-slate-500 ">
                                    {{ $akunUser->nama }}
                                </td>
                                <td class="p-2 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ $akunUser->username }}
                                </td>
                                <td class="p-2 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ substr($akunUser->password, 0, 20) }}
                                </td>
                                <td class="p-2 text-sm font-normal">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $akunUser->hak_akses }}
                                    </span>
                                </td>
                                <td class="p-2 text-center">
                                    <button
                                        @click="EditAkunStaff = true; selectedUser = {
                                        id: '{{ $akunUser->id_user }}',
                                        nama: '{{ $akunUser->nama }}',
                                        username: '{{ $akunUser->username }}',
                                        hak_akses: '{{ $akunUser->hak_akses }}',
                                    }"
                                        class="p-2 text-slate-900 hover:text-blue-500">
                                        <span
                                            class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                                    </button>
                                    <button
                                        class="p-2 text-slate-900 hover:text-red-500 @if ($akunUser->hak_akses === 'pimpinan' or $akunUser->hak_akses === 'kaprodi' or $JmlhAdmin === 1) hidden @endif"
                                        @click="DeleteAkunStaff = true; selectedUser = {
                                        id: '{{ $akunUser->id_user }}',
                                    }">
                                        <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <!-- show tambah akun -->
    <div x-show="AddAkunStaff"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition x-cloak>
        <div @click.outside="AddAkunStaff = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="AddAkunStaff = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-xl font-semibold mb-4 text-center text-gray-700">Add Akun Staff</h2>

            <form method="POST" action="{{ route('addAkunAdmin') }}">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder=" " required>
                            <label class="form-label">nama</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder=" " required>
                            <label class="form-label">username</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" name="password" id="password"
                                value="" placeholder=" " required>
                            <label for="password" class="form-label">password</label>
                        </div>
                    </div>

                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <select name="hak_akses" id="hak_akses" class="form-select" required disabled>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Tambah Akun</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- show edit akun --}}
    <div x-show="EditAkunStaff" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="EditAkunStaff = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="EditAkunStaff = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-xl font-semibold mb-4 text-center text-gray-700">Edit Akun Staff</h2>

            <form method="POST" :action="'/edit-akun/' + selectedUser.id">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama" x-model="selectedUser.nama"
                                required>
                            <label class="form-label">nama</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username"
                                x-model="selectedUser.username" maxlength="12" required>
                            <label class="form-label">username</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" name="password" value=""
                                placeholder=" " maxlength="12">
                            <label for="password" class="form-label">password</label>
                        </div>
                        <label for="foto" class="form-label text-sm text-red-500">kosongkan jika tidak mengganti
                            password!</label>
                    </div>

                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <input type="text" class="form-control" name="hak_akses"
                                x-model="selectedUser.hak_akses" required readonly>
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

    {{-- show delet akun staff --}}
    <div x-show="DeleteAkunStaff" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="DeleteAkunStaff = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="DeleteAkunStaff = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;
            </button>

            <h5 class="text-xl font-semibold mb-4 text-center text-gray-700">Yakin Ingin Menghapus Akun?</h5>

            <form method="POST" :action="'/hapus-akun/' + selectedUser.id">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                        <input type="text" class="hidden" name="id_user" x-model="selectedUser.id">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Hapus Akun</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pengelolaan Peminjam -->
<div x-data="{ AddAkunPeminjam: false, EditAkunPeminjam: false, selectedPeminjam: {}, DeleteAkunPeminjam: false, OpenImgIdentitas: false }">
    <section class="bg-white dark:bg-background-dark rounded-xl shadow-sm p-6">
        <h5 class="text-slate-900 dark:text-white text-xl font-bold leading-tight tracking-tight">Data Akun
            Peminjam</h5>
        <!-- Toolbar for Peminjam -->
        <div class="flex flex-col md:flex-row justify-between gap-4 py-4">
            <div class="relative w-full md:w-72">
                <i
                    class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                    placeholder="Search" type="text" />
            </div>
            <div class="flex gap-2">
                <button
                    class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors"
                    @click="AddAkunPeminjamFile = true">
                    <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
                    <span>Add Akun file</span>
                </button>
                <button
                    class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors"
                    @click="AddAkunPeminjam = true">
                    <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
                    <span>Add Akun</span>
                </button>
            </div>
        </div>
        <!-- Table for Peminjam -->
        <div class="max-h-70 overflow-y-auto overflow-x-auto">
            <table class="w-full text-left">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-primary text-white">
                        <th class="px-4 py-3 text-sm font-medium">No.
                            Identitas</th>
                        <th class="px-4 py-3 text-sm font-medium">Nama
                            Peminjam</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Username</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Password</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Fakultas</th>
                        <th class="px-4 py-3 text-sm font-medium">Prodi
                        </th>
                        <th class="px-4 py-3 text-sm font-medium">foto identitas
                        </th>
                        <th class="px-4 py-3 text-sm font-medium text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if ($AkunPeminjams->isEmpty())
                        <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                            <td class="px-4 py-3 text-sm font-normal text-center" colspan="8">
                                <span class="text-gray-700 font-semibold">Data kosong!</span>
                            </td>
                        </tr>
                    @else
                        @foreach ($AkunPeminjams as $akunPeminjam)
                            <tr class="border-b border-slate-200 dark:border-slate-800 odd:bg-gray-200 even:bg-white">
                                <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ $akunPeminjam->no_identitas }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal text-slate-500">
                                    {{ $akunPeminjam->nama_peminjam }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ $akunPeminjam->username }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ substr($akunPeminjam->password, 0, 10) }}
                                    {{-- {{ Crypt::decrypt($akunPeminjam->password) }} --}}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ $akunPeminjam->fakultas }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                    {{ $akunPeminjam->prodi }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal text-primary hover:underline cursor-pointer">
                                    <button class="p-2 text-slate-900 hover:text-blue-500"
                                        @click="OpenImgIdentitas = true; selectedPeminjam = {
                                        no_identitas: '{{ $akunPeminjam->no_identitas }}',
                                        img: '{{ $akunPeminjam->img_identitas }}',
                                    }">
                                        <span class="material-symbols-outlined text-sm fa-solid fa-image"></span>
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button class="p-2 text-slate-900 hover:text-blue-500"
                                        @click="EditAkunPeminjam = true; selectedPeminjam = {
                                        no_identitas: '{{ $akunPeminjam->no_identitas }}',
                                        nama_peminjam: '{{ $akunPeminjam->nama_peminjam }}',
                                        username: '{{ $akunPeminjam->username }}',
                                        fakultas: '{{ $akunPeminjam->fakultas }}',
                                        prodi: '{{ $akunPeminjam->prodi }}',
                                    }">
                                        <span
                                            class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                                    </button>
                                    <button class="p-2 text-slate-900 hover:text-red-500"
                                        @click="DeleteAkunPeminjam = true; selectedPeminjam = {
                                        no_identitas: '{{ $akunPeminjam->no_identitas }}',
                                    }">
                                        <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    {{-- showw tambah akun peminjam --}}
    <div x-show="AddAkunPeminjam" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="AddAkunPeminjam = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="AddAkunPeminjam = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;
            </button>

            <h2 class="text-xl font-semibold mb-4 text-center text-gray-700">Add Akun Peminjam</h2>

            <form method="POST" action="{{ route('addAkunPeminjam') }}" enctype="multipart/form-data">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="no_identitas" id="no_identitas"
                                placeholder=" " required>
                            <label class="form-label">No Identitas (npm)</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama_peminjam" id="nama_peminjam"
                                placeholder=" " required>
                            <label class="form-label">nama</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder=" " required>
                            <label class="form-label">username</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" name="password" id="password"
                                value="" placeholder=" " required>
                            <label for="password" class="form-label">password</label>
                        </div>
                    </div>

                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-building-columns"></i>
                            </span>
                            <select name="prodi" id="prodi" class="form-select" required>
                                <option value="">--- Pilih Prodi ---</option>
                                <optgroup label="TEKNIK">
                                    <option value="teknik sipil">Teknik Sipil</option>
                                    <option value="teknik komputer">Teknik Komputer</option>
                                </optgroup>
                                <optgroup label="HUKUM">
                                    <option value="ilmu hukum">Ilmu Hukum</option>
                                </optgroup>
                                <optgroup label="KEGURUAN DAN ILMU PENDIDIKAN">
                                    <option value="pendidikan bahasa inggris">Pendidikan Bahasa Inggris
                                    </option>
                                    <option value="pendidikan bahasa indonesia">Pendidikan Bahasa
                                        Indonesia</option>
                                    <option value="pendidikan matematika">Pendidikan Matematika</option>
                                    <option value="pendidikan biologi">Pendidikan Biologi</option>
                                </optgroup>
                                <optgroup label="ILMU SOSIAL DAN ILMU POLITIK">
                                    <option value="ilmu politik">Ilmu Politik</option>
                                </optgroup>
                                <optgroup label="EKONOMI">
                                    <option value="manajemen">Manajemen</option>
                                </optgroup>
                                <optgroup label="AGAMA ISLAM">
                                    <option value="pendidikan agama islam">pendidikan agama islam
                                    </option>
                                    <option value="ekonomi syariah">ekonomi syariah</option>
                                    <option value="bimbingan konseling islam">bimbingan konseling islam
                                    </option>
                                </optgroup>
                                <optgroup label="PERTANIAN">
                                    <option value="agribisnis">agribisnis</option>
                                    <option value="agroteknologi">agribisnis</option>
                                </optgroup>
                                <optgroup label="KESEHATAN MASYARAKAT">
                                    <option value="kesehatan masyarakat">Kesehatan Masyarakat</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 m-0">
                        <div class="mb-2">
                            <label for="foto" class="form-label">Masukkan foto ktm</label>
                            <input type="file" name="img_identitas" class="form-control" accept="image/*"
                                capture="environment" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Daftar Akun</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- show edit akun peminjam --}}
    <div x-show="EditAkunPeminjam" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="EditAkunPeminjam = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="EditAkunPeminjam = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h4 class="text-xl font-semibold mb-4 text-center text-gray-700">Edit Akun Peminjam</h4>

            <form method="POST" :action="'/admin/edit-akun-peminjam/' + selectedPeminjam.no_identitas"
                enctype="multipart/form-data">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama_peminjam"
                                x-model="selectedPeminjam.nama_peminjam" required>
                            <label class="form-label">nama</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username"
                                x-model="selectedPeminjam.username" maxlength="12" required>
                            <label class="form-label">username</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" name="password" value=""
                                placeholder=" " maxlength="12">
                            <label for="password" class="form-label">password</label>
                        </div>
                        <label for="foto" class="form-label text-sm text-red-500">kosongkan jika tidak mengganti
                            password!</label>
                    </div>
                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-building-columns"></i>
                            </span>
                            <select name="prodi" id="prodi" class="form-select"
                                x-model="selectedPeminjam.prodi" required>
                                <option value="">pilih prodi</option>
                                <optgroup label="TEKNIK">
                                    <option value="teknik sipil">Teknik Sipil</option>
                                    <option value="teknik komputer">Teknik Komputer</option>
                                </optgroup>
                                <optgroup label="HUKUM">
                                    <option value="ilmu hukum">Ilmu Hukum</option>
                                </optgroup>
                                <optgroup label="KEGURUAN DAN ILMU PENDIDIKAN">
                                    <option value="pendidikan bahasa inggris">Pendidikan Bahasa Inggris
                                    </option>
                                    <option value="pendidikan bahasa indonesia">Pendidikan Bahasa
                                        Indonesia</option>
                                    <option value="pendidikan matematika">Pendidikan Matematika</option>
                                    <option value="pendidikan biologi">Pendidikan Biologi</option>
                                </optgroup>
                                <optgroup label="ILMU SOSIAL DAN ILMU POLITIK">
                                    <option value="ilmu politik">Ilmu Politik</option>
                                </optgroup>
                                <optgroup label="EKONOMI">
                                    <option value="manajemen">Manajemen</option>
                                </optgroup>
                                <optgroup label="AGAMA ISLAM">
                                    <option value="pendidikan agama islam">pendidikan agama islam
                                    </option>
                                    <option value="ekonomi syariah">ekonomi syariah</option>
                                    <option value="bimbingan konseling islam">bimbingan konseling islam
                                    </option>
                                </optgroup>
                                <optgroup label="PERTANIAN">
                                    <option value="agribisnis">agribisnis</option>
                                    <option value="agroteknologi">agribisnis</option>
                                </optgroup>
                                <optgroup label="KESEHATAN MASYARAKAT">
                                    <option value="kesehatan masyarakat">Kesehatan Masyarakat</option>
                                </optgroup>
                            </select>
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

    {{-- show delet akun peminjam --}}
    <div x-show="DeleteAkunPeminjam" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="DeleteAkunPeminjam = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="DeleteAkunPeminjam = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;
            </button>

            <h5 class="text-xl font-semibold mb-4 text-center text-gray-700">Yakin Ingin Menghapus Akun?</h5>

            <form method="POST" :action="'/admin/hapus-akun-peminjam/' + selectedPeminjam.no_identitas">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                        <input type="text" class="hidden" name="no_identitas"
                            x-model="selectedPeminjam.no_identitas">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Hapus Akun</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- show image identitas --}}
    <div x-show="OpenImgIdentitas" x-cloak
        class="fixed inset-0 flex items-center justify-center bg-opacity-10 backdrop-blur-sm z-50" x-transition>

        <div class="flex justify-center rounded-2xl w-full max-w-xl relative"
            @click.outside="OpenImgIdentitas = false">
            <img :src="`/storage/${selectedPeminjam.img}`" alt="Foto Peminjam" class="container">
        </div>
    </div>
</div>
