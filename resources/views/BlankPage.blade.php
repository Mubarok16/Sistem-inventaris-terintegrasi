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
    ])


    <title>Landing Page</title>
</head>

<body id="page-top " class=".container-fluid"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.712), rgba(1, 1, 19, 0.897)), url('{{ asset('images/backgoound.jpg') }}'); background-size: cover; background-repeat: no-repeat;   background-position: center center;   background-attachment: fixed;">

    <!-- Login 13 - Bootstrap Brain Component -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="{{ asset('images/logo_ft.png') }}" class=" mx-auto"
                                        alt="BootstrapBrain Logo" width="100" height="57">
                                </a>
                            </div>
                            <h5 class="fs-6 fw-normal text-center text-secondary mb-4">Sistem Peminjaman sarana dan
                                prasarana terintegrasi</h5>
                            {{-- <h5 class="fs-6 fw-normal text-center text-secondary mb-2">Fakultas Teknik Unwir</h5> --}}
                            <p class="text-secondary mb-2">Sign in</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder=" " required>
                                            <label class="form-label">username</label>

                                        </div>
                                    </div>
                                    <div class="col-12 m-0">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password"
                                                value="" placeholder=" " required>
                                            <label for="password" class="form-label">password</label>

                                        </div>
                                    </div>
                                    <div class="col-12 m-0">
                                        <div class="d-flex gap-2 justify-content-between">
                                            {{-- <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="rememberMe" id="rememberMe">
                                                <p class="form-check-label text-secondary">
                                                    click for sign in
                                                </p>
                                            </div> --}}
                                            <p class="form-check-label text-secondary">
                                                click bellow for sign in
                                            </p>
                                            <a href="#!" class="link-primary text-decoration-none">Forgot
                                                password?</a>
                                        </div>
                                    </div>
                                    <div class="col-12 m-0">
                                        <div class="d-grid my-2 ">
                                            <button class="btn btn-primary w-100" type="submit">Log in</button>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <p class="m-0 text-secondary text-center">Don't have an account? <a
                                                href="#!" class="link-primary text-decoration-none">Sign up</a></p>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
