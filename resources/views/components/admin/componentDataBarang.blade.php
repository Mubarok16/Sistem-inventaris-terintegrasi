<!-- Main Content -->

<div class="bg-white dark:bg-gray-800/50 p-6 rounded-xl shadow-sm">
    <!-- PageHeading & Actions -->
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
    <!-- Table -->
    <div class="@container">
        <div
            class="flex overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-transparent">
            <table class="w-full">
                <thead class="bg-background-light dark:bg-gray-900/50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 w-20 text-xs font-medium uppercase tracking-wider">
                            ID</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 w-16 text-xs font-medium uppercase tracking-wider">
                            Image</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 w-1/4 text-xs font-medium uppercase tracking-wider">
                            Nama Barang</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">
                            Type</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">
                            Tempat Menyimpan</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 w-20 text-xs font-medium uppercase tracking-wider">
                            Qty</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 w-40 text-xs font-medium uppercase tracking-wider">
                            Kondisi</th>
                        <th
                            class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 w-32 text-xs font-medium uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            001</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg w-10"
                                data-alt="Proyektor Epson EB-X500"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAd8wWd5nZuVhel55Qk_GKq_Ky9x5H-yfI2hBYlDrSZ5ZeRA5XPTwy4IPftBJUxh88ijCvBcuivk4KOMrJ-MtliaMrmCkkOs2zGQboXcvDE-phfXIBfWMxgLs1t8PGWLe0uFRoG3H8h2FRN5JXDiuc215sOimkE4TlQTPKcvUQZ-6INPB7TbN1QQAOB_1cdY5bp7pxcSdj12lp3fGNbqpE2r6qaX6SrIbYhZZi6ZAtfMTlh3f8TbFhVWCVtyoGu8lL19nJDnAk6tCbG");'>
                            </div>
                        </td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#111418] dark:text-white text-sm font-medium leading-normal">
                            Proyektor Epson EB-X500</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Elektronik</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Gudang A</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            5</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <span
                                class="inline-flex items-center rounded-full h-6 px-3 bg-success/20 text-success text-xs font-medium">Berfungsi</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-bold leading-normal tracking-[0.015em]">
                            <div class="flex items-center gap-2">
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">edit</span></button>
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-danger dark:hover:text-danger hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            002</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg w-10"
                                data-alt="Laptop Dell Latitude 5420"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDnFozga3oUXS9TPbWTRW6H61M_MG7uTMug_kbg2EvniCGLvxPuNMaF06QsEdaPRQ25pEO2mAA4THkBcxj7pZFJE3muGKAHQpRwR5_7de4KfzO4ooNxwMUKhYwDd1G0-YcCJUm3sKec6i31-WbInjOLn35_6yKxxCIgi8Yf_n5dHwNqiakePmoNI_lqTjp4FfL7UEDziHZofafIOJHK00O26-oTqdbKXr7DOtn4qpR3QNYMoPVEQ_xp0TZvpGAMs70qfryRHgiD31jq");'>
                            </div>
                        </td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#111418] dark:text-white text-sm font-medium leading-normal">
                            Laptop Dell Latitude 5420</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Elektronik</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Lab Komputer</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            20</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <span
                                class="inline-flex items-center rounded-full h-6 px-3 bg-success/20 text-success text-xs font-medium">Berfungsi</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-bold leading-normal tracking-[0.015em]">
                            <div class="flex items-center gap-2">
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">edit</span></button>
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-danger dark:hover:text-danger hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            003</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg w-10"
                                data-alt="Papan Tulis Gantung"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDvygxMCLTqa5z5Gx7KxFmlsjyvU90_KWqpHVxUmRUfOHtaROrpP5oQDIAMaalFnZdEUATKL85J48wLbsTMrbKEe-qXOinKxRiUuuBQihMRjrQMA-UE63aWuqX16r7Zgf_RvqQopam_13UNWIkA4WPIBKx2Dv3C8foOoDEemgHUHUeiE8pD6SosbCYN1dhFTApnOsoaCWCBpDOH0k5Qj_6CXWQTiW5YTmz4V6oNcGaG7FWC5WIioEPOyqJ6z8GIvUS0xLjHBFV8ycv0");'>
                            </div>
                        </td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#111418] dark:text-white text-sm font-medium leading-normal">
                            Papan Tulis Gantung</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Perabotan</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Ruang Kelas 101</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            1</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <span
                                class="inline-flex items-center rounded-full h-6 px-3 bg-danger/20 text-danger text-xs font-medium">Rusak</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-bold leading-normal tracking-[0.015em]">
                            <div class="flex items-center gap-2">
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">edit</span></button>
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-danger dark:hover:text-danger hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            004</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg w-10"
                                data-alt="Kursi Kuliah"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCdi2xO_B58uIknYCMfA4Q0Xx6zdzcTfa-nYyCmTY2qxFvBD-MGvxAadnLBC4a0PolSfXtP5xM4PRB4FCuLXcJlJiPE1FP3AbORC1EW9Bqo45fFbcFi0bXqVkBgOd1AaDvU85iAv1-uWV2nOzjOxaazaHBoq8cbB5rLVkVLRnr2fgaxlj3lbgyHBRVUSobawew6FcK14kaNz8vITIFtfNfvMOteI46UGrYW5qcG2IzfZZnSzAXWDa1gSL2Fu9I6B9pqE_V0Ccqv_QfB");'>
                            </div>
                        </td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#111418] dark:text-white text-sm font-medium leading-normal">
                            Kursi Kuliah</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Perabotan</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Gudang B</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            50</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <span
                                class="inline-flex items-center rounded-full h-6 px-3 bg-success/20 text-success text-xs font-medium">Berfungsi</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-bold leading-normal tracking-[0.015em]">
                            <div class="flex items-center gap-2">
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">edit</span></button>
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-danger dark:hover:text-danger hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            005</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg w-10"
                                data-alt="Router Cisco 2901"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCPottyIPwD-yNuQqQ7lZQj9eYofIJcUnkWu2XUYSjXcv-j20t2uTdvSRF9AuRDE2rxMJXRFE4SGb7dBZq_0LWizqKtSCutVRta92jx_rGFEH8TyHLk8hEPtEbNg3pIQDDiBU-3KJMCPfiFnVxZg3k7RrejJe1_PSUyf7FtTKHAhUu6iJT-55bLvKs0Ep5tqE-ag29yawtzRHDaGk8PSbD2zr4rwPiZnXrllq7zzXopPcD4zwtkO_5kWjebUlXp8g6kvZTgNkuOOClm");'>
                            </div>
                        </td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#111418] dark:text-white text-sm font-medium leading-normal">
                            Router Cisco 2901</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Jaringan</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            Ruang Server</td>
                        <td
                            class="h-[72px] px-4 py-2 text-[#60758a] dark:text-gray-400 text-sm font-normal leading-normal">
                            2</td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <span
                                class="inline-flex items-center rounded-full h-6 px-3 bg-success/20 text-success text-xs font-medium">Berfungsi</span>
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-bold leading-normal tracking-[0.015em]">
                            <div class="flex items-center gap-2">
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">edit</span></button>
                                <button
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-danger dark:hover:text-danger hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full"><span
                                        class="material-symbols-outlined !text-xl">delete</span></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
