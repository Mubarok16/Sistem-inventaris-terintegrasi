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
                    <div class="flex flex-col md:flex-row md:justify-between gap-3 items-start mb-8">
                        <div class="item-start">
                            <h4>Dashboard</h4>
                            <div>
                                <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                                <span class="text-gray-500">/</span>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-3 w-full md:w-auto bg-white p-2 px-4 rounded-xl border border-slate-200 shadow-sm text-sm font-medium text-slate-600">
                            <i class="fa-solid fa-calendar-days text-primary"></i>
                            {{-- Kamis, 24 Oktober 2024 --}}
                            {{ now()->format('D, d M Y') }}
                        </div>
                    </div>
                    @include('components.admin.componentDashboardAdm')
                @elseif ($halaman === 'contentAgendaBerlangsung')
                    <div class="flex flex-col md:flex-row md:justify-between gap-3 items-start mb-8">
                        <div>
                            <h4>Agenda yang Berlangsung</h4>
                            <div>
                                <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                                <span class="text-gray-500">/</span>
                                <a href="" class="text-gray-400! no-underline! font-medium">Agenda-yang-berlangsung</a>
                            </div>
                        </div>
                        <div
                            class="flex flex-col w-full md:w-auto items-start gap-1 bg-white p-2 px-4 rounded-xl border border-slate-200 shadow-sm text-sm font-medium text-slate-600">
                            <div>
                                <i class="fa-solid fa-clock text-primary"></i>
                                <span id="realtime-clock"></span>
                            </div>
                            <div>
                                <i class="fa-solid fa-calendar-days text-primary"></i>
                                {{ now()->format('D, d M Y') }}
                            </div>
                            
                        </div>
                    </div>
                    @include('components.admin.componentAgendaBerlangsung')
                @elseif ($halaman === 'contentPengelolaanUser')
                    <h4>Pengelolaan User</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengelolaan-Pengguna</a>
                    </div>
                    @include('components.admin.componentPengelolaanUser')
                @elseif ($halaman === 'contentEditUser')
                    <h4>Edit User</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('pengelolaan-user') }}"
                            class="text-gray-400! no-underline!">Pengelolaan-Pengguna</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">edit-akun-Pengguna</a>
                    </div>
                    @include('components.admin.componentEditAkunUserAdmin')
                @elseif ($halaman === 'contentAddAllUserByAdmin')
                    <h4>Tambah User</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('pengelolaan-user') }}"
                            class="text-gray-400! no-underline!">Pengelolaan-Pengguna</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">add-akun-Pengguna</a>
                    </div>
                    @include('components.admin.componentAddAkunUserAllByAdmin')
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
                    <h4>Pengeloaan Barang</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengelolaan-Barang</a>
                    </div>
                    @include('components.admin.componentDataBarang')
                @elseif ($halaman === 'contentEditBarang')
                    <h4>Edit Barang</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('peng-barang') }}" class="text-gray-400! no-underline!">Pengelolaan-barang</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Edit-barang</a>
                    </div>
                    @include('components.admin.componentEditBarang')
                @elseif ($halaman === 'contentDetailRuangan')
                    <h4>Edit Ruangan</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('peng-ruang') }}" class="text-gray-400! no-underline!">Pengelolaan-raungan</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Edit-ruangan</a>
                    </div>
                    @include('components.admin.componentEditRuangan')
                @elseif ($halaman === 'contentDataRuangan')
                    <h4>Pengelolaan Ruangan</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengelolaan-ruangan</a>
                    </div>
                    @include('components.admin.componentDataRuangan')
                @elseif ($halaman === 'contentAgenda')
                    <h4>Agenda</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengelolaan-agenda</a>
                    </div>
                    @include('components.admin.componentPengelolaanAgenda')
                @elseif ($halaman === 'contentDetailAgendaCalender')
                    <h4>Detail Agenda</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/agenda" class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Detail-agenda</a>
                    </div>
                    @include('components.admin.contentDetailAgendaCalender')
                @elseif ($halaman === 'contentImportAgenda')
                    <h4>Import Agenda</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/agenda" class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Import-agenda</a>
                    </div>
                    @include('components.admin.componentImportAgenda')
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
                @elseif ($halaman === 'contentEditAgenda')
                    <h4>Edit Agenda</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/agenda" class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('admin-detail-agenda', ['id' => urlencode($id)]) }}"
                            class="text-gray-400! no-underline!">detail-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">edit-agenda</a>
                    </div>
                    @include('components.admin.componentEditAgendaAdm')
                @elseif ($halaman === 'contentPengadaanBarang')
                    <h4>Pengadaan Barang</h4>
                    @include('components.admin.componentPengadaanBarang')
                @endif
            </div>
        </div>
    </div>

@endsection
