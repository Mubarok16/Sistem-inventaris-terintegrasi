<!DOCTYPE html>
<html>

<head>
    <title>Laporan Bulanan Penggunaan</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin-left: 40px;
            margin-right: 40px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        /* Style Tabel Utama */
        .table-laporan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        .table-laporan th {
            border: 1px solid black;
            padding: 10px 8px;
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table-laporan td {
            border: 1px solid black;
            padding: 8px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .footer-container {
            margin-top: 40px;
            width: 100%;
        }

        .footer-ttd {
            float: right;
            text-align: center;
            width: 220px;
        }

        /* Jarak kosong untuk tanda tangan basah */
        .space-ttd {
            height: 80px;
        }
    </style>
</head>

<body>

    <!-- Header Kop Surat -->
    <header>
        <img src="{{ public_path('images/kop-surat.png') }}" style="width: 100%; height: auto;">
    </header>

    <!-- Metadata Laporan -->
    {{-- <table style="width: 100%; border: none; border-collapse: collapse; margin-top: 10px;">
        <tbody>
            <tr>
                <td style="width: 15%; border: none; padding: 2px 0;">Nomor</td>
                <td style="width: 45%; border: none; padding: 2px 0;">: 
                    {{ $nomor_laporan }}
                    123/FT/2024
                </td>
                <td style="width: 40%; border: none; text-align: right; padding: 2px 0;">
                    Indramayu, 1 Januari 2024
                    {{ \Carbon\Carbon::parse($created_at)->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Hal</td>
                <td style="border: none; padding: 2px 0;">: Rekapitulasi Penggunaan Bulanan</td>
                <td style="none;"></td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Periode</td>
                <td style="border: none; padding: 2px 0;">: 
                    {{ $bulan_laporan }}
                    Januari 2024
                </td>
            </tr>
        </tbody>
    </table> --}}

    <!-- Judul Dokumen -->
    <div class="judul">
        LAPORAN REKAPITULASI PENGGUNAAN DAN PEMINJAMAN <br> SARANA DAN PRASARANA
        {{-- {{ strtoupper($jenis_laporan) }} --}}
        PERIODE <br> {{ strtoupper(\Carbon\Carbon::createFromFormat('m', $bulan)->locale('id')->isoFormat('MMMM')) }} {{ $tahun }}
        {{-- {{ strtoupper($bulan_laporan) }} --}}
    </div>

    <!-- Tabel Rekapitulasi -->
    <p style="text-align: justify; font-size: 14px; margin-top: 25px;">
        Berikut merupakan hasil rekapitulasi penggunaan sarana.
    </p>
    <table class="table-laporan">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Sarana
                    {{-- {{ $jenis_laporan }} --}}
                </th>
                <th style="width: 35%;">Nama
                    {{-- {{ $jenis_laporan }} --}}
                    Sarana
                </th>
                <th style="width: 15%;">Jumlah Digunakan</th>
                {{-- <th style="width: 30%;">Kondisi</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($dataPenggunaanBarang as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->id_item }}</td>
                <td>{{ $item->nama_item }} {{ $item->merek_model }}</td>
                <td class="text-center">{{ $item->total_qty }}</td>
                {{-- <td>{{ $item->kondisi }}</td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data penggunaan sarana untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>


    <br>
    <p style="text-align: justify; font-size: 14px; margin-top: 25px;">
        Berikut merupakan hasil rekapitulasi penggunaan prasaranan.
    </p>
    <table class="table-laporan">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode Prasarana
                    {{-- {{ $jenis_laporan }} --}}
                </th>
                <th style="width: 35%;">Nama
                    {{-- {{ $jenis_laporan }} --}}
                    Prasarana
                </th>
                <th style="width: 15%;">Jumlah Digunakan</th>
                {{-- <th style="width: 30%;">Kondisi</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($dataPenggunaanRuangan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->id_room }}</td>
                <td>{{ $item->nama_tipe_room }} {{ $item->nama_room }}</td>
                <td class="text-center">{{ $item->total_usage }}</td>
                {{-- <td>{{ $item->kondisi }}</td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data penggunaan prasarana untuk periode ini.</td>
            </tr>
            @endforelse
           
        </tbody>
    </table>

    {{-- <p style="text-align: justify; font-size: 14px; margin-top: 25px;">
        Demikian laporan rekapitulasi penggunaan ini dibuat dengan sebenar-benarnya untuk digunakan sebagai bahan
        evaluasi operasional bulanan.
    </p> --}}

    {{-- <!-- Bagian Tanda Tangan Konvensional -->
    <div class="footer-container">
        <div class="footer-ttd">
            <p style="margin-bottom: 0;">Mengetahui,<br>dewa</p>
            
            <!-- Ruang Kosong Tanda Tangan Fisik / Cap -->
            <div class="space-ttd"></div>

            <p style="margin-bottom: 0;">
                <span style="border-bottom: 1px solid black; font-weight: bold; white-space: nowrap;">
                    {{ $nama_penanggung_jawab }}
                    ahmad farhan mubarok
                </span>
            </p>
            <p style="margin-top: 2px;">NIDN/NIP. 562020121010</p>
        </div>
    </div> --}}

    <!-- Bagian Tembusan Arsip -->
    <div style="clear: both; margin-top: 50px; font-size: 13px;">
        <p style="margin-bottom: 5px; font-weight: bold;">Hasil Rekapitulasi :</p>
        <ul style="margin-left: 0; padding-left: 20px; margin-top: 0;">
            <li>Sistem peminjaman sarana dan prasarana terintegrasi</li>
        </ul>
        <p style="padding-left: 20px; margin-top: -10px;">fakultas teknik universitas wiralodra</p>
    </div>

</body>

</html>
