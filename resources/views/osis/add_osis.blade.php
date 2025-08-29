<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-vote | {{ auth()->user()->level }} | Tambah Data OSIS</title>
    @include('template.headerr')
    <title>E-vote | {{auth()->user()->level}} | Add</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | ' +
                     'bold italic backcolor | alignleft aligncenter ' +
                     'alignright alignjustify | bullist numlist outdent indent | ' +
                     'removeformat | help',
            menubar: 'file edit view insert format tools table help',
        });
    </script>

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
        .btn-primary {
            background: linear-gradient(45deg, #EB8153, #ff9b72);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(235,129,83,0.4);
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
        }
        .breadcrumb-item a {
            color: #EB8153;
            text-decoration: none;
            transition: 0.3s;
        }
        .breadcrumb-item a:hover {
            color: #ff9b72;
        }
        label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .form-control-file {
            padding: 10px 0;
        }
    </style>
</head>

<body>
    @include('template.topbarr')
    @include('template.sidebarr')

    <div class="content-body animate__animated animate__fadeIn">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Selamat Datang!</h4>
                        <p class="mb-0">Tambah Calon OSIS Baru</p>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Calon OSIS</a></li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-white">Form Tambah Calon OSIS</h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="/osis/store" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Calon (Ketua/Wakil Ketua OSIS) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_calon" name="nama_calon" placeholder="Masukkan nama calon" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Periode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="periode" name="periode" placeholder="Contoh: 2023/2024" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>NIS <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="NIS" name="NIS" placeholder="Masukkan NIS" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kelas <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Contoh: XI RPL 1 / XII RPL 1" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Slogan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="slogan" name="slogan" placeholder="Masukkan slogan ">
                                </div>
                                <div class="form-group">
                                    <label>Visi</label>
                                    <textarea class="form-control" id="visi" name="visi" rows="8" placeholder="Tuliskan visi"></textarea>
                                </div>  
                                <div class="form-group">
                                    <label>Misi</label>
                                    <textarea class="form-control" id="misi" name="misi" rows="8" placeholder="Tuliskan misi"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Foto Calon</label>
                                    <input type="file" class="form-control-file" id="gambar" name="gambar">
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                                </div>
                                < <div class="form-group mt-4 text-right">
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