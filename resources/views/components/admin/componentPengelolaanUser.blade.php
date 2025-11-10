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

<div x-data="{ AddAkunStaff: false, EditAkunStaff: false, selectedUser: {} }" class="">
    <!-- Section 1: Pengelolaan Pegawai -->
    <section class="bg-white dark:bg-background-dark rounded-xl shadow-sm p-6 mb-8">
        <h5 class=" dark:text-white text-xl font-bold leading-tight tracking-tight">Data Akun
            staff dan pimpinan fakultas</h5>
        <!-- Toolbar for Pegawai -->
        <div class="flex flex-col md:flex-row justify-between gap-4 py-4">
            <div class="relative w-full md:w-72">
                <i
                    class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input
                    class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                    placeholder="Search" type="text" />
            </div>
            <button @click="AddAkunStaff = true" class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
                <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
                <span>Add Akun</span>
            </button>
        </div>
        <!-- Table for Pegawai -->
        <div class="max-h-70 overflow-y-auto overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="px-4 py-3 text-sm font-medium ">
                            Nama
                        </th>
                        <th class="px-4 py-3 text-sm font-medium ">
                            Username</th>
                        <th class="px-4 py-3 text-sm font-medium ">
                            Password</th>
                        <th class="px-4 py-3 text-sm font-medium ">
                            Hak-Akses</th>
                        <th class="px-4 py-3 text-sm font-medium  text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($AkunUsers as $akunUser)
                        <tr class="border-b border-slate-200 dark:border-slate-800">
                            <td class="px-4 py-3 text-sm font-normal text-slate-500 ">
                                {{ $akunUser->nama }}
                            </td>
                            <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                {{ $akunUser->username }}
                            </td>
                            <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                                {{ substr($akunUser->password, 0, 20) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-normal">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $akunUser->hak_akses }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button @click="EditAkunStaff = true; selectedUser = {
                                        id: '{{ $akunUser->id_user }}',
                                        nama: '{{ $akunUser->nama }}',
                                        username: '{{ $akunUser->username }}',
                                        hak_akses: '{{ $akunUser->hak_akses }}',
                                    }" class="p-2 text-slate-900 hover:text-blue-500">
                                    <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                                </button>
                                <button class="p-2 text-slate-900 hover:text-red-500">
                                    <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Overlay + Form -->
    <div x-show="AddAkunStaff"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="AddAkunStaff = false" class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="AddAkunStaff = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-xl font-semibold mb-4 text-center text-gray-700">Add Akun Staff</h2>

            <form method="POST" action="{{ route('addAkunAdmin') }}">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder=" "
                                required>
                            <label class="form-label">nama</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username" id="username" placeholder=" "
                                required>
                            <label class="form-label">username</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" name="password" id="password" value=""
                                placeholder=" " required>
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

    {{-- div edit akun staff --}}
    <div x-show="EditAkunStaff"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="EditAkunStaff = false" class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="EditAkunStaff = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-xl font-semibold mb-4 text-center text-gray-700">Edit Akun Staff</h2>

            <form method="POST" :action="'/edit-akun/' + selectedUser.id">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="nama" id="nama" x-model="selectedUser.nama"
                                required>
                            <label class="form-label">nama</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="username" id="username" x-model="selectedUser.username" maxlength="12" required>
                            <label class="form-label">username</label>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" name="password" id="password" value=""
                                placeholder=" " maxlength="12" required>
                            <label for="password" class="form-label">password</label>
                        </div>
                    </div>

                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <input type="text" class="form-control" name="hak_akses" id="hak_akses" x-model="selectedUser.hak_akses" required readonly>
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
</div>



<!-- Section 2: Pengelolaan Peminjam -->
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
        <button
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Akun</span>
        </button>
    </div>
    <!-- Table for Peminjam -->
    <div class="max-h-70 overflow-y-auto overflow-x-auto">
        <table class="w-full text-left">
            <thead class="">
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
                @foreach ($AkunPeminjams as $akunPeminjam)
                    <tr class="border-b border-slate-200 dark:border-slate-800">
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
                        </td>
                        <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                            {{ $akunPeminjam->fakultas }}
                        </td>
                        <td class="px-4 py-3 text-sm font-normal text-slate-500 dark:text-slate-400">
                            {{ $akunPeminjam->prodi }}
                        </td>
                        <td class="px-4 py-3 text-sm font-normal text-primary hover:underline cursor-pointer">
                            <a href="{{ asset('storage/' . $akunPeminjam->img_identitas) }}"
                                target="_blank">lihat</a>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="p-2 text-slate-900 hover:text-blue-500">
                                <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                            </button>
                            <button class="p-2 text-slate-900 hover:text-red-500">
                                <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</section>
