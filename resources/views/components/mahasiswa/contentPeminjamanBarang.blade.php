{{-- <div class="row g-2">
    <div class="col-md-8 ">
        <div class="bg-amber-500">
            peminjaman barang
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-amber-500">
            cek
        </div>
    </div>
</div> --}}

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Data Barang -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm p-4">
            <!-- SearchBar -->
            <label class="flex flex-col w-full">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-12">
                    <div
                        class="text-[#60758a] dark:text-slate-400 flex bg-background-light dark:bg-background-dark items-center justify-center pl-4 rounded-l-lg">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-[#111418] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border-none bg-background-light dark:bg-background-dark h-full placeholder:text-[#60758a] dark:placeholder:text-slate-400 px-4 pl-2 text-base font-normal leading-normal"
                        placeholder="Search for items..." value="" />
                </div>
            </label>
        </div>
        <!-- Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-background-light dark:bg-background-dark">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-[#111418] dark:text-slate-300 text-sm font-medium leading-normal">
                                Nama Barang</th>
                            <th
                                class="px-6 py-3 text-left text-[#111418] dark:text-slate-300 text-sm font-medium leading-normal">
                                Kategori</th>
                            <th
                                class="px-6 py-3 text-left text-[#111418] dark:text-slate-300 text-sm font-medium leading-normal">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                            <td class="px-6 py-4 whitespace-nowrap text-[#111418] dark:text-white text-sm font-normal">
                                Infocus</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-[#60758a] dark:text-slate-400 text-sm font-normal">
                                Elektronik</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">Tersedia</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                            <td class="px-6 py-4 whitespace-nowrap text-[#111418] dark:text-white text-sm font-normal">
                                Kursi Chitos</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-[#60758a] dark:text-slate-400 text-sm font-normal">
                                Furnitur</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">Tidak
                                    Tersedia</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                            <td class="px-6 py-4 whitespace-nowrap text-[#111418] dark:text-white text-sm font-normal">
                                Proyektor</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-[#60758a] dark:text-slate-400 text-sm font-normal">
                                Elektronik</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">Tersedia</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                            <td class="px-6 py-4 whitespace-nowrap text-[#111418] dark:text-white text-sm font-normal">
                                Papan Tulis</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-[#60758a] dark:text-slate-400 text-sm font-normal">
                                Peralatan Kantor</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">Tersedia</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                            <td class="px-6 py-4 whitespace-nowrap text-[#111418] dark:text-white text-sm font-normal">
                                Meja Rapat</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-[#60758a] dark:text-slate-400 text-sm font-normal">
                                Furnitur</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300">Tidak
                                    Tersedia</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Right Column: Data Ketersediaan -->
    <div class="lg:col-span-1 bg-white dark:bg-slate-900 rounded-xl shadow-sm p-6 flex flex-col gap-6 h-fit">
        <div>
            <!-- PageHeading -->
            <h2 class="text-[#111418] dark:text-white tracking-light text-xl font-bold leading-tight">
                Cek Ketersediaan &amp; Ajukan Peminjaman</h2>
            <p class="text-sm text-[#60758a] dark:text-slate-400 mt-1">Data Ketersediaan untuk: <span
                    class="font-semibold text-[#111418] dark:text-white">01/Jan/2025</span></p>
        </div>
        <div class="border rounded-lg border-slate-200 dark:border-slate-800">
            <table class="w-full text-sm">
                <thead class="bg-background-light dark:bg-background-dark">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-[#111418] dark:text-slate-300">
                            Item</th>
                        <th class="px-4 py-2 text-right font-medium text-[#111418] dark:text-slate-300">
                            Tersedia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <tr>
                        <td class="px-4 py-2 text-[#111418] dark:text-white">Infocus</td>
                        <td class="px-4 py-2 text-right text-[#60758a] dark:text-slate-400">2</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 text-[#111418] dark:text-white">Proyektor</td>
                        <td class="px-4 py-2 text-right text-[#60758a] dark:text-slate-400">5</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-800 pt-6">
            <h3 class="text-lg font-semibold text-[#111418] dark:text-white">Form Pengajuan</h3>
            <form class="flex flex-col gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-[#60758a] dark:text-slate-400 mb-1"
                        for="qty">Jumlah Pinjam</label>
                    <input
                        class="form-input w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-[#111418] dark:text-white placeholder:text-slate-400 focus:ring-primary focus:border-primary"
                        id="qty" name="qty" placeholder="e.g., 1" type="number" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#60758a] dark:text-slate-400 mb-1"
                        for="return_date">Tanggal Kembali</label>
                    <input
                        class="form-input w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-[#111418] dark:text-white focus:ring-primary focus:border-primary"
                        id="return_date" name="return_date" type="date" />
                </div>
                <button
                    class="w-full flex items-center justify-center gap-2 h-10 px-4 mt-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-slate-900"
                    type="submit">
                    <span class="material-symbols-outlined text-base">add_shopping_cart</span>
                    <span>Add to Cart</span>
                </button>
            </form>
        </div>
    </div>
</div>
