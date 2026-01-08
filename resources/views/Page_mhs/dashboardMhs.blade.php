@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard mahasiswa')

@section('content')
    {{-- Sidebar --}}
    @include('Page_mhs.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- Navbar --}}
            @include('Page_mhs.navbarmhs')

            <div class="container-fluid" id="container-wrapper">
                {{-- isi content --}}

                @if ($halaman === 'contentDashbord')
                    {{-- <h4>Dashboard</h4>
                     <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline! font-medium">
                            Dahsboard-mahasiswa
                        </a>
                        <span class="text-gray-500">/</span>
                    </div> --}}
                    <h4 class="text-2xl md:text-3xl font-bold text-text-main">Selamat Datang, {{ $user }}! 👋</h4>
                    <p class="text-text-secondary">Berikut adalah informasi terkini mengenai pinjaman anda dan agenda fakultas hari ini.</p>
                    @include('components.mahasiswa.contentDashbordMhs')
                @elseif ($halaman === 'contentPeminjamanBarang')
                    <h4>Peminjaman Barang</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">
                            Dahsboard-mahasiswa
                        </a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Peminjaman-Barang</a>
                    </div>
                    @include('components.mahasiswa.contentPeminjamanBarang')
                @elseif ($halaman === 'contentDetailPeminjamanBarang')
                    <h4>Detail Peminjaman Barang</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('mhs-peminjaman-barang') }}"
                            class="text-gray-400! no-underline!">Peminjaman-Barang</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">detail-peminjaman-barang</a>
                    </div>
                    @include('components.mahasiswa.contentDetailPeminjamanbarang')
                @elseif ($halaman === 'contentPeminjamanRuang')
                    <h4>Peminjaman Ruang</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Peminjaman-Ruangan</a>
                    </div>
                    @include('components.mahasiswa.contentPeminjamanRuang')
                @elseif ($halaman === 'contentDetailPeminjamanRuangan')
                    <h4>Detail Peminjaman Ruangan</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('mhs-peminjaman-ruang') }}"
                            class="text-gray-400! no-underline!">Peminjaman-Ruangan</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">detail-peminjaman-ruangan</a>
                    </div>
                    @include('components.mahasiswa.contentDetailPeminjamanRuangan')
                @elseif ($halaman === 'contentListPeminjaman')
                    <h4>Cart Peminjaman</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Cart-peminjaman</a>
                    </div>
                    @include('components.mahasiswa.contentListPeminjaman')
                @elseif ($halaman === 'contentDetailTransaksiPeminjamanMhs')
                    <h4>Detail Transaksi</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('mhs-list-peminjaman') }}"
                            class="text-gray-400! no-underline!">Cart-peminjaman</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">detail-transaksi</a>
                    </div>
                    @include('components.mahasiswa.contentDetailTransaksi')
                @elseif ($halaman === 'contentRiwayat')
                    <h4>Riwayat Peminjaman</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('mhs-list-peminjaman') }}"
                            class="text-gray-400! no-underline! font-medium">Riwayat-peminjaman</a>
                    </div>
                    @include('components.mahasiswa.contentRiwayat')
                @elseif ($halaman === 'contentRiwayatDetail')
                    <h4>Riwayat Peminjaman</h4>
                    <div class="pb-4">
                        <a href="{{ route('dashboard-mhs') }}" class="text-gray-400! no-underline!">Dahsboard-mahasiswa</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('mhs-riwayat') }}" class="text-gray-400! no-underline!">Riwayat-peminjaman</a>
                        <span class="text-gray-500">/</span>
                        <a href="" class="text-gray-400! no-underline! font-medium">Riwayat-detail-transaksi</a>
                    </div>
                    @include('components.mahasiswa.contentDetailRiwayat')
                @endif
                {{-- end isi content --}}
            </div>
        </div>
    </div>

@endsection
