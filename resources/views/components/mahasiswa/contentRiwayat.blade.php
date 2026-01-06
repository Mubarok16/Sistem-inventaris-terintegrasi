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

{{-- <main class="flex-1 p-8">
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
</main> --}}

<div class="relative flex min-h-screen flex-col">
    <main class="flex-1 flex flex-col items-center py-8 px-4 md:px-10 lg:px-20">
        <div class="w-full max-w-[1024px] flex flex-col gap-6">
            <!-- Controls: Search & Filter -->

            <!-- Filters -->
            {{-- menu sortir --}}
            {{-- <form action="{{ route('pilih-data-pengelolaan-peminjaman-by-status') }}" method="post"> --}}
            <div
                class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
                @csrf
                <div class="flex! gap-1 bg-slate-100 p-1 rounded-lg w-full sm:w-auto overflow-x-auto">
                    <button value="semua" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-white rounded shadow-sm transition-all whitespace-nowrap">
                        Semua
                    </button>
                    <button value="diajukan" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Menunggu
                    </button>
                    <button value="ditolak" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Ditolak
                    </button>
                    <button value="terjadwal" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Terjadwal
                    </button>
                    <button value="dipinjam" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Dipinjam
                    </button>
                    <button value="terlambat" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Terlambat
                    </button>
                    <button value="selesai" name="status"
                        class="px-4 py-2 text-sm font-medium text-slate-500 transition-all whitespace-nowrap">
                        Selesai
                    </button>
                </div>

            </div>
            {{-- </form> --}}

            <!-- Content List -->
            <div class="flex flex-col gap-4">
                <!-- Item 1: Active Loan -->
                <div
                    class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow p-5 flex flex-col md:flex-row gap-5 items-start md:items-center relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                    <!-- Thumbnail -->
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg bg-slate-100 bg-cover bg-center border border-slate-100"
                            data-alt="Epson Projector device"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBfCAqy59Kpi4CO10P9Hlf89XIamSWM5hhHYRGztkuSkOSghBDNFPZ4GksGc5aHppFQPq6uA1uzZAuO0uJRErCGo1d08XUNlEEIIJrZGWxAkt3QYepLoMaW51DYeE_VAVWsBSzWAzAbBUrEPeThEQkEDgeZOg9vuXlU5O2IvsvNwcT9jmMNJ-icAZczUKMgAi32i5uN7GOnzKS-7Lv04v5IUdVA9rYIL2bDjMCPwjkfHxm89vQVQtqXFsuOj1gFV5O5e9uLR1YW2zU");'>
                        </div>
                    </div>
                    <!-- Info -->
                    <div class="flex-1 min-w-0 flex flex-col gap-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-xs font-semibold tracking-wider text-slate-500 uppercase">INV-20231024-001</span>
                            <span
                                class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium border border-blue-200">Sedang
                                Dipinjam</span>
                        </div>
                        <h3
                            class="text-lg md:text-xl font-bold text-slate-900 truncate group-hover:text-primary transition-colors cursor-pointer">
                            Proyektor Epson EB-X05
                        </h3>
                        <p class="text-sm text-slate-500 truncate">
                            + 2 Kabel HDMI, 1 Remote Control
                        </p>
                        <div class="flex items-center gap-4 mt-2 text-sm">
                            <div class="flex items-center gap-1.5 text-slate-600">
                                <span class="material-symbols-outlined text-lg">calendar_month</span>
                                <span>Pinjam: <span class="font-medium text-slate-900">24 Okt
                                        2023</span></span>
                            </div>
                            <div class="flex items-center gap-1.5 text-orange-600">
                                <span class="material-symbols-outlined text-lg">event_busy</span>
                                <span>Kembali: <span class="font-bold">26 Okt 2023</span></span>
                            </div>
                        </div>
                    </div>
                    <!-- Action -->
                    <div class="w-full md:w-auto mt-2 md:mt-0 flex md:flex-col gap-2">
                        <button
                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-primary text-slate-700 hover:text-primary rounded-lg text-sm font-medium transition-all">
                            <span>Detail</span>
                        </button>
                    </div>
                </div>
                <!-- Item 2: Returned -->
                <div
                    class="group bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex flex-col md:flex-row gap-5 items-start md:items-center relative">
                    <!-- Thumbnail -->
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg bg-slate-100 bg-cover bg-center border border-slate-100"
                            data-alt="Modern minimalist meeting room interior"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCbznLrgaodNAZGGU6d-9TrH5ZgXHv7wM2V5GqFQ4oZeBroSKNQ46bgkXRcLZLOTwY5fkYt9H_SC1g9bfgeOiWS_cDDrmx75s7UYZE4_LhC7nfLtBVxfvA7UUcXzZmaj0Co7h3FgzxqkTXdUPwj6sTwvxevllxrTpW12p6poLOPkPl7yo_iBZ0Tquo0T5KjSONaL6gZq1U9oT7dYOPaFp8tHVZ_e5eFJJWXPLFEJ1EaqoWiy7rbztuG2IgZCtRDotmAYoicRMKudzM");'>
                        </div>
                    </div>
                    <!-- Info -->
                    <div class="flex-1 min-w-0 flex flex-col gap-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-xs font-semibold tracking-wider text-slate-500 uppercase">ROOM-20231020-055</span>
                            <span
                                class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium border border-green-200">Sudah
                                Dikembalikan</span>
                        </div>
                        <h3
                            class="text-lg md:text-xl font-bold text-slate-900 truncate group-hover:text-primary transition-colors cursor-pointer">
                            Ruang Meeting Alpha
                        </h3>
                        <p class="text-sm text-slate-500 truncate">
                            Kapasitas 10 orang, Lantai 3
                        </p>
                        <div class="flex items-center gap-4 mt-2 text-sm">
                            <div class="flex items-center gap-1.5 text-slate-600">
                                <span class="material-symbols-outlined text-lg">calendar_month</span>
                                <span>20 Okt 2023, 09:00 - 11:00</span>
                            </div>
                        </div>
                    </div>
                    <!-- Action -->
                    <div class="w-full md:w-auto mt-2 md:mt-0 flex md:flex-col gap-2">
                        <button
                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-sm font-medium transition-colors">
                            <span>Detail</span>
                        </button>
                    </div>
                </div>
                <!-- Item 3: Returned -->
                <div
                    class="group bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex flex-col md:flex-row gap-5 items-start md:items-center relative">
                    <!-- Thumbnail -->
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg bg-slate-100 bg-cover bg-center border border-slate-100"
                            data-alt="Apple MacBook Pro laptop on a desk"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBa0V2gpwdn6gpJSKZAg_fMb8wDSPMd9dWSM2bjZZoQpe9h9O1-J0dEvLRDtCybXgLX0A-gNAESSdOUqsFtV8qf92oy5FXRQocNO--H-BsLPqw4EXUCfPBWohwmgTGZ3YyxRJnscxb4wYstuRtXYh-_0bFmtzA1eFqKfGq2LqLMpTsJGetaHnk7L8CXvSDx9ZdBvZeioxESjGGUIf6oZn3JYlt2GpfwwxlmoxOpJ6f9cxo-DaehkWqJNvXc5X78A-mP8NocepBh5OA");'>
                        </div>
                    </div>
                    <!-- Info -->
                    <div class="flex-1 min-w-0 flex flex-col gap-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-xs font-semibold tracking-wider text-slate-500 uppercase">INV-20231015-089</span>
                            <span
                                class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium border border-green-200">Sudah
                                Dikembalikan</span>
                        </div>
                        <h3
                            class="text-lg md:text-xl font-bold text-slate-900 truncate group-hover:text-primary transition-colors cursor-pointer">
                            MacBook Pro M1 13"
                        </h3>
                        <p class="text-sm text-slate-500 truncate">
                            Serial No: C02F...
                        </p>
                        <div class="flex items-center gap-4 mt-2 text-sm">
                            <div class="flex items-center gap-1.5 text-slate-600">
                                <span class="material-symbols-outlined text-lg">calendar_month</span>
                                <span>15 Okt 2023 - 18 Okt 2023</span>
                            </div>
                        </div>
                    </div>
                    <!-- Action -->
                    <div class="w-full md:w-auto mt-2 md:mt-0 flex md:flex-col gap-2">
                        <button
                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-sm font-medium transition-colors">
                            <span>Detail</span>
                        </button>
                    </div>
                </div>
                <!-- Item 4: Cancelled -->
                <div
                    class="group bg-slate-50 rounded-xl border border-slate-200 p-5 flex flex-col md:flex-row gap-5 items-start md:items-center relative opacity-80 hover:opacity-100 transition-opacity">
                    <!-- Thumbnail -->
                    <div class="relative shrink-0 grayscale">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg bg-slate-200 bg-cover bg-center border border-slate-100"
                            data-alt="Digital DSLR Camera"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPEwS06_IlMcBQfn4UtZnchVRLfnFW_CXsnB8Xn6QzC8FDHX-L2JzGPEmM_UC_jMohtE20NhM8teV_aCybdhiJf-x0-YjU-i2eWVrwH0E2jhfbvUUtTEZEwGwO9yqi1lSyaTLcNNydcDvs58yhp4XeqN1UirIICi_9E8bU1t0IjMgOdLcOorXBen80Qo9mwCUnYNR8kBXIzj9oneLJVglcaXnHiX7HxHnipSf-kXyDhfi5xOhOM_qYQlowV9xkxt1E75aJlvmdbZk");'>
                        </div>
                    </div>
                    <!-- Info -->
                    <div class="flex-1 min-w-0 flex flex-col gap-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-xs font-semibold tracking-wider text-slate-500 uppercase">INV-20231010-002</span>
                            <span
                                class="bg-slate-200 text-slate-600 text-xs px-2 py-0.5 rounded-full font-medium border border-slate-300">Dibatalkan</span>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-slate-700 truncate decoration-slate-400">
                            Kamera Canon EOS 80D
                        </h3>
                        <p class="text-sm text-slate-500 truncate">
                            Dibatalkan oleh pengguna
                        </p>
                        <div class="flex items-center gap-4 mt-2 text-sm">
                            <div class="flex items-center gap-1.5 text-slate-500">
                                <span class="material-symbols-outlined text-lg">event_busy</span>
                                <span>Diajukan: 10 Okt 2023</span>
                            </div>
                        </div>
                    </div>
                    <!-- Action -->
                    <div class="w-full md:w-auto mt-2 md:mt-0 flex md:flex-col gap-2">
                        <button
                            class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-transparent border border-slate-300 hover:bg-slate-100 text-slate-500 rounded-lg text-sm font-medium transition-colors">
                            <span>Detail</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-slate-200 pt-6 mt-2">
                <p class="text-sm text-slate-500">
                    Menampilkan <span class="font-medium text-slate-900">1</span> sampai <span
                        class="font-medium text-slate-900">4</span> dari <span
                        class="font-medium text-slate-900">12</span> riwayat
                </p>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-2 border border-slate-200 rounded-lg text-sm font-medium text-slate-600 bg-white hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled="">
                        Sebelumnya
                    </button>
                    <button
                        class="px-3 py-2 border border-slate-200 rounded-lg text-sm font-medium text-slate-600 bg-white hover:bg-slate-50">
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
