# Perbaikan Penyimpanan Gambar – Laravel Cloud

## Perubahan pada kode

- Upload gambar barang & ruangan menggunakan disk **`public`**, bukan `s3` manual. Cloud environment ini menyuntikkan Object Storage dengan nama disk `public`.
- Seluruh URL gambar barang/ruangan dan foto identitas di Blade menggunakan `Storage::disk('public')->url(...)` atau base URL disk `public` untuk Alpine/JavaScript; tidak lagi mengandalkan `/storage` lokal di production.
- Penghapusan ruangan mencoba menghapus foto dari disk `public` **setelah** baris database berhasil dihapus, sehingga kegagalan foreign key tidak menghapus foto lebih dulu.
- `config/filesystems.php` mengaktifkan `throw` pada disk `public` agar kegagalan menulis gambar tidak diam-diam dianggap berhasil. Disk `s3` tetap ada untuk kompatibilitas, tetapi alur gambar tidak menggunakannya.
- `.env.example`: `FILESYSTEM_DISK=public` untuk development lokal. Jalankan `php artisan storage:link` jika menggunakan local public disk. **Di Laravel Cloud, `public` ditangani oleh disk terinjeksi Cloud**, bukan oleh link lokal tersebut.

## Pengaturan environment di Laravel Cloud

1. Pastikan layanan **Object Storage** sudah tertaut ke `production`, dan `Injected variables` berisi `FILESYSTEM_DISK=public` serta `LARAVEL_CLOUD_DISK_CONFIG=...`.
2. Pada **Custom environment variables**, hapus variabel AWS manual yang Anda tambahkan sebelumnya (`AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET`, `AWS_ENDPOINT`, `AWS_URL`, dan konfigurasi AWS lain) **hanya setelah resource Cloud dipastikan terhubung**.
3. Pertahankan `SESSION_DRIVER=database` yang sudah memperbaiki draft Tambah/Edit Agenda.
4. Jangan mengganti `APP_KEY` secara sembarangan. Jika sudah terungkap secara publik, rencanakan rotasi dengan memperhatikan data terenkripsi.
5. Simpan pengaturan, deploy ulang aplikasi, lalu tes tambah barang, edit gambar barang, tambah/ubah ruangan, dan gambar pada halaman admin, mahasiswa, pimpinan.
6. Jika masih muncul `401 Unauthorized`, cek bahwa Object Storage **yang tepat** terhubung ke `production` dan kredensial diinjeksi oleh Cloud. Ini tidak dapat diverifikasi offline hanya dari kode.

## Catatan penting

- Path gambar tetap relatif (`uploads/barang/...`, `uploads/ruangan/...`); database tidak perlu migrasi hanya untuk perubahan disk.
- **Berkas lama tidak dipindahkan secara otomatis.** Jika gambar terdahulu berada di bucket S3/R2 yang berbeda dari disk `public` Cloud, migrasikan file tersebut sebelum mengharapkan semua gambar lama tampil.
- Jika Cloud menggunakan URL publik berbeda atau akses objek bersifat privat, pengaturan Object Storage perlu dicek langsung dari dashboard.
- Jangan pernah menaruh kredensial AWS/R2 ke repository. Key yang pernah dibagikan perlu dirotasi/dinonaktifkan dengan membuat key baru di penyedia storage.
- Folder `vendor` tidak disertakan dalam paket source. Jalankan Composer dan test deployment sesuai lingkungan Anda.

## Pemeriksaan pasca-deploy

- **Tambah Barang** dengan gambar baru → data tersimpan dan URL gambar terbuka.
- **Edit Barang** mengganti foto → foto baru tampil.
- **Tambah/Edit Ruangan** → foto bisa disimpan dan ditampilkan.
- **Hapus Ruangan** → hanya boleh jika tidak tertahan foreign key; jika gagal, file foto tidak ikut terhapus.
- **Halaman agenda, pengajuan, laporan, user/mahasiswa, dan pimpinan** → gambar tidak lagi memanggil URL bucket S3 manual atau URL storage lokal yang salah.
- **Edit/tambah agenda** tetap berjalan seperti sebelum patch; perubahan ini tidak menyentuh controller agenda, import, maupun fungsi laporan.
