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

@if ($listBarangDiajukan->isEmpty() && $listRuanganDiajukan->isEmpty())
    {{-- jika hanya ada barang yang diajukan --}}
    <div class="mt-1">
        <div class="flex gap-2 bg-blue-50 text-blue-700 p-2.5 rounded-lg border border-blue-100 items-center">
            <i class="fa-solid fa-circle-info" style="color: #007bff;"></i>
            <span class="text-normal leading-relaxed font-medium">
                "Tidak ada barang dan ruangan di cart peminjaman. Silahkan pilih barang atau ruangan yang ingin dipinjam!"
            </span>
        </div>
    </div>
@else
    <!-- Content Grid: Items (Left) + Summary (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Column: Cart Items List -->
        <div class="lg:col-span-8 flex flex-col gap-4">

            <!-- Header for List (Desktop only)
        <div
            class="hidden md:flex justify-between items-center pb-2 border-b border-gray-300 text-[#617589] text-sm font-medium">
            <span class="pl-4">Cart Barang</span>
        </div> -->

            <!-- cart barang -->
            @foreach ($listBarangDiajukan as $cartbarang)
                {{-- @dump($cartbarang) --}}
                <div class="flex flex-col md:flex-row gap-4 bg-white rounded-xl p-3 shadow-sm border border-[#f0f2f">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-24 md:size-[100px] shrink-0"
                            data-alt="Nike Air running shoes side profile on grey background"
                            style='background-image: url("/storage/{{ $cartbarang['img_item'] }}");'>
                        </div>
                        <div class="flex flex-1 flex-col justify-between h-full min-h-[100px]">
                            <div>
                                <div class="items-center">
                                    <p class="text-[#111418] text-lg font-bold leading-normal m-0!">
                                        {{ $cartbarang['nama_item'] }}
                                    </p>
                                </div>
                                <p class="text-[#617589] text-sm font-normal leading-normal">
                                    {{ $cartbarang['nama_tipe_item'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex md:flex-col items-center md:items-end justify-between gap-4 shrink-0 border-t md:border-t-0 border-[#f0f2f4] pt-4 md:pt-0 mt-2 md:mt-0">
                        <div class="flex items-center gap-2 text-[#111418] bg-[#f0f2f4] rounded-lg p-1"
                            x-data="{ qty: {{ $cartbarang['qty_pinjam'] }} }">
                            <button
                                class="flex h-8 w-8 items-center justify-center rounded-md! bg-white shadow-sm cursor-pointer hover:text-primary transition-colors"
                                @click="qty = Math.max(0, qty - 1)" :disabled="qty <= 0">
                                <span class="material-symbols-outlined text-[16px]"></span>
                                &minus;
                            </button>
                            <input x-model="qty" min="0"
                                class="w-8 p-0 text-center bg-transparent focus:outline-0 focus:ring-0 border-none font-semibold text-sm"
                                readonly="" type="text" />
                            <button @click="qty = Math.min(qty + 1)" :disabled="qty >= {{ $cartbarang['qty_item'] }}"
                                class="flex h-8 w-8 items-center justify-center rounded-md! bg-white shadow-sm cursor-pointer hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]"></span>
                                &plus;
                            </button>
                        </div>
                        <form method="POST" action="{{ route('hapus-item-cart') }}">
                            @csrf
                            <input type="text" name="id_item" class="hidden" value="{{ $cartbarang['id_item'] }}">
                            <button
                                class=" md:flex items-center gap-1 text-[#617589] hover:text-red-500 text-sm font-medium transition-colors">
                                <i class="fa-solid fa-trash"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Header for List (Desktop only) -->
            <!--<div
            class="hidden md:flex justify-between items-center pb-2 border-b border-gray-300 text-[#617589] text-sm font-medium">
            <span class="pl-4">Cart Ruangan</span>
        </div> -->

            <!-- cart ruangan -->
            @foreach ($listRuanganDiajukan as $cartruangan)
                <div class="flex flex-col md:flex-row gap-4 bg-white rounded-xl p-3 shadow-sm border border-[#f0f2f">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-24 md:size-[100px] shrink-0"
                            data-alt="Nike Air running shoes side profile on grey background"
                            style='background-image: url("/storage/{{ $cartruangan['gambar_room'] }}");'>
                        </div>
                        <div class="flex flex-1 flex-col justify-between h-full min-h-[100px]">
                            <div>
                                <div class="items-center">
                                    <p class="text-[#111418] text-lg font-bold leading-normal m-0!">
                                        {{ $cartruangan['nama_room'] }}
                                    </p>
                                </div>
                                <p class="text-[#617589] text-sm font-normal leading-normal">
                                    {{ $cartruangan['nama_tipe_room'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex md:flex-col items-center md:items-end justify-between gap-4 shrink-0 border-t md:border-t-0 border-[#f0f2f4] pt-4 md:pt-0 mt-2 md:mt-0">
                        <div class="flex items-center gap-2 text-[#111418] bg-[#f0f2f4] rounded-lg p-1"
                            x-data="{ qty: 1 }">
                            <button readonly=""
                                class="flex h-8 w-8 items-center justify-center rounded-md! bg-[#f0f2f4] shadow-sm cursor-pointer hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]"></span>
                                &minus;
                            </button>
                            <input x-model="qty" min="0"
                                class="w-8 p-0 text-center bg-transparent focus:outline-0 focus:ring-0 border-none font-semibold text-sm"
                                readonly="" type="text" />
                            <button readonly
                                class="flex h-8 w-8 items-center justify-center rounded-md! bg-[#f0f2f4] shadow-sm cursor-pointer hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px]"></span>
                                &plus;
                            </button>
                        </div>
                        <form method="POST" action="{{ route('hapus-room-cart') }}">
                            @csrf
                            <input type="text" name="id_room" class="hidden" value="{{ $cartruangan['id_room'] }}">
                            <button
                                class=" md:flex items-center gap-1 text-[#617589] hover:text-red-500 text-sm font-medium transition-colors">
                                <i class="fa-solid fa-trash"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Right Column: Order Summary-->
        <div class="lg:col-span-4">
            <div class="sticky top-24 flex flex-col gap-6 bg-whi rounded-xl p-6 shadow-sm border border-[#f0f2f4]">
                <h4 class="text-[#111418] text-xl font-bold leading-tight">Ringkasan
                    Peminjaman
                </h4>
                <div class="flex flex-col pb-6 border-b border-[#f0f2f4]">
                    <div class="flex justify-between items-center">
                        <p class="text-[#617589] text-base font-normal">Nama</p>
                        <p class="text-[#111418] text-base font-medium">{{ $user }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-[#617589] text-base font-normal">Total Barang</p>
                        <p class="text-[#111418] text-base font-medium">{{ $jmlhBrng }} unit</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-[#617589] text-base font-normal">Total Ruangan</p>
                        <p class="text-[#111418] text-base font-medium">{{ $jmlhRuang }} Unit</p>
                    </div>
                </div>
                <!-- Promo Code Input -->

                {{-- <form action="{{ route('mhs-pengajuan-peminjaman') }}" method="POST" enctype="multipart/form-data"> --}}
                <form action="{{ route('mhs-detail-transaksi') }}" method="get">
                    @csrf
                    {{-- <div class="flex flex-col gap-2">
                    <span class="text-[#617589] text-base font-normal">Nama Kegiatan</span>
                    <input type="text" name="nama_kegiatan"
                        class="form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                        placeholder="nama kegiatan" />
                    <span class="text-[#617589] text-base font-normal">Lampiran file (docx atau pdf)</span>
                    <input name="lampiran_file" accept=".pdf, .docx"
                        class="block w-full text-sm text-gray-900 shadow-sm cursor-pointer rounded-md border border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-2 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-blue-500  file:text-white hover:file:bg-blue-700"
                        id="file_input" type="file">

                    <span class="text-[#617589] text-base font-normal">tanggal pinjam</span>
                    <input type="date" name="tgl_pinjam"
                        class="form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                        placeholder="tanggal pinjam" />
                    <span class="text-[#617589] text-base font-normal">tanggal kembali</span>
                    <input type="date" name="tgl_kembali"
                        class="form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                        placeholder="tanggal kembali" />

                    <div class="mt-1">
                        <div class="flex gap-2 bg-blue-50 text-blue-700 p-2.5 rounded-lg border border-blue-100">
                            <i class="fa-solid fa-circle-info" style="color: #007bff;"></i>
                            <p class="text-[12px] leading-relaxed font-medium">
                                Jika ingin meminjam spesifik jam penggunaan, dan lebih dari satu hari, silahkan aktifkan opsi
                                berulang dan atur jam mulai serta jam selesai pada form dibawah!
                                <br>
                                matikan opsi tersebut jika ingin meminjam full day sesuai dengan tanggal pinjam - tanggal kembali!
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl border border-slate-200 p-3.5 shadow-sm transition-all group hover:border-primary/40">
                        <div class="flex items-center justify-between">
                            <label class="cursor-pointer select-none" for="recurring-toggle">
                                <div class="font-semibold text-sm text-slate-900 flex items-center gap-2">
                                    <i class="fa fa-repeat"></i>
                                    Opsi Berulang
                                </div>
                                <div class="text-[10px] text-slate-500 mt-0.5 ml-7">
                                    Ulangi transaksi berdasarkan jadwal yang diatur
                                </div>
                            </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="recurring-toggle" class="sr-only peer" checked>
                                <div
                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-100 grid grid-cols-2 gap-3">
                            <div class="w-full">
                                <label class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">
                                    Jam Mulai
                                </label>
                                <input type="time" name="jam_mulai"
                                    class="block w-full! form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                                    placeholder="tanggal kembali" />

                            </div>
                            <div class="w-full">
                                <label class="text-[12px] font-semibold text-slate-500 mb-1 block tracking-wider">
                                    Jam Selesai
                                </label>
                                <input type="time" name="jam_selesai"
                                    class="block w-full! form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                                    placeholder="tanggal kembali" />
                            </div>
                            <div class="col-span-2 w-full!">
                                <label
                                    class="text-[12px] font-semibold text-slate-500 mb-1 block uppercase tracking-wider">
                                    Frekuensi
                                </label>
                                <select
                                    class="block w-full! rounded-lg border-slate-300 bg-slate-50 text-[12px] py-2 px-2 focus:border-primary focus:ring-primary text-slate-900">
                                    <option>Harian</option>
                                    <option>Mingguan</option>
                                    <option>Bulanan</option>
                                </select>
                            </div>
                            <div class="col-span-2 mt-1">
                                <div
                                    class="flex gap-2 bg-blue-50 text-blue-700 p-2.5 rounded-lg border border-blue-100">
                                    <i class="fa-solid fa-circle-info" style="color: #007bff;"></i>
                                    <p class="text-[12px] leading-relaxed font-medium">
                                        Jadwal: Setiap hari pukul <span class="font-bold">09:00 - 12:00</span>, mulai
                                        <span class="font-bold">25 Okt</span> selama <span class="font-bold">3
                                            hari</span>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="id_peminjam" class="hidden" value="{{ $no_identitas }}">
                </div> --}}
                    <button type="submit"
                        class="flex w-full cursor-pointer items-center justify-center rounded-lg! bg-blue-500 my-3 py-2 text-white text-base font-normal leading-normal hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/20">
                        Checkout Peminjaman
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif
