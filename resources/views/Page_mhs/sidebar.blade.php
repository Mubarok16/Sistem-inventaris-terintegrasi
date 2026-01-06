<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard/mahasiswa') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logo_ft.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">SIPRA</div> {{-- Sistem inteGrasi peMinjaman sarana prasarana dan Agenda kegiatan --}}
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ $halaman === 'contentDashbord' ? 'bg-gray-200' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard/mahasiswa') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Features
    </div>
    <li
        class="nav-item {{ $halaman === 'contentPeminjamanBarang' || $halaman === 'contentDetailPeminjamanBarang' ? 'bg-gray-200' : '' }} m-0">
        <a class="nav-link collapsed" href="{{ url('/dashboard/mahasiswa/peminjaman-barang') }}">
            <i class="fas fa-cube fa-fw mr-3"></i>
            <span>Peminjaman Barang</span>
        </a>
    </li>
    <li class="nav-item {{ $halaman === 'contentPeminjamanRuang' || $halaman === 'contentDetailPeminjamanRuangan' ? ' bg-gray-200' : '' }} m-0">
        <a class="nav-link collapsed" href="{{ url('/dashboard/mahasiswa/peminjaman-ruang') }}">
            <i class="fas fa-building"></i>
            <span>Peminjaman Ruang</span>
        </a>
    </li>
    <li class="nav-item m-0" x-data="{ open: {{ $halaman === 'contentListPeminjaman' || $halaman === 'contentCetakQR' || $halaman === 'contentDetailTransaksiPeminjamanMhs' ? 'true' : 'false' }} }">

        <a href="#" @click.prevent="open = !open"
            class="nav-link collapsed flex! items-center transition duration-150 ease-in-out {{ $halaman === 'contentListPeminjaman' || $halaman === 'contentCetakQR' || $halaman === 'contentDetailTransaksiPeminjamanMhs' ? 'bg-gray-200' : '' }}">

            <i class="fas fa-list"></i>

            <span class="flex-1">List Peminjaman</span>

            <i class="fas fa-angle-down w-4 h-4 transition-transform duration-200"
                :class="{ 'transform rotate-180': open, 'transform rotate-0': !open }"></i>
        </a>

        <div x-show="open" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-y-100"
            x-transition:leave-end="opacity-0 scale-y-0" class="origin-top ml-4 pt-1 pb-2 space-y-1 py-2 collapse-inner">

            <a href="{{ url('/dashboard/mahasiswa/list-peminjaman') }}" class="block px-2 py-2 text-sm text-gray-600 hover:bg-gray-100 no-underline! {{ $halaman === 'contentListPeminjaman' || $halaman === 'contentDetailTransaksiPeminjamanMhs' ? 'bg-gray-200' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart Peminjaman</span>
            </a>
            <a href="#" class="block px-2 py-2 text-sm text-gray-600 hover:bg-gray-100 no-underline! {{ $halaman === 'contentCetakQR' ? 'bg-gray-200' : '' }}">
                <i class="fas fa-qrcode"></i>
                <span>Cetak QR Code</span>
            </a>
        </div>
    </li>
    {{-- <li class="nav-item {{ $halaman === 'contentListPeminjaman' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('/dashboard/mahasiswa/list-peminjaman') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>List Peminjaman</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tables</h6>
                <a class="collapse-item" href="simple-tables.html">Simple Tables</a>
                <a class="collapse-item" href="datatables.html">DataTables</a>
            </div>
        </div>
    </li> --}}
    <li class="nav-item {{ $halaman === 'contentRiwayat' ? 'bg-gray-200' : '' }} m-0">
        <a class="nav-link" href="{{ url('/dashboard/mahasiswa/riwayat') }}">
            <i class="fas fa-history"></i>
            <span>Riwayat</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->
