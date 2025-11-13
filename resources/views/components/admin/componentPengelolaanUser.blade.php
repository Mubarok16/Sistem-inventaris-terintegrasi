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
                <thead>
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
                                <button
                                    @click="EditAkunStaff = true; selectedUser = {
                                        id: '{{ $akunUser->id_user }}',
                                        nama: '{{ $akunUser->nama }}',
                                        username: '{{ $akunUser->username }}',
                                        hak_akses: '{{ $akunUser->hak_akses }}',
                                    }"
                                    class="p-2 text-slate-900 hover:text-blue-500">
                                    <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
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
                </tbody>
            </table>
        </div>
    </section>

    <!-- show tambah akun -->
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

    {{-- show edit akun --}}
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
                        <label for="foto" class="form-label text-sm text-red-500">kosongkan jika tidak mengganti password!</label>
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
    <div x-show="DeleteAkunStaff"
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
                                    <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
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

                </tbody>
            </table>
        </div>
    </section>

    {{-- showw tambah akun peminjam --}}
    <div x-show="AddAkunPeminjam"
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
                            <input type="file" name="img_identitas" class="form-control"
                                accept="image/*" capture="environment" required>
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
    <div x-show="EditAkunPeminjam"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="EditAkunPeminjam = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="EditAkunPeminjam = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h4 class="text-xl font-semibold mb-4 text-center text-gray-700">Edit Akun Peminjam</h4>

            <form method="POST" :action="'/admin/edit-akun-peminjam/'+selectedPeminjam.no_identitas" enctype="multipart/form-data">
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
                        <label for="foto" class="form-label text-sm text-red-500">kosongkan jika tidak mengganti password!</label>
                    </div>
                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-building-columns"></i>
                            </span>
                            <select name="prodi" id="prodi" class="form-select" x-model="selectedPeminjam.prodi" required>
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
    <div x-show="DeleteAkunPeminjam"
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
                        <input type="text" class="hidden" name="no_identitas" x-model="selectedPeminjam.no_identitas">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Hapus Akun</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- show image identitas --}}
    <div x-show="OpenImgIdentitas"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition>
        <div @click.outside="OpenImgIdentitas = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-lg relative">

            <button @click="OpenImgIdentitas = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;
            </button>

            <h5 class="text-xl font-semibold mb-4 text-center text-gray-700">Yakin Ingin Menghapus Akun?</h5>

            
            {{-- {{ $akunPeminjam->img_identitas }} --}}
            {{-- <form method="POST" :action="'/admin/hapus-akun-peminjam/' + selectedPeminjam.no_identitas">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                        <input type="text" class="hidden" name="no_identitas" x-model="selectedPeminjam.no_identitas">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">Hapus Akun</button>
                        </div>
                    </div>
                </div>
            </form> --}}
            <div class="flex items-center justify-center">
                <img :src="`/storage/${selectedPeminjam.img}`" alt="Foto Peminjam" style="max-width: 500px;">

            </div>
        </div>
    </div>
</div>
