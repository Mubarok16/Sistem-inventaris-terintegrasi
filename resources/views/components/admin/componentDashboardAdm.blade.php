{{-- <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Beranda Dashboard Admin - Sistem Manajemen Sumber Daya</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#136dec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101822",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-item-active {
            background-color: rgba(19, 109, 236, 0.1);
            color: #136dec;
            border-right: 4px solid #136dec;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head> --}}

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<main class="flex-1 py-2 px-2 mb-4">

    <!-- summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-100 rounded-lg text-primary">
                    <i class="fa-solid fa-clipboard-list text-primary"></i>
                </div>
                {{-- <span class="text-emerald-600 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-full">+12%</span> --}}
            </div>
            <p class="text-slate-500 text-sm font-medium">Semua Peminjaman</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalPeminjamanAktif }}
                <span class="text-sm font-normal text-slate-400">Total</span>
            </h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                {{-- <span class="text-slate-400 text-xs font-bold bg-slate-50 px-2 py-1 rounded-full">Tetap</span> --}}
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Ruangan</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalRuangan }} <span
                    class="text-sm font-normal text-slate-400">Unit</span></h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                {{-- <span class="text-rose-600 text-xs font-bold bg-rose-50 px-2 py-1 rounded-full">-3%</span> --}}
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Barang</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalBarang }} <span
                    class="text-sm font-normal text-slate-400">Unit</span></h3>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                {{-- <span class="text-emerald-600 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-full">+5</span> --}}
            </div>
            <p class="text-slate-500 text-sm font-medium">Agenda Hari Ini</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $AgendaToday }} <span
                    class="text-sm font-normal text-slate-400">Agenda</span></h3>
        </div>
    </div>
    {{-- isi konten --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- chart dan peminjaman Area -->
        <div class="lg:col-span-2 space-y-8">
            <!-- chart -->
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-primary"></i>
                        Tren Peminjaman
                    </h4>
                    <select
                        class="text-xs border-slate-200 rounded-lg font-medium focus:ring-primary focus:border-primary">
                        <option>7 Hari Terakhir</option>
                        {{-- <option>30 Hari Terakhir</option> --}}
                    </select>
                </div>
                <div id="chart"></div>

            </div>

            <!-- table peminjaman -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-bottom border-slate-100 flex justify-between items-center">
                    <h4 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-primary"></i>
                        Pengajuan peminjaman
                    </h4>
                    <button class="text-primary text-xs font-bold hover:underline">Lihat Semua</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-y border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    Peminjam</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    Keterangan Peminjaman</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    Durasi Peminjaman</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">
                                    Status</th>
                                {{-- <th
                                    class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">
                                    aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($pengajuanPeminjaman as $pp)
                                <tr class="hover:bg-blue-50 transition-colors cursor-pointer"
                                    onclick="window.location='{{ route('admin.detailPeminjaman', $pp->kode_peminjaman) }}'">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center overflow-hidden">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span
                                                class="text-sm font-semibold text-slate-700">{{ $pp->nama_peminjam }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm font-medium text-slate-700">{{ $pp->ket_peminjaman }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm text-slate-600 font-medium">{{ date('d M y', strtotime($pp->tgl_pinjam)) }}</span>
                                        - <span
                                            class="text-sm text-slate-600 font-medium">{{ date('d M y', strtotime($pp->tgl_kembali)) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                            {{ $pp->status_peminjaman }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div>
                                            <i class="fa-solid fa-calendar-xmark text-3xl text-red-300"></i>
                                        </div>
                                        <div class="text-slate-400 text-sm">Tidak ada pengajuan peminjaman</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- agenda berlangsung -->
        <div class="space-y-8">
            <!-- detail agenda today -->
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h5 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-minus text-primary"></i>
                        Agenda Berlangsung
                    </h5>
                </div>
                <livewire:agenda-berlangsung :limit="2" />
                
                <a href="{{ route('dashboard-agenda-berlangsung') }}"
                    class="w-full mt-8 py-2.5 bg-slate-50 text-slate-600! text-xs font-bold rounded-lg! border border-slate-200 hover:bg-blue-100 transition-colors no-underline! w-full flex items-center justify-center gap-2">
                    Buka Kalender Lengkap
                </a>
            </div>
            <!-- Quick Actions Card -->
            {{-- <div class="bg-primary p-6 rounded-xl shadow-lg shadow-primary/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-bold mb-2">Aksi Cepat</h4>
                    <p class="text-blue-100 text-xs mb-6">Mulai peminjaman baru untuk mahasiswa atau staf
                        secara langsung.</p>
                    <div class="space-y-3">
                        <button
                            class="w-full bg-white text-primary py-2.5 rounded-lg text-xs font-black shadow-md hover:bg-blue-50 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">add_circle</span>
                            Buat Peminjaman
                        </button>
                        <button
                            class="w-full bg-primary-dark/20 bg-white/10 text-white py-2.5 rounded-lg text-xs font-bold border border-white/20 hover:bg-white/20 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            Verifikasi Pengembalian
                        </button>
                    </div>
                </div>
                <!-- Decorative circle -->
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            </div> --}}
        </div>
    </div>
</main>


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

{{-- 
<section class="flex flex-col gap-6">
    <!-- SectionHeader -->

    <!-- ImageGrid / Room Status Cards -->
    <div class="overflow-x-auto pb-4">

        <div class="flex flex-nowrap gap-3">
            <a href="javascript:void(0);"
                class="text-decoration-none hover-dashboard-agenda flex flex-col gap-3 p-4 rounded-lg shadow-sm w-full min-w-[280px] sm:w-1/2 md:w-1/3 flex-shrink-0">
                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg"
                    data-alt="Photo of Room A, a modern meeting space."
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA5uHVhv4FD2kFfQfGJUy_VxwICdOGGExUhdDRgn9Mnp5Krm87S8xITvOoLRJxUw6DEDHSCvdXDG4ETIRe6P_4eI-wMdGlFPnIb5ftL2pxM7BTzIz4OVk82y2Luv4wKV3IS_iM6Fnlow1PPwz81T5luw8a51e9DPsmNcOnM1BgWc1P3iFWZiUNBt_9gqN29JkdbdSsFY76st2PRtmyjvbXkeN7p0VdwOt5fwAD7g79WI1vHXoy0iF385M4y0p4QcXal6uCoSd7lTc2w");'>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-[#111418] text-base font-medium leading-normal">Ruangan A</p>
                    <span
                        class="text-sm font-medium px-2.5 py-0.5 rounded-full bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-100">
                        Digunakan
                    </span>
                </div>
            </a>
            <a href="javascript:void(0);"
                class="text-decoration-none hover-dashboard-agenda flex flex-col gap-3 p-4 rounded-lg shadow-sm w-full min-w-[280px] sm:w-1/2 md:w-1/3 flex-shrink-0">
                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg"
                    data-alt="Photo of Room B, a collaborative workspace."
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD7F7VmHbwPbDSya2Ktr8fBR04CiFxQygAphyRgNRMNve-4VXSzAgZfPn04vrf6mzq_JCNtVh5YrqXVgEr182kby1AtA4dvZUMMk8UFL3Id3rcPfG09256tT3gAAFzzZQMJDPFFbPHFW8uh6Y46OOQKZz1Uk_z9McxEBIZydLMtRr0-BPUh5UYHeCnAJJA0rwFvxWEOCoIMDsx-wcDSnLvsJsnzb6o7pjW49KU8jAEJeASDL9c1R6FMOWzTKrNR6Nx6gbez9T8hYE35");'>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-[#111418] text-base font-medium leading-normal">Ruangan B</p>
                    <span
                        class="text-sm font-medium px-2.5 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">Tersedia</span>
                </div>
            </a>
            <a href="javascript:void(0);"
                class="text-decoration-none hover-dashboard-agenda flex flex-col gap-3 p-4 rounded-lg shadow-sm w-full min-w-[280px] sm:w-1/2 md:w-1/3 flex-shrink-0">
                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg"
                    data-alt="Photo of Room A, a modern meeting space."
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA5uHVhv4FD2kFfQfGJUy_VxwICdOGGExUhdDRgn9Mnp5Krm87S8xITvOoLRJxUw6DEDHSCvdXDG4ETIRe6P_4eI-wMdGlFPnIb5ftL2pxM7BTzIz4OVk82y2Luv4wKV3IS_iM6Fnlow1PPwz81T5luw8a51e9DPsmNcOnM1BgWc1P3iFWZiUNBt_9gqN29JkdbdSsFY76st2PRtmyjvbXkeN7p0VdwOt5fwAD7g79WI1vHXoy0iF385M4y0p4QcXal6uCoSd7lTc2w");'>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-[#111418] text-base font-medium leading-normal">Ruangan A</p>
                    <span
                        class="text-sm font-medium px-2.5 py-0.5 rounded-full bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-100">
                        Digunakan
                    </span>
                </div>
            </a>
            <a href="javascript:void(0);"
                class="text-decoration-none hover-dashboard-agenda flex flex-col gap-3 p-4 rounded-lg shadow-sm w-full min-w-[280px] sm:w-1/2 md:w-1/3 flex-shrink-0">
                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg"
                    data-alt="Photo of Room B, a collaborative workspace."
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD7F7VmHbwPbDSya2Ktr8fBR04CiFxQygAphyRgNRMNve-4VXSzAgZfPn04vrf6mzq_JCNtVh5YrqXVgEr182kby1AtA4dvZUMMk8UFL3Id3rcPfG09256tT3gAAFzzZQMJDPFFbPHFW8uh6Y46OOQKZz1Uk_z9McxEBIZydLMtRr0-BPUh5UYHeCnAJJA0rwFvxWEOCoIMDsx-wcDSnLvsJsnzb6o7pjW49KU8jAEJeASDL9c1R6FMOWzTKrNR6Nx6gbez9T8hYE35");'>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-[#111418] text-base font-medium leading-normal">Ruangan B</p>
                    <span
                        class="text-sm font-medium px-2.5 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">Tersedia</span>
                </div>
            </a>
            <a href="javascript:void(0);"
                class="text-decoration-none hover-dashboard-agenda flex flex-col gap-3 p-4 rounded-lg shadow-sm w-full min-w-[280px] sm:w-1/2 md:w-1/3 flex-shrink-0">
                <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-lg"
                    data-alt="Photo of Room B, a collaborative workspace."
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD7F7VmHbwPbDSya2Ktr8fBR04CiFxQygAphyRgNRMNve-4VXSzAgZfPn04vrf6mzq_JCNtVh5YrqXVgEr182kby1AtA4dvZUMMk8UFL3Id3rcPfG09256tT3gAAFzzZQMJDPFFbPHFW8uh6Y46OOQKZz1Uk_z9McxEBIZydLMtRr0-BPUh5UYHeCnAJJA0rwFvxWEOCoIMDsx-wcDSnLvsJsnzb6o7pjW49KU8jAEJeASDL9c1R6FMOWzTKrNR6Nx6gbez9T8hYE35");'>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-[#111418] text-base font-medium leading-normal">Ruangan B</p>
                    <span
                        class="text-sm font-medium px-2.5 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">Tersedia</span>
                </div>
            </a>
        </div>
    </div>
    <!-- Detailed Schedule -->
    <div class="bg-white dark:bg-gray-800/50 rounded-lg shadow-sm p-4 sm:p-6 flex flex-col gap-4">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <h3 class="text-[#111418] dark:text-white text-lg font-bold">Jadwal Ruangan A</h3>
            <div class="flex items-center gap-2">
                <button
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-gray-300">
                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                </button>
                <button
                    class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-gray-300">
                    <span class="material-symbols-outlined text-xl">calendar_today</span>
                    <span class="text-sm font-medium">1 Jan 2025</span>
                </button>
                <button
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-[#111418] dark:text-gray-300">
                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 rounded-l-lg" scope="col">Jam</th>
                        <th class="px-6 py-3" scope="col">Pengguna</th>
                        <th class="px-6 py-3 rounded-r-lg" scope="col">Keterangan Agenda</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white dark:bg-gray-800/50 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            08:00 - 09:00</td>
                        <td class="px-6 py-4">Tim Marketing</td>
                        <td class="px-6 py-4">Rapat Mingguan</td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800/50 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            09:00 - 11:00</td>
                        <td class="px-6 py-4">Divisi HR</td>
                        <td class="px-6 py-4">Wawancara Kandidat</td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800/50">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            11:00 - 12:00</td>
                        <td class="px-6 py-4 text-gray-400 dark:text-gray-500 italic">Tersedia</td>
                        <td class="px-6 py-4 text-gray-400 dark:text-gray-500 italic">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- Bottom Section: Equipment Information -->
<section class="flex flex-col gap-6">
    <!-- SectionHeader -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em]">
            Informasi Barang</h2>
        <div class="relative min-w-64">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">search</span>
            </div>
            <input
                class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary"
                placeholder="Cari barang..." type="text" />
        </div>
    </div>
    <!-- Equipment Table -->
    <div class="bg-white dark:bg-gray-800/50 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 rounded-l-lg" scope="col">Nama Barang</th>
                        <th class="px-6 py-3 text-center" scope="col">Qty Digunakan</th>
                        <th class="px-6 py-3 text-center rounded-r-lg" scope="col">Qty Tersedia
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white dark:bg-gray-800/50 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Proyektor InFocus</td>
                        <td class="px-6 py-4 text-center">2</td>
                        <td class="px-6 py-4 text-center">8</td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800/50 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Papan Tulis Portable</td>
                        <td class="px-6 py-4 text-center">1</td>
                        <td class="px-6 py-4 text-center">4</td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800/50 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Kabel HDMI 5m</td>
                        <td class="px-6 py-4 text-center">5</td>
                        <td class="px-6 py-4 text-center">15</td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800/50">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            Speaker Portable</td>
                        <td class="px-6 py-4 text-center">0</td>
                        <td class="px-6 py-4 text-center">3</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section> --}}
