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
                    </div>
                    <div id="chart"></div>

                </div>
            </div>

            {{-- usage room terdekat --}}
            <div class="bg-white border border-border-light rounded-xl overflow-hidden mb-8">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="text-lg font-bold text-text-main">
                        <i class="fa-solid fa-calendar-check text-primary"></i>
                        Penggunaan Ruangan Terdekat
                    </h4>
                    <a class="text-primary text-xs font-bold hover:underline" href="#">Lihat selengkapnya di
                        Kalender <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Nama Kegiatan</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Ruangan</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Tanggal & jam</th>
                                <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Status</th>
                                {{-- <th class="px-6 py-4 text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                    Kesiapan</th> --}}
                            </tr>
                        </thead>
                        <livewire:pimpinan.agenda-terdekat />
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
            type: 'line',
            height: 400,
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
