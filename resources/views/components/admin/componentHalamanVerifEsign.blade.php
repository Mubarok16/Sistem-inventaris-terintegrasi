<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi E-Sign - Universitas Wiralodra</title>
    {{-- <script src="https://tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cloudflare.com"> --}}

    @vite([
        // css js app
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <!-- Header -->
        <div class="bg-emerald-600 p-6 text-center text-white">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                {{-- <i class="fa-solid fa-shield-check text-2xl"></i> --}}
                <i class="fa-solid fa-circle-check text-7xl"></i>
            </div>
            <h1 class="text-xl font-bold">Dokumen Terverifikasi</h1>
            <p class="text-emerald-100 text-sm">Tanda Tangan Elektronik SAH</p>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <div class="pb-4 border-bottom border-slate-100 text-center">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Nomor Surat</p>
                <p class="text-slate-800 font-mono font-medium">{{ $data->id_pengadaan }}</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-file-lines text-slate-400 mt-1"></i>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">Jenis Dokumen</p>
                        <p class="text-sm text-slate-800">Surat Pengajuan Pengadaan Barang</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-box text-slate-400 mt-1"></i>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">Barang</p>
                        <p class="text-sm text-slate-800">{{ $data->qty_item }} Unit {{ $data->nama_item }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-user-check text-slate-400 mt-1"></i>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">Penandatangan (E-Sign)</p>
                        <p class="text-sm text-slate-800 font-bold text-emerald-700">{{ $data->nama }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-calendar-check text-slate-400 mt-1"></i>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">Waktu Ditandatangani (E-SIGN)</p>
                        <p class="text-sm text-slate-800">
                            {{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d F Y H:i') }} WIB</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 italic">
                    Dokumen ini dihasilkan secara elektronik oleh Sistem Informasi Pengadaan Universitas Wiralodra.
                    Segala bentuk manipulasi data pada halaman ini adalah pelanggaran hukum.
                </p>
            </div>
        </div>
    </div>

</body>

</html>
