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

    <div x-data="{ tab: 'admin' }" class="ml-3 mt-6">

        <div class="mb-4 bg-white p-3 shadow-xs border-slate-200 border-1 rounded-xl">
            <button @click="tab = 'admin'"
                :class="tab === 'admin' ? 'bg-blue-500 text-white shadow-md' : 'bg-slate-200 text-slate-600'"
                class="px-6 py-2 rounded-xl! font-semibold text-sm transition-all">
                Staff (admin)
            </button>

            <button @click="tab = 'kprodi'"
                :class="tab === 'kprodi' ? 'bg-blue-500 text-white shadow-md' : 'bg-slate-200 text-slate-600'"
                class="px-6 py-2 rounded-xl! font-semibold text-sm transition-all">
                kaprodi
            </button>

            <button @click="tab = 'mhs'"
                :class="tab === 'mhs' ? 'bg-blue-500 text-white shadow-md' : 'bg-slate-200 text-slate-600'"
                class="px-6 py-2 rounded-xl! font-semibold text-sm transition-all">
                Mahasiswa
            </button>


        </div>

        {{-- kprodi --}}
        <div x-show="tab === 'kprodi'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">

            {{-- Form Admin dan Pimpinan Anda di sini --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form class="p-8 space-y-6" method="POST" action="{{ route('addAkunKaprodi') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Nidn
                            </label>
                            <input name="nip"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="number" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Nama
                                Lengkap</label>
                            <input name="nama"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Username
                            </label>
                            <input name="username"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Password
                            </label>
                            <input name="password"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="password" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Jabatan
                            </label>

                            <select name="jabatan"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($prodi as $data)
                                <option value="{{ $data->nama_prodi }}">Kaprodi {{ $data->nama_prodi }} </option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Peran (Role)
                            </label>
                            <input name="role" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" value="Kaprodi" />
                        </div>
                        {{-- <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                ID Telegram </label>
                            </label>
                            <input name="no_hp"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="number" />
                        </div> --}}

                        <div class="space-y-3 md:col-span-2 pt-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status
                                Akun</label>
                            <div class="flex flex-col md:flex-row gap-2">
                                <label class="flex-1 cursor-pointer">
                                    <input class="peer hidden" name="status" type="radio" value="active" />
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
                                    <input class="peer hidden" name="status" type="radio" value="unactive" />
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

                    </div>
                    <div class="pt-8 w-full! gap-3 border-t border-slate-100">
                        <button type="submit"
                            class="w-full! flex-col item-center px-3 py-3 bg-blue-500 hover:bg-blue-700 text-white rounded-xl! font-bold text-sm shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"
                            type="submit">
                            <div>
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- admin --}}
        <div x-show="tab === 'admin'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">

            {{-- Form Admin dan Pimpinan Anda di sini --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form class="p-8 space-y-6" method="POST" action="{{ route('addAkunAdmin') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Nip
                            </label>
                            <input name="nip"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="number" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Nama
                                Lengkap</label>
                            <input name="nama"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Username
                            </label>
                            <input name="username"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Password
                            </label>
                            <input name="password"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="password" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Peran (Role)
                            </label>
                            <input name="role" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" value="Admin" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                ID Telegram </label>
                            </label>
                            <input name="no_hp"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="number" />
                        </div>

                        <div class="space-y-3 md:col-span-2 pt-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status
                                Akun</label>
                            <div class="flex flex-col md:flex-row gap-2">
                                <label class="flex-1 cursor-pointer">
                                    <input class="peer hidden" name="status" type="radio" value="active" />
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
                                    <input class="peer hidden" name="status" type="radio" value="unactive" />
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

                    </div>
                    <div class="pt-8 w-full! gap-3 border-t border-slate-100">
                        <button type="submit"
                            class="w-full! flex-col item-center px-3 py-3 bg-blue-500 hover:bg-blue-700 text-white rounded-xl! font-bold text-sm shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"
                            type="submit">
                            <div>
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- mhs --}}
        <div x-show="tab === 'mhs'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">

            {{-- Form Peminjam Mahasiswa Anda di sini --}}

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form id="admin-student-registration-form" class="p-8 space-y-6" method="POST" action="{{ route('addAkunPeminjam') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Nomor Identitas</label>
                            <input id="admin_no_identitas" name="no_identitas" maxlength="12" minlength="12" inputmode="numeric" pattern="[0-9]{12}" autocomplete="off"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" required />
                            <p class="text-xs text-slate-500 mt-2">Masukkan NPM 12 digit. Program studi dan tahun masuk akan terisi otomatis.</p>
                            <div id="admin_npm_status" class="hidden mt-2 rounded-lg px-3 py-2 text-xs" role="status" aria-live="polite"></div>
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Nama
                                Lengkap</label>
                            <input name="nama_peminjam"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Username
                            </label>
                            <input name="username"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Password
                            </label>
                            <input name="password"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="password" />
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
                            <select name="prodi" id="admin_prodi" required disabled
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-semibold transition-all text-slate-700">
                                <option value="">Terisi otomatis dari NPM</option>
                                <option value="teknik sipil">Teknik Sipil</option>
                                <option value="kesehatan masyarakat">Kesehatan Masyarakat</option>
                                <option value="agribisnis">Agribisnis</option>
                                <option value="agroteknologi">Agroteknologi</option>
                                <option value="teknik komputer">Teknik Komputer</option>
                                <option value="manajemen">Manajemen</option>
                                <option value="perbankan syariah">Perbankan Syariah</option>
                                <option value="ilmu pemerintahan">Ilmu Pemerintahan</option>
                                <option value="bimbingan konseling islam">Bimbingan dan Konseling Islam (BKPI)</option>
                                <option value="ilmu hukum">Ilmu Hukum</option>
                                <option value="pendidikan matematika">Pendidikan Matematika</option>
                                <option value="pendidikan biologi">Pendidikan Biologi</option>
                                <option value="pendidikan agama islam">Pendidikan Agama Islam (PAI)</option>
                                <option value="pendidikan bahasa indonesia">Pendidikan Bahasa dan Sastra Indonesia (PBSI)</option>
                                <option value="pendidikan bahasa inggris">Pendidikan Bahasa Inggris</option>
                            </select>
                            <p class="text-xs text-slate-500 mt-2">Program studi mengikuti kode lima digit pertama NPM.</p>
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
                            <input id="admin_tahun_masuk" name="tahun_masuk" readonly placeholder="Otomatis dari NPM"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                                type="text" required />
                        </div>
                        <div class="space-y-3 md:col-span-2 pt-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status
                                Akun</label>
                            <div class="flex flex-col md:flex-row gap-2">
                                <label class="flex-1 cursor-pointer">
                                    <input class="peer hidden" name="status" type="radio" value="active" />
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
                                    <input class="peer hidden" name="status" type="radio" value="unactive" />
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
                    </div>
                    <div class="pt-8 w-full! gap-3 border-t border-slate-100">
                        <button type="submit"
                            class="w-full! flex-col item-center px-3 py-3 bg-blue-500 hover:bg-blue-700 text-white rounded-xl! font-bold text-sm shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"
                            type="submit">
                            <div>
                                <i class="fa-solid fa-floppy-disk"></i>
                                Simpan
                            </div>
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </div>

