<!DOCTYPE html>
<html lang="en">
<head>
    @include('template.headerr')
    <title>E-vote | {{auth()->user()->level}} | Setting </title>
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
            overflow: hidden;
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
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
            padding: 15px;
            color: #333;
        }
        .table tbody tr {
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .animate__animated {
            animation-duration: 0.8s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #495057);
            border: none;
        }
        .btn-primary {
            background: linear-gradient(45deg, #ff0000b4, #c80a0a);
                border: none;
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
            border: none;
        }
        .modal-footer {
            border: none;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #EB8153;
            box-shadow: 0 0 0 0.2rem rgba(235,129,83,0.25);
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

    <div class="content-body animate__animated animate__fadeIn">
        <div class="container-fluid">
            <div class="row page-titles mx-0 mb-4">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4 class="text-primary">Selamat Datang!</h4>
                        <p class="mb-0">Pengaturan Waktu Voting</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengaturan Waktu</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 text-white">Pengaturan Waktu Voting</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            @if(session('update_success'))
                            <div class="alert alert-warning alert-dismissible fade show">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ session('update_success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            <div class="table-responsive" id="uptTable">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($settings as $waktu)
                                        <tr>
                                            <td>{{ $waktu->id_setting }}</td>
                                            <td>
                                                <span id="selectedDate_{{ $waktu->id_setting }}" class="font-weight-medium">
                                                    @if ($waktu->waktu)
                                                        {{ $waktu->waktu }}
                                                    @else
                                                        <span class="text-muted">Tanggal belum dipilih</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-secondary mr-2" data-toggle="modal" data-target="#tanggalModal_{{ $waktu->id_setting}}">
                                                        <i class="fas fa-calendar-alt mr-1"></i> Pilih Tanggal
                                                    </button>
                                                    <button type="button" class="btn btn-primary" id="saveBtn_{{ $waktu->id_setting }}" style="display: none;">
                                                        <i class="fas fa-save mr-1"></i> Simpan
                                                    </button>
                                                </div>
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

    <div class="footer">
        <div class="copyright">
            <p>Copyright © Designed &amp; Developed by <a href="/home" class="text-primary">Deo Andreas</a> 2024</p>
        </div>
    </div>

    @foreach($settings as $waktu)
    <div class="modal fade" id="tanggalModal_{{ $waktu->id_setting }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Tanggal Voting</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_{{ $waktu->id_setting}}" data-id="{{ $waktu->id_setting }}" action="/save-date" method="POST">
                        @csrf
                        <input type="date" name="waktu" id="waktu" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveTanggal({{ $waktu->id_setting }})">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @include('template.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function saveTanggal(id) {
            var form = $('#form_' + id);
            var selectedDate = form.find('input[name="waktu"]').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/update-waktu',
                method: 'POST',
                data: {
                    id: id,
                    waktu: selectedDate,
                    _token: csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Response:', response);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tanggal voting berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui tanggal voting'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan tanggal'
                    });
                }
            });
        }
    </script>

</body>
</html>