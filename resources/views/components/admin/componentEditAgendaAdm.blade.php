@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-success">
        <ul style="margin-bottom: 0;">
            {{ session('success') }}
        </ul>
    </div>
@endif

@if (session('gagal'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="alert alert-danger">
        <ul style="margin-bottom: 0;">
            {{ session('gagal') }}
        </ul>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<main class="layout-container flex grow flex-col items-center justify-center my-4 mx-3 px-0 sm:px-8 lg:px-20">
    <div class="w-full max-w-[1200px] flex flex-col gap-5">
        @foreach ($dataAgenda as $dataPeminjaman)
            <div class="w-full!">
                <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-200 shadow-sm flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b border-slate-100 pb-4">
                        <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-primary"></i>
                            Edit Jadwal &amp; Keperluan
                        </h5>
                        <div class="text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
                            Riwayat yang sudah selesai, digunakan, dibatalkan, atau terlewat tidak akan dibuat ulang.
                        </div>
                    </div>

                    <form action="{{ route('simpan-agenda') }}" method="post" id="agendaEditForm">
                        @csrf
                        <input type="hidden" name="kode_agenda_lama" value="{{ $id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kode Agenda</span>
                                    <input type="text" value="{{ $dataPeminjaman->kode_agenda }}" readonly
                                        class="mt-1 text-sm text-slate-500 leading-relaxed bg-slate-100 p-2 rounded-lg border border-slate-200 w-full cursor-not-allowed">
                                    <p class="text-xs text-slate-400 mt-1">Kode agenda tidak dapat diubah karena digunakan sebagai identitas agenda.</p>
                                </div>

                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Agenda</span>
                                    <input type="text" name="nama_agenda" id="nama_agenda"
                                        value="{{ old('nama_agenda', $dataPeminjaman->nama_agenda) }}" required maxlength="255"
                                        class="mt-1 text-sm text-slate-700 leading-relaxed bg-slate-50 p-2 rounded-lg border border-slate-200 w-full">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Mulai Agenda</span>
                                        <input type="date" name="tgl_mulai_agenda" id="tgl_mulai_agenda"
                                            value="{{ old('tgl_mulai_agenda', date('Y-m-d', strtotime($dataPeminjaman->tgl_mulai_agenda))) }}" required
                                            class="text-sm text-slate-700 bg-slate-50 p-2 rounded-lg border border-slate-200">
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Selesai Agenda</span>
                                        <input type="date" name="tgl_selesai_agenda" id="tgl_selesai_agenda"
                                            value="{{ old('tgl_selesai_agenda', date('Y-m-d', strtotime($dataPeminjaman->tgl_selesai_agenda))) }}" required
                                            class="text-sm text-slate-700 bg-slate-50 p-2 rounded-lg border border-slate-200">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipe Agenda</span>
                                    @php
                                        $tipeAgendaOptions = ['kegiatan belajar mengajar', 'rapat', 'rapat pimpinan', 'pts/pas', 'seminar'];
                                        $tipeAgendaAktif = old('tipe_agenda', trim($dataPeminjaman->tipe_agenda));
                                    @endphp
                                    <select name="tipe_agenda" id="tipe_agenda" required
                                        class="mt-1 form-control text-sm text-slate-700 bg-slate-50 border-slate-200">
                                        @foreach ($tipeAgendaOptions as $tipeAgenda)
                                            <option value="{{ $tipeAgenda }}" {{ $tipeAgendaAktif === $tipeAgenda ? 'selected' : '' }}>
                                                {{ ucwords($tipeAgenda) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hari Pengulangan</span>
                                    @php
                                        $semuaHari = ['setiap hari', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
                                        $hariAktif = old('loop_agenda', trim($dataPeminjaman->loop_hari));
                                    @endphp
                                    <select name="loop_agenda" id="loop_agenda" required
                                        class="mt-1 form-control text-sm text-slate-700 bg-slate-50 border-slate-200">
                                        @foreach ($semuaHari as $hari)
                                            <option value="{{ $hari }}" {{ $hariAktif === $hari ? 'selected' : '' }}>
                                                {{ ucwords($hari) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tipe Jam</span>
                                    @php
                                        $tipeJamAktif = old('tipe_jam', $dataPeminjaman->tipe_jam);
                                    @endphp
                                    <select name="tipe_jam" id="tipe_waktu" class="mt-1 form-control" onchange="toggleJam()" required>
                                        <option value="full day" {{ $tipeJamAktif === 'full day' ? 'selected' : '' }}>Full Day</option>
                                        <option value="spesifik" {{ $tipeJamAktif === 'spesifik' ? 'selected' : '' }}>Spesifik</option>
                                    </select>
                                </div>

                                <div id="input_jam_container" style="{{ $tipeJamAktif === 'full day' ? 'display:none;' : 'display:block;' }}">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-sm text-slate-600">Jam Mulai</label>
                                            <input type="time" name="jam_mulai" class="form-control" id="jam_mulai"
                                                value="{{ old('jam_mulai', $tipeJamAktif === 'full day' ? '' : $dataPeminjaman->jam_mulai) }}">
                                        </div>
                                        <div>
                                            <label class="text-sm text-slate-600">Jam Selesai</label>
                                            <input type="time" name="jam_selesai" class="form-control" id="jam_selesai"
                                                value="{{ old('jam_selesai', $tipeJamAktif === 'full day' ? '' : $dataPeminjaman->jam_selesai) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-blue-600 border border-blue-600 rounded-md! text-white font-medium hover:bg-blue-700 transition-colors shadow-sm w-full justify-center mt-5">
                            <i class="fas fa-check-circle text-white"></i>
                            <span>Simpan Perubahan Agenda</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- tampilan add barang dan ruang --}}
        <div>
            <div x-data="{
                showPicker: false,
                currentTab: 'barang',
                products: [],
                init() { this.products = productsData }
            }" x-init="init()">

                <div
                    class="flex flex-col md:flex-row items-center justify-start md:justify-between border-b border-slate-100 pb-4 gap-4">
                    <h5 class="font-semibold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-primary"></i>
                        Detail Barang &amp; Ruangan yang Digunakan
                    </h5>
                    <button @click="showPicker = true"
                        class="flex items-center gap-2 px-4 py-2 bg-green-500 border border-slate-200 rounded-md! text-slate-700 font-medium hover:bg-green-700 transition-colors shadow-sm">
                        {{-- <i class="fa-solid fa-print text-lg text-white"></i> --}}
                        <i class="fas fa-plus text-white"></i>
                        <span class="text-white">add barang atau ruangan</span>
                    </button>
                </div>

                <div x-show="showPicker" x-transition.opacity
                    class="fixed inset-0 bg-black/60 z-50 backdrop-blur-sm flex items-center justify-center p-4 md:p-10"
                    x-cloak>

                    <div @click.away="showPicker = false"
                        class="bg-gray-50 w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">

                        <div class="bg-white border-b border-gray-300">
                            <div class="py-3 px-6 flex justify-between items-center">
                                <h5 class="text-xl font-bold text-gray-800">
                                    <i class="fa-solid fa-box text-primary"></i>
                                    Pilih Barang atau Ruangan Yang ingin ditambahkan
                                </h5>

                                <button @click="showPicker = false"
                                    class="text-gray-400 hover:text-red-500 text-3xl font-light">
                                    &times;
                                </button>
                            </div>

                            <div class="flex px-5 space-x-6 gap-3">
                                <button @click="currentTab = 'barang'"
                                    :class="currentTab === 'barang' ? 'text-indigo-600 border-indigo-600' :
                                        'text-gray-500 border-transparent hover:text-gray-700'"
                                    class="pb-3 border-b-1 font-normal transition">
                                    Daftar Barang
                                </button>
                                <button @click="currentTab = 'ruangan'"
                                    :class="currentTab === 'ruangan' ? 'text-indigo-600 border-indigo-600' :
                                        'text-gray-500 border-transparent hover:text-gray-700'"
                                    class="pb-3 border-b-1 font-normal transition">
                                    Daftar Ruangan
                                </button>
                            </div>
                        </div>

                        <div class="p-6 overflow-y-auto">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                                <template x-for="item in products.filter(i => i.category === currentTab)"
                                    :key="item.id">

                                    <!-- Product Card 1 -->
                                    <article
                                        class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">
                                        <!-- Image Container -->
                                        <div class="relative aspect-square overflow-hidden bg-gray-200 ">
                                            <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                                                data-alt="Modern high-end sneakers with white and grey accents floating in a studio setting"
                                                :style="`background-image: url('{{ asset('storage') }}/${item.img_item}')`">
                                            </div>
                                            <!-- Quick Action Overlay -->
                                            <div
                                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                <button
                                                    class="bg-white text-slate-900 hover:bg-primary hover:text-white transition-colors p-3 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 duration-300">
                                                    <span class="material-symbols-outlined text-[20px]"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Content -->
                                        <div class="px-3 py-3 flex flex-col gap-2">
                                            <div class="flex items-center justify-between">
                                                <span
                                                    class="text-xs font-medium text-slate-400 uppercase tracking-wide"
                                                    x-text="item.nama_tipe_item"></span>
                                                <div class="flex items-center gap-1 text-green-500">
                                                    stok:  
                                                    <span class="material-symbols-outlined text-[16px] leading-none"
                                                        x-text="item.qty_item">
                                                    </span>
                                                </div>
                                            </div>
                                            <form action="{{ route('tambah-barang-agenda') }}" method="post" onsubmit="syncAgendaFields(this)">
                                                @csrf
                                                <div class="flex justify-between">
                                                    <h3 class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors"
                                                        x-text="item.nama_item">
                                                    </h3>
                                                    <input x-show="currentTab === 'barang'" type="number" name="qty_usage" class="w-10 border-1 border-slate-300 rounded-md px-1" value="0">
                                                    <input name="qty_item" type="text"
                                                            :value="item.qty_item" hidden>
                                                </div>
                                                <div class="flex items-center justify-between mt-auto pt-2">
                                                    <div class="flex gap-2 w-full">
                                                        <input name="id_agenda" type="text"
                                                            value="{{ $id }}" hidden>
                                                        <input name="id_item_room" type="text"
                                                            :value="item.id" hidden>
                                                        <button type="submit" id="pilih_barangruang"
                                                            class="py-1 px-2 text-white bg-blue-500 hover:bg-blue-300 flex justify-center items-center text-center gap-1 w-full rounded ">
                                                            Pilih <span
                                                                x-text="currentTab === 'barang' ? 'Barang' : 'Ruangan'"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </article>
                                </template>

                            </div>

                            <div x-show="products.filter(i => i.category === currentTab).length === 0"
                                class="text-center py-20 text-gray-400">
                                Tidak ada data ditemukan.
                            </div>
                        </div>

                        {{-- <div class="bg-white p-4 border-t text-right">
                        <button @click="showPicker = false"
                            class="px-6 py-2 bg-gray-100 rounded-lg text-gray-600 hover:bg-gray-200 transition">
                            Selesai
                        </button>
                    </div> --}}
                    </div>
                </div>
            </div>

            <style>
                [x-cloak] {
                    display: none !important;
                }

                .overflow-y-auto::-webkit-scrollbar {
                    width: 6px;
                }

                .overflow-y-auto::-webkit-scrollbar-thumb {
                    background: #d1d5db;
                    border-radius: 10px;
                }
            </style>
        </div>


        <!-- tampilan barang dan runagan sementara -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-8">
            @foreach ($semuaData as $dataBarang)
                <!-- Product Card 1 -->
                <article
                    class="group relative flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border-0">
                    <!-- Image Container -->
                    <div class="relative aspect-square overflow-hidden bg-gray-200 ">
                        <div class="h-full w-full bg-center bg-cover transition-transform duration-500 group-hover:scale-110"
                            data-alt="Modern high-end sneakers with white and grey accents floating in a studio setting"
                            style='background-image: url("/storage/{{ $dataBarang->img_item ?? $dataBarang->gambar_room }}");'>
                        </div>
                        <!-- Quick Action Overlay -->
                        <div class="absolute top-2 right-2 z-[10] pointer-events-auto">
                            <form action="{{ route('hapus-barang-agenda') }}" method="post" onsubmit="syncAgendaFields(this)">
                                @csrf
                                <input name="id_agenda" type="hidden" value="{{ $id }}">

                                <input name="id_item_room" type="text"
                                    value="{{ $dataBarang->id_room ?? $dataBarang->id_item }}" hidden>

                                <button type="submit"
                                    class="flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-lg! shadow-lg transition-all duration-200 opacity-100 md:opacity-0 md:group-hover:opacity-100 hover:bg-red-700 hover:scale-110 active:scale-90">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="px-3 py-3 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                {{ $dataBarang->merek_model ?? $dataBarang->nama_tipe_room }}
                            </span>
                            <div class="flex items-center gap-1 text-green-500">
                                <span
                                    class="material-symbols-outlined text-[16px] leading-none">{{ $dataBarang->kondisi_item ?? $dataBarang->kondisi_room }}</span>
                                {{-- <span class="text-xs font-semibold text-slate-600 ">5.0</span> --}}
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3
                                class="text-lg font-bold leading-tight truncate group-hover:text-primary transition-colors">
                                {{ $dataBarang->nama_item ?? $dataBarang->nama_room }}
                            </h3>
                            <span
                                class="text-xs font-medium text-slate-700 uppercase tracking-wide">
                                qty: {{ $dataBarang->qty_usage_item ?? '-' }}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</main>

<script>
    const productsData = @json($allBarangRuang);

    function toggleJam() {
        const tipeWaktu = document.getElementById('tipe_waktu').value;
        const containerJam = document.getElementById('input_jam_container');
        const jamMulai = document.getElementById('jam_mulai');
        const jamSelesai = document.getElementById('jam_selesai');

        if (tipeWaktu === 'spesifik') {
            containerJam.style.display = 'block';
            jamMulai.required = true;
            jamSelesai.required = true;
        } else {
            containerJam.style.display = 'none';
            jamMulai.required = false;
            jamSelesai.required = false;
        }
    }

    // Saat menambah/menghapus resource, bawa nilai form agenda saat ini agar draft tidak kembali ke nilai lama.
    function syncAgendaFields(targetForm) {
        const sourceForm = document.getElementById('agendaEditForm');
        if (!sourceForm) return;

        const fieldMap = {
            nama_agenda: 'draft_nama_agenda',
            tgl_mulai_agenda: 'draft_tgl_mulai_agenda',
            tgl_selesai_agenda: 'draft_tgl_selesai_agenda',
            tipe_agenda: 'draft_tipe_agenda',
            loop_agenda: 'draft_loop_agenda',
            tipe_jam: 'draft_tipe_jam',
            jam_mulai: 'draft_jam_mulai',
            jam_selesai: 'draft_jam_selesai'
        };

        Object.entries(fieldMap).forEach(([sourceName, targetName]) => {
            const source = sourceForm.elements[sourceName];
            if (!source) return;

            let hidden = targetForm.querySelector(`input[name="${targetName}"]`);
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = targetName;
                targetForm.appendChild(hidden);
            }
            hidden.value = source.value ?? '';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleJam();

        const tanggalMulai = document.getElementById('tgl_mulai_agenda');
        const tanggalSelesai = document.getElementById('tgl_selesai_agenda');
        if (tanggalMulai && tanggalSelesai) {
            const sinkronMinTanggal = () => {
                tanggalSelesai.min = tanggalMulai.value;
            };
            tanggalMulai.addEventListener('change', sinkronMinTanggal);
            sinkronMinTanggal();
        }
    });
</script>
