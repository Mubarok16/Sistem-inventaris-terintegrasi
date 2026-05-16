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

<main class="flex-1 min-w-0 overflow-auto bg-slate-50/50 mb-5">

    <div class="mt-3  mx-auto">
        @if ($dataUser != null)
            {{-- edit admin dan pimpinan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg border border-blue-200">
                        <i class="fa-solid fa-user text-sky-400 text-[20px]"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            {{ $dataUser->nama }}
                        </h3>
                        <p class="text-sm text-slate-500 font-medium">Informasi Profil Pengguna</p>
                    </div>
                </div>
                <form class="p-8 space-y-6" method="POST"
                    action="{{ route('edit-akun-users', ['id' => $dataUser->id_user]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Nama
                                Lengkap</label>
                            <input name="nama"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                placeholder="Masukkan nama lengkap" type="text" value="{{ $dataUser->nama }}" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Username
                            </label>
                            <input name="username"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" value="{{ $dataUser->username }}" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Password
                            </label>
                            <input name="password"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                placeholder="kosongkan jika tidak ingin mengubah password!" type="password" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Peran (Role)
                            </label>
                            <input name="role" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                value="{{ $dataUser->hak_akses }}" type="text" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Nomor Hp
                            </label>
                            <input name="no_hp"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                value="{{ $dataUser->no_hp }}" type="text" />
                        </div>
                        @if ($dataUser->hak_akses === 'admin' && $JmlhAdmin > 1)
                            <div class="space-y-3 md:col-span-2 pt-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status
                                    Akun</label>
                                <div class="flex flex-col md:flex-row gap-2">
                                    <label class="flex-1 cursor-pointer">
                                        <input {{ $dataUser->status === 'active' ? 'checked="active"' : '' }}
                                            class="peer hidden" name="status" type="radio" value="active" />
                                        <div
                                            class="p-2 border-2 border-slate-100 rounded-xl flex items-center gap-3 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                                            <i class="fa-solid fa-circle-check text-emerald-500 text-[20px]"></i>
                                            <div>
                                                <span class="text-sm font-bold text-slate-900">Aktif</span>
                                                <span class="text-[10px] text-slate-500 font-medium block">Dapat
                                                    mengakses
                                                    sistem</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input {{ $dataUser->status === 'unactive' ? 'checked="uncative"' : '' }}
                                            class="peer hidden" name="status" type="radio" value="unactive" />
                                        <div
                                            class="p-2 border-2 border-slate-100 rounded-xl flex items-center gap-3 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                            <i
                                                class="fa-solid fa-ban text-slate-400 peer-checked:text-red-500 transition-colors"></i>
                                            <div>
                                                <span class="text-sm font-bold text-slate-900">Nonaktif</span>
                                                <span class="text-[10px] text-slate-500 font-medium block">Akses
                                                    diblokir
                                                    sementara</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="pt-8 w-full! gap-3 border-t border-slate-100">
                        <button type="submit"
                            class="w-full! flex-col item-center px-3 py-3 bg-blue-500 hover:bg-blue-700 text-white rounded-xl! font-bold text-sm shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"
                            type="submit">
                            <div>
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan Perubahan
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        @else
            {{-- edit peminjam atau mahasiswa --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg border border-blue-200">
                        <i class="fa-solid fa-user text-sky-400 text-[20px]"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            {{ $dataPeminjam->nama_peminjam }}
                        </h3>
                        <p class="text-sm text-slate-500 font-medium">Informasi Profil Pengguna</p>
                    </div>
                </div>
                <form class="p-8 space-y-6" method="POST"
                    action="{{ route('edit-akun-mhs-peminjam', ['id' => $dataPeminjam->no_identitas]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Nama
                                Lengkap</label>
                            <input name="nama_peminjam"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                placeholder="Masukkan nama lengkap" type="text"
                                value="{{ $dataPeminjam->nama_peminjam }}" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Username
                            </label>
                            <input name="username"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" value="{{ $dataPeminjam->username }}" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Password
                            </label>
                            <input name="password"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                placeholder="kosongkan jika tidak ingin mengubah password!" type="password" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Peran (Role)
                            </label>
                            <input name="role" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                value="mahasiswa" type="text" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Program
                                Studi</label>
                            <input name="prodi" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                value="{{ $dataPeminjam->prodi }}" type="text" />

                            {{-- <select name="prodi" id="prodi" required readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-semibold transition-all text-slate-700">

                                <option value="">pilih prodi</option>
                                <optgroup label="TEKNIK">
                                    <option value="teknik sipil"
                                        {{ $dataPeminjam->prodi === 'teknik sipil' ? 'selected' : '' }}>Teknik Sipil
                                    </option>
                                    <option value="teknik komputer"
                                        {{ $dataPeminjam->prodi === 'teknik komputer' ? 'selected' : '' }}>Teknik
                                        Komputer
                                    </option>
                                </optgroup>
                                <optgroup label="HUKUM">
                                    <option value="ilmu hukum"
                                        {{ $dataPeminjam->prodi === 'ilmu hukum' ? 'selected' : '' }}>Ilmu Hukum
                                    </option>
                                </optgroup>
                                <optgroup label="KEGURUAN DAN ILMU PENDIDIKAN">
                                    <option value="pendidikan bahasa inggris"
                                        {{ $dataPeminjam->prodi === 'pendidikan bahasa inggris' ? 'selected' : '' }}>
                                        Pendidikan Bahasa Inggris
                                    </option>
                                    <option
                                        value="pendidikan bahasa indonesia {{ $dataPeminjam->prodi === 'pendidikan bahasa indonesia' ? 'selected' : '' }}">
                                        Pendidikan Bahasa
                                        Indonesia</option>
                                    <option value="pendidikan matematika"
                                        {{ $dataPeminjam->prodi === 'pendidikan matematika' ? 'selected' : '' }}>
                                        Pendidikan Matematika</option>
                                    <option value="pendidikan biologi"
                                        {{ $dataPeminjam->prodi === 'pendidikan biologi' ? 'selected' : '' }}>
                                        Pendidikan
                                        Biologi</option>
                                </optgroup>
                                <optgroup label="ILMU SOSIAL DAN ILMU POLITIK">
                                    <option value="ilmu politik"
                                        {{ $dataPeminjam->prodi === 'ilmu politik' ? 'selected' : '' }}>Ilmu Politik
                                    </option>
                                </optgroup>
                                <optgroup label="EKONOMI">
                                    <option value="manajemen"
                                        {{ $dataPeminjam->prodi === 'manajemen' ? 'selected' : '' }}>Manajemen</option>
                                </optgroup>
                                <optgroup label="AGAMA ISLAM">
                                    <option value="pendidikan agama islam"
                                        {{ $dataPeminjam->prodi === 'pendidikan agama islam' ? 'selected' : '' }}>
                                        pendidikan agama islam
                                    </option>
                                    <option value="perbankan syariah"
                                        {{ $dataPeminjam->prodi === 'perbankan syariah' ? 'selected' : '' }}>perbankan
                                        syariah</option>
                                    <option value="bimbingan konseling islam"
                                        {{ $dataPeminjam->prodi === 'bimbingan konseling islam' ? 'selected' : '' }}>
                                        bimbingan konseling islam
                                    </option>
                                </optgroup>
                                <optgroup label="PERTANIAN">
                                    <option value="agribisnis"
                                        {{ $dataPeminjam->prodi === 'agribisnis' ? 'selected' : '' }}>agribisnis
                                    </option>
                                    <option value="agroteknologi"
                                        {{ $dataPeminjam->prodi === 'agroteknologi' ? 'selected' : '' }}>agroteknologi
                                    </option>
                                </optgroup>
                                <optgroup label="KESEHATAN MASYARAKAT">
                                    <option value="kesehatan masyarakat"
                                        {{ $dataPeminjam->prodi === 'kesehatan masyarakat' ? 'selected' : '' }}>
                                        Kesehatan
                                        Masyarakat</option>
                                </optgroup>
                            </select> --}}
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Foto Identitas
                            </label>
                            <input name="img_identitas"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                value="sdasd" type="file" />
                            <span class="text-red-600 text-xs">
                                kosongkan jika tidak ingin mengubah gambar!
                            </span>
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                tahun masuk
                            </label>
                            <input name="tahun_masuk" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" value="{{ $dataPeminjam->tahun_masuk }}" />
                        </div>
                        <div class="space-y-3 md:col-span-2 pt-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status
                                Akun</label>

                            <input name="status" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" value="{{ $dataPeminjam->status }}" />

                            {{-- <div class="flex flex-col md:flex-row gap-2">
                                <label class="flex-1 cursor-pointer">
                                    <input {{ $dataPeminjam->status === 'active' ? 'checked="active"' : '' }} readonly
                                        class="peer hidden" name="status" type="radio" value="active" />
                                    <div
                                        class="p-2 border-2 border-slate-100 rounded-xl flex items-center gap-3 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                                        <i class="fa-solid fa-circle-check text-emerald-500 text-[20px]"></i>
                                        <div>
                                            <span class="text-sm font-bold text-slate-900">Aktif</span>
                                            <span class="text-[10px] text-slate-500 font-medium block">Dapat mengakses
                                                sistem</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input {{ $dataPeminjam->status === 'unactive' ? 'checked="uncative"' : '' }}
                                        readonly class="peer hidden" name="status" type="radio"
                                        value="unactive" />
                                    <div
                                        class="p-2 border-2 border-slate-100 rounded-xl flex items-center gap-3 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                        <i
                                            class="fa-solid fa-ban text-slate-400 peer-checked:text-red-500 transition-colors"></i>
                                        <div>
                                            <span class="text-sm font-bold text-slate-900">Nonaktif</span>
                                            <span class="text-[10px] text-slate-500 font-medium block">Akses diblokir
                                                sementara</span>
                                        </div>
                                    </div>
                                </label>
                            </div> --}}
                        </div>
                    </div>
                    <div class="pt-8 w-full! gap-3 border-t border-slate-100">
                        <button type="submit"
                            class="w-full! flex-col item-center px-3 py-3 bg-blue-500 hover:bg-blue-700 text-white rounded-xl! font-bold text-sm shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"
                            type="submit">
                            <div>
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan Perubahan
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</main>