</main>

<script>
(function () {
    const form = document.getElementById('admin-student-registration-form');
    if (!form || form.dataset.npmAutofillBound === '1') return;
    form.dataset.npmAutofillBound = '1';
    const npm = document.getElementById('admin_no_identitas');
    const prodi = document.getElementById('admin_prodi');
    const year = document.getElementById('admin_tahun_masuk');
    const status = document.getElementById('admin_npm_status');
    const programs = {'22201':'teknik sipil','13201':'kesehatan masyarakat','54201':'agribisnis','54211':'agroteknologi','56202':'teknik komputer','61201':'manajemen','61206':'perbankan syariah','65201':'ilmu pemerintahan','70232':'bimbingan konseling islam','74201':'ilmu hukum','84202':'pendidikan matematika','84205':'pendidikan biologi','86208':'pendidikan agama islam','88201':'pendidikan bahasa indonesia','88203':'pendidikan bahasa inggris'};
    function resolveNpm() {
        const value = npm.value.trim();
        prodi.value = ''; year.value = '';
        status.className = 'hidden mt-2 rounded-lg px-3 py-2 text-xs';
        status.textContent = '';
        if (!value) return;
        if (!/^\\d{12}$/.test(value)) {
            if (value.length >= 5) {
                status.className = 'mt-2 rounded-lg px-3 py-2 text-xs bg-amber-50 border border-amber-200 text-amber-800';
                status.textContent = 'NPM harus terdiri dari tepat 12 angka.';
            }
            return;
        }
        const code = value.slice(0, 5);
        if (!programs[code]) {
            status.className = 'mt-2 rounded-lg px-3 py-2 text-xs bg-amber-50 border border-amber-200 text-amber-800';
            status.textContent = 'Kode prodi ' + code + ' tidak dikenali. Periksa kembali NPM.';
            return;
        }
        prodi.value = programs[code];
        year.value = String(2000 + Number(value.slice(7, 9)));
        status.className = 'mt-2 rounded-lg px-3 py-2 text-xs bg-emerald-50 border border-emerald-200 text-emerald-800';
        status.textContent = 'NPM dikenali: ' + prodi.options[prodi.selectedIndex].text + ' · Tahun masuk ' + year.value + '.';
    }
    npm.addEventListener('input', resolveNpm);
    form.addEventListener('submit', function (event) {
        resolveNpm();
        if (!/^\\d{12}$/.test(npm.value.trim()) || !prodi.value || !year.value) {
            event.preventDefault();
            status.className = 'mt-2 rounded-lg px-3 py-2 text-xs bg-amber-50 border border-amber-200 text-amber-800';
            status.textContent = 'Masukkan NPM 12 digit dengan kode prodi yang terdaftar.';
            npm.focus();
        }
    });
    if (npm.value) resolveNpm();
})();
</script>

