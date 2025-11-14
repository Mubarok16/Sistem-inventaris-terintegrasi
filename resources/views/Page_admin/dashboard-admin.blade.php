@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard admin')

@section('content')
    {{-- Sidebar --}}
        @include('Page_admin.sidebar-admin')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Navbar --}}
                @include('components.dashboard.navbar')

                <div class="container-fluid" id="container-wrapper">
                    {{-- isi content --}}
                     @if ($halaman === 'contentDashbord')
                        <h4>Dashboard Staff</h4>
                        @include('components.admin.componentDashboardAdm')
                    @elseif ($halaman === 'contentPengelolaanUser')
                        <h4>Pengelolaan User</h4>
                        @include('components.admin.componentPengelolaanUser')
                    @elseif ($halaman === 'contentPengajuanPeminjaman')
                        <h4>Pengajuan Peminjaman</h4>
                        @include('components.admin.componentPengajuanPeminjaman')
                    @elseif ($halaman === 'contentDataBarang')
                        <h4>Data Barang</h4>
                        @include('components.admin.componentDataBarang')
                    @elseif ($halaman === 'contentDataRuangan')
                        <h4>Pengelolaan Ruangan</h4>
                        @include('components.admin.componentDataRuangan')
                    @elseif ($halaman === 'contentAgenda')
                        <h4>Agenda</h4>
                        @include('components.admin.componentPengelolaanAgenda')
                    @elseif ($halaman === 'contentPengadaanBarang')
                        <h4>Pengadaan Barang</h4>
                        @include('components.admin.componentPengadaanBarang')
                    @endif
                </div>
            </div>
        </div>
    
@endsection
