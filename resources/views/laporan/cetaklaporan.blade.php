<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 100%;
            max-width: 600px;
            height: auto;
        }

        .content {
            max-width: 800px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }

        .text {
            text-align: justify;
            margin-bottom: 20px;
            line-height: 1.8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
            padding-right: 50px;
        }

        .signature p {
            margin: 5px 0;
        }

        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 200px;
            display: inline-block;
        }
    </style>
    <title>Berita Acara</title>
</head>
<body>
    <div class="content">
        <div class="header">
            <img src="/foto_calon/print.png" alt="Header">
        </div>

        <div class="title">Berita Acara</div>

        <div class="text">
            Pada hari ini tanggal {{ date('d F Y') }}, telah dilaksanakan pemilihan Ketua dan Wakil Ketua Organisasi Siswa Intra Sekolah (OSIS) di SMKN 1 TAPEN. Setelah proses pemungutan dan penghitungan suara, {{ $calonTerpilih->nama_calon }} terpilih sebagai Ketua OSIS periode 2024/2025 dengan jumlah {{ $calonTerpilih->jumlah_vote }} suara.
        </div>

        <div class="text">
            Dokumen ini menjadi catatan resmi hasil pemilihan Ketua dan Wakil Ketua OSIS. Demikianlah berita acara ini dibuat dengan sebenarnya untuk menjadi catatan resmi hasil pemilihan Ketua dan Wakil Ketua OSIS SMKN 1 TAPEN.
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Calon</th>
                <th>Jumlah</th>
            </tr>
            @foreach ($cosis as $calon)
            <tr>
                <td>{{ $calon->id }}</td>
                <td>{{ $calon->nama_calon }}</td>
                <td>{{ $calon->jumlah_vote }}</td>
            </tr>
            @endforeach
        </table>

        <div class="signature">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="signature-line"></div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
