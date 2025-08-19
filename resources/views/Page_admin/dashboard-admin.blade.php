@extends('dashboard.dashboard_app')

@section('title', 'dashboard admin')

@section('content')
    {{-- Sidebar --}}
        @include('Page_admin.sidebar-admin')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Navbar --}}
                @include('dashboard.navbar')

                <div class="container-fluid" id="container-wrapper">
                    {{-- isi content --}}
                    <h1>Welcome to dashboard admin</h1>
                    <p>This is the main content of the dashboard admin.!!</p>
                </div>
            </div>
        </div>
    
@endsection
