<div class="bg-white dark:bg-[#182431] rounded-xl shadow-sm p-6">
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
    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-6 py-3" scope="col">ID</th>
                    <th class="px-6 py-3" scope="col">Image</th>
                    <th class="px-6 py-3" scope="col">Nama Ruangan</th>
                    <th class="px-6 py-3" scope="col">Type</th>
                    <th class="px-6 py-3" scope="col">List Barang</th>
                    <th class="px-6 py-3 text-center" scope="col">Qty</th>
                    <th class="px-6 py-3" scope="col">Kondisi</th>
                    <th class="px-6 py-3 text-center" scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b dark:bg-[#182431] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        R001</td>
                    <td class="px-6 py-4">
                        <div class="w-16 h-10 bg-cover bg-center rounded-md" data-alt="Image of a computer lab"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC_smzQIln4p2V5sVTF3bbqrFpCOJjXCZjsAgywSvSyzCRnakVNl9DQRJm3Hv2O52B4-FpvrA7-pnEfCBm7IBZSL8cxr7k8GCVco0Ly0if4TcQFA9TLg3ZEv6Bc9tsgjRGRKv3H2MweLO42nZYfV-clorQVRpV4iLtcX67zjBWR1XW5IiDXqi9X4KsOQN3Wh3es4YJndUp7fB1_xg6mOTPvuJJPTUUmA7eZSyoBlz1LCJo2EqJGxIF6lpcok6roYpN9UvJhJNrD9ael')">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Laboratorium
                        Komputer 1</td>
                    <td class="px-6 py-4">Laboratorium</td>
                    <td class="px-6 py-4">
                        <button class="text-primary hover:underline text-sm font-medium">Lihat
                            Daftar</button>
                    </td>
                    <td class="px-6 py-4 text-center">25</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success/20 text-success dark:bg-success/30">berfungsi</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button aria-label="Detail"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span
                                    class="material-symbols-outlined text-lg text-gray-600 dark:text-gray-300">visibility</span>
                            </button>
                            <button aria-label="Edit"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span class="material-symbols-outlined text-lg text-primary">edit</span>
                            </button>
                            <button aria-label="Delete"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span class="material-symbols-outlined text-lg text-danger">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr
                    class="bg-white border-b dark:bg-[#182431] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        R002</td>
                    <td class="px-6 py-4">
                        <div class="w-16 h-10 bg-cover bg-center rounded-md" data-alt="Image of a classroom"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBS29zG7D3dRlwWi4jhDOwDJigKH6Na_3k4spMEx-QddxtAU0vuoTrlnPeeT-xKw8ycNdZf3PlrEVkJupJKVjfB0yXPJ8ugRnKEAl2NcF5RiE5T9xe4FDK3LvMfg7IuLhx90iVdv6eIO6ScgwilRpTfqxNRvWSrVhvJifKYz3QTG3nEPVc6phFLa-bIilzsxP-e7uNswyQOaQTo2cs5z69CLea50m2-9V2S-MtEC40vhz5bdOh_sNX-cV35gjufpcJjnlIID5YeRKw-')">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Ruang Kelas A.1
                    </td>
                    <td class="px-6 py-4">Kelas</td>
                    <td class="px-6 py-4">
                        <button class="text-primary hover:underline text-sm font-medium">Lihat
                            Daftar</button>
                    </td>
                    <td class="px-6 py-4 text-center">30</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success/20 text-success dark:bg-success/30">berfungsi</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button aria-label="Detail"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span
                                    class="material-symbols-outlined text-lg text-gray-600 dark:text-gray-300">visibility</span>
                            </button>
                            <button aria-label="Edit"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span class="material-symbols-outlined text-lg text-primary">edit</span>
                            </button>
                            <button aria-label="Delete"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span class="material-symbols-outlined text-lg text-danger">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-white dark:bg-[#182431] hover:bg-gray-50 dark:hover:bg-gray-800">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        R003</td>
                    <td class="px-6 py-4">
                        <div class="w-16 h-10 bg-cover bg-center rounded-md" data-alt="Image of a storage room"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAnGXap7SAte8RC27KsKKuZZ6zlL0Kcx9bnpQTpgFRBVZZQvrMGbw0qbDsrXQly_9dmNzx4SqgitMtvCZr0S2o8_JkmSSW390dXOP1jgyQTzU_2s79HS_xId2GJphdZPpLQ4_mLQQaeWva27EA8XXqU9VA_suiwXLe4V_jQHd4dLMll7McMUq2Al-U5tZhEcg3S6MDjcZAGPX1sRattd1yye7fp2e9bDABenrpzUGReXHDa4176ScrX8FzqPqfmm2XgHrSFmt1T1Df4')">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Gudang Penyimpanan
                    </td>
                    <td class="px-6 py-4">Gudang</td>
                    <td class="px-6 py-4">
                        <button class="text-primary hover:underline text-sm font-medium">Lihat
                            Daftar</button>
                    </td>
                    <td class="px-6 py-4 text-center">150</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger/20 text-danger dark:bg-danger/30">Rusak</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button aria-label="Detail"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span
                                    class="material-symbols-outlined text-lg text-gray-600 dark:text-gray-300">visibility</span>
                            </button>
                            <button aria-label="Edit"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span class="material-symbols-outlined text-lg text-primary">edit</span>
                            </button>
                            <button aria-label="Delete"
                                class="p-1.5 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                <span class="material-symbols-outlined text-lg text-danger">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
