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

<!-- menampilkan data agenda fakultas kbm rapat dan seminar -->
<div class="bg-white py-4 px-3 rounded-sm shadow-md mb-4">
    <!-- button untuk menambahkan  -->
    <div class="flex justify-between items-center gap-4 mb-2">
        <div class="flex-1 max-w-md">
            <label class="flex flex-col w-full">
                <div class="relative w-full md:w-72">
                    <i
                        class="fa-solid fa-magnifying-glass search-icon material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-background-light border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-black"
                        placeholder="Search" type="text" />
                </div>
            </label>
        </div>

        <a href="/admin/pengelolaan-agenda/tambah-agenda/"
            class="no-underline! flex items-center justify-center gap-2 h-10 px-4 bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            Add Agenda
        </a>
    </div>
    <!-- Table list agenda yg berjalan -->
    <div class=" py-3 @container">
        <div class="flex overflow-hidden">
            <table class="w-full text-left">
                <thead class="sticky top-0 z-1">
                    <tr class="bg-primary text-white ">
                        <th class="px-4 py-3 text-sm font-medium">
                            Kode Agenda</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Nama Agenda</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Periode mulai</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Periode selesai</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Jam Mulai</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Jam Selesai</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Tipe Agenda</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($DataAgenda->isEmpty())
                        <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                            <td class="px-4 py-3 text-sm font-normal text-center" colspan="8">
                                <span class="text-gray-700 font-semibold">Data kosong!</span>
                            </td>
                        </tr>
                    @else
                        @foreach ($DataAgenda as $DataAgenda)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm font-normal">
                                    {{ $DataAgenda->kode_agenda }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal">
                                    {{ $DataAgenda->nama_agenda }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal">
                                    {{ $DataAgenda->tgl_mulai_agenda }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal">
                                    {{ $DataAgenda->tgl_selesai_agenda }}
                                </td>
                                <td class="px-4 py-3 text-sm font-normal">09:00</td>
                                <td class="px-4 py-3 text-sm font-normal">11:00</td>
                                <td class="px-4 py-3 text-sm font-normal">
                                    <span
                                        class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-blue-100 text-blue-800 text-xs font-medium">
                                        {{ $DataAgenda->tipe_agenda }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-normal">
                                    <div class="flex items-center gap-2">
                                        <form action="/admin/detail-agenda/detail/{{ $DataAgenda->kode_agenda }}"
                                            method="get">
                                            @csrf
                                            <button
                                                class="px-3 py-1.5 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-background-dark">
                                                Detail
                                            </button>
                                        </form>
                                        {{-- <button
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-background-dark">Approve</button>
                                        <button
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-background-dark">Reject</button> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- table tidak berguna skrng tapi mungkin nanti -->
    <div class="flex justify-between items-center px-6 py-3 border-t border-gray-200 dark:border-white/10">
        <p class="text-sm text-gray-600 dark:text-gray-400">Showing <span
                class="font-semibold text-gray-800 dark:text-gray-200">1</span> to <span
                class="font-semibold text-gray-800 dark:text-gray-200">5</span> of <span
                class="font-semibold text-gray-800 dark:text-gray-200">25</span> results</p>
        <div class="flex gap-2">
            <button
                class="flex items-center justify-center h-9 px-4 rounded-lg bg-white dark:bg-white/10 border border-gray-300 dark:border-white/20 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-white/20">Previous</button>
            <button
                class="flex items-center justify-center h-9 px-4 rounded-lg bg-white dark:bg-white/10 border border-gray-300 dark:border-white/20 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-white/20">Next</button>
        </div>
    </div>
</div>


        <main class="flex-1 flex flex-col h-full overflow-hidden relative mb-4!">
            <div
                class="px-8 py-6 bg-white border-b border-slate-200 shrink-0">
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
                <div class="flex items-center justify-end gap-3">
                    {{-- <div class="bg-slate-100 rounded-lg p-1 flex text-sm font-medium">
                        <button
                            class="px-3 py-1.5 border-0 rounded-md! bg-white shadow-md text-slate-900">Bulan</button>
                        <button
                            class="px-3 py-1.5 border-0 rounded-md! text-slate-500 hover:text-slate-900">Minggu</button>
                        <button
                            class="px-3 py-1.5 border-0 rounded-md! text-slate-500 hover:text-slate-900">Hari</button>
                        <button
                            class="px-3 py-1.5 border-0 rounded-md! text-slate-500 hover:text-slate-900">Agenda</button>
                    </div> --}}
                    <form action="{{ route('dashboard-admin-page-import-agenda') }}" method="get">
                        <button
                            class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 border-0 rounded-lg! font-medium transition-colors shadow-sm shadow-blue-200">
                            {{-- <i class="fa-solid fa-plus text-[20px]"></i> --}}
                            <i class="fa-solid fa-file-import text-[20px]"></i>
                            <span class="hidden sm:inline">Import Agenda</span>
                        </button>
                    </form>
                    <button
                        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 border-0 rounded-lg! font-medium transition-colors shadow-sm shadow-blue-200">
                        <i class="fa-solid fa-plus text-[20px]"></i>
                        <span class="hidden sm:inline">Buat Agenda</span>
                    </button>
                </div>
                <div id="calendar" class="my-2 border-t-1 pt-4 border-gray-300 fc-tailwind"></div>
            </div>
            {{-- <div class="flex-1 flex overflow-hidden bg-white">
                <div class="flex-1 flex flex-col h-full overflow-hidden">
                    <div class="grid grid-cols-7 border-b border-slate-200 shrink-0">
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Min</div>
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Sen</div>
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Sel</div>
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Rab</div>
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Kam</div>
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Jum</div>
                        <div class="p-3 text-center text-sm font-medium text-slate-500">Sab</div>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        <div class="grid grid-cols-7 grid-rows-5 h-full min-h-[800px]">
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] bg-slate-50/50">
                                <span class="text-slate-400 text-sm font-medium block mb-1">29</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] bg-slate-50/50">
                                <span class="text-slate-400 text-sm font-medium block mb-1">30</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">1</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">2</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div
                                    class="text-xs bg-purple-100 text-purple-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-purple-500 truncate">
                                    09:00 Rapat Koordinasi
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">3</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">4</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div
                                    class="text-xs bg-green-100 text-green-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-green-500 truncate">
                                    13:00 Sidang Skripsi
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">5</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span class="text-red-500 text-sm font-medium block mb-1">6</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">7</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">8</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">9</span>
                                <div
                                    class="text-xs bg-blue-100 text-blue-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-blue-500 truncate shadow-sm flex items-center justify-between group/event">
                                    <span>08:00 Workshop Kurikulum</span>
                                    <div class="hidden group-hover/event:flex gap-1">
                                        <button class="hover:bg-blue-200 rounded p-0.5"><span
                                                class="material-symbols-outlined text-[14px]">edit</span></button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">10</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">11</span>
                                <div
                                    class="text-xs bg-amber-100 text-amber-800 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-amber-500 truncate">
                                    13:00 Briefing Panitia Wisuda
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">12</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span class="text-red-500 text-sm font-medium block mb-1">13</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">14</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">15</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">16</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">17</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">18</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">19</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span class="text-red-500 text-sm font-medium block mb-1">20</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">21</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">22</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">23</span>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors bg-blue-50/30">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="bg-primary text-white rounded-full size-7 flex items-center justify-center text-sm font-bold shadow-md shadow-primary/30">24</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all"
                                        title="Add Event">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div class="relative group/event">
                                    <div
                                        class="mt-2 text-xs bg-primary text-white p-1.5 rounded shadow-sm cursor-pointer hover:bg-blue-600 border-l-2 border-white/50 truncate flex items-center gap-1">
                                        <span class="size-1.5 rounded-full bg-white animate-pulse"></span>
                                        <span>09:00 Seminar AI</span>
                                    </div>
                                    <div
                                        class="absolute left-0 top-full mt-2 z-50 w-72 bg-white rounded-xl shadow-xl border border-slate-200 p-4 opacity-0 invisible group-hover/event:opacity-100 group-hover/event:visible transition-all duration-200 transform translate-y-2 group-hover/event:translate-y-0">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center gap-2">
                                                <div class="size-3 rounded-full bg-primary"></div>
                                                <h4 class="font-bold text-slate-900 text-sm">Seminar
                                                    Nasional AI</h4>
                                            </div>
                                            <div class="flex gap-1">
                                                <button class="text-slate-400 hover:text-primary"><span
                                                        class="material-symbols-outlined text-[18px]">edit</span></button>
                                                <button class="text-slate-400 hover:text-red-500"><span
                                                        class="material-symbols-outlined text-[18px]">delete</span></button>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div
                                                class="flex items-center gap-3 text-xs text-slate-600">
                                                <span
                                                    class="material-symbols-outlined text-[18px] text-slate-400">schedule</span>
                                                <span>09:00 - 12:00 WIB</span>
                                            </div>
                                            <div
                                                class="flex items-start gap-3 text-xs text-slate-600">
                                                <span
                                                    class="material-symbols-outlined text-[18px] text-slate-400">meeting_room</span>
                                                <div>
                                                    <span class="font-medium">Aula Utama</span>
                                                    <p class="text-slate-400 text-[10px] mt-0.5">Kapasitas 200 Orang
                                                    </p>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-start gap-3 text-xs text-slate-600">
                                                <span
                                                    class="material-symbols-outlined text-[18px] text-slate-400">inventory_2</span>
                                                <div class="flex flex-wrap gap-1">
                                                    <span
                                                        class="bg-slate-100 px-1.5 py-0.5 rounded text-[10px]">Mic
                                                        Wireless (2)</span>
                                                    <span
                                                        class="bg-slate-100 px-1.5 py-0.5 rounded text-[10px]">Kamera
                                                        Sony</span>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-3 text-xs text-slate-600 pt-2 border-t border-slate-100">
                                                <span
                                                    class="material-symbols-outlined text-[18px] text-slate-400">person</span>
                                                <span>BEM Fakultas</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">25</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div
                                    class="text-xs bg-amber-100 text-amber-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-amber-500 truncate flex items-center justify-between">
                                    <span>13:00 Rapat Dosen</span>
                                    <span class="material-symbols-outlined text-[12px]">schedule</span>
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">26</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div
                                    class="text-xs bg-slate-200 text-slate-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-slate-500 truncate opacity-60">
                                    08:00 Workshop Robotika (Done)
                                </div>
                            </div>
                            <div
                                class="border-b border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span
                                        class="text-slate-700 text-sm font-medium block mb-1">27</span>
                                    <button
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div
                                    class="text-xs bg-red-100 text-red-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-red-500 truncate decoration-line-through">
                                    10:00 Kuliah Tamu (Cancel)
                                </div>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span class="text-red-500 text-sm font-medium block mb-1">28</span>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">29</span>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">30</span>
                                <div
                                    class="text-xs bg-blue-100 text-blue-700 p-1.5 rounded mb-1 cursor-pointer hover:opacity-80 border-l-2 border-blue-500 truncate">
                                    09:00 Sosialisasi PKM
                                </div>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] relative group hover:bg-slate-50 transition-colors">
                                <span
                                    class="text-slate-700 text-sm font-medium block mb-1">31</span>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] bg-slate-50/50">
                                <span class="text-slate-400 text-sm font-medium block mb-1">1</span>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] bg-slate-50/50">
                                <span class="text-slate-400 text-sm font-medium block mb-1">2</span>
                            </div>
                            <div
                                class="border-r border-slate-100 p-2 min-h-[120px] bg-slate-50/50">
                                <span class="text-slate-400 text-sm font-medium block mb-1">3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </main>

