@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard mahasiswa')

@section('content')
    {{-- Sidebar --}}
        @include('Page_mhs.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Navbar --}}
                @include('components.dashboard.navbar')

                <div class="container-fluid" id="container-wrapper">
                    {{-- isi content --}}
                    
                    
                    {{-- @include('components.mahasiswa.'. ($halaman === 'contentDashbord' ? 'contentDashbord' : ($halaman === 'contentPeminjamanBarang' ? 'contentPeminjamanBarang' : 'contentPeminjamanBarang'))) --}}
                    @if ($halaman === 'contentDashbord')
                        <h4>Dashboard</h4>
                        @include('components.mahasiswa.contentDashbordMhs')
                    @elseif ($halaman === 'contentPeminjamanBarang')
                        <h4>Peminjaman Barang</h4>
                        @include('components.mahasiswa.contentPeminjamanBarang')
                    @elseif ($halaman === 'contentPeminjamanRuang')
                        <h4>Peminjaman Ruang</h4>
                        @include('components.mahasiswa.contentPeminjamanRuang')
                    @elseif ($halaman === 'contentListPeminjaman')
                        <h4>List Peminjaman</h4>
                        @include('components.mahasiswa.contentListPeminjaman')
                    @elseif ($halaman === 'contentRiwayat')
                        <h4>Riwayat</h4>
                        @include('components.mahasiswa.contentRiwayat')
                    @endif
                    {{-- end isi content --}}
                </div>
            </div>
        </div>
    
@endsection
