<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    {{-- CSS --}}
    @vite([
        // css js app
        'resources/css/app.css',
        'resources/js/app.js',
    ])
    {{-- panggil css template --}}
    <link rel="stylesheet" href="{{ asset('css/ruang-admin.css') }}"> 
</head>
<body id="page-top " class=".container-fluid ">
    <div id="wrapper">
        @yield('content')
    </div>

    {{-- JS template --}}
    <script src="{{ asset('js/ruang-admin.js') }}"></script> 
</body>
</html>
