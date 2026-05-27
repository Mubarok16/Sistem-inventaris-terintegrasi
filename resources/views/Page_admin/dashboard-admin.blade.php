@extends('components.dashboard.dashboard_app')


@if (Auth::user()->hak_akses === 'admin')
    @section('title', 'dashboard admin')
@elseif (Auth::user()->hak_akses === 'pimpinan')
    @section('title', 'dashboard pimpinan')
@elseif (Auth::user()->hak_akses === 'kaprodi')
    @section('title', 'dashboard kaprodi')
@endif

@section('content')
    {{-- Sidebar --}}
    @if (Auth::user()->hak_akses === 'admin')
        @include('Page_admin.sidebar-admin')
    @elseif (Auth::user()->hak_akses === 'pimpinan')
        @include('Page_pimpinan.sidebar-pimpinan')
    @elseif (Auth::user()->hak_akses === 'kaprodi')
        @include('Page_kaprodi.sidebar-kaprodi')
    @endif

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
                        <div class="flex gap-2">
                            <form action="{{ route('input-bulan-dashboard-pimpinan') }}" method="post">
                                @csrf
                                <input type="month" name="tanggal" value="{{ $bulanInput }}"
                                    onchange="this.form.submit()"
                                    class="bg-slate-50 border border-border-light px-4 py-2.5 rounded-lg! text-sm font-bold text-text-main hover:bg-slate-100 transition-all flex items-center gap-2">
                            </form>

                            <form action="{{ route('preview_laporan_penggunaan', ['date' => $bulanInput]) }}" target="_blank"
                                method="get">
                                @csrf
                                <!-- Isi input dan tombol submit form di sini -->
                                <button
                                    class="bg-blue-500 text-white px-5 py-2.5 rounded-lg! text-sm font-bold hover:bg-blue-700 transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-file-export"></i>
                                    <span>Cetak Laporan</span>
                                </button>
                            </form>
                        </div>
                        {{-- <div
                            class="flex items-center gap-3 w-full md:w-auto bg-white p-2 px-4 rounded-xl border border-slate-200 shadow-sm text-sm font-medium text-slate-600">
                            <i class="fa-solid fa-calendar-days text-primary"></i>
                            {{ now()->format('D, d M Y') }}
                        </div> --}}
                    </div>
                    @include('components.admin.componentDashboardAdm')
                @elseif ($halaman === 'contentAgendaBerlangsung')
                    <div class="flex flex-col md:flex-row md:justify-between gap-3 items-start mb-8">
                        <div>
                            <h4>Agenda yang Berlangsung</h4>
                            <div>
                                <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                                <span class="text-gray-500">/</span>
                                <a href=""
                                    class="text-gray-400! no-underline! font-medium">Agenda-yang-berlangsung</a>
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
                        @if (Auth::user()->hak_akses === 'admin')
                            @php
                                $cekAgenda = DB::table('agenda_fakultas')->where('kode_agenda', $id)->first();
                            @endphp
                            @if ($cekAgenda === null)
                                <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                                <span class="text-gray-500">/</span>
                                <a href="/dashboard/admin/pengajuan-peminjaman"
                                    class="text-gray-400! no-underline!">pengajuan-peminjaman</a>
                                <span class="text-gray-500">/</span>

                                <a href="/admin/pengajuan-peminjaman/detail/{{ $id }}"
                                    class="text-gray-400! no-underline!">detail-peminjaman</a>
                                <span class="text-gray-500">/</span>
                                <a href=""
                                    class="text-gray-400! no-underline! font-medium">Daftar-Penggunaan-Barang-dan-Ruangan</a>
                            @else
                                <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                                <span class="text-gray-500">/</span>
                                <a href="/dashboard/admin/agenda"
                                    class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                                <span class="text-gray-500">/</span>
                                <a href="{{ route('admin-detail-agenda', ['id' => urlencode($id)]) }}"
                                    class="text-gray-400! no-underline!">Detail-agenda</a>
                                <span class="text-gray-500">/</span>
                                <a href=""
                                    class="text-gray-400! no-underline! font-medium">Daftar-Penggunaan-Barang-dan-Ruangan</a>
                            @endif
                        @elseif (Auth::user()->hak_akses === 'pimpinan')
                            <a href="/dashboard/pimpinan" class="text-gray-400! no-underline!">Dahsboard</a>
                            <span class="text-gray-500">/</span>
                            <a href=""
                                class="text-gray-400! no-underline! font-medium">Daftar-Penggunaan-Barang-dan-Ruangan</a>
                        @elseif (Auth::user()->hak_akses === 'kaprodi')
                            <a href="/dashboard/kaprodi" class="text-gray-400! no-underline!">Dahsboard</a>
                            <span class="text-gray-500">/</span>
                            <a href=""
                                class="text-gray-400! no-underline! font-medium">Daftar-Penggunaan-Barang-dan-Ruangan</a>
                        @endif
                    </div>
                    @include('components.admin.contentDetailAgendaCalender')
                @elseif ($halaman === 'contentDetailAgendaEditPerhari')
                    <h4>Edit Penggunaan Barang dan Ruangan</h4>
                    <div class="pb-4">
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="/dashboard/admin/agenda" class="text-gray-400! no-underline!">Pengelolaan-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('admin-detail-agenda', ['id' => urlencode($id)]) }}"
                            class="text-gray-400! no-underline!">Detail-agenda</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('admin.agenda-calender', ['id' => urlencode($id), 'date' => $date]) }}"
                            class="text-gray-400! no-underline!">Daftar-Penggunaan-Barang-dan-Ruangan</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Edit</a>
                    </div>
                    @include('components.admin.componentAgendaEditPenggunaanBarangRuang')
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
                        <a href="" class="text-gray-400! no-underline! font-medium">Detail-agenda</a>
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
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengadaan-Barang</a>
                    </div>
                    @include('components.admin.componentPengadaanBarang')
                @elseif ($halaman === 'contentPerawatanBarang')
                    <h4>Perawatan Barang</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Perawatan-Barang</a>
                    </div>
                    @include('components.admin.contentPerawatanBarang')
                @elseif ($halaman === 'contentPengajuanPerawatanBarang')
                    <h4>Pengajuan Perawatan Barang</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('page_perawatan_barang') }}"
                            class="text-gray-400! no-underline!">Perawatan-Barang</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengajuan-Perawatan-Barang</a>
                    </div>
                    @include('components.admin.contentFormPengajuanPerawatan')
                @elseif ($halaman === 'contentDashbordChekInBarang')
                    <h4>Alokasi Barang</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('page_pengadaan_barang') }}"
                            class="text-gray-400! no-underline!">Pengadaan-Barang</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('pageCheckInBarang', base64_encode($pengadaan->id_pengadaan)) }}"
                            class="text-gray-400! no-underline! font-medium">Alokasi-Barang</a>
                    </div>
                    @include('components.admin.componentCheckinBarangPengadaan')
                @elseif ($halaman === 'contentProfile')
                    <h4>Profile User</h4>
                    <div>
                        <a href="/dashboard/admin" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Profile</a>
                    </div>
                    @include('components.dashboard.page_profile_users')
                @endif
            </div>
        </div>
    </div>

@endsection
