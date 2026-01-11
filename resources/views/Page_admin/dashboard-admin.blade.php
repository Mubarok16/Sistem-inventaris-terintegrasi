@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard admin')

@section('content')
    {{-- Sidebar --}}
    @include('Page_admin.sidebar-admin')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- Navbar --}}
            @include('components.dashboard.navbar')

            <div class="container-fluid px-2 sm:px-4!" id="container-wrapper">
                {{-- isi content --}}
                @if ($halaman === 'contentDashbord')
                    <h4>Dashboard Staff</h4>
                    @include('components.admin.componentDashboardAdm')
                @elseif ($halaman === 'contentPengelolaanUser')
                    <h4>Pengelolaan User</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengelolaan-Pengguna</a>
                    </div>
                    @include('components.admin.componentPengelolaanUser')
                @elseif ($halaman === 'contentEditUser')
                    <h4>Pengelolaan User</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('pengelolaan-user') }}" class="text-gray-400! no-underline!">Pengelolaan-Pengguna</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">edit-akun-Pengguna</a>
                    </div>
                    @include('components.admin.componentEditAkunUserAdmin')
                @elseif ($halaman === 'contentPengajuanPeminjaman')
                    <h4>Pengajuan Peminjaman</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengajuan-peminjaman</a>
                    </div>
                    @include('components.admin.componentPengajuanPeminjaman')
                @elseif ($halaman === 'contentDetailPenminjaman')
                    <h4>Detail Peminjaman</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/pengajuan-peminjaman"
                            class="text-gray-400! no-underline!">pengajuan-peminjaman</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">detail-peminjaman</a>
                    </div>
                    @include('components.admin.componentDetailPengajuanPeminjaman')
                @elseif ($halaman === 'contentDataBarang')
                    <h4>Data Barang</h4>
                    @include('components.admin.componentDataBarang')
                @elseif ($halaman === 'contentDetailRuangan')
                    <h4>Detail Ruangan</h4>
                    {{-- @include('components.admin.componentDataRuangan') --}}
                @elseif ($halaman === 'contentDataRuangan')
                    <h4>Pengelolaan Ruangan</h4>
                    @include('components.admin.componentDataRuangan')
                @elseif ($halaman === 'contentAgenda')
                    <h4>Agenda</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengelolaan-agenda</a>
                    </div>
                    @include('components.admin.componentPengelolaanAgenda')
                @elseif ($halaman === 'contentDetailAgenda')
                    <h4>Detail Agenda</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/agenda" class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">detail-agenda</a>
                    </div>
                    @include('components.admin.componentDetailAgendaAdmin')
                @elseif ($halaman === 'contentTambahAgenda')
                    <h4>Tambah Agenda</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/agenda" class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">tambah-agenda</a>
                    </div>
                    @include('components.admin.componentTambahAgenda')
                @elseif ($halaman === 'contentPengadaanBarang')
                    <h4>Pengadaan Barang</h4>
                    @include('components.admin.componentPengadaanBarang')
                @endif
            </div>
        </div>
    </div>

@endsection
