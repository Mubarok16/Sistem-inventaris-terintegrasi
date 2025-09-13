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
                    {{-- isi content --}}
                    <h1>Welcome to dashboard kaprodi</h1>
                    <p>This is the main content of the dashboard kaprodi</p>
                </div>
            </div>
        </div>
    
@endsection
