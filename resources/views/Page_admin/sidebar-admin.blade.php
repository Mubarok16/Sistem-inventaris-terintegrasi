<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard/mahasiswa') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logo_ft.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">SIPRA</div> {{-- Sistem inteGrasi peMinjaman sarana prasarana dan Agenda kegiatan --}}
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ $halaman === 'contentDashbord' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard/admin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Features
    </div>
    <li class="nav-item {{ $halaman === 'contentPengelolaanUser' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('/dashboard/admin/pengelolaan-user') }}">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Pengelolaan User</span>
        </a>
        {{-- <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Bootstrap UI</h6>
                <a class="collapse-item" href="#">Alerts</a>
                <a class="collapse-item" href="#">Buttons</a>
                <a class="collapse-item" href="#">Dropdowns</a>
                <a class="collapse-item" href="#">Modals</a>
                <a class="collapse-item" href="#">Popovers</a>
                <a class="collapse-item" href="#">Progress Bars</a>
            </div>
        </div> --}}
    </li>
    <li class="nav-item {{ $halaman === 'contentPengajuanPeminjaman' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('/dashboard/admin/pengajuan-peminjaman') }}">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Pengajuan Peminjaman</span>
        </a>
        {{-- <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Forms</h6>
                <a class="collapse-item" href="form_basics.html">Form Basics</a>
                <a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>
            </div>
        </div> --}}
    </li>
    <li class="nav-item {{ $halaman === 'contentDataBarang' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('/dashboard/admin/data-barang') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Barang</span>
        </a>
        {{-- <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tables</h6>
                <a class="collapse-item" href="simple-tables.html">Simple Tables</a>
                <a class="collapse-item" href="datatables.html">DataTables</a>
            </div>
        </div> --}}
    </li>
    <li class="nav-item {{ $halaman === 'contentDataRuangan' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard/admin/data-ruangan') }}">
            <i class="fas fa-fw fa-palette"></i>
            <span>Data Ruangan</span>
        </a>
    </li>
    <li class="nav-item {{ $halaman === 'contentAgenda' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard/admin/agenda') }}">
            <i class="fas fa-fw fa-palette"></i>
            <span>Pengelolaan Agenda</span>
        </a>
    </li>
    <li class="nav-item {{ $halaman === 'contentPengadaanBarang' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard/admin/pengadaan-barang') }}">
            <i class="fas fa-fw fa-palette"></i>
            <span>Pengadaan Barang</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->
