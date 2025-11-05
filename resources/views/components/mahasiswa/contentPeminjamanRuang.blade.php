<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Section: Data Ruangan -->
    <div class="lg:col-span-2 bg-white dark:bg-background-dark rounded-xl p-6">
        <h2 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] mb-4">
            Data Ruangan</h2>
        <!-- SearchBar -->
        <div class="mb-4">
            <label class="flex flex-col min-w-40 h-12 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                    <div
                        class="text-gray-500 dark:text-gray-400 flex border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-lg border-r-0">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary focus:ring-opacity-50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-primary h-full placeholder:text-gray-500 dark:placeholder-text-gray-400 px-4 border-l-0 text-base font-normal"
                        placeholder="Cari ruangan" value="" />
                </div>
            </label>
        </div>
        <!-- Table -->
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    scope="col">Nama Ruangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"
                                    scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    A</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Available</span>
                                </td>
                            </tr>
                            <tr
                                class="bg-primary/10 dark:bg-primary/20 hover:bg-primary/20 dark:hover:bg-primary/30 cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary">B
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">In
                                        Use</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    Lab Elektronik</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Available</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    Auditorium</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Available</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Section: Data Ketersediaan -->
    <div class="lg:col-span-1 bg-white dark:bg-background-dark rounded-xl p-6 flex flex-col gap-6">
        <div>
            <h2 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] mb-2">
                Data Ketersediaan</h2>
            <div class="flex items-center justify-between text-gray-600 dark:text-gray-400">
                <button class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                </button>
                <p class="text-sm font-medium">01 Jan 2025</p>
                <button class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                </button>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
        <div>
            <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Jadwal Ruangan B</h3>
            <div class="space-y-2">
                <div class="flex justify-between items-center p-3 rounded-lg bg-gray-100 dark:bg-gray-800">
                    <p class="text-sm text-gray-900 dark:text-white font-medium">12:00 - 13:00</p>
                    <p class="text-sm text-red-600 dark:text-red-400">Booked</p>
                </div>
                <div class="flex justify-between items-center p-3 rounded-lg bg-gray-100 dark:bg-gray-800">
                    <p class="text-sm text-gray-900 dark:text-white font-medium">13:00 - 15:00</p>
                    <p class="text-sm text-red-600 dark:text-red-400">Booked</p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700"></div>
        <!-- Form Pengajuan -->
        <div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Form Pengajuan Jam Agenda
            </h3>
            <form class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1"
                            for="jam-mulai">Jam Mulai</label>
                        <input
                            class="form-input block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm"
                            id="jam-mulai" type="time" value="12:00" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1"
                            for="jam-selesai">Jam Selesai</label>
                        <input
                            class="form-input block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm"
                            id="jam-selesai" type="time" value="13:00" />
                    </div>
                </div>
                <button
                    class="w-full flex items-center justify-center gap-2 rounded-lg bg-primary h-10 px-4 text-white text-sm font-medium shadow-sm hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                    type="submit">
                    <span class="material-symbols-outlined text-base">add_shopping_cart</span>
                    <span>Add to Cart</span>
                </button>
            </form>
        </div>
    </div>
</div>
