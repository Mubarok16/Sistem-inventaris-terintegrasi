@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-success">
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

{{-- data peminjam --}}
<div class="flex flex-col gap-8 mt-4">
    <!-- Section 1: Permohonan Peminjaman -->
    <section class="bg-white rounded-md p-6 shadow-sm">
        <!-- SectionHeader -->
        <h3 class="text-gray-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] pb-2">
            Data Agenda</h3>
        <!-- Table -->
        <div class="@container pb-2">
            <div class="text-gray-600">

                @forelse ($dataAgendaTemp as $DataAgenda)
                    <form method="POST" action="{{ route('tambah-agenda') }}">
                        @csrf
                        <table>
                            <tr>
                                <td>Nama Agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="text" class="form-control" name="nama_agenda"
                                        value="{{ $DataAgenda['nama_agenda'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Periode mulai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="date" name="tgl-mulai" class="form-control"
                                        value="{{ $DataAgenda['tgl-mulai'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Periode selesai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="date" name="tgl-selesai" class="form-control"
                                        value="{{ $DataAgenda['tgl-selesai'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Repeat Periode</td>
                                <td class="pl-4! pb-2 flex gap-2">
                                    <div class="flex items-center">
                                        <input id="default-radio-1" type="radio" value="harian" name="repeat"
                                            {{ $DataAgenda['repeat'] === 'harian' ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-500 bg-neutral-secondary-medium rounded-full">
                                        <label for="default-radio-1"
                                            class="select-none ms-2 text-sm font-medium text-heading">
                                            harian
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="default-radio-2" type="radio" value="mingguan"
                                            {{ $DataAgenda['repeat'] === 'mingguan' ? 'checked' : '' }} name="repeat"
                                            class="w-4 h-4 text-blue-500 bg-neutral-secondary-medium rounded-full">
                                        <label for="default-radio-2"
                                            class="select-none ms-2 text-sm font-medium text-heading">
                                            mingguan
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jam mulai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="time" name="jam_mulai" class="form-control"
                                        value="{{ $DataAgenda['jam_mulai'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Jam selesai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="time" name="jam_selesai" class="form-control"
                                        value="{{ $DataAgenda['jam_selesai'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe agenda</td>
                                <td class="pl-4! pb-2">
                                    <select name="tipe" class="form-select">
                                        <option value="{{ $DataAgenda['tipe'] }}">{{ $DataAgenda['tipe'] }}</option>
                                        <option value="kegiatan belajar mengajar"
                                            class="{{ $DataAgenda['tipe'] === 'kegiatan belajar mengajar' ? 'hidden' : '' }}">
                                            kegiatan belajar mengajar</option>
                                        <option value="Rapat pimpinan"
                                            class="{{ $DataAgenda['tipe'] === 'Rapat pimpinan' ? 'hidden' : '' }}">
                                            Rapat
                                            pimpinan</option>
                                        <option value="seminar/sidang"
                                            class="{{ $DataAgenda['tipe'] === 'seminar/sidang' ? 'hidden' : '' }}">seminar/sidang
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="flex gap-2 mt-2">
                            <button
                                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                kunci perubahan
                            </button>
                        </div>
                    </form>
                @empty
                    <form method="POST" action="{{ route('tambah-agenda') }}">
                        @csrf
                        <table>
                            <tr>
                                <td>Nama Agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="text" class="form-control" name="nama_agenda" placeholder=" "
                                        required>
                                </td>
                            </tr>
                            <tr>
                                <td>Periode mulai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="date" name="tgl-mulai" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Periode selesai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="date" name="tgl-selesai" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Repeat Periode</td>
                                <td class="pl-4! pb-2 flex gap-2">
                                    <div class="flex items-center">
                                        <input type="radio" value="harian" name="repeat"
                                            class="w-4 h-4 text-blue-500 bg-neutral-secondary-medium rounded-full">
                                        <label for="default-radio-1"
                                            class="select-none ms-2 text-sm font-medium text-heading">
                                            harian
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" value="mingguan" name="repeat"
                                            class="w-4 h-4 text-blue-500 bg-neutral-secondary-medium rounded-full">
                                        <label for="default-radio-2"
                                            class="select-none ms-2 text-sm font-medium text-heading">
                                            mingguan
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Jam mulai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="time" name="jam_mulai" class="form-control" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>Jam selesai agenda</td>
                                <td class="pl-4! pb-2">
                                    <input type="time" name="jam_selesai" class="form-control" value="">
                                </td>
                            </tr>
                            <tr>
                                <td>Tipe agenda</td>
                                <td class="pl-4! pb-2">
                                    <select name="tipe" class="form-select">
                                        <option value="kegiatan belajar mengajar">kegiatan belajar mengajar</option>
                                        <option value="Rapat pimpinan">Rapat pimpinan</option>
                                        <option value="seminar/sidang">seminar/sidang</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="flex gap-2 mt-2">
                            <button
                                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                kunci perubahan
                            </button>
                        </div>
                    </form>
                @endforelse

            </div>
        </div>
    </section>
</div>

{{-- data usage barang --}}
<div x-data="{ AddDataBarang: false, EditDataBarang: false, selectedDataBarang: {}, DeleteDataBarang: false }" class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <div class="flex justify-betwean items-center gap-4 mb-2">
        <h5 class="flex-1 text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Daftar Barang yang
            digunakan</h5>
        <button @click="AddDataBarang = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <span>Add Barang</span>
        </button>
    </div>
    <div class="relative overflow-x-auto bg-neutral-primary-soft">
        <table class="w-full text-left table-striped text-sm">
            <thead class="sticky top-0 z-1 bg-primary">
                <tr class="text-white">
                    <th scope="col" class="px-6 py-3 font-medium">
                        Kode Barang
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nama Barang
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        tempat menyimpan
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        qty usage
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataAgendaBarangTemp as $dataBarangTemp)
                    <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">

                        <th scope="row" class="px-6 py-4 font-normal!">
                            {{ $dataBarangTemp['id_item'] }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-normal!">
                            {{ $dataBarangTemp['nama_item'] }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-normal!">
                            {{ $dataBarangTemp['nama_room'] }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $dataBarangTemp['qty_usage'] }}
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('hapus-barang-agenda') }}" method="POST">
                                @csrf
                                <input type="text" name="id_item" class="hidden"
                                    value="{{ $dataBarangTemp['id_item'] }}">
                                <button
                                    class="py-1 px-2 text-white bg-red-500 hover:bg-red-400 flex items-center gap-1">
                                    <i class="material-symbols-outlined text-xs fa-solid fa-trash-can"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="5">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- show add tipe ruangan --}}
    <div x-show="AddDataBarang"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition x-cloak>
        <div @click.outside="AddDataBarang = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="AddDataBarang = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Add Barang</h2>

            <form method="POST" action="{{ route('tambah-barang-agenda') }}" enctype="multipart/form-data">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-home"></i>
                            </span>
                            <select name="id_item" class="form-select" required>
                                <option value="">--- Pilih Barang ---</option>
                                @foreach ($dataBarang as $dataBarang)
                                    <option value="{{ $dataBarang->id_item }}">
                                        {{ $dataBarang->nama_item }}
                                        Ruang
                                        {{ $dataBarang->nama_room }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 m-0">
                        <div class="form-floating mb-2">
                            <input type="number" class="form-control" name="qty_usage" placeholder=" " required>
                            <label class="form-label">Qty usage</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">kunci perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- data usage ruangan --}}
<div x-data="{ AddDataRuangan: false }" class="bg-white rounded-md shadow-md my-4 py-4 px-3">
    <div class="flex justify-betwean items-center gap-4 mb-2">
        <h5 class="flex-1 text-xl font-bold leading-tight tracking-tight mb-4 text-gray-600">Daftar ruangan yang
            digunakan
        </h5>
        <button @click="AddDataRuangan = true"
            class="flex items-center justify-center gap-2 h-10 px-4 rounded-lg bg-primary text-white text-sm leading-normal tracking-wide hover:bg-primary/90 transition-colors">
            <span>Add Ruangan</span>
        </button>
    </div>
    <div class="relative overflow-x-auto bg-neutral-primary-soft">
        <table class="w-full text-left table-striped text-sm">
            <thead class="sticky top-0 z-1 bg-primary">
                <tr class="text-white">
                    <th scope="col" class="px-6 py-3 font-medium">
                        Kode Ruangan
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nama Ruangan
                    </th>
                    {{-- <th scope="col" class="px-6 py-3 font-medium">
                        tanggal selesai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        jam mulai
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        jam selesai
                    </th> --}}
                    <th scope="col" class="px-6 py-3 font-medium">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataAgendaRuanganTemp as $dataRuanganTemp)
                    <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $dataRuanganTemp['id_room'] }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $dataRuanganTemp['nama_tipe_room'] }}
                            {{ $dataRuanganTemp['nama_room'] }}
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('hapus-ruangan-agenda') }}" method="POST">
                                @csrf
                                <input type="text" name="id_room" class="hidden"
                                    value="{{ $dataRuanganTemp['id_room'] }}">
                                <button
                                    class="py-1 px-2 text-white bg-red-500 hover:bg-red-400 flex items-center gap-1">
                                    <i class="material-symbols-outlined text-xs fa-solid fa-trash-can"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-b border-slate-200 odd:bg-gray-200 even:bg-white">
                        <td class="px-4 py-3 text-sm font-normal text-center" colspan="3">
                            <span class="text-gray-700 font-semibold">Data kosong!</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- show add tipe ruangan --}}
    <div x-show="AddDataRuangan"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 backdrop-blur-sm z-50"
        x-transition x-cloak>
        <div @click.outside="AddDataRuangan = false"
            class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md relative">

            <button @click="AddDataRuangan = false"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-lg font-semibold mb-4 text-center text-gray-700">Add Ruangan</h2>

            <form method="POST" action="{{ route('tambah-ruangan-agenda') }}" enctype="multipart/form-data">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12 m-0">
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa-solid fa-home"></i>
                            </span>
                            <select name="id_room" class="form-select" required>
                                <option value="">--- Pilih Ruangan ---</option>
                                @foreach ($dataRoom as $dataRoom)
                                    <option value="{{ $dataRoom->id_room }}">
                                        {{ $dataRoom->nama_tipe_room }}
                                        {{ $dataRoom->nama_room }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-primary w-100" type="submit">kunci perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="my-4 ">
    <form action="{{ route('simpan-agenda') }}" method="POST">
        @csrf
        <button class="px-3 py-1.5 text-sm font-medium text-white bg-green-500 rounded-md! hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-background-dark w-full">
            simpan agenda
        </button>
    </form>
</div>
