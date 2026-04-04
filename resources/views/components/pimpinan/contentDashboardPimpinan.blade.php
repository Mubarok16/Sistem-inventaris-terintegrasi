<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<body>
    <div class="flex-1 flex flex-col ">
        <main class="flex-1 p-6 lg:px-4 lg:py-2 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- <div class="stat-card bg-white p-6 border border-border-light rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <div class="size-10 bg-blue-50 text-primary rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">+5.2%</span>
                    </div>
                    <p class="text-text-muted text-xs font-bold uppercase tracking-wider">Okupansi Ruangan</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h3 class="text-3xl font-black text-text-main">85.4%</h3>
                        <livewire:pimpinan.okupansi-ruangan-perbulan />
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                        <div class="bg-primary h-full" style="width: 85.4%"></div>
                    </div>
                </div> --}}

                {{-- total okupansi ruangan --}}
                <div class="stat-card bg-white p-6 border border-border-light rounded-xl">
                    <livewire:pimpinan.okupansi-ruangan-perbulan />
                </div>

                {{-- total penggunaan barang --}}
                <div class="stat-card bg-white p-6 border border-border-light rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <div class="size-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        {{-- <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">Populer</span> --}}
                    </div>
                    <p class="text-text-muted text-xs font-bold uppercase tracking-wider">Total Penggunaan Barang</p>
                    {{-- <h3 class="text-xl font-bold text-text-main mt-1">Lab. Komputer 03</h3> --}}
                    <livewire:pimpinan.total-peminjaman-barang />

                    <p class="text-[10px] text-slate-400 mt-4 font-medium italic">
                        Total penggunaan barang perbulan.
                    </p>
                </div>

                {{-- total transaksi peminjaman --}}
                <div class="stat-card bg-white p-6 border border-border-light rounded-xl">
                    <div class="flex justify-between items-start mb-4">
                        <div class="size-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        {{-- <span
                            class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">+12.8%</span> --}}
                    </div>
                    <p class="text-text-muted text-xs font-bold uppercase tracking-wider">Total Transaksi Peminjaman</p>
                    {{-- <div class="flex items-baseline gap-2 mt-1">
                        <h3 class="text-3xl font-black text-text-main">1,240</h3>
                    </div> --}}
                    <livewire:pimpinan.total-transaksi-peminjaman />
                    <p class="text-[10px] text-slate-400 mt-4 font-medium italic">
                        Total transaksi peminjaman perbulan yang telah selesai diproses.
                    </p>
                </div>
            </div>

            {{-- chart --}}
            {{-- grid grid-cols-1 lg:grid-cols-2 gap-8  --}}
            <div class="mb-8">
                <!-- chart -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-primary"></i>
                            Tren Penggunaan Barang dan Ruangan
                        </h4>
                        {{-- <select
                            class="text-xs border-slate-200 rounded-lg font-medium focus:ring-primary focus:border-primary">
                            <option>7 Hari Terakhir</option>
                            <option>30 Hari Terakhir</option>
                        </select> --}}
                    </div>
                    <div id="chart"></div>

                </div>
                {{-- <div class="bg-white border border-border-light p-8 rounded-xl">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h4 class="text-lg font-bold text-text-main">Tren Penggunaan</h4>
                            <p class="text-xs text-text-muted">Akumulasi jam penggunaan per bulan</p>
                        </div>
                        <button class="text-slate-400 hover:text-primary"><i class="fa-solid fa-ellipsis"></i></button>
                    </div>
                    <div class="h-56 w-full flex flex-col">
                        <div class="flex-1 relative">
                            <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 400 120">
                                <path d="M0,100 Q50,20 100,80 T200,40 T300,90 T400,30" fill="none" stroke="#136dec"
                                    stroke-width="3"></path>
                                <path d="M0,100 Q50,20 100,80 T200,40 T300,90 T400,30 V120 H0 Z"
                                    fill="rgba(19, 109, 236, 0.05)"></path>
                            </svg>
                        </div>
                        <div class="flex justify-between mt-4 px-2">
                            <span class="text-[10px] font-bold text-slate-400">JAN</span>
                            <span class="text-[10px] font-bold text-slate-400">FEB</span>
                            <span class="text-[10px] font-bold text-slate-400">MAR</span>
                            <span class="text-[10px] font-bold text-slate-400">APR</span>
                            <span class="text-[10px] font-bold text-slate-400">MEI</span>
                            <span class="text-[10px] font-bold text-slate-400">JUN</span>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="bg-white border border-border-light p-8 rounded-xl">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h4 class="text-lg font-bold text-text-main">Distribusi Kegiatan</h4>
                            <p class="text-xs text-text-muted">Kategori pemanfaatan fasilitas</p>
                        </div>
                        <button class="text-slate-400 hover:text-primary"><i class="fa-solid fa-filter"></i></button>
                    </div>
                    <div class="flex items-end justify-between h-56 px-4 gap-4">
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-blue-50 border-t-2 border-primary rounded-t" style="height: 60%">
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Kuliah</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-blue-50 border-t-2 border-primary rounded-t" style="height: 85%">
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Rapat</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-blue-50 border-t-2 border-primary rounded-t" style="height: 40%">
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Seminar</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-blue-50 border-t-2 border-primary rounded-t" style="height: 25%">
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Ujian</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-blue-50 border-t-2 border-primary rounded-t" style="height: 55%">
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Lainnya</span>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="bg-white border border-border-light rounded-xl overflow-hidden mb-12">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-text-main">Agenda Besar Terdekat</h4>
                    <a class="text-primary text-xs font-bold hover:underline" href="#">Lihat Kalender <i
                            class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Nama Kegiatan</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Lokasi</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Tanggal</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Status</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Kesiapan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-9 rounded bg-blue-50 text-primary flex items-center justify-center">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-text-main">Yudisium Periode IV 2024
                                            </p>
                                            <p class="text-[10px] text-text-muted">Akademik • Protokoler</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-text-muted text-sm">Aula Utama Gd. A</td>
                                <td class="px-6 py-5 text-text-muted text-sm font-medium">24 Juni 2024</td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex px-2 py-1 rounded bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">Persiapan</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-slate-100 h-1 rounded-full overflow-hidden min-w-[60px]">
                                            <div class="bg-amber-500 h-full w-[65%]"></div>
                                        </div>
                                        <span class="text-slate-400 text-[10px] font-bold">65%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-9 rounded bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-text-main">Seminar Internasional ICT
                                            </p>
                                            <p class="text-[10px] text-text-muted">Penelitian • Umum</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-text-muted text-sm">Auditorium Multimedia</td>
                                <td class="px-6 py-5 text-text-muted text-sm font-medium">28 Juni 2024</td>
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex px-2 py-1 rounded bg-blue-50 text-blue-700 text-[10px] font-bold uppercase border border-blue-100">Terjadwal</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-slate-100 h-1 rounded-full overflow-hidden min-w-[60px]">
                                            <div class="bg-blue-500 h-full w-[30%]"></div>
                                        </div>
                                        <span class="text-slate-400 text-[10px] font-bold">30%</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

<script>
    console.log("Labels:", @json($labels));
    console.log("Data Barang:", @json($countsBarang));
    console.log("Data Ruangan:", @json($countsRuangan));
    var options = {
        chart: {
            type: 'line'
        },
        series: [{
                name: 'Peminjaman Barang',
                data: @json($countsBarang)
            },
            {
                name: 'Peminjaman Ruangan',
                data: @json($countsRuangan)
            }
        ],
        xaxis: {
            type: 'category', // Paksa menjadi kategori agar menyamping
            categories: @json($labels),
            labels: {
                rotate: -45, // Biar tanggalnya miring kalau terlalu rapat
                style: {
                    fontSize: '12px'
                }
            }
        },
        stroke: {
            curve: 'smooth',
        }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>
