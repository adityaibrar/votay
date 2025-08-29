<!DOCTYPE html>
<html lang="en">

<head>
    @include('template.headerr')
    <title>E-vote | {{ auth()->user()->level }} | Polling</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
            overflow: hidden;
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background: linear-gradient(45deg, #EB8153, #EB8153);
            color: white;
            border-bottom: none;
            padding: 25px;
        }
        .table thead th {
            background-color: #f8f9fa;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            padding: 15px;
            color: #333;
        }
        .table tbody tr {
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .media.style-1 img {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .badge {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
        }
        .badge-primary {
            background: linear-gradient(45deg, #EB8153, #ff9b72);
        }
        .badge-success {
            background: linear-gradient(45deg, #4CAF50, #8BC34A);
        }
    </style>
</head>

<body>
    @include('template.topbarr')
    @include('template.sidebarr')

    <div class="content-body animate_animated animate_fadeIn">
        <div class="container-fluid py-4">
            <div class="row page-titles mx-0 mb-4">
                <div class="col-sm-6">
                    <div class="welcome-text">
                        <h4 class="mb-2">Selamat Datang Kembali!</h4>
                        <p class="mb-0 text-muted">Pantau hasil polling secara real-time</p>
                    </div>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-primary">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Polling</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card animate_animated animate_fadeInUp">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 text-white">Hasil Polling Terkini</h4>
                            <a href="/cetaklaporan" target="blank" class="btn btn-light" title="Print Report">
                                <i class="fa fa-print mr-2"></i>Cetak Laporan
                            </a>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show animate_animated animate_bounceIn">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span><i class="mdi mdi-close"></i></span>
                                </button>
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; width: 120px;">Ranking</th>
                                            <th>Profil Calon</th>
                                            <th style="text-align: center; width: 150px;">Perolehan Suara</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($calonOsis as $index => $calon)
                                        <tr class="animate_animated animate_fadeIn">
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <div class="media style-1">
                                                    <img src="{{ asset('foto_calon/' . $calon->gambar) }}" class="mr-3" alt="">
                                                    <div class="media-body">
                                                        <h6 class="mb-1">{{ $calon->nama_calon }}</h6>
                                                        <span class="text-muted">{{ $calon->kelas }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success">
                                                    {{ $calon->jumlah_vote }} Suara
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                          

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <footer class="footer mt-auto py-3 bg-white shadow-sm animate_animated animate_fadeInUp">
        <div class="container text-center">
            <span class="text-muted">
                Hak Cipta © Dirancang &amp; Dikembangkan oleh 
                <a href="https://www.instagram.com/_calldeo?igsh=MmR6Mm4yem54NXA5" target="_blank" class="text-primary">Deo Andreas</a> 2025
            </span>
        </div>
    </footer>

    @include('template.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        setInterval(function() {
            location.reload();
        }, 60000);
    </script>
</body>
</html>