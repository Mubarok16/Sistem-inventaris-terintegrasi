<div class="bg-white rounded-xl shadow-sm p-6">
    <!-- ToolBar -->
    <div class="flex justify-between items-center gap-4 mb-4">
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
        <button @click="AddRuangan = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <i class="fa-solid fa-plus material-symbols-outlined text-sm"></i>
            <span>Add Akun</span>
        </button>
    </div>
    <!-- Data Table -->
    <div class="max-h-70 overflow-y-auto overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-primary text-white ">
                    <th class="px-4 py-3 text-sm font-medium ">
                        ID
                    </th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Nama</th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Tipe</th>
                    <th class="px-4 py-3 text-sm font-medium">
                        List Barang</th>
                    <th class="px-4 py-3 text-sm font-medium">
                        Kondisi</th>
                    <th class="px-4 py-3 text-sm font-medium ">
                        Gambar</th>
                    <th class="px-4 py-3 text-sm font-medium  text-center">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($AkunUsers as $akunUser) --}}
                <tr class="border-b border-slate-200 ">
                    <td class="px-4 py-3 text-sm font-normal  ">
                        R001
                    </td>
                    <td class="px-4 py-3 text-sm font-normal ">
                        Lab Komputer
                    </td>
                    <td class="px-4 py-3 text-sm font-normal">
                        Laboratorium
                    </td>
                    <td class="px-4 py-3">
                        <a href="">Lihat</a>
                    </td>
                    <td class="px-4 py-3">
                        baik
                    </td>
                    <td class="px-4 py-3 text-sm font-normal">
                        <button class="p-2 text-slate-900 hover:text-blue-500 text-center"
                            @click="OpenImgRuangan = true;">
                            <span class="material-symbols-outlined text-sm fa-solid fa-image"></span>
                        </button>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button @click="EditRuangan = true;" class="p-2 text-slate-900 hover:text-blue-500">
                            <span class="material-symbols-outlined text-sm fa-solid fa-pen-to-square"></span>
                        </button>
                        <button class="p-2 text-slate-900 hover:text-red-500" @click="DeleteRuangan = true;">
                            <span class="material-symbols-outlined text-sm fa-solid fa-trash-can"></span>
                        </button>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
