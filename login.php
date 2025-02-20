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
            <diic class="col-md-4 mt-2">
                <div class="card card-custom-shadow">
                    <div class="card-body bg-light">
                        <div class="text-center">
                            <h5>LOGIN</h5>
                        </div>

                        <div class="ket">
                            <?php
                            if (isset($_GET['pesan'])) {
                                if ($_GET['pesan'] == "gagal") {
                                    echo '<div class="alert alert-danger" role="alert">
                            Login gagal, Username atau Password salah!
                            </div>';
                                } elseif ($_GET['pesan'] == "logout") {
                                    echo '<div class="alert alert-info" role="alert">
                            Anda telah berhasil logout
                            </div>';
                                } else {
                                    echo '<div class="alert alert-info" role="alert">
                            Anda harus login untuk mengakses halaman tersebut
                            </div>';
                                }

                            }
                            ?>
                        </div>
                        
                        <form action="c/ceklogin.php" method="post">
                            <div class="form-group was-validated mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input class="form-control" type="text" name="username" required>
                            </div>
                            <div class="form-group was-validated mb-5">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" type="password" name="password" required>
                            </div>
                            <input type="submit" class="btn btn-dark w-100" name="login" value="Login">
                            </a>
                        </form>
                        <hr>
                        <p>Belum punya akun? <a href="register.php">Register dahulu!</a></p>
                    </div>
                </div>
            </diic>
        </div>
    </div>

    <footer class="bg-black text-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="assets/js/bootstrap.min.js">

    </script>
</body>

</html>