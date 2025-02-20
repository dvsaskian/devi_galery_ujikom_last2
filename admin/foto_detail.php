<?php
session_start();
include '../c/koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "
        <script>
            alert('Anda Belum Login !');
            location.href='../index.php';
        </script>";
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "
        <script>
            alert('User ID tidak ditemukan!');
            location.href='../index.php';
        </script>";
    exit;
}

$user_id = $_SESSION['user_id'];


    $foto_id = isset($_GET['foto_id']) ? $_GET['foto_id'] : null;

    if ($foto_id === null) {
        echo "
        <script>
            alert('Foto tidak ditemukan!');
            location.href='foto.php';
        </script>";
        exit;
    }

    $query = mysqli_query($koneksi, "SELECT * FROM foto 
                                    JOIN users ON foto.user_id=users.user_id 
                                    JOIN album ON foto.album_id=album.album_id 
                                    WHERE foto.foto_id = '$foto_id'");


    if (mysqli_num_rows($query) == 0) {
        echo "
        <script>
            alert('Foto tidak ditemukan!');
            location.href='foto.php';
        </script>";
        exit;
    }

    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'Galeri Foto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/icons/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
    .content {
        flex-grow: 1;
    }

    footer {
        background-color: #f8f9fa;
        text-align: center;
        padding: 10px 0;
        border-top: 1px solid #ddd;
    }

    .foto-container {
        max-width: 100%;
        height: auto;
    }

    .info-container {
        padding-left: 20px;
    }

    .info-container input {
        margin-bottom: 10px;
    }
    .card-body {
    padding: 1.5rem;
    overflow: hidden;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 8px;
        border: none;;
    }



</style>

<body class="">

    <nav class="navbar navbar-expand-lg bg-black">
            <div class="container">
                <a class="navbar-brand text-light" href="index.php">
                    <h3><strong>D'Galery</strong></h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                    <div class="navbar-nav me-auto">
                        <a href="index.php" class="btn btn-secondary m-2">Beranda</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="user_verification.php" class="btn btn-warning m-2">User Verification</a>
                        <a href="pengguna.php" class="btn btn-success m-2">Data Pengguna</a>
                        <a href="laporan.php" class="btn btn-info m-2">Laporan</a>
                        <a href="profile.php" class="btn btn-secondary m-2">Profile</a>
                        <a href="../c/aksi_logout.php" class="btn btn-outline-danger m-2">Keluar</a>
                    </div>
                </div>
            </div>
        </nav>

    <div class="container mt-3 mb-5">
        <div class="card bg-bone-white mx-3">
            <div class="row">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <figure>
                                <img src="../assets/img/<?php echo $data['lokasi_file'] ?>" alt="" class="img-fluid img-thumbnail rounded m-2">
                            </figure>
                        </div>
                        <div class="col-9">
                            <table class="table m-2 table-responsiv">
                                <tbody>
                                    <tr>
                                        <th>Judul</th>
                                        <td>: <?php echo $data['judul_foto'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>: <?php echo $data['deskripsi_foto'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Album</th>
                                        <td>: <?php echo $data['nama_album'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Unggah</th>
                                        <td>: <?php echo $data['tanggal_unggah'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pengunggah</th>
                                        <td>: <?php echo $data['nama_lengkap'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="text-center m-3">
            <a href="index.php" class="btn btn-warning">Kembali</a>
    </div>

    <footer class="bg-black text-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>

</html>
