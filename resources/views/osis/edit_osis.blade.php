<!DOCTYPE html>
<html lang="en">

<head>
    @include('template.headerr')
    <title>E-vote | {{auth()->user()->level}} | Edit Data OSIS</title>
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
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background: linear-gradient(45deg, #EB8153, #ff9b72);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 25px;
        }
        .welcome-text {
            animation: fadeInLeft 1s ease;
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
        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(45deg, #EB8153, #ff9b72);
            border: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(235,129,83,0.4);
        }
        .btn-light {
            background: #f8f9fa;
            border: none;
        }
        .btn-light:hover {
            background: #e9ecef;
        }
        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .breadcrumb {
            background: transparent;
        }
        .breadcrumb-item a {
            color: #EB8153;
            text-decoration: none;
        }
        .footer {
            background: #fff;
            padding: 20px 0;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
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
                        <h4>Selamat Datang!</h4>
                        <p class="mb-0">Edit Data Calon OSIS</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Data Calon OSIS</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-white"> Form Edit Calon OSIS</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="/calonosis/{{ $calon->id }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Nama Calon *</label>
                                            <input type="text" class="form-control" name="nama_calon" value="{{ $calon->nama_calon }}" placeholder="Masukkan Nama Calon" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Periode</label>
                                            <input type="text" class="form-control" name="periode" value="{{ $calon->periode }}" placeholder="Masukkan Periode" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>NIS *</label>
                                            <input type="text" class="form-control" name="NIS" value="{{ $calon->NIS }}" placeholder="Masukkan NIS" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Kelas</label>
                                            <input type="text" class="form-control" name="kelas" value="{{ $calon->kelas }}" placeholder="Masukkan kelas" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Slogan *</label>
                                        <input type="text" class="form-control" name="slogan" value="{{ $calon->slogan }}" placeholder="Masukkan Slogan" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Visi</label>
                                        <textarea class="form-control" id="visi" name="visi" rows="8" placeholder="Tuliskan visi">{{ $calon->visi }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Misi</label>
                                        <textarea class="form-control" id="misi" name="misi" rows="8" placeholder="Tuliskan misi">{{ $calon->misi }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar *</label>
                                        <input type="file" class="form-control" name="gambar" accept="image/*">
                                    </div>
                                     <div class="form-group mt-4 text-right">
                                        <a href="/calon-osis" class="btn btn-danger btn-cancel mr-2"><i class="fas fa-times mr-1"></i> Batal</a>
                                        <button type="submit" class="btn btn-primary btn-submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                                    </div>  
                                </form>
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
</body>

</html>