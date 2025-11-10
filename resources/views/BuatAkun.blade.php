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
    @if (session('success'))
        <div class="alert alert-success">
            <ul style="margin-bottom: 0;">
                {{ session('success') }}
            </ul>
        </div>
    @endif
    @if (session('gagal'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-danger">
            <ul style="margin-bottom: 0;">
                {{ session('gagal') }}
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
                                {{-- <a href="#!">
                                    <img src="{{ asset('images/logo_ft.png') }}" class=" mx-auto"
                                        alt="BootstrapBrain Logo" width="100" height="57">
                                </a> --}}
                            </div>
                            <h3 class="fs-7 fw-normal text-center text-secondary mb-2">Daftar Akun</h3>
                            <h5 class="fs-6 fw-normal text-center text-secondary mb-4">Sistem Peminjaman sarana dan
                                prasarana terintegrasi</h5>
                            {{-- <h5 class="fs-6 fw-normal text-center text-secondary mb-2">Fakultas Teknik Unwir</h5> --}}
                            <p class="text-secondary mb-2">Daftar</p>
                            <form method="POST" action="{{ route('daftar') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-2 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="no_identitas"
                                                id="no_identitas" placeholder=" " required>
                                            <label class="form-label">No Identitas (npm)</label>
                                        </div>
                                    </div>
                                    <div class="col-12 m-0">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="nama_peminjam"
                                                id="nama_peminjam" placeholder=" " required>
                                            <label class="form-label">nama</label>
                                        </div>
                                    </div>
                                    <div class="col-12 m-0">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder=" " required>
                                            <label class="form-label">username</label>
                                        </div>
                                    </div>
                                    <div class="col-12 m-0">
                                        <div class="form-floating mb-2">
                                            <input type="password" class="form-control" name="password" id="password"
                                                value="" placeholder=" " required>
                                            <label for="password" class="form-label">password</label>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-building-columns"></i>
                                            </span>
                                            <select name="prodi" id="prodi" class="form-select" required>
                                                <option value="">--- Pilih Prodi ---</option>
                                                <optgroup label="TEKNIK">
                                                    <option value="teknik sipil">Teknik Sipil</option>
                                                    <option value="teknik komputer">Teknik Komputer</option>
                                                </optgroup>
                                                <optgroup label="HUKUM">
                                                    <option value="ilmu hukum">Ilmu Hukum</option>
                                                </optgroup>
                                                <optgroup label="KEGURUAN DAN ILMU PENDIDIKAN">
                                                    <option value="pendidikan bahasa inggris">Pendidikan Bahasa Inggris
                                                    </option>
                                                    <option value="pendidikan bahasa indonesia">Pendidikan Bahasa
                                                        Indonesia</option>
                                                    <option value="pendidikan matematika">Pendidikan Matematika</option>
                                                    <option value="pendidikan biologi">Pendidikan Biologi</option>
                                                </optgroup>
                                                <optgroup label="ILMU SOSIAL DAN ILMU POLITIK">
                                                    <option value="ilmu politik">Ilmu Politik</option>
                                                </optgroup>
                                                <optgroup label="EKONOMI">
                                                    <option value="manajemen">Manajemen</option>
                                                </optgroup>
                                                <optgroup label="AGAMA ISLAM">
                                                    <option value="pendidikan agama islam">pendidikan agama islam
                                                    </option>
                                                    <option value="ekonomi syariah">ekonomi syariah</option>
                                                    <option value="bimbingan konseling islam">bimbingan konseling islam
                                                    </option>
                                                </optgroup>
                                                <optgroup label="PERTANIAN">
                                                    <option value="agribisnis">agribisnis</option>
                                                    <option value="agroteknologi">agribisnis</option>
                                                </optgroup>
                                                <optgroup label="KESEHATAN MASYARAKAT">
                                                    <option value="kesehatan masyarakat">Kesehatan Masyarakat</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0">
                                        <div class="mb-2">
                                            <label for="foto" class="form-label">Masukkan foto ktm</label>
                                            <input type="file" name="img_identitas" id="foto"
                                                class="form-control" accept="image/*" capture="environment" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary w-100" type="submit">Daftar Akun</button>
                                        </div>
                                    </div>

                                    <div class="col-12 m-0">
                                        <div class="d-flex gap-2 justify-content-between mt-2">
                                            <a href="/" class="link-primary text-decoration-none">Sudah Punya
                                                Akun?</a>
                                        </div>
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
