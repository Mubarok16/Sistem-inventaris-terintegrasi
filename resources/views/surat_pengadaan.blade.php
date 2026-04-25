<!DOCTYPE html>
<html>

<head>
    <title>Surat Pengajuan</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin-left: 40px;
            margin-right: 40px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        .footer {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 200px;
        }
    </style>
</head>

<body>
    {{-- <div class="kop-surat">
        <h2 style="margin:0; color: #548DD4;">UNIVERSITAS WIRALODRA</h2>
        <h1 style="margin:0; color: #7030A0;">FAKULTAS TEKNIK</h1>
        <p style="margin:0;">Jl. Ir. H. Juanda Km.3 Telp/Fax. (0234) 275907 Indramayu 45213 www. ft.unwir.ac.id</p>
    </div> --}}

    <header>
        <!-- Lebar 100% agar memenuhi lebar kertas -->
        <img src="{{ public_path('images/kop-surat.png') }}" style="width: 100%; height: auto;">
    </header>

    <table style="width: 100%; border: none; border-collapse: collapse;">
        <tbody>
            <tr>
                <!-- Tambahkan border: none juga pada <td> untuk memastikan -->
                <td style="width: 15%; border: none; padding: 2px 0;">Nomor</td>
                <td style="width: 45%; border: none; padding: 2px 0;">: {{ $nomor_surat }}</td>
                <td style="width: 40%; border: none; text-align: right; padding: 2px 0;">April 2026</td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Lampiran</td>
                <td style="border: none; padding: 2px 0;">: -</td>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Perihal</td>
                <td style="border: none; padding: 2px 0;">: Permohonan</td>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Yth</td>
                <td style="border: none; padding: 2px 0;">: Rektor Universitas Wiralodra Indramayu</td>
                <td style="border: none;"></td>
            </tr>
        </tbody>
    </table>


    {{-- <div class="judul">SURAT PENGAJUAN PENGADAAN BARANG</div> --}}

    <p style="padding-left:2px; padding-right:2px; text-indent: 40px; text-align: justify;">
        Disampaikan dengan hormat, sehubungan kebutuhan sarana penunjang perkuliahan Tahun Akademik
        {{ $tahun_akademik }} di {{ $keperluan_prodi }}, dengan ini kami mengajukan permohonan pengadaan sarana berupa
        <label style="font-weight: bold">{{ $qty }} unit {{ $nama_barang }}</label>.
    </p>
    <p style="padding-left:2px; padding-right:2px; text-indent: 40px; text-align: justify;">
        Demikian permohonan ini kami sampaikan, atas perhatian dan realisasinya kami ucapkan terima kasih.
    </p>



    {{-- <table>
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Nama Barang</th>
                <th>Jumlah (Qty)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $nama_barang }}</td>
                <td style="text-align: center;">{{ $qty }}</td>
            </tr>
        </tbody>
    </table> --}}

    {{-- <p><strong>Alasan Pengadaan:</strong><br>
        {{ $alasan }}</p> --}}

    <!-- Bagian Tanda Tangan -->
    <div class="footer">
        <p>Dekan,</p>
        <br><br><br>
        <p style="margin-bottom: 0;">
            <span style="border-bottom: 1px solid black; font-weight: bold; white-space: nowrap;">
                {{ $dekan }}
            </span>
        </p>
        <p style="margin-top: 2px;">NIDN. {{ $nidn }}</p>
    </div>

    <!-- Bagian Tembusan (Diberi clear:both agar turun ke bawah ttd) -->
    <div style="clear: both; margin-top: 40px; font-size: 14px;">
        <p style="margin-bottom: 5px;">Tembusan :</p>
        <ol style="margin-left: 0; padding-left: 20px; list-style-type: decimal; margin-top: 0;">
            <li>Ketua Umum Yayasan Wiraloda Indramayu;</li>
        </ol>
        <p style="padding-left: 20px; margin-top: -10px;">Arsip</p>
    </div>



</body>

</html>
