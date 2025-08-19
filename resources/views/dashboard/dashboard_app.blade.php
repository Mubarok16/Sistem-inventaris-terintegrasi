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
        // css js ruang-admin
        'resources/css/ruang-admin.css',
        'resources/js/ruang-admin.js',
    ])
</head>
<body id="page-top " class=".container-fluid">
    <div id="wrapper">
        @yield('content')
    </div> 
</body>
</html>
