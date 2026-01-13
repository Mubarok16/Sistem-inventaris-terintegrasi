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
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $jmlhPenggunaAll }}</span>
                    <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded text-xs font-bold flex items-center">
                        <span class="material-icons text-sm mr-1">Active</span>
                    </span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mahasiswa</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-primary tracking-tight">{{ $jmlhMhs }}</span>
                     <span
                        class="text-emerald-600 text-[10px] font-bold uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded">Active
                    </span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mahasiswa</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $jmlhMhsTA }}</span>
                    <span
                        class="text-red-500 text-[10px] font-bold uppercase tracking-widest bg-red-100 px-2 py-1 rounded">None
                        Active</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-shadow hover:shadow-md">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Staff Administrasi</p>
                <div class="flex items-end justify-between mt-3">
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $JmlhAdmin }}</span>
                    <span
                        class="text-emerald-600 text-[10px] font-bold uppercase tracking-widest bg-emerald-50 px-2 py-1 rounded">Active</span>
                </div>
            </div>
        </div>
        <div
            class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="flex flex-1 flex-wrap items-center gap-4">
                <form action="{{ route('filter-role-user') }}" method="GET">
                    @csrf
                    <select onchange="this.form.submit()" name="role"
                        class="bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700">
                        <option {{ $role === 'all' ? 'selected':'' }} value="all">Semua Peran</option>
                        <option {{ $role === 'mahasiswa' ? 'selected':'' }} value="mahasiswa">Mahasiswa</option>
                        <option {{ $role === 'pimpinan' ? 'selected':'' }} value="pimpinan">Pimpinan</option>
                        <option {{ $role === 'kaprodi' ? 'selected':'' }} value="kaprodi">Kaprodi</option>
                        <option {{ $role === 'staff' ? 'selected':'' }} value="staff">Staff</option>
                    </select>
                </form>
                <form action="{{ route('filter-status-user') }}" method="GET">
                    @csrf
                    <select onchange="this.form.submit()" name="status"
                        class="bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all text-slate-700">
                        <option {{ $status === 'active' ? 'selected':'' }} value="active">Aktif</option>
                        <option {{ $status === 'unactive' ? 'selected':'' }} value="unactive">Nonaktif</option>
                    </select>
                </form>

            </div>
            <form action="{{ route('page-buat-akun-by-admin') }}" method="get">
                <button
                    class="bg-primary hover:bg-blue-700 text-white px-6 border-0 py-2.5 rounded-md! font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
                    <i class="fas fa-user-plus text-lg"></i>
                    Tambah Pengguna
                </button>
            </form>
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
                                        <form action="{{ route('page-edit-akun', ['id' => $akunUser->id_user]) }}"
                                            method="get">
                                            @csrf
                                            <button
                                                class="p-2 text-slate-400 hover:text-primary hover:bg-blue-50 rounded-lg transition-all"
                                                title="Edit Detail">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </form>
                                        @if ($akunUser->hak_akses === 'admin')
                                            @if ($JmlhAdmin > 1)
                                                <form
                                                    action="{{ route('hapus-akun-users', ['id' => $akunUser->id_user]) }}"
                                                    method="post">
                                                    @csrf

                                                    <button type="submit"
                                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                                        title="hapus">
                                                        <i class="fa-solid fa-trash text-red-500"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
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
                                        {{-- <button
                                            class="p-2 text-slate-400 hover:text-primary hover:bg-red-50 rounded-lg transition-all"
                                            title="Nonaktifkan">
                                            <i class="fa-solid fa-ban text-gray-600"></i>
                                        </button> --}}

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
