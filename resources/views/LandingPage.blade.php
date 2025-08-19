<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite([
        // css js app
        'resources/css/app.css',
        'resources/js/app.js',
        // css js ruang-admin
        // 'resources/css/ruang-admin.css',
        // 'resources/js/ruang-admin.js',
    ])

    <title>Landing Page</title>
</head>

<body id="page-top " class=".container-fluid">
    <div id="wrapper">
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
               
                <a href="{{ url('/dashboardMhs') }}">Menuju Halaman dashboard mhs</a><br>
                <a href="{{ url('/dashboardAdmin') }}">Menuju Halaman dashboard admin</a>
                
                
              
            </div>
        </div>
    </div>

</body>

</html>
