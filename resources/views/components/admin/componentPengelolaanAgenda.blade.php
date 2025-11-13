<!-- Main card for table -->
<div class="flex flex-col bg-white dark:bg-background-dark rounded-xl border border-gray-200 dark:border-white/10">
    <!-- SearchBar -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-white/10">
        <!-- ToolBar -->
        <div class="flex justify-between items-center gap-4 mb-4">
            <div class="flex-1 max-w-md">
                <label class="flex flex-col w-full">
                    <div class="flex w-full flex-1 items-stretch rounded-lg h-10">
                        <div
                            class="text-gray-500 dark:text-gray-400 flex bg-background-light dark:bg-background-dark items-center justify-center pl-3 rounded-l-lg">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                        <input
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-sm font-normal text-gray-800 dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border-none bg-background-light dark:bg-background-dark h-full placeholder:text-gray-500 dark:placeholder:text-gray-400"
                            placeholder="Search nama ruangan..." value="" />
                    </div>
                </label>
            </div>
            <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white gap-2 pl-3 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined text-base">add</span>
                <span class="truncate">Add ruang</span>
            </button>
        </div>
    </div>
    <!-- Table -->
    <div class="px-4 py-3 @container">
        <div class="flex overflow-hidden">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 dark:border-white/10">
                    <tr class="bg-white dark:bg-background-dark">
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium w-16">
                            ID</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium min-w-[200px]">
                            Keterangan Agenda</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium">
                            Tanggal</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium">
                            Jam Mulai</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium">
                            Jam Selesai</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium">
                            Tipe Agenda</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium">
                            Ruangan</th>
                        <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 font-medium w-36">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 dark:border-white/5 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">1</td>
                        <td class="h-[72px] px-4 py-2 text-gray-800 dark:text-gray-100 font-medium">
                            Rapat Dosen Awal Semester</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">2024-08-01
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">09:00</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">11:00</td>
                        <td class="h-[72px] px-4 py-2">
                            <span
                                class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 text-xs font-medium">Rutin</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">Ruang Rapat
                            A</td>
                        <td class="h-[72px] px-4 py-2">
                            <div class="flex gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">visibility</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">edit</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"><span
                                        class="material-symbols-outlined !text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-white/5 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">2</td>
                        <td class="h-[72px] px-4 py-2 text-gray-800 dark:text-gray-100 font-medium">
                            Kuliah Umum Kecerdasan Buatan</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">2024-08-05
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">13:00</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">15:00</td>
                        <td class="h-[72px] px-4 py-2">
                            <span
                                class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300 text-xs font-medium">Insidental</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">Aula Gedung
                            B</td>
                        <td class="h-[72px] px-4 py-2">
                            <div class="flex gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">visibility</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">edit</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"><span
                                        class="material-symbols-outlined !text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-white/5 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">3</td>
                        <td class="h-[72px] px-4 py-2 text-gray-800 dark:text-gray-100 font-medium">
                            Maintenance Server</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">2024-08-07
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">10:00</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">12:00</td>
                        <td class="h-[72px] px-4 py-2">
                            <span
                                class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 text-xs font-medium">Rutin</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">Ruang
                            Server</td>
                        <td class="h-[72px] px-4 py-2">
                            <div class="flex gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">visibility</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">edit</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"><span
                                        class="material-symbols-outlined !text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-white/5 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">4</td>
                        <td class="h-[72px] px-4 py-2 text-gray-800 dark:text-gray-100 font-medium">
                            Presentasi Proyek Mahasiswa Akhir</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">2024-08-10
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">09:00</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">17:00</td>
                        <td class="h-[72px] px-4 py-2">
                            <span
                                class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300 text-xs font-medium">Insidental</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">
                            Laboratorium Komputer</td>
                        <td class="h-[72px] px-4 py-2">
                            <div class="flex gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">visibility</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">edit</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"><span
                                        class="material-symbols-outlined !text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">5</td>
                        <td class="h-[72px] px-4 py-2 text-gray-800 dark:text-gray-100 font-medium">
                            Rapat Evaluasi Bulanan</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">2024-08-15
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">14:00</td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">15:30</td>
                        <td class="h-[72px] px-4 py-2">
                            <span
                                class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 text-xs font-medium">Rutin</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-gray-600 dark:text-gray-300">Ruang Rapat
                            A</td>
                        <td class="h-[72px] px-4 py-2">
                            <div class="flex gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">visibility</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-white/10 dark:text-gray-400"><span
                                        class="material-symbols-outlined !text-[20px]">edit</span></button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"><span
                                        class="material-symbols-outlined !text-[20px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Table Pagination -->
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
