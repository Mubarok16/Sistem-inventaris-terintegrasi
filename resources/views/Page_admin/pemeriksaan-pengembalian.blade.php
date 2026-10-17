@extends('components.dashboard.dashboard_app')

@section('title', 'Pemeriksaan Pengembalian')

@section('content')
    @include('Page_admin.sidebar-admin')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('components.dashboard.navbar')
            <div class="container-fluid px-3 py-4">
                <div class="mb-6">
                    <a href="{{ route('dashboard-admin') }}" class="text-blue-600 hover:underline">Dashboard</a>
                    <span class="text-slate-400"> / Pemeriksaan Pengembalian</span>
                    <h1 class="mt-3 text-2xl font-bold text-slate-800">Pemeriksaan Pengembalian</h1>
                    <p class="mt-1 text-sm text-slate-500">Periksa kondisi aset sebelum menyelesaikan transaksi.</p>
                    <a href="{{ route('admin.pengembalian.riwayat') }}" class="mt-3 inline-block text-sm font-semibold text-blue-600 hover:underline">Lihat riwayat pemeriksaan pengembalian</a>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p class="font-bold">Periksa kembali data berikut:</p>
                        <ul class="mt-2 list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="font-bold text-slate-800">Informasi Peminjaman</h2>
                    <div class="mt-3 grid gap-3 sm:grid-cols-3 text-sm">
                        <div><p class="text-slate-500">Kode Peminjaman</p><p class="font-semibold">{{ $peminjaman->kode_peminjaman }}</p></div>
                        <div><p class="text-slate-500">Nama Peminjam</p><p class="font-semibold">{{ $peminjaman->nama_peminjam }}</p></div>
                        <div><p class="text-slate-500">Tanggal Pemeriksaan</p><p class="font-semibold">{{ now()->translatedFormat('d F Y, H:i') }}</p></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.pengembalian.simpan', $peminjaman->kode_peminjaman) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if ($barang->isNotEmpty())
                        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h2 class="mb-4 text-lg font-bold text-slate-800">Barang yang Dikembalikan</h2>
                            <div class="space-y-5">
                                @foreach ($barang as $item)
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="mb-4 flex flex-wrap items-start justify-between gap-2">
                                            <div><h3 class="font-semibold text-slate-800">{{ $item->nama_item }}</h3><p class="text-xs text-slate-500">{{ $item->merek_model }} · ID: {{ $item->id_item }}</p></div>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold">Dipinjam: {{ $item->qty }} unit</span>
                                        </div>
                                        <input type="hidden" name="barang[{{ $item->id_item }}][qty_dikembalikan]" value="{{ $item->qty }}">
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div>
                                                <label class="mb-1 block text-sm font-medium">Jumlah unit rusak</label>
                                                <input type="number" min="0" max="{{ $item->qty }}" value="{{ old('barang.'.$item->id_item.'.qty_rusak', 0) }}" name="barang[{{ $item->id_item }}][qty_rusak]" class="w-full rounded-lg border-slate-300" required>
                                            </div>
                                            <div>
                                                <label class="mb-1 block text-sm font-medium">Foto kerusakan (opsional)</label>
                                                <input type="file" accept="image/*" name="barang[{{ $item->id_item }}][foto_kerusakan]" class="w-full rounded-lg border border-slate-300 p-2 text-sm">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="mb-1 block text-sm font-medium">Deskripsi kerusakan (wajib jika ada unit rusak)</label>
                                                <textarea name="barang[{{ $item->id_item }}][deskripsi_kerusakan]" rows="2" class="w-full rounded-lg border-slate-300" placeholder="Contoh: layar retak, tombol tidak berfungsi">{{ old('barang.'.$item->id_item.'.deskripsi_kerusakan') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($ruangan->isNotEmpty())
                        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h2 class="mb-4 text-lg font-bold text-slate-800">Pemeriksaan Ruangan</h2>
                            <div class="space-y-5">
                                @foreach ($ruangan as $room)
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="mb-4"><h3 class="font-semibold text-slate-800">{{ $room->nama_room }}</h3><p class="text-xs text-slate-500">ID: {{ $room->id_room }}</p></div>
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div>
                                                <label class="mb-1 block text-sm font-medium">Kondisi ruangan</label>
                                                <select name="ruangan[{{ $room->id_room }}][rusak]" class="w-full rounded-lg border-slate-300">
                                                    <option value="0" @selected(old('ruangan.'.$room->id_room.'.rusak', '0') == '0')>Baik</option>
                                                    <option value="1" @selected(old('ruangan.'.$room->id_room.'.rusak') == '1')>Rusak</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="mb-1 block text-sm font-medium">Foto kerusakan (opsional)</label>
                                                <input type="file" accept="image/*" name="ruangan[{{ $room->id_room }}][foto_kerusakan]" class="w-full rounded-lg border border-slate-300 p-2 text-sm">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="mb-1 block text-sm font-medium">Deskripsi kerusakan (wajib jika rusak)</label>
                                                <textarea name="ruangan[{{ $room->id_room }}][deskripsi_kerusakan]" rows="2" class="w-full rounded-lg border-slate-300" placeholder="Contoh: engsel pintu rusak, lampu mati">{{ old('ruangan.'.$room->id_room.'.deskripsi_kerusakan') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <div class="flex flex-wrap justify-end gap-3">
                        <a href="{{ route('admin.pengajuan.peminjaman') }}" class="rounded-lg border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                        <button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-bold text-white hover:bg-blue-700" onclick="return confirm('Simpan hasil pemeriksaan dan selesaikan pengembalian?')">Simpan Pemeriksaan & Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
