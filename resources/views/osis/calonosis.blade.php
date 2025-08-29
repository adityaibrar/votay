<!DOCTYPE html>
<html lang="en">

<head>
    @include('template.headerr')
    <title>E-vote | {{auth()->user()->level}} | Calon Osis </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }

        .new-arrivals-img-contnent img {
            border-radius: 10px;
            width: 100%;
            height: 250px;
            object-fit: cover;
            cursor: pointer;
            transition: 0.3s;
        }

        .new-arrivals-img-contnent img:hover {
            opacity: 0.8;
        }

        .welcome-text h4 {
            font-weight: 600;
            color: #2c3e50;
        }

        .btn-success {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-success:hover {
            transform: scale(1.05);
        }

        .alert {
            border-radius: 10px;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            border-bottom: none;
            padding: 20px 30px;
        }

        .modal-body {
            padding: 30px;
        }

        .btn-group button {
            margin: 0 5px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-group button:hover {
            transform: scale(1.1);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #3498db;
            text-decoration: none;
        }

        .new-arrival-content h4 {
            margin-top: 15px;
            font-weight: 600;
        }

        .new-arrival-content h4 a {
            color: #2c3e50;
            text-decoration: none;
            transition: 0.3s;
        }

        .new-arrival-content h4 a:hover {
            color: #3498db;
        }
    </style>
</head>

<body>
    @include('template.topbarr')
    @include('template.sidebarr')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0 mb-4">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Selamat Datang!</h4>
                        <p class="mb-0">Data Calon OSIS</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Calon OSIS</li>
                    </ol>
                </div>
            </div>

            <div class="mb-4">
                <a href="/add_osis" class="btn btn-success">
                    <i class="fa fa-plus mr-2"></i>Tambah Calon
                </a>
            </div>

            <div class="card-body px-0">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                        <span><i class="mdi mdi-close"></i></span>
                    </button>
                </div>
                @endif

                @if(session('update_success'))
                <div class="alert alert-warning alert-dismissible fade show">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <strong>Berhasil!</strong> {{ session('update_success') }}
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close">
                        <span><i class="mdi mdi-close"></i></span>
                    </button>
                </div>
                @endif

                <div class="row">
                    @foreach($calonOsis as $calon)
                    <div class="col-xl-3 col-lg-6 col-sm-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img src="{{ asset('foto_calon/' . $calon->gambar) }}" alt="{{ $calon->nama_calon }}" data-toggle="modal" data-target="#myModal{{ $calon->id }}">
                                    </div>
                                    <div class="new-arrival-content text-center mt-3">
                                        <h4><a href="#">{{ $calon->nama_calon }}</a></h4>
                                    </div>
                                    <div class="btn-group d-flex justify-content-center" style="margin-top: 15px" role="group">
                                        <form id="editForm_{{ $calon->id}}" action="/calonosis/{{ $calon->id}}/edit_osis" method="GET">
                                            <button type="submit" class="btn btn-warning shadow btn-xs sharp"><i class="fas fa-edit"></i></button>
                                        </form>
                                        <form id="deleteForm_{{ $calon->id}}" action="{{ route('osis.destroy', $calon->id) }}" method="POST" class="delete-form ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp delete-btn" data-id="{{ $calon->id }}"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="myModal{{ $calon->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $calon->nama_calon }}</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <img src="{{ asset('foto_calon/' . $calon->gambar) }}" class="img-fluid rounded" alt="{{ $calon->nama_calon }}">
                                            </div>
                                            <div class="col-md-8">
                                                <h6 class="font-weight-bold mb-3">{{ $calon->nama_calon }}</h6>
                                                <p class="text-muted">{{ $calon->visi }}</p>
                                                <p class="text-muted">{{ $calon->misi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('template.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin hapus data ini?',
                    text: "Data akan dihapus secara permanen",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, hapus data!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteForm_' + id).submit();
                    }
                });
            });
        });
    </script>

</body>
</html>