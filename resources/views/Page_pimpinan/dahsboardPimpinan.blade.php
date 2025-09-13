@extends('components.dashboard.dashboard_app')

@section('title', 'dashboard pimpinan')

@section('content')
    {{-- Sidebar --}}
        @include('Page_pimpinan.sidebar-pimpinan')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Navbar --}}
                @include('components.dashboard.navbar')

                <div class="container-fluid" id="container-wrapper">
                    {{-- isi content --}}
                    <h1>Welcome to dashboard pimpinan</h1>
                    <p>This is the main content of the dashboard pimpinan</p>
                </div>
            </div>
        </div>
    
@endsection
