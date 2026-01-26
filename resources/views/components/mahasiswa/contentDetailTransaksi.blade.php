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

<!-- Right Column: Order Summary-->
<div class="lg:col-span-4 mb-4">
    <div class="sticky top-24 flex flex-col gap-6 bg-whi rounded-md p-6 shadow-sm border border-[#f0f2f4]">
        {{-- <form action="{{ route('mhs-pengajuan-peminjaman') }}" method="POST" enctype="multipart/form-data"> --}}
        <form action="{{ route('mhs-pengajuan-peminjaman') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-2">
                <span class="text-[#617589] text-base font-normal">Keterangan pememinjaman atau nama Kegiatan</span>
                <input type="text" name="nama_kegiatan"
                    class="form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                    placeholder="keterangan peminjaman" />
                <span class="text-[#617589] text-base font-normal">Lampiran file (docx atau pdf)</span>
                <input name="lampiran_file" accept=".pdf, .docx"
                    class="block w-full text-sm text-gray-900 shadow-sm cursor-pointer rounded-md border border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-2 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-blue-500  file:text-white hover:file:bg-blue-700"
                    id="file_input" type="file">

                <div class="mt-1">
                    <div class="flex gap-2 bg-blue-50 text-blue-700 p-2.5 rounded-lg border border-blue-100">
                        <i class="fa-solid fa-circle-info" style="color: #007bff;"></i>
                        <p class="text-[12px] leading-relaxed font-medium">
                            "Aktifkan Opsi peminjaman full (berdasarkan rentang tanggal pinjam) jika Anda memerlukan
                            barang/ruangan secara full dalam rentang tanggal yang ditentukan."
                            <br>
                            "Aktifkan Opsi Spesifik jika Anda memerlukan barang/ruangan di jam tertentu saja."
                        </p>
                    </div>
                </div>

                <div x-data="{ isRecurring: 'none' }" class="flex flex-col gap-2">

                    {{-- opsi peminjaman full --}}
                    <div
                        class="bg-white rounded-xl border border-slate-200 p-3.5 shadow-sm transition-all group hover:border-primary/40">
                        <div class="flex items-center justify-between">
                            <label class="cursor-pointer select-none" for="toggle-full">
                                <div class="font-semibold text-sm text-slate-900 flex items-center gap-2">
                                    <i class="fa fa-calendar-day"></i> Opsi peminjaman Full Durasi
                                </div>
                                <div class="text-[10px] text-slate-500 mt-0.5 ml-7">Pinjam penuh dalam
                                    rentang tanggal</div>
                            </label>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle-full" class="sr-only peer"
                                    :checked="isRecurring === 'full'"
                                    @click="isRecurring = (isRecurring === 'full' ? 'none' : 'full')">

                                <div
                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all">
                                </div>
                            </label>
                        </div>

                        <div x-show="isRecurring === 'full'" x-transition
                            class="mt-3 pt-3 border-t border-slate-100 md:grid md:grid-cols-2 md:gap-3">
                            <div class="w-full">
                                <label
                                    class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">Tanggal
                                    Pinjam</label>
                                <input type="date" name="tgl_pinjam" :disabled="isRecurring !== 'full'"
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />
                            </div>

                            <div class="w-full">
                                <label
                                    class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">Tanggal
                                    Kembali</label>
                                <input type="date" name="tgl_kembali" :disabled="isRecurring !== 'full'"
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />
                            </div>

                            <div class="col-span-2 p-2 bg-blue-50 text-blue-700 rounded-lg text-[12px]">
                                <i class="fa-solid fa-info-circle"></i> Opsi Peminjaman full: Barang atau ruangan
                                dipinjam full mulai dari pinjam hingga kembali.
                            </div>
                        </div>
                    </div>

                    {{-- opsi peminjaman spesifik --}}
                    <div
                        class="bg-white rounded-xl border border-slate-200 p-3.5 shadow-sm transition-all group hover:border-primary/40">
                        <div class="flex items-center justify-between">
                            <label class="cursor-pointer select-none" for="toggle-spec">
                                <div class="font-semibold text-sm text-slate-900 flex items-center gap-2">
                                    <i class="fa fa-clock"></i> Opsi Peminjaman Spesifik
                                </div>
                                <div class="text-[10px] text-slate-500 mt-0.5 ml-7">Pinjam secara spesifik berdasarkan
                                    jam penggunaan</div>
                            </label>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle-spec" class="sr-only peer"
                                    :checked="isRecurring === 'spesifik'"
                                    @click="isRecurring = (isRecurring === 'spesifik' ? 'none' : 'spesifik')">

                                <div
                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all">
                                </div>
                            </label>
                        </div>

                        <div x-show="isRecurring === 'spesifik'" x-transition x-data="{ jamMulai: '', error: false, jamSelesai: '' }"
                            class="mt-3 pt-3 border-t border-slate-100  md:grid md:grid-cols-2 md:gap-3">

                            <div class="w-full">
                                <label
                                    class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">Tanggal
                                    Pinjam</label>
                                <input type="date" name="tgl_pinjam" :disabled="isRecurring !== 'spesifik'"
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />
                            </div>

                            <div class="w-full">
                                <label
                                    class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">Tanggal
                                    Kembali</label>
                                <input type="date" name="tgl_kembali" :disabled="isRecurring !== 'spesifik'"
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />
                            </div>

                            <div class="w-full">
                                <label class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">
                                    Jam Mulai Digunakan
                                </label>
                                <input type="time" name="jam_mulai" min="08:00" max="15:00"
                                    x-model="jamMulai" :disabled="isRecurring !== 'spesifik'"
                                    @change="
                                           if(jamMulai < '08:00' || jamMulai > '15:00') {
                                                error = true;
                                                jamMulai = ''; 
                                            } else {
                                                error = false;
                                            }
                                        "
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />
                            </div>

                            {{-- jam selesai --}}
                            <div class="w-full">
                                <label class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">
                                    Jam Selesai Digunakan
                                </label>
                                <input type="time" name="jam_selesai" min="08:00" max="15:00"
                                    x-model="jamSelesai" :disabled="isRecurring !== 'spesifik'"
                                    @change="
                                           if(jamSelesai < '08:00' || jamSelesai > '15:00') {
                                                error = true;
                                                jamSelesai = ''; 
                                            } else {
                                                error = false;
                                            }
                                        "
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />

                            </div>

                            <div x-show="error" x-transition
                                class="text-[10px] text-red-500 flex items-center gap-1 font-medium">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                Batas waktu penggunaan: 08:00 - 15:00, Lebih dari itu silahkan ajukan opsi peminjaman full.
                            </div>


                            {{-- <div class="w-full">
                                <label class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">Jam
                                    Selesai</label>
                                <input type="time" name="jam_selesai" :disabled="isRecurring !== 'spesifik'"
                                    class="block w-full rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary disabled:bg-slate-100" />
                            </div> --}}

                            <div class="col-span-2 p-2 bg-blue-50 text-blue-700 rounded-lg text-[12px]">
                                <i class="fa-solid fa-info-circle"></i> Opsi Peminjaman Spesifik: Barang atau ruangan
                                dipinjam pada jam tertentu selama rentang tanggal pinjam hingga kembali.
                                <br>
                                <i class="fa-solid fa-info-circle"></i>
                                Opsi ini berlaku untuk peminjaman di jam kerja saja (08:00 - 15:00). lebih dari itu,
                                silahkan
                                ajukan opsi peminjaman full.
                            </div>
                        </div>
                    </div>
                </div>

                <input type="text" name="id_peminjam" class="hidden" value="{{ $no_identitas }}">
            </div>
            <button type="submit"
                class="flex w-full cursor-pointer items-center justify-center rounded-lg! bg-blue-500 my-3 py-2 text-white text-base font-normal leading-normal hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/20">
                Ajukan Peminjaman
            </button>
        </form>
    </div>
</div>
