<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#102a56">
@vite(['resources/css/app.css','resources/js/app.js'])
<title>Daftar Akun | SIPRA Fakultas Teknik UNWIR</title>
<style>
:root{--navy:#102a56;--blue:#1d4ed8;--ink:#172b4d;--muted:#64748b;--line:#e5ebf3}
*{box-sizing:border-box}body{margin:0;background:#f4f7fb;color:var(--ink);font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif}
.shell{min-height:100vh;padding:24px clamp(12px,3vw,44px);background:radial-gradient(ellipse at 8% 0%,#dbeafe 0,transparent 32%),radial-gradient(ellipse at 100% 90%,#e0f2fe 0,transparent 30%),#f6f8fc}
.top{max-width:1120px;margin:0 auto 22px;display:flex;align-items:center;justify-content:space-between;gap:14px}.brand{display:flex;align-items:center;gap:12px}.brand img{width:54px;height:48px;object-fit:contain}.brand h2{font-size:1rem;font-weight:850;letter-spacing:.04em;color:var(--navy);margin:0}.brand p{font-size:.76rem;color:var(--muted);margin:3px 0 0}.public-pill{border:1px solid #dbeafe;background:#fff;color:#1d4ed8;border-radius:999px;padding:9px 13px;font-size:.75rem;font-weight:800}
.layout{max-width:1120px;margin:0 auto;display:grid;grid-template-columns:minmax(280px,.75fr) minmax(0,1.25fr);gap:22px;align-items:stretch}.intro-panel{position:relative;overflow:hidden;padding:clamp(25px,3vw,38px);border-radius:24px;background:linear-gradient(145deg,#102a56,#17477e 70%,#17649a);color:#fff;box-shadow:0 22px 55px #102a5626}.intro-panel:after{content:"";position:absolute;width:270px;height:270px;right:-140px;top:-130px;border:1px solid #ffffff24;border-radius:50%;box-shadow:0 0 0 35px #ffffff09,0 0 0 70px #ffffff08}.intro-inner{position:relative;z-index:1}.eyebrow{font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;font-weight:850;color:#bfdbfe;margin-bottom:25px}.intro-panel h1{font-size:clamp(2rem,3vw,2.65rem);line-height:1.1;letter-spacing:-.04em;font-weight:850;margin:0 0 16px}.intro-panel p{color:#d5e5f8;font-size:.9rem;line-height:1.8;margin:0 0 26px}.benefit{display:flex;gap:12px;align-items:flex-start;padding:13px 0;border-top:1px solid #ffffff22;color:#e2edfb;font-size:.82rem;line-height:1.6}.benefit b{display:block;color:#fff;font-size:.85rem}.benefit-icon{width:34px;height:34px;display:flex;align-items:center;justify-content:center;flex:0 0 34px;border:1px solid #ffffff35;background:#ffffff12;border-radius:10px}
.form-panel{background:#fff;border:1px solid var(--line);border-radius:24px;overflow:hidden;box-shadow:0 15px 45px #172b4d0d}.form-heading{padding:25px 28px 20px;border-bottom:1px solid #edf1f6}.form-heading .kicker{font-size:.7rem;letter-spacing:.14em;text-transform:uppercase;font-weight:850;color:#2563eb;margin-bottom:8px}.form-heading h2{font-size:1.65rem;letter-spacing:-.035em;font-weight:850;margin:0 0 7px}.form-heading p{font-size:.84rem;line-height:1.6;color:var(--muted);margin:0}.form-body{padding:24px 28px 28px}.field{margin-bottom:17px}.field label{display:block;font-size:.78rem;font-weight:800;color:#334155;margin-bottom:7px}.field .form-control,.field .form-select{min-height:46px;border:1px solid #dbe3ed;border-radius:10px;background:#f8fafc;color:#172b4d;font-size:.88rem;box-shadow:none}.field .form-control:focus,.field .form-select:focus{border-color:#60a5fa;background:#fff;box-shadow:0 0 0 3px #60a5fa25}.field .form-control[readonly],.field .form-select:disabled{background:#eff6ff;color:#1e40af;border-color:#bfdbfe;opacity:1}.field-hint{font-size:.72rem;color:#64748b;margin-top:6px;line-height:1.5}.npm-status{display:none;margin-top:9px;padding:10px 12px;border-radius:10px;font-size:.77rem;line-height:1.5}.npm-status.success{display:block;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}.npm-status.error{display:block;background:#fff7ed;border:1px solid #fed7aa;color:#9a3412}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 14px}.wide{grid-column:1/-1}.submit-btn{min-height:48px;border:0;border-radius:11px;background:#1d4ed8;color:#fff;font-weight:850;box-shadow:0 8px 20px #1d4ed829}.submit-btn:hover{background:#1e40af;color:#fff}.bottom-links{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:18px;font-size:.78rem}.bottom-links a{color:#1d4ed8;font-weight:800;text-decoration:none}.bottom-links a:hover{text-decoration:underline}.footer{max-width:1120px;margin:18px auto 0;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;color:#8995a7;font-size:.72rem}
@media(max-width:820px){.shell{padding:15px 12px}.layout{grid-template-columns:1fr}.intro-panel{padding:24px}.intro-panel h1{font-size:2rem}.intro-panel p{margin-bottom:18px}.benefit{padding:9px 0}.form-heading{padding:22px 20px 17px}.form-body{padding:20px}.top{margin-bottom:15px}}@media(max-width:480px){.brand img{width:44px;height:40px}.brand h2{font-size:.86rem}.brand p{font-size:.67rem}.public-pill{font-size:.67rem;padding:8px}.form-grid{grid-template-columns:1fr}.wide{grid-column:auto}.form-heading h2{font-size:1.45rem}}
</style>
</head>
<body><div class="shell">
<header class="top"><div class="brand"><img src="{{ asset('images/logo_ft.png') }}" alt="Logo Fakultas Teknik UNWIR"><div><h2>SIPRA <span style="color:#64748b;font-weight:600">| UNWIR</span></h2><p>Sistem Informasi Sarana dan Prasarana</p></div></div><div class="public-pill">Pendaftaran mahasiswa</div></header>
@if (session('success') || session('gagal') || $errors->any())
<div style="max-width:1120px;margin:0 auto 16px">
@if(session('success'))<div class="alert alert-success mb-2" role="alert">{{ session('success') }}</div>@endif
@if(session('gagal'))<div class="alert alert-danger mb-2" role="alert">{{ session('gagal') }}</div>@endif
@if($errors->any())<div class="alert alert-danger mb-2" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
</div>
@endif
<main class="layout">
<section class="intro-panel"><div class="intro-inner"><div class="eyebrow">Fakultas Teknik · Universitas Wiralodra</div><h1>Mulai akses<br>SIPRA dengan mudah.</h1><p>Buat akun mahasiswa untuk mengakses layanan peminjaman sarana dan prasarana fakultas. Program studi dan tahun masuk akan terisi otomatis berdasarkan NPM Anda.</p>
<div class="benefit"><span class="benefit-icon">✓</span><div><b>Identitas terdeteksi otomatis</b>Kode program studi dan tahun masuk dibaca dari NPM.</div></div>
<div class="benefit"><span class="benefit-icon">◈</span><div><b>Siapkan foto KTM</b>Unggah foto kartu tanda mahasiswa untuk verifikasi akun.</div></div>
<div class="benefit"><span class="benefit-icon">⌁</span><div><b>Aktivasi akun</b>Akun baru menunggu aktivasi sesuai prosedur pengelola.</div></div>
</div></section>
<section class="form-panel"><div class="form-heading"><div class="kicker">Registrasi mandiri</div><h2>Daftar akun mahasiswa</h2><p>Masukkan NPM 12 digit. Prodi dan tahun masuk akan ditentukan otomatis dari kode NPM.</p></div>
<div class="form-body"><form method="POST" action="{{ route('daftar') }}" enctype="multipart/form-data" id="student-registration-form">@csrf
<div class="field"><label for="no_identitas">Nomor Pokok Mahasiswa (NPM)</label><input type="text" inputmode="numeric" pattern="[0-9]{12}" maxlength="12" minlength="12" class="form-control" name="no_identitas" id="no_identitas" value="{{ old('no_identitas') }}" placeholder="Contoh: 562020121040" autocomplete="off" required><div class="field-hint">5 digit pertama adalah kode prodi; digit ke-8 dan ke-9 menunjukkan tahun masuk.</div><div id="npm-status" class="npm-status" role="status" aria-live="polite"></div></div>
<div class="form-grid">
<div class="field wide"><label for="nama_peminjam">Nama lengkap</label><input type="text" class="form-control" name="nama_peminjam" id="nama_peminjam" value="{{ old('nama_peminjam') }}" placeholder="Sesuai identitas mahasiswa" autocomplete="name" required></div>
<div class="field"><label for="username">Username</label><input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" placeholder="Buat username" autocomplete="username" required></div>
<div class="field"><label for="password">Password</label><input type="password" class="form-control" name="password" id="password" placeholder="Buat password" autocomplete="new-password" maxlength="12" required><div class="field-hint">Maksimal 12 karakter sesuai ketentuan saat ini.</div></div>
<div class="field"><label for="tahun_masuk">Tahun masuk</label><input type="text" class="form-control" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk') }}" placeholder="Otomatis dari NPM" readonly required></div>
<div class="field"><label for="prodi">Program studi</label><select name="prodi" id="prodi" class="form-select" required disabled><option value="">Terisi otomatis dari NPM</option>
<option value="teknik sipil">Teknik Sipil</option><option value="kesehatan masyarakat">Kesehatan Masyarakat</option><option value="agribisnis">Agribisnis</option><option value="agroteknologi">Agroteknologi</option><option value="teknik komputer">Teknik Komputer</option><option value="manajemen">Manajemen</option><option value="perbankan syariah">Perbankan Syariah</option><option value="ilmu pemerintahan">Ilmu Pemerintahan</option><option value="bimbingan konseling islam">Bimbingan dan Konseling Islam (BKPI)</option><option value="ilmu hukum">Ilmu Hukum</option><option value="pendidikan matematika">Pendidikan Matematika</option><option value="pendidikan biologi">Pendidikan Biologi</option><option value="pendidikan agama islam">Pendidikan Agama Islam (PAI)</option><option value="pendidikan bahasa indonesia">Pendidikan Bahasa dan Sastra Indonesia (PBSI)</option><option value="pendidikan bahasa inggris">Pendidikan Bahasa Inggris</option></select><div class="field-hint">Kolom ini dikunci agar sesuai dengan kode NPM.</div></div>
<div class="field wide"><label for="foto">Foto kartu tanda mahasiswa (KTM)</label><input type="file" name="img_identitas" id="foto" class="form-control" accept=".jpg,.jpeg,.png,image/jpeg,image/png" capture="environment" required><div class="field-hint">Format JPG atau PNG. Pastikan tulisan pada KTM terbaca jelas.</div></div>
</div>
<button class="btn submit-btn w-100" type="submit">Daftar akun →</button>
<div class="bottom-links"><a href="/">← Sudah punya akun? Masuk</a><span style="color:#64748b">Data prodi dan tahun diverifikasi saat disimpan.</span></div>
</form></div></section>
</main><footer class="footer"><span>© {{ date('Y') }} Fakultas Teknik · Universitas Wiralodra</span><span>SIPRA · Registrasi mahasiswa</span></footer></div>
<script>
(function(){
 const npm=document.getElementById('no_identitas'), prodi=document.getElementById('prodi'), year=document.getElementById('tahun_masuk'), status=document.getElementById('npm-status'), form=document.getElementById('student-registration-form');
 const programs={'22201':'teknik sipil','13201':'kesehatan masyarakat','54201':'agribisnis','54211':'agroteknologi','56202':'teknik komputer','61201':'manajemen','61206':'perbankan syariah','65201':'ilmu pemerintahan','70232':'bimbingan konseling islam','74201':'ilmu hukum','84202':'pendidikan matematika','84205':'pendidikan biologi','86208':'pendidikan agama islam','88201':'pendidikan bahasa indonesia','88203':'pendidikan bahasa inggris'};
 function resolveNpm(){const value=npm.value.trim();prodi.value='';year.value='';status.className='npm-status';status.textContent='';
   if(value.length===0)return;
   if(!/^\d{12}$/.test(value)){if(value.length>=5){status.className='npm-status error';status.textContent='NPM harus terdiri dari tepat 12 angka.';}return;}
   const code=value.slice(0,5), program=programs[code];
   if(!program){status.className='npm-status error';status.textContent='Kode prodi '+code+' belum dikenali. Periksa kembali NPM Anda.';return;}
   prodi.value=program;year.value=String(2000+Number(value.slice(7,9)));
   status.className='npm-status success';status.textContent='NPM dikenali: '+prodi.options[prodi.selectedIndex].text+' · Tahun masuk '+year.value+'.';
 }
 npm.addEventListener('input',resolveNpm);
 form.addEventListener('submit',function(event){resolveNpm();if(!/^\d{12}$/.test(npm.value.trim())||!prodi.value||!year.value){event.preventDefault();status.className='npm-status error';status.textContent='Masukkan NPM 12 digit yang memiliki kode prodi terdaftar sebelum melanjutkan.';npm.focus();}});
 if(npm.value)resolveNpm();
})();
</script>
</body></html>