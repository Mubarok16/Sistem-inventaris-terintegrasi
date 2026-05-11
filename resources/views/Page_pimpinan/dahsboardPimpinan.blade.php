@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard pimpinan')

@section('content')
    {{-- Sidebar --}}
    @include('Page_pimpinan.sidebar-pimpinan')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- Navbar --}}
            @include('components.dashboard.navbar')

            <div class="container-fluid px-2 sm:px-4!" id="container-wrapper">
                @if ($halaman === 'contentDashbordPimpinan')
                    <div class="flex flex-col md:flex-row md:justify-between gap-3 items-start mb-8">
                        <div class="item-start">
                            <h4>Dashboard</h4>
                            <div>
                                <a href="/dashboard/pimpinan" class="text-gray-400! no-underline!">Dahsboard</a>
                                <span class="text-gray-500">/</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('input-bulan-dashboard-pimpinan') }}" method="post">
                                @csrf
                                <input type="month" name="tanggal" value="{{ $bulanInput }}" onchange="this.form.submit()"
                                 class="bg-slate-50 border border-border-light px-4 py-2.5 rounded-lg! text-sm font-bold text-text-main hover:bg-slate-100 transition-all flex items-center gap-2">
                            </form>
                           
                            <button
                                class="bg-blue-500 text-white px-5 py-2.5 rounded-lg! text-sm font-bold hover:bg-blue-700 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-file-export"></i>
                                <span>Ekspor Laporan</span>
                            </button>
                        </div>
                    </div>
                    @include('components.pimpinan.contentDashboardPimpinan')
                @elseif ($halaman === 'contentCalenderPimpinan')
                    <h4>Penggunaan Ruangan Terdekat</h4>
                    <div class="mb-8">
                        <a href="{{ route('dashboard-pimpinan') }}" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Penggunaan-Ruangan</a>
                    </div>
                    @include('components.pimpinan.contentCalender')
                @elseif ($halaman === 'contentPengadaanBarang')
                    <h4>Pengadaan Barang</h4>
                    <div>
                        <a href="/dashboard/pimpinan" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Pengadaan-Barang</a>
                    </div>
                    @include('components.pimpinan.contentPengadaanBarang')
                @elseif ($halaman === 'contentPerawatanBarang')
                    <h4>Perawatan Barang</h4>
                    <div>
                        <a href="/dashboard/pimpinan" class="text-gray-400! no-underline!">Dahsboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Perawatan-Barang</a>
                    </div>
                    @include('components.pimpinan.contentPerawatanBarang')
                @endif
            </div>
        </div>
    </div>

@endsection
