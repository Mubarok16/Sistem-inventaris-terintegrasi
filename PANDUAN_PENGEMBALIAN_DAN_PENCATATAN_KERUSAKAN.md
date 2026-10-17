# Fitur Pemeriksaan Pengembalian Barang dan Ruangan

## Alur penggunaan
1. Petugas admin memasukkan/scan `kode_peminjaman` pada kartu konfirmasi pengambilan dan pengembalian di dashboard.
2. Saat status penggunaan masih `terjadwal`, sistem menjalankan alur pengambilan yang sudah ada.
3. Saat aset berstatus `digunakan`, sistem membuka halaman **Pemeriksaan Pengembalian**.
4. Petugas mengisi jumlah unit barang yang rusak, kondisi ruangan, deskripsi kerusakan, dan foto bukti (opsional).
5. Setelah disimpan, sistem membuat catatan pemeriksaan, mengubah status penggunaan menjadi `selesai`, dan memperbarui inventaris jika ditemukan kerusakan.
6. Catatan dapat dilihat melalui tombol **Riwayat Pengembalian** pada dashboard admin.

## Database
Migration tambahan `2026_10_17_000001_create_pemeriksaan_pengembalian_table.php` membuat tabel `pemeriksaan_pengembalian`. Migration ini tidak mengubah atau menghapus data dari tabel lama.

Jalankan di lingkungan proyek:

```bash
php artisan migrate
php artisan storage:link
```

Jika aplikasi menggunakan disk `public` lokal, `storage:link` diperlukan agar foto kerusakan dapat dibuka dari riwayat. Pastikan folder storage dapat ditulis oleh proses PHP.

## Aturan pencatatan
- Barang: jumlah unit rusak tidak boleh melebihi jumlah unit yang dikembalikan. Deskripsi wajib jika jumlah rusak lebih dari nol.
- Ruangan: petugas memilih kondisi baik/rusak. Deskripsi wajib jika ruangan rusak.
- Foto bersifat opsional, harus berupa gambar, dan maksimal 4 MB.
- Jika barang rusak, jumlah persediaan dikurangi sesuai jumlah unit rusak. Jika persediaan menjadi nol, barang ditandai `Rusak` dan disembunyikan dari peminjaman.
- Jika ruangan rusak, ruangan ditandai `Rusak` dan dinonaktifkan dari peminjaman.
- Kerusakan otomatis dicatat pada alur `perawatan_barang` dengan status `pendding` agar bisa ditindaklanjuti melalui modul perawatan yang sudah tersedia.
- Akses formulir dan riwayat pemeriksaan dibatasi untuk admin.

## Catatan pengujian
File ini dibuat berdasarkan struktur proyek yang diberikan. Lakukan pengujian alur pengambilan/pengembalian dan migration di salinan database pengembangan terlebih dahulu sebelum deploy ke produksi.
