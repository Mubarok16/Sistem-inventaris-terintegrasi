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

<main class="flex-1 flex flex-col h-full overflow-hidden relative mb-4!">
    <div x-data="{ activeTab: 'Mata Kuliah' }" class="px-6 py-6 border-slate-200 shrink-0">
        {{-- <div class="flex items-center gap-4">
                    <h4 class="text-xl font-bold text-slate-900">Oktober 2023</h4>
                    <div class="flex items-center bg-slate-100 rounded-lg p-0.5">
                        <button
                            class="p-1 hover:bg-white hover:shadow-sm rounded text-slate-500 transition-all">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button
                            class="p-1 hover:bg-white hover:shadow-sm rounded text-slate-500 transition-all">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div> --}}
        <div class="flex items-center justify-end gap-3 mb-3">
            {{-- <div class="bg-white p-1 rounded-xl border border-slate-200 inline-flex shadow-sm gap-2">
                <button @click="activeTab = 'Mata Kuliah'"
                    :class="activeTab === 'Mata Kuliah' ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'"
                    class="px-4 py-2 rounded-lg! text-sm font-medium transition-colors">
                    Mata Kuliah
                </button>

                <button @click="activeTab = 'PTS'"
                    :class="activeTab === 'PTS' ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'"
                    class="px-4 py-2 rounded-lg! text-sm font-medium transition-colors">
                    PTS / PAS
                </button>
            </div> --}}
            <div class="flex items-center justify-end gap-3">
                <form action="{{ route('dashboard-admin-page-import-agenda') }}" method="get">
                    <button
                        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 border-0 rounded-lg! font-medium transition-colors shadow-sm shadow-blue-200">
                        {{-- <i class="fa-solid fa-plus text-[20px]"></i> --}}
                        <i class="fa-solid fa-file-import text-[20px]"></i>
                        <span class="hidden sm:inline">Import Agenda</span>
                    </button>
                </form>
                <form action="/admin/pengelolaan-agenda/tambah-agenda/" method="get">
                    <button
                        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 border-0 rounded-lg! font-medium transition-colors shadow-sm shadow-blue-200">
                        <i class="fa-solid fa-plus text-[20px]"></i>
                        <span class="hidden sm:inline">Buat Agenda</span>
                    </button>
                </form>
            </div>

        </div>
        <!-- Filters -->
        <form action="{{ route('simpan-riwayat-session') }}" method="post">
            <div
                class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm mb-3">
                @csrf
                <div class="flex! gap-1 bg-slate-100 p-1 rounded-lg w-full sm:w-auto overflow-x-auto">
                    <button value="semua" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-white rounded shadow-sm  transition-all whitespace-nowrap">
                        Semua Agenda
                    </button>
                    <button value="kbm" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        KBM
                    </button>
                    <button value="pts/pas" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        PTS/PAS
                    </button>
                    <button value="rapat" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Rapat Pimpinan
                    </button>
                    <button value="seminar" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Seminar
                    </button>
                </div>

            </div>
        </form>

        <!-- Content List -->
        <div class="flex flex-col gap-3 mb-6">

            <!-- Item -->
            {{-- @if ($dataPeminjamanByPeminjam->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 px-4 py-3 mb-2 rounded-lg">
                    <div class="flex items-center"> <i
                            class="fa-solid fa-triangle-exclamation text-yellow-500 mr-3"></i>
                        <span class="text-sm text-yellow-700 leading-none"> Belum ada data riwayat peminjaman untuk
                            kategori ini.
                        </span>
                    </div>
                </div>
            @else --}}
                @foreach ($dataAgendas as $riwayat)
                    <div
                        class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden ring-1 ring-primary/20">
                        <div
                            class="px-4 py-3 flex flex-col md:flex-row gap-2 justify-between items-start md:items-center border-b border-slate-100 bg-slate-50/50 cursor-pointer">
                            <div class="flex flex-col gap-1.5 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-bold text-slate-900 text-md tracking-tight uppercase">
                                        {{ $riwayat->nama_agenda }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium md:ml-0! tracking-tight">
                                        {{ $riwayat->kode_agenda }}
                                    </span>

                                    @if ($riwayat->tipe_agenda === 'kegiatan belajar mengajar')
                                         <span
                                            class="bg-blue-100 text-blue-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-blue-200">
                                            KBM
                                        </span>
                                    @elseif ($riwayat->tipe_agenda === 'pts/pas')
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-blue-200">
                                            PTS/PAS
                                        </span>
                                    @elseif ($riwayat->tipe_agenda === 'rapat pimpinan')
                                        <span
                                            class="bg-gray-100 text-gray-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-gray-200">
                                            Rapat Pimpinan
                                        </span>
                                    @elseif ($riwayat->tipe_agenda === 'seminar')
                                        <span
                                            class="bg-green-100 text-green-700 text-xs px-2.5 py-0.5 rounded-full font-semibold border border-green-200">
                                            Seminar
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-600 mt-1">

                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span class="text-xs">
                                            {{ date('d M Y', strtotime($riwayat->tgl_pinjam_usage_item != null ? $riwayat->tgl_pinjam_usage_item : $riwayat->tgl_pinjam_usage_room)) }}
                                            -
                                            <span class="text-orange-600 font-medium">
                                                {{ date('d M Y', strtotime($riwayat->tgl_kembali_usage_item != null ? $riwayat->tgl_kembali_usage_item : $riwayat->tgl_kembali_usage_room)) }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-clock text-slate-400"></i>
                                        <span class="text-xs">
                                            @if ($riwayat->jam_mulai_usage_item != null)
                                                {{ date('H:i', strtotime($riwayat->jam_mulai_usage_item)) }}
                                                -
                                                {{ date('H:i', strtotime($riwayat->jam_selesai_usage_item)) }}
                                            @elseif($riwayat->jam_mulai_usage_room != null)
                                                {{ date('H:i', strtotime($riwayat->jam_mulai_usage_room)) }}
                                                -
                                                {{ date('H:i', strtotime($riwayat->jam_selesai_usage_room)) }}
                                            @else
                                                Full day
                                            @endif

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 self-end md:self-center">
                                <form action="{{ route('admin-detail-agenda', ['id' => urlencode($riwayat->kode_agenda)]) }}"
                                    method="get">
                                    @csrf
                                    <button value=""
                                        class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-100! text-slate-700 rounded-lg! text-sm font-medium transition-colors ">
                                        <span>Detail</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            {{-- @endif --}}

        </div>

        {{-- calender --}}
        {{-- <div id="calendar" data-url="{{ url('/admin/events-calender') }}"
            class="my-2 border-t-1 pt-4 border-gray-300 fc-tailwind">
        </div> --}}
    </div>
</main>
