@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard kaprodi')

@section('content')
    {{-- Sidebar --}}
    @include('Page_kaprodi.sidebar-kaprodi')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- Navbar --}}
            @include('components.dashboard.navbar')

            <div class="container-fluid" id="container-wrapper">
                @if ($halaman === 'contentDashborKaprodi')
                    <div class="flex flex-col md:flex-row md:justify-between gap-3 items-start mb-8">
                        <div class="item-start">
                            <h4>Dashboard</h4>
                            <div>
                                <a href="{{ route('dashboard-kaprodi') }}" class="text-gray-400! no-underline!">Dahsboard</a>
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

                            <button
                                class="bg-blue-500 text-white px-5 py-2.5 rounded-lg! text-sm font-bold hover:bg-blue-700 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-file-export"></i>
                                <span>Ekspor Laporan</span>
                            </button>
                        </div>
                    </div>
                    @include('components.kaprodi.contentDashboardKaprodi')
                @elseif ($halaman === 'contentCalenderKaprodi')
                    <h4>Penggunaan Ruangan Terdekat</h4>
                    <div class="mb-8">
                        <a href="{{ route('dashboard-kaprodi') }}" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Penggunaan-Ruangan</a>
                    </div>
                    @include('components.kaprodi.contentCalender')
                @elseif ($halaman === 'contentPengadaanBarang')
                    <h4>Pengadaan Barang</h4>
                    <div>
                        <a href="{{ route('dashboard-kaprodi') }}" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengadaan-Barang</a>
                    </div>
                    @include('components.kaprodi.contentPengadaanBarang')
                @elseif ($halaman === 'contentPerawatanBarang')
                    <h4>Perawatan Barang dan Ruang</h4>
                    <div>
                        <a href="{{ route('dashboard-kaprodi') }}" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Perawatan-Barang</a>
                    </div>
                    @include('components.kaprodi.contentPerawatanKaprodi')
                @elseif ($halaman === 'contentFormPerawatanBarang')
                    <h4>Pengajuan Perawatan Barang dan Ruang</h4>
                    <div>
                        <a href="{{ route('dashboard-kaprodi') }}" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('pengadaan-barang-kaprodi') }}"
                            class="text-gray-400! no-underline!">Perawatan-Barang</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengajuan-Perawatan-Barang</a>
                    </div>
                    @include('components.admin.contentFormPengajuanPerawatan')
                @elseif ($halaman === 'contentProfile')
                    <h4>Profile User</h4>
                    <div>
                        <a href="{{ route('dashboard-kaprodi') }}" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Profile</a>
                    </div>
                    @include('components.dashboard.page_profile_users')
                @endif
            </div>
        </div>
    </div>

@endsection
