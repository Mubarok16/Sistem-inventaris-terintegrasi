<!DOCTYPE html>
<html>

<head>
    <title>Surat Pengajuan Perawatan</title>
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

        /* Watermark CSS */
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.4;
            font-size: 60px;
            color: red;
            width: 100%;
            text-align: center;
            z-index: -1000;
        }

        /* Kotak Blur untuk TTD */
        .blur-ttd {
            filter: blur(4px);
            background: #f0f0f0;
            width: 80px;
            height: 80px;
            margin: 10px auto;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }

        /* Ukuran QR Code agar pas di footer */
        .qr-code img {
            width: 80px;
            height: 80px;
            margin: 5px 0;
        }
    </style>
</head>

<body>

    <!-- Watermark Muncul di Seluruh Halaman jika belum ACC -->
    @if (!$is_approved)
        <div id="watermark">DRAF / BELUM DISETUJUI</div>
    @endif

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
        Disampaikan dengan hormat, sehubungan kebutuhan {{ $kategori }} penunjang perkuliahan Tahun Akademik
        {{ $tahun_akademik }} di {{ $keperluan_prodi }}, dengan ini kami mengajukan permohonan perawatan {{ $kategori }} berupa
        <label style="font-weight: bold">{{ $qty }} {{ $kategori == 'sarana' ? 'unit' : '' }} {{ $nama_barang }}</label>.
    </p>
    <p style="padding-left:2px; padding-right:2px; text-indent: 40px; text-align: justify;">
        Demikian permohonan ini kami sampaikan, atas perhatian dan realisasinya kami ucapkan terima kasih.
    </p>


    <!-- Bagian Tanda Tangan yang Diupdate -->
    <div class="footer">
        <p>Dekan,</p>

        {{-- @if ($is_approved)
            <div class="qr-code">
                <img
                    src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(80)->margin(1)->generate($verif_url)) }}">
                
                <label>{{ $verif_url }}</label>
            </div>
        @else
            <div class="blur-ttd">
                <span>BELUM ACC</span>
            </div>
        @endif --}}

        @if ($is_approved)
            <div style="width: 80px; height: 80px; margin: 0 auto; text-align: center;">

                <!-- 1. QR Code SVG -->
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->errorCorrection('H')->size(80)->margin(0)->generate($verif_url)) }}"
                    style="width: 80px; height: 80px; display: block;">

                <!-- 2. Logo (Dinaikkan dengan margin-top negatif) -->
                <div
                    style="
                        background-color: white; 
                        width: 24px; 
                        height: 24px; 
                        margin: -53px auto 0 auto; /* -52px untuk menarik logo ke tengah QR */
                        padding: 2px;
                        position: relative; 
                        z-index: 100;
                    ">
                    <img src="{{ public_path('images/logo_ft.png') }}"
                        style="width: 100%; height: auto; display: block;">
                </div>

            </div>
            <!-- Spacer agar elemen di bawah QR tidak tertabrak -->
            {{-- <div style="height: 30px;"></div> --}}
        @else
            <div class="blur-ttd">
                <span>BELUM ACC</span>
            </div>
        @endif



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
