<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'Galeri Foto</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        .card-custom-shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5), 0 6px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container">
            <a class="navbar-brand text-light" href="index.php"><strong>D'Galery</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a href="index.php" class="btn btn-secondary m-2">Beranda</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="register.php" class="btn btn-outline-primary m-2">Daftar</a>
                    <a href="login.php" class="btn btn-outline-success m-2">Masuk</a>

                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-1">
                    <div class="card-body bg-light">
                        <div class="text-center">
                            <h5>DAFTAR AKUN BARU</h5>
                        </div>
                        <form action="c/aksi_register.php" method="post" enctype="multipart/form-data">
                            <div class="form-group was-validated mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input class="form-control" type="text" name="username" required>
                            </div>
                            <div class="form-group was-validated mb-3">
                                <label class="form-label" for="username">Password</label>
                                <input class="form-control" type="text" name="password" required>
                            </div>
                            <div class="form-group was-validated mb-3">
                                <label for="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group was-validated mb-3">
                                <label for="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" required>
                            </div>
                            <div class="form-group was-validated mb-3">
                                <label for="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" required>
                            </div>
                            <div class="form-group was-validated mb-3">
                                <label for="foto">Foto</label>
                                <input type="file" name="foto" class="form-control" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-dark" type="submit" name="submit">MASUK </button>
                            </div>
                        </form>
                        <hr>
                        <p>Sudah punya akun? <a href="login.php">Daftar disini!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-black text-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="assets/js/bootstrap.min.js">

    </script>
</body>

</html>