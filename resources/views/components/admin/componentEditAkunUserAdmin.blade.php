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

<main class="flex-1 min-w-0 overflow-auto bg-slate-50/50">

    <div class="p-8 max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg border border-blue-200">
                    <i class="fa-solid fa-user text-sky-400 text-[20px]"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Ahmad Sulaiman</h3>
                    <p class="text-sm text-slate-500 font-medium">Informasi Profil Pengguna</p>
                </div>
            </div>
            <form class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Nama
                            Lengkap</label>
                        <input
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                            placeholder="Masukkan nama lengkap" type="text" value="Ahmad Sulaiman" />
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                            Username
                        </label>
                        <input name="username"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                            placeholder="name@example.com" type="text" value="" />
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
                            value="sdasd" type="text" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Program
                            Studi</label>
                        <select name="prodi" id="prodi"
                            required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-semibold transition-all text-slate-700">

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
                        <input name="tahun_masuk"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white text-sm font-medium transition-all"
                            type="text" value="2021" />
                    </div>
                    <div class="space-y-3 md:col-span-2 pt-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Status
                            Akun</label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer">
                                <input checked="" class="peer hidden" name="status" type="radio" />
                                <div
                                    class="p-4 border-2 border-slate-100 rounded-xl flex items-center gap-3 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-[20px]"></i>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Aktif</p>
                                        <p class="text-[10px] text-slate-500 font-medium">Dapat mengakses
                                            sistem</p>
                                    </div>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input class="peer hidden" name="status" type="radio" />
                                <div
                                    class="p-4 border-2 border-slate-100 rounded-xl flex items-center gap-3 peer-checked:border-red-500 peer-checked:bg-red-50 transition-all">
                                    <i
                                        class="fa-solid fa-ban text-slate-400 peer-checked:text-red-500 transition-colors"></i>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Nonaktif</p>
                                        <p class="text-[10px] text-slate-500 font-medium">Akses diblokir
                                            sementara</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="pt-8 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button
                        class="px-6 py-3 rounded-xl! text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all"
                        type="button">
                        Batal
                    </button>
                    <button
                        class="px-8 py-3 bg-primary hover:bg-blue-700 text-white rounded-xl! font-bold text-sm shadow-lg shadow-primary/20 transition-all active:scale-[0.98] flex items-center gap-2"
                        type="submit">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 bg-blue-50/50 border border-blue-100 p-5 rounded-2xl flex gap-4 items-start">
            <div class="bg-blue-100 p-2 rounded-lg">
                <span class="material-icons text-blue-600">info</span>
            </div>
            <div class="text-sm text-blue-900/80">
                <p class="font-bold text-blue-900">Catatan Perubahan</p>
                <p class="mt-1 leading-relaxed font-medium">Setiap perubahan pada akun akan dicatat dalam log
                    aktivitas admin. Pengguna akan menerima notifikasi email otomatis jika terdapat perubahan
                    pada email atau status akun mereka.</p>
            </div>
        </div>
    </div>
</main>
