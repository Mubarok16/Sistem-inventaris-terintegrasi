<main class="flex-1 p-8">
    <div class="layout-content-container flex flex-col max-w-full flex-1">
        <!-- PageHeading -->
        <header class="flex flex-wrap justify-between gap-4 pb-8 items-center">
            <div class="flex flex-col gap-1">
                <p class="text-3xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
                    Riwayat Peminjaman</p>
                <p class="text-base font-normal leading-normal text-gray-500 dark:text-gray-400">Lihat
                    riwayat peminjaman barang dan ruangan Anda.</p>
            </div>
            <button
                class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-wide shadow-sm hover:bg-primary/90 disabled:bg-gray-300 dark:disabled:bg-gray-600 disabled:cursor-not-allowed"
                disabled="">
                <span class="truncate">Cetak QR</span>
            </button>
        </header>
        <!-- SectionHeader for Barang -->
        <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white px-4 pb-3 pt-5">
            Riwayat Peminjaman Barang</h2>
        <!-- Table for Barang -->
        <div class="px-4 py-3 @container">
            <div
                class="flex overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Nama</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Tgl Pinjam</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Tgl Kembali</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Qty</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Status</th>
                            <th
                                class="px-4 py-3 text-center text-sm font-medium leading-normal text-gray-600 dark:text-gray-300 w-28">
                                Cetak QR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-800 dark:text-gray-200">
                                Proyektor InFocus</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                15/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                16/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                1</td>
                            <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                                <span
                                    class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-xs font-medium text-success">Returned</span>
                            </td>
                            <td class="h-[72px] px-4 py-2 text-center text-sm font-normal leading-normal">
                                <input
                                    class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-primary focus:ring-primary/50"
                                    type="checkbox" />
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-800 dark:text-gray-200">
                                Laptop Dell XPS</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                12/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                14/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                1</td>
                            <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                                <span
                                    class="inline-flex items-center rounded-full bg-danger/10 px-3 py-1 text-xs font-medium text-danger">Overdue</span>
                            </td>
                            <td class="h-[72px] px-4 py-2 text-center text-sm font-normal leading-normal">
                                <input
                                    class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-primary focus:ring-primary/50"
                                    type="checkbox" />
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-800 dark:text-gray-200">
                                Kabel HDMI</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                10/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                10/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                2</td>
                            <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                                <span
                                    class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-xs font-medium text-success">Returned</span>
                            </td>
                            <td class="h-[72px] px-4 py-2 text-center text-sm font-normal leading-normal">
                                <input
                                    class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-primary focus:ring-primary/50"
                                    type="checkbox" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- SectionHeader for Ruangan -->
        <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white px-4 pb-3 pt-10">
            Riwayat Peminjaman Ruangan</h2>
        <!-- Table for Ruangan -->
        <div class="px-4 py-3 @container">
            <div
                class="flex overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Nama Ruangan</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Tgl Pinjam</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Jam Mulai</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Jam Selesai</th>
                            <th class="px-4 py-3 text-sm font-medium leading-normal text-gray-600 dark:text-gray-300">
                                Status</th>
                            <th
                                class="px-4 py-3 text-center text-sm font-medium leading-normal text-gray-600 dark:text-gray-300 w-28">
                                Cetak QR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-800 dark:text-gray-200">
                                Ruang Rapat A</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                20/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                09:00</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                11:00</td>
                            <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                                <span
                                    class="inline-flex items-center rounded-full bg-success/10 px-3 py-1 text-xs font-medium text-success">Completed</span>
                            </td>
                            <td class="h-[72px] px-4 py-2 text-center text-sm font-normal leading-normal">
                                <input
                                    class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-primary focus:ring-primary/50"
                                    type="checkbox" />
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-800 dark:text-gray-200">
                                Laboratorium Komputer</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                18/08/2023</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                13:00</td>
                            <td
                                class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-gray-500 dark:text-gray-400">
                                15:00</td>
                            <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                                <span
                                    class="inline-flex items-center rounded-full bg-warning/10 px-3 py-1 text-xs font-medium text-warning">In
                                    Use</span>
                            </td>
                            <td class="h-[72px] px-4 py-2 text-center text-sm font-normal leading-normal">
                                <input
                                    class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-primary focus:ring-primary/50"
                                    type="checkbox" />
                            </td>
                        </tr>
                        <!-- Empty State Example -->
                        <!--
                                <tr>
                                    <td colspan="6" class="h-32 text-center text-gray-500 dark:text-gray-400">
                                        Anda belum memiliki riwayat peminjaman ruangan.
                                    </td>
                                </tr>
                                -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
