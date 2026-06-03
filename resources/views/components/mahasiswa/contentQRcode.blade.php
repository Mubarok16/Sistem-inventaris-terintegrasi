<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tampilan Kode QR Peminjaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background-light text-[#0d131b] font-display min-h-screen flex flex-col overflow-x-hidden relative">

    <div id="popup-belum-waktu" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full text-center shadow-2xl border border-slate-100">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Waktunya Mengambil</h3>
            <p class="text-sm text-slate-500 mb-6">QR Code belum aktif. Silakan tunggu hingga waktu jadwal peminjaman dimulai:</p>

            <div class="flex items-center justify-between gap-2 text-center max-w-[240px] mx-auto mb-6">
                <div class="flex flex-col flex-1">
                    <div class="bg-slate-50 rounded py-2 border border-slate-200 shadow-sm">
                        <span id="p1-jam" class="text-lg font-bold font-mono text-blue-600">00</span>
                    </div>
                </div>
                <span class="text-slate-400 font-bold">:</span>
                <div class="flex flex-col flex-1">
                    <div class="bg-slate-50 rounded py-2 border border-slate-200 shadow-sm">
                        <span id="p1-menit" class="text-lg font-bold font-mono text-blue-600">00</span>
                    </div>
                </div>
                <span class="text-slate-400 font-bold">:</span>
                <div class="flex flex-col flex-1">
                    <div class="bg-slate-50 rounded py-2 border border-slate-200 shadow-sm">
                        <span id="p1-detik" class="text-lg font-bold font-mono text-blue-600">00</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('mhs-riwayat-detail', ['id' => $kode_peminjaman]) }}"
                class="w-full inline-block bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 px-4 rounded-xl text-sm transition-colors">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div id="popup-terlambat" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full text-center shadow-2xl border border-red-100">
            <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-red-600 mb-2">Waktu Peminjaman Habis!</h3>
            <p class="text-sm text-slate-500 mb-6">Anda telah melewati batas akhir pengembalian. Segera kembalikan barang/ruangan ke meja petugas.</p>

            <p class="text-xs font-semibold text-slate-400 uppercase mb-2">Waktu Terlambat:</p>
            <div class="flex items-center justify-between gap-2 text-center max-w-[240px] mx-auto mb-6">
                <div class="flex flex-col flex-1">
                    <div class="bg-red-50 rounded py-2 border border-red-200 shadow-sm">
                        <span id="p2-jam" class="text-lg font-bold font-mono text-red-600">00</span>
                    </div>
                </div>
                <span class="text-red-400 font-bold">:</span>
                <div class="flex flex-col flex-1">
                    <div class="bg-red-50 rounded py-2 border border-red-200 shadow-sm">
                        <span id="p2-menit" class="text-lg font-bold font-mono text-red-600">00</span>
                    </div>
                </div>
                <span class="text-red-400 font-bold">:</span>
                <div class="flex flex-col flex-1">
                    <div class="bg-red-50 rounded py-2 border border-red-200 shadow-sm">
                        <span id="p2-detik" class="text-lg font-bold font-mono text-red-600">00</span>
                    </div>
                </div>
            </div>
            <button onclick="document.getElementById('popup-terlambat').classList.add('hidden')"
                class="w-full inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-4 rounded-xl text-sm transition-colors mb-2">
                Saya Mengerti, Tutup Peringatan
            </button>
        </div>
    </div>

    <main class="flex-grow flex flex-col items-center justify-center py-10 px-4 sm:px-6">
        <div class="text-center mb-8 max-w-lg">
            <h1 class="text-3xl font-bold tracking-tight text-[#0d131b] mb-2">Kode QR Peminjaman</h1>
            <p class="text-slate-500 text-sm">
                Gunakan kode ini untuk verifikasi pengambilan dan pengembalian barang di meja petugas.
            </p>
        </div>

        <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-[#e7ecf3] overflow-hidden">
            <div class="p-8 flex flex-col items-center">
                
                @if (($Pengambilan->status_usage ?? '') === 'terjadwal' || ($Pengembalian->status_usage ?? '') === 'dipinjam' || ($Pengembalian->status_usage ?? '') === 'digunakan')
                    @if (($Pengambilan->status_usage ?? '') === 'terjadwal')
                        <p class="font-semibold text-black text-xs uppercase mb-1">Rentang Penggunaan</p>
                        <p class="font-bold text-blue-700 text-sm uppercase mb-3 tracking-wide">
                            @if(isset($semuaRiwayatTergabung) && $semuaRiwayatTergabung->count() > 1)
                                {{ \Carbon\Carbon::parse($semuaRiwayatTergabung->min('tgl_pinjam_usage'))->format('d M') }} 
                                - 
                                {{ \Carbon\Carbon::parse($semuaRiwayatTergabung->max('tgl_pinjam_usage'))->format('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($Pengambilan->tgl_pinjam_usage)->format('d M Y') }}
                            @endif
                        </p>
                        <div class="mb-6 flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100">
                            <div class="size-2 rounded-full bg-blue-500 animate-pulse"></div>
                            <span class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Belum Diambil</span>
                        </div>
                    @else
                        <div class="mb-6 flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 border border-green-100">
                            <div class="size-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-xs font-semibold text-green-700 uppercase tracking-wide">Sedang Aktif Dipinjam</span>
                        </div>
                    @endif
                @else
                    <div class="mb-6 flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 border border-gray-100">
                        <div class="size-2 rounded-full bg-gray-500"></div>
                        <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Tidak Berlaku</span>
                    </div>
                @endif

                <div class="bg-white p-4 rounded-xl border-2 border-dashed border-slate-200 mb-6">
                    <div class="visible-print text-center">
                        {!! QrCode::size(200)->generate($kode_peminjaman) !!}
                    </div>
                </div>

                <div class="text-center space-y-1 mb-4">
                    <p class="text-sm text-slate-500">Tunjukkan kepada petugas untuk dipindai</p>
                </div>

                <div class="w-full p-4 bg-background-light rounded-lg mb-1">
                    <p id="status-text" class="text-sm text-slate-500 text-center mb-3">Sinkronisasi Waktu...</p>

                    <div class="flex items-center justify-between gap-2 text-center">
                        <div class="flex flex-col flex-1">
                            <span class="text-xs text-slate-500 uppercase font-semibold mb-1">Jam</span>
                            <div class="bg-white rounded py-2 border border-slate-200 shadow-sm">
                                <span id="main-jam" class="text-lg font-bold font-mono text-primary">00</span>
                            </div>
                        </div>
                        <span class="text-slate-400 font-bold mt-4">:</span>

                        <div class="flex flex-col flex-1">
                            <span class="text-xs text-slate-500 uppercase font-semibold mb-1">Menit</span>
                            <div class="bg-white rounded py-2 border border-slate-200 shadow-sm">
                                <span id="main-menit" class="text-lg font-bold font-mono text-primary">00</span>
                            </div>
                        </div>
                        <span class="text-slate-400 font-bold mt-4">:</span>

                        <div class="flex flex-col flex-1">
                            <span class="text-xs text-slate-500 uppercase font-semibold mb-1">Detik</span>
                            <div class="bg-white rounded py-2 border border-slate-200 shadow-sm">
                                <span id="main-detik" class="text-lg font-bold font-mono text-primary">00</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-center text-xs text-slate-400 mt-3">Kode berlaku terbatas untuk keamanan</p>
                </div>
            </div>
            <div class="bg-slate-50 p-4 border-t border-[#e7ecf3] flex justify-center">
                <button class="text-sm font-medium text-slate-500 hover:text-primary transition-colors">
                    Perlu bantuan? Hubungi Admin
                </button>
            </div>
        </div>

        <div class="mt-8">
            <a class="no-underline! inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-[#0d131b] transition-colors"
                href="{{ route('mhs-riwayat-detail', ['id' => $kode_peminjaman]) }}">
                <i class="fa-solid fa-arrow-left text-[18px] no-underline!"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </main>

    @php
        $tglMulai = $Pengambilan->tgl_pinjam_usage;
        $jamMulai = $Pengambilan->jam_mulai_usage ?? '00:00:00';

        // Cari tanggal paling akhir (max) dari seluruh records rangkaian hari peminjaman
        $tglTerakhir = isset($semuaRiwayatTergabung) ? $semuaRiwayatTergabung->max('tgl_pinjam_usage') : $tglMulai;
        $jamSelesai = $Pengembalian->jam_selesai_usage ?? $Pengambilan->jam_selesai_usage ?? '23:59:59';

        // Ditransfer aman ke format ISO-8601 tanpa gangguan offset Client/Server
        $waktuMulaiIso = \Carbon\Carbon::parse($tglMulai . ' ' . $jamMulai)->toIso8601String();
        $waktuSelesaiIso = \Carbon\Carbon::parse($tglTerakhir . ' ' . $jamSelesai)->toIso8601String();
    @endphp

    <script>
        // Ambil Data Waktu Absolut dari Blade Backend
        const waktuMulai = new Date("{{ $waktuMulaiIso }}").getTime();
        const waktuSelesai = new Date("{{ $waktuSelesaiIso }}").getTime();
        const statusUsage = "{{ $Pengembalian->status_usage ?? $Pengambilan->status_usage ?? 'terjadwal' }}";

        // Element DOM Utama
        const mainJam = document.getElementById('main-jam');
        const mainMenit = document.getElementById('main-menit');
        const mainDetik = document.getElementById('main-detik');
        const statusText = document.getElementById('status-text');

        // Element DOM Popup Belum Waktunya
        const popBelum = document.getElementById('popup-belum-waktu');
        const p1Jam = document.getElementById('p1-jam');
        const p1Menit = document.getElementById('p1-menit');
        const p1Detik = document.getElementById('p1-detik');

        // Element DOM Popup Terlambat
        const popTerlambat = document.getElementById('popup-terlambat');
        const p2Jam = document.getElementById('p2-jam');
        const p2Menit = document.getElementById('p2-menit');
        const p2Detik = document.getElementById('p2-detik');

        function ubahWarnaMainTimer(keMerah) {
            [mainJam, mainMenit, mainDetik].forEach(el => {
                if (keMerah) {
                    el.classList.remove('text-primary');
                    el.classList.add('text-red-600');
                } else {
                    el.classList.remove('text-red-600');
                    el.classList.add('text-primary');
                }
            });
        }

        function runner() {
            const sekarang = new Date().getTime();

            // =========================================================================
            // SKENARIO 1: Belum Masuk Waktu Pinjam (Waktu Sekarang < Waktu Mulai)
            // =========================================================================
            if (sekarang < waktuMulai) {
                let selisihWaktu = Math.floor((waktuMulai - sekarang) / 1000);
                
                // Kalkulasi total Jam (Aman jika hitung mundur bernilai hari/panjang)
                let jam = Math.floor(selisihWaktu / 3600);
                let menit = Math.floor((selisihWaktu % 3600) / 60);
                let detik = selisihWaktu % 60;

                popBelum.classList.remove('hidden');
                popTerlambat.classList.add('hidden');
                ubahWarnaMainTimer(false);

                p1Jam.textContent = String(jam).padStart(2, '0');
                p1Menit.textContent = String(menit).padStart(2, '0');
                p1Detik.textContent = String(detik).padStart(2, '0');

                statusText.textContent = "Waktu Pengambilan Dibuka Dalam:";
                mainJam.textContent = String(jam).padStart(2, '0');
                mainMenit.textContent = String(menit).padStart(2, '0');
                mainDetik.textContent = String(detik).padStart(2, '0');
            } 
            
            // =========================================================================
            // SKENARIO 2: Rentang Waktu Pemakaian Berjalan (3 Hari Penuh Berlangsung)
            // =========================================================================
            else if (sekarang >= waktuMulai && sekarang < waktuSelesai) {
                popBelum.classList.add('hidden');
                popTerlambat.classList.add('hidden');
                ubahWarnaMainTimer(true); // Warna teks di bawah QR berubah MERAH

                statusText.textContent = "Barang dan Ruangan sedang digunakan (Sisa Waktu):";

                let selisihSelesai = Math.floor((waktuSelesai - sekarang) / 1000);
                
                let jam = Math.floor(selisihSelesai / 3600); 
                let menit = Math.floor((selisihSelesai % 3600) / 60);
                let detik = selisihSelesai % 60;

                mainJam.textContent = String(jam).padStart(2, '0');
                mainMenit.textContent = String(menit).padStart(2, '0');
                mainDetik.textContent = String(detik).padStart(2, '0');
            } 
            
            // =========================================================================
            // SKENARIO 3: Melebihi Batas Selesai Hari Ke-3 & Status Masih Dipinjam
            // =========================================================================
            else {
                popBelum.classList.add('hidden');
                ubahWarnaMainTimer(true);

                let selisihTerlambat = Math.floor((sekarang - waktuSelesai) / 1000);
                let jam = Math.floor(selisihTerlambat / 3600);
                let menit = Math.floor((selisihTerlambat % 3600) / 60);
                let detik = selisihTerlambat % 60;

                statusText.textContent = "Waktu terlambat pengembalian:";
                mainJam.textContent = String(jam).padStart(2, '0');
                mainMenit.textContent = String(menit).padStart(2, '0');
                mainDetik.textContent = String(detik).padStart(2, '0');

                // Jika statusnya terdeteksi aktif dipinjam/digunakan, kunci layar dengan Popup Terlambat
                if (statusUsage === 'dipinjam' || statusUsage === 'digunakan') {
                    popTerlambat.classList.remove('hidden');
                    p2Jam.textContent = String(jam).padStart(2, '0');
                    p2Menit.textContent = String(menit).padStart(2, '0');
                    p2Detik.textContent = String(detik).padStart(2, '0');
                } else {
                    popTerlambat.classList.add('hidden');
                }
            }
        }

        // Eksekusi sistem secara berkala
        runner();
        setInterval(runner, 1000);
    </script>
</body>

</html>