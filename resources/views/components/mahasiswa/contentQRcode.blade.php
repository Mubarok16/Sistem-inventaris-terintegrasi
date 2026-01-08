<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tampilan Kode QR</title>
    @vite([
        // css js app
        'resources/css/app.css',
        'resources/js/app.js',
    ])

</head>

<body class="bg-background-light text-[#0d131b] font-display min-h-screen flex flex-col overflow-x-hidden">
    <main class="flex-grow flex flex-col items-center justify-center py-10 px-4 sm:px-6">
        <div class="text-center mb-8 max-w-lg">
            <h1 class="text-3xl font-bold tracking-tight text-[#0d131b] mb-2">Kode QR Peminjaman</h1>
            <p class="text-slate-500 text-sm">
                Gunakan kode ini untuk verifikasi pengambilan dan pengembalian barang di meja petugas.
            </p>
        </div>
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-[#e7ecf3] overflow-hidden">
            <div class="p-8 flex flex-col items-center">
                {{-- {{ $status_peminjaman }} --}}
                @if ($status_peminjaman === 'terjadwal' || $status_peminjaman === 'dipinjam')

                    {{-- {{ $status_peminjaman }} --}}
                    @if ($status_peminjaman === 'terjadwal')
                        <div
                            class="mb-6 flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100">
                            <div class="size-2 rounded-full bg-blue-500 animate-pulse"></div>
                            <span class="text-xs font-semibold text-blue-700 uppercase tracking-wide">
                                Belum Diambil
                            </span>
                        </div>
                    @else
                        <div
                            class="mb-6 flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 border border-green-100">
                            <div class="size-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-xs font-semibold text-green-700 uppercase tracking-wide">
                                Belum Dikembalikan
                            </span>
                        </div>
                    @endif
                @else
                    <div class="mb-6 flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 border border-gray-100">
                        <div class="size-2 rounded-full bg-gray-500 animate-pulse"></div>
                        <span class="text-xs font-semibold text-gray-700 uppercase tracking-wide">tidak berlaku</span>
                    </div>
                @endif
                <div class="bg-white p-4 rounded-xl border-2 border-dashed border-slate-200 mb-6">
                    <div class="visible-print text-center">
                        {!! QrCode::size(200)->generate($kode_peminjaman) !!}
                    </div>
                </div>
                <div class="text-center space-y-1 mb-1">
                    {{-- <h3 class="text-xl font-bold text-[#0d131b]">#{{ $kode_peminjaman }}</h3> --}}
                    <p class="text-sm text-slate-500">Tunjukkan kepada petugas untuk dipindai</p>
                </div>
                <div class="w-full p-4 bg-background-light rounded-lg mb-1">
                    <div class="flex items-center justify-between gap-2 text-center">
                        <div class="flex flex-col flex-1">
                            <span class="text-xs text-slate-500 uppercase font-semibold mb-1">Jam</span>
                            <div class="bg-white rounded py-2 border border-slate-200 shadow-sm">
                                <span class="text-lg font-bold font-mono text-primary">00</span>
                            </div>
                        </div>
                        <span class="text-slate-400 font-bold mt-4">:</span>
                        <div class="flex flex-col flex-1">
                            <span class="text-xs text-slate-500 uppercase font-semibold mb-1">Menit</span>
                            <div class="bg-white rounded py-2 border border-slate-200 shadow-sm">
                                <span class="text-lg font-bold font-mono text-primary">04</span>
                            </div>
                        </div>
                        <span class="text-slate-400 font-bold mt-4">:</span>
                        <div class="flex flex-col flex-1">
                            <span class="text-xs text-slate-500 uppercase font-semibold mb-1">Detik</span>
                            <div class="bg-white rounded py-2 border border-slate-200 shadow-sm">
                                <span class="text-lg font-bold font-mono text-primary">59</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-center text-xs text-slate-400 mt-3">Kode berlaku terbatas untuk keamanan</p>
                </div>
                {{-- <div class="flex flex-col w-full gap-2">
                    <button
                        class="w-full flex items-center justify-center gap-2 h-11 bg-blue-600 hover:bg-blue-800 text-white border-0 font-bold rounded-lg! transition-colors">
                        <i class="fa-solid fa-download text-[20px]"></i>
                        <span>Unduh Kode QR</span>
                    </button>
                    <button
                        class="w-full flex items-center justify-center gap-2 h-11 bg-transparent hover:bg-slate-50 text-slate-600 font-medium rounded-lg! border border-slate-200 transition-colors">
                        <i class="fa-solid fa-share-nodes text-[20px]"></i>
                        <span>Bagikan</span>
                    </button>
                </div> --}}
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

</body>

</html>
