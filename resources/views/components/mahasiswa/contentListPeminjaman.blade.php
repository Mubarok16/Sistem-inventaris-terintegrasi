<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <!-- Left Column: Carts -->
    <div class="lg:col-span-2 flex flex-col gap-8">
        <!-- Cart Peminjaman Barang -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6">
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] mb-4">
                Cart Peminjaman Barang</h2>
            <div class="overflow-x-auto @container">
                <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-background-light dark:bg-background-dark">
                            <tr>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Nama</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Tgl Pinjam</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Tgl Kembali</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Qty</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#dbe0e6] dark:divide-gray-700">
                            <tr>
                                <td class="px-4 py-3 text-[#111418] dark:text-white">Proyektor</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">25/10/2024</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">26/10/2024</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">1</td>
                                <td class="px-4 py-3">
                                    <button class="text-destructive font-bold flex items-center gap-1 hover:underline">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-[#111418] dark:text-white">Kabel HDMI</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">25/10/2024</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">26/10/2024</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">2</td>
                                <td class="px-4 py-3">
                                    <button class="text-destructive font-bold flex items-center gap-1 hover:underline">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Cart Peminjaman Ruangan -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6">
            <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] mb-4">
                Cart Peminjaman Ruangan</h2>
            <div class="overflow-x-auto @container">
                <div class="border border-[#dbe0e6] dark:border-gray-700 rounded-lg overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-background-light dark:bg-background-dark">
                            <tr>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Nama</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Tgl Pinjam</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Jam Mulai</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Jam Selesai</th>
                                <th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 font-medium">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#dbe0e6] dark:divide-gray-700">
                            <tr>
                                <td class="px-4 py-3 text-[#111418] dark:text-white">Ruang Meeting A1
                                </td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">28/10/2024</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">09:00</td>
                                <td class="px-4 py-3 text-[#60758a] dark:text-gray-400">11:00</td>
                                <td class="px-4 py-3">
                                    <button class="text-destructive font-bold flex items-center gap-1 hover:underline">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <!-- Empty state example -->
                            <!-- <tr>
                                                <td colspan="6" class="text-center p-8 text-gray-500 dark:text-gray-400">
                                                    Keranjang ruangan masih kosong.
                                                </td>
                                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Column: Submission Form -->
    <div class="lg:col-span-1 space-y-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6">
            <h3 class="text-[#111418] dark:text-white text-lg font-bold mb-4">Data Pengaju</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Nama</span>
                    <span class="font-medium text-[#111418] dark:text-white">Ahmad</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Identitas</span>
                    <span class="font-medium text-[#111418] dark:text-white">56120XXXXXX</span>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-6">
            <h3 class="text-[#111418] dark:text-white text-lg font-bold mb-4">File Pengajuan</h3>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="keterangan">Isi
                        Keterangan Peminjaman</label>
                    <textarea
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-primary focus:ring-primary"
                        id="keterangan" name="keterangan" rows="4"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        for="lampiran">Lampiran</label>
                    <input
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/20 file:text-primary hover:file:bg-primary/30 cursor-pointer"
                        id="lampiran" name="lampiran" type="file" />
                </div>
                <button
                    class="w-full bg-primary text-white font-bold py-2 px-4 rounded-lg hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                    type="submit">
                    Ajukan Peminjaman
                </button>
            </form>
        </div>
    </div>
</div>
