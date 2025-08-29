<!DOCTYPE html>
<html lang="en">

<head>
    @include('template.headerr')
    <title>E-vote | {{auth()->user()->level}} | Dashboard </title>
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
            transition: all 0.5s ease;
            background: #fff;
            margin-bottom: 30px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .welcome-text {
            animation: fadeInLeft 1s ease;
        }
        .new-arrivals-img-contnent img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .new-arrivals-img-contnent img:hover {
            transform: scale(1.02);
        }
        .new-arrival-content h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 15px 0;
        }
        .new-arrival-content p {
            color: #666;
            margin: 8px 0;
        }
        .new-arrival-content .text-content {
            font-style: italic;
            color: #888;
            border-left: 3px solid #EB8153;
            padding-left: 15px;
            margin: 15px 0;
        }
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .modal-header {
            background: linear-gradient(45deg, #EB8153, #ff9b72);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 30px;
        }
        .modal-body {
            padding: 30px;
        }
        .btn {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
        }
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #495057);
            border: none;
        }
        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    @include('template.topbarr')
    @include('template.sidebarr')

    <div class="content-body animate_animated animate_fadeIn">
        <div class="container-fluid">
            <div class="row page-titles mx-0 mb-4">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                         <h4 class="text-primary">Selamat Datang!</h4>
                        <p class="mb-0">Dashboard E-Voting</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Vote</li>
                    </ol>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span><i class="fas fa-times"></i></span>
                </button>
            </div>
            @endif

            @if(session('update_success'))
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('update_success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span><i class="fas fa-times"></i></span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-times-circle mr-2"></i>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span><i class="fas fa-times"></i></span>
                </button>
            </div>
            @endif

             
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-xxl-6 col-sm-6">
                    <div class="widget-stat card bg-primary">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="mr-3">
                                    <i class="la la-users"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Sudah Memilih</p>
                                    <h3 class="text-white">{{ $jumlahSuaraSudahMemilih }}</h3>
                                    <div class="progress mb-2">
                                        <div class="progress-bar progress-animated bg-light" style="width: {{ $persentaseSuaraSudahMemilih }}%"></div>
                                    </div>
                                    <small>{{ number_format($persentaseSuaraSudahMemilih, 1) }}% Pemilih telah melakukan Voting</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-xxl-6 col-sm-6">
                    <div class="widget-stat card bg-warning">
                        <div class="card-body p-4">
                            <div class="media">
                                <span class="mr-3">
                                    <i class="la la-user"></i>
                                </span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Belum Memilih</p>
                                    <h3 class="text-white">{{ $jumlahSuaraBelumMemilih }}</h3>
                                    <div class="progress mb-2">
                                        <div class="progress-bar progress-animated bg-light" style="width: {{ $persentaseSuaraBelumMemilih }}%"></div>
                                    </div>
                                    <small>{{ number_format($persentaseSuaraBelumMemilih, 1) }}% Pemilih belum melakukan voting</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($calonOsis as $calon)
                <div class="col-lg-12 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="new-arrivals-img-contnent">
                                        <img src="{{ asset('foto_calon/' . $calon->gambar) }}" 
                                             alt="{{ $calon->nama_calon }}" 
                                             data-toggle="modal" 
                                             data-target="#myModal{{ $calon->id }}"
                                             class="shadow">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="new-arrival-content">
                                        <h4>
                                            <span class="badge badge-primary mr-2">No. {{ $calon->id }}</span>
                                            {{ $calon->nama_calon }}
                                        </h4>
                                        <p><i class="fas fa-calendar-alt mr-2"></i> <strong>Periode:</strong> {{ $calon->periode }}</p>
                                        <p><i class="fas fa-id-card mr-2"></i> <strong>NIS:</strong> {{ $calon->NIS }} <i class="fas fa-check-circle text-success ml-1"></i></p>
                                        <p><i class="fas fa-graduation-cap mr-2"></i> <strong>Kelas:</strong> {{ $calon->kelas }}</p>
                                        <p class="text-content">{{ $calon->slogan }}</p>
                                    </div>
                                </div>
                                        <div class="col-12 mt-4">
                                    <h6 class="d-flex justify-content-between">
                                        Progress
                                        <span class="text-primary">{{number_format($presentaseVotePerCalon[$calon->id], 1) }}%</span>
                                    </h6>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary progress-animated" style="width: {{ $presentaseVotePerCalon[$calon->id] }}%" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="myModal{{ $calon->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1);">
                            <div class="modal-header border-0" style="background: linear-gradient(45deg, #EB8153, #ff9b72); color: white; border-radius: 15px 15px 0 0;">
                                <h5 class="modal-title" id="myModalLabel" style="font-weight: 600;">{{ $calon->nama_calon }}</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body py-4">
                                <div class="container">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-4">
                                            <div class="position-relative" style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                                <img src="{{ asset('foto_calon/' . $calon->gambar) }}" class="img-fluid" alt="{{ $calon->nama_calon }}" style="object-fit: cover; width: 100%; height: 300px;">
                                            </div>
                                        </div>
                                      <div class="col-md-8">
                                            <div class="mb-4">
                                                <h6 class="font-weight-bold mb-3">
                                                    <i class="fas fa-bullseye mr-2"></i>Visi
                                                </h6>
                                                <p class="text-muted">{{ $calon->visi }}</p>
                                            </div>
                                            <div class="mb-4">
                                                <h6 class="font-weight-bold mb-3">
                                                    <i class="fas fa-list-ul mr-2"></i>Misi
                                                </h6>
                                                <p class="text-muted">{{ $calon->misi }}</p>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold mb-3">
                                                    <i class="fas fa-quote-left mr-2"></i>Slogan
                                                </h6>
                                                <p class="text-muted font-italic">{{ $calon->slogan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                        
                                <button type="button" class="btn px-4" style="background: #e9ecef; color: #333; border-radius: 25px;" data-dismiss="modal">
                                    <i class="fas fa-times mr-2"></i>Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
    <!-- Content body end -->

    <!-- Main wrapper end -->

    <!-- Scripts -->
    <!-- Required vendors -->
    @include('template.scripts')

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Fungsi untuk menampilkan notifikasi toast
        function showVoteSuccessToast() {
            toastr.success('You have successfully voted!', 'Success');
        }
    
        // Fungsi untuk menampilkan notifikasi toast ketika terjadi kesalahan
        function showVoteErrorToast() {
            toastr.error('Failed to vote. Please try again later.', 'Error');
        }
    </script>

</body>

</html>