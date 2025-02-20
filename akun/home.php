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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'Galeri Foto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
</style>

<body class="bg-black">

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <h3><strong>D'Galery</strong></h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                    <div class="navbar-nav me-auto">
                        <a href="index.php" class="btn btn-secondary m-2">Beranda</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="album.php" class="nav-link m-2">Album</a>
                        <a href="foto.php" class="nav-link m-2">Foto</a>
                        <a href="galeri.php" class="btn btn-secondary m-2">Galeriku</a>
                        <a href="notifikasi.php" class="nav-link m-2 position-relative">
                            Notifikasi <i class="bi bi-bell"></i>
                            <?php if ($unread_count > 0) { ?>
                                <span class=" top-0 start-100 translate-middle badge rounded-circle bg-danger  w-auto h-auto">
                                    <?php echo $unread_count; ?>
                                </span>
                            <?php } ?>
                        </a>
                        <a href="laporan.php" class="btn btn-info m-2">Laporan</a>
                        <a href="data_laporan.php" class="btn btn-info m-2">Laporan Galeri</a>
                        <a href="profile.php" class="btn btn-warning m-2">Profile</a>
                        <a href="../c/aksi_logout.php" class="btn btn-outline-danger m-2">Keluar</a>

                    </div>
                </div>
            </div>
        </nav>  

    <div class="container mt-3">
        <div class="row">

            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id='$user_id'");

            while ($data = mysqli_fetch_array($query)) {
                ?>

                <div class="col-md-3 mt-5" style="height: 15rem;">
                    <div class="card mx-5">
                    <a href="foto_detail.php?id=<?php echo $data['foto_id']; ?>">
                        <img src="../assets/img/<?php echo $data['lokasi_file']?>" class="card-img-top" alt="" style="height: 15rem;" title="<?php echo $data['judul_foto']?>">
                    </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data['judul_foto']?></h5>
                            <p class="card-text"><?php echo $data['deskripsi_foto']?> </p>
                            <a href="foto_detail.php?id=<?php echo $data['foto_id']; ?>" class="btn btn-primary">Lihat Foto</a>
                        </div>
                        <div class="card-footer text-center">
                            <a href=""><i class="bi bi-heart"></i></a> Suka
                            <a href=""><i class="bi bi-chat-dots ms-2"></i></a> Komentar
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

    <footer>
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js">

    </script>
</body>

</html>