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
        <button
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Akun</span>
        </button>
    </div>
    <!-- Table for Pegawai -->
    <div class="max-h-70 overflow-y-auto overflow-x-auto">
        <table class="w-full text-left border border-b-gray-500">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700">
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Nama
                    </th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Username</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Password</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Hak-Akses</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 text-right">
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
                            <button class="p-2 text-slate-500 hover:text-primary dark:hover:text-primary-300">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </button>
                            <button class="p-2 text-slate-500 hover:text-red-500">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
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
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700">
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">No.
                        Identitas</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">Nama
                        Peminjam</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Username</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Password</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                        Fakultas</th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">Prodi
                    </th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">ID
                    </th>
                    <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 text-right">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
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
                            <a href="{{ asset('storage/' .$akunPeminjam->img_identitas) }}" target="_blank">lihat</a>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="p-2 text-slate-500 hover:text-primary dark:hover:text-primary-300"><span
                                    class="material-symbols-outlined text-sm">edit</span></button>
                            <button class="p-2 text-slate-500 hover:text-red-500"><span
                                    class="material-symbols-outlined text-sm">delete</span></button>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</section>
