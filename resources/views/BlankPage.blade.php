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
    {{-- <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }

        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style> --}}

    <title>Landing Page</title>
</head>

<body id="page-top " class=".container-fluid" style="background-image: linear-gradient(rgba(0, 0, 0, 0.712), rgba(1, 1, 19, 0.897)), url('{{ asset('images/backgoound.jpg') }}'); background-size: cover; background-repeat: no-repeat;   background-position: center center;   background-attachment: fixed;">

    {{-- <section class="vh-100" style="background-color: #ffffff;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="{{ asset('images/login.png') }}" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem; height: 100%;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sistem peminjaman
                                            sarana dan prasarana</h5>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" id="form2Example17" name="username"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example17">Usename</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" id="form2Example27" name="password"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example27">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Login 13 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5" >
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="{{ asset('images/logo_ft.png') }}" class=" mx-auto" alt="BootstrapBrain Logo" width="100" height="57">
                                </a>
                            </div>
                            <h5 class="fs-6 fw-normal text-center text-secondary mb-4">Sign in to your account</h5>
                             <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder=" " required>
                                            <label for="email" class="form-label">username</label>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password"
                                                value="" placeholder=" " required>
                                            <label for="password" class="form-label">password</label>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="rememberMe" id="rememberMe">
                                                <label class="form-check-label text-secondary" for="rememberMe">
                                                    Keep me logged in
                                                </label>
                                            </div>
                                            <a href="#!" class="link-primary text-decoration-none">Forgot
                                                password?</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid my-2 ">
                                            <button class="btn btn-primary w-100" type="submit">Log in</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="m-0 text-secondary text-center">Don't have an account? <a
                                                href="#!" class="link-primary text-decoration-none">Sign up</a></p>
                                    </div>
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
