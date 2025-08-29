<!DOCTYPE html>
<html lang="en">

<head>
    @include('template.headerr')
    <title>E-vote | {{auth()->user()->level}} | Voted </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
            transition: all 0.3s ease;
            background: #fff;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
       .card-header {
            background: linear-gradient(45deg, #EB8153 , #EB8153);
            color: white;
            border-bottom: none;
            padding: 25px;
            position: relative;
            overflow: hidden;
            animation: gradientBG 10s ease infinite;
        }
        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            transform: rotate(45deg);
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer {
            0% {transform: translateX(-50%) rotate(45deg);}
            100% {transform: translateX(50%) rotate(45deg);}
        }
        .welcome-text {
            animation: fadeInLeft 1s ease;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0 15px;
        }
        .table thead th {
            background-color: #f8f9fa;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
            padding: 15px;
        }
        .table tbody tr {
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .media.style-1 {
            align-items: center;
        }
        .media.style-1 .icon-name {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            font-size: 18px;
        }
        .badge {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 12px;
        }
        .badge-info {
            background: linear-gradient(45deg, #2196F3, #00BCD4);
            color: white;
        }
        .badge-light {
            background: linear-gradient(45deg, #e9ecef, #f8f9fa);
            color: #333;
        }
        .badge-success {
            background: linear-gradient(45deg, #4CAF50, #8BC34A);
            color: white;
        }
        .footer {
            background: #fff;
            padding: 20px 0;
            margin-top: 50px;
            box-shadow: 0 -5px 25px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>
    @include('template.topbarr')
    @include('template.sidebarr')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4 class="mb-2">Selamat Datang Kembali!</h4>
                        <p class="mb-0">Data Hasil Voting</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tabel</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Voted</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 text-white">Data Hasil Voting</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <strong>Berhasil!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            @endif
                            
                            @if(session('update_success'))
                            <div class="alert alert-warning alert-dismissible fade show">
                                <strong>Berhasil!</strong> {{ session('update_success') }}
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th>Nama Calon</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hasilVotings as $hasilVoting)
                                        <tr>
                                            <td>
                                                <div class="media style-1">
                                                    @php
                                                    $iconClass = '';
                                                    $badgeClass = '';
                                                    if ($hasilVoting->roles == 'guru') {
                                                        $iconClass = 'bgl-info text-info';
                                                        $badgeClass = 'badge-info';
                                                    } elseif ($hasilVoting->roles == 'siswa') {
                                                        $iconClass = 'bgl-light'; 
                                                        $badgeClass = 'badge-light';
                                                    } elseif ($hasilVoting->roles == 'admin') {
                                                        $iconClass = 'bgl-success text-success';
                                                        $badgeClass = 'badge-success';
                                                    }
                                                    @endphp
                                                    <span class="icon-name mr-3 {{ $iconClass }}">{{ substr($hasilVoting->name, 0, 1) }}</span>
                                                    <div class="media-body">
                                                        <h6 class="mb-0">{{ $hasilVoting->name }}</h6>
                                                        <small class="text-muted">{{ $hasilVoting->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge {{ $badgeClass }}">{{ $hasilVoting->roles }}</span></td>
                                            <td>{{ $hasilVoting->nama_calon }}</td>
                                            <td><span class="text-primary">{{ $hasilVoting->tanggal }}</span></td>
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


  <footer class="footer mt-auto py-3 bg-white shadow-sm animate__animated animate__fadeInUp">
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
        $(document).ready(function() {
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteForm_' + id).submit();
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus.',
                            'success'
                        )
                    }
                });
            });
        });
    </script>
</body>
</html>