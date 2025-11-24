<!-- Main card for table -->
<div class="bg-white py-4 px-3 rounded-sm shadow-md">
    <!-- ToolBar -->
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
        <button @click="AddDataBarang = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Agenda</span>
        </button>
    </div>
    <!-- Table -->
    <div class=" py-3 @container">
        <div class="flex overflow-hidden">
            <table class="w-full text-left">
                <thead class="sticky top-0 z-1">
                    <tr class="bg-primary text-white ">
                        <th class="px-4 py-3 text-sm font-medium">
                            ID</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Keterangan Agenda</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Tanggal</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Jam Mulai</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Jam Selesai</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Tipe Agenda</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Ruangan</th>
                        <th class="px-4 py-3 text-sm font-medium">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm font-normal">1</td>
                        <td class="px-4 py-3 text-sm font-normal">
                            Rapat Dosen Awal Semester</td>
                        <td class="px-4 py-3 text-sm font-normal">2024-08-01
                        </td>
                        <td class="px-4 py-3 text-sm font-normal">09:00</td>
                        <td class="px-4 py-3 text-sm font-normal">11:00</td>
                        <td class="px-4 py-3 text-sm font-normal">
                            <span
                                class="truncate inline-flex items-center justify-center rounded-full h-7 px-3 bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 text-xs font-medium">Rutin</span>
                        </td>
                        <td class="px-4 py-3 text-sm font-normal">Ruang Rapat
                            A</td>
                        <td class="px-4 py-3 text-sm font-normal">
                            <div class="flex items-center gap-2">
                                <button
                                    class="px-3 py-1.5 text-sm font-medium text-white bg-primary rounded-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-background-dark">Detail</button>
                                <button
                                    class="px-3 py-1.5 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-background-dark">Approve</button>
                                <button
                                    class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-background-dark">Reject</button>
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
