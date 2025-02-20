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


$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id ='$user_id' AND status= 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

$sql = mysqli_query($koneksi, "
    SELECT u.username, a.nama_album,
        COUNT(DISTINCT f.foto_id) AS foto_count, 
        SUM(IFNULL(lf.like_count, 0)) AS total_like,
        SUM(IFNULL(kf.comment_count, 0)) AS total_comment
    FROM album a
    JOIN foto f ON a.album_id = f.album_id
    LEFT JOIN users u ON f.user_id = u.user_id
    LEFT JOIN (
        SELECT foto_id, COUNT(*) AS like_count
        FROM like_foto
        GROUP BY foto_id
    ) lf ON f.foto_id = lf.foto_id
    LEFT JOIN (
        SELECT foto_id, COUNT(*) AS comment_count
        FROM komentar_foto
        GROUP BY foto_id
    ) kf ON f.foto_id = kf.foto_id
     WHERE f.user_id = $user_id
    GROUP BY a.album_id, u.username, a.nama_album
    ORDER BY total_like DESC, total_comment DESC
");


// $sql = mysqli_query($koneksi, $query);

if (!$sql) {
die('Query Error: ' . mysqli_error($koneksi));
}

$data_foto = mysqli_num_rows($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - D'Galeri Foto </title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/nmp/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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

    .truncate {}
</style>

<body>

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
                    <a href="album.php" class="nav-link m-2 text-light">Album</a>
                    <a href="foto.php" class="nav-link m-2 text-light">Foto</a>
                    <a href="galeri.php" class="btn btn-secondary m-2 text-light">Galeriku</a>
                    <a href="notifikasi.php" class="nav-link m-2 position-relative text-light">
                        Notifikasi <i class="bi bi-bell"></i>
                        <?php if ($unread_count > 0) { ?>
                            <span class="top-0 start-100 translate-middle badge rounded-circle bg-danger  w-auto h-auto">
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

    <div class="container mt-4 mb-5">
        <div class="float-right mb-4">
            <a href="data-galeri_cetak_pdf.php" target="_blank" class="btn btn-warning">Download PDF</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card m-2 me-4 ms-4 mb-5">
                    <div class="card-header">
                        <h3 align="center">Laporan per Album</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if ($data_foto == 0) {
                                echo "<p class='text-center'>Data laporan tidak ditemukan.</p>";
                            } else {
                        ?>
                        <table class="table table-striped table-hover">
                            <thead class="table-dark" align="center">
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama Album</th>
                                    <th>Jumlah Foto</th>
                                    <th>Jumlah Like</th>
                                    <th>Jumlah Komentar</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                $no = 1;
                                while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?php echo $data['username']; ?></td>
                                    <td><?php echo $data['nama_album']; ?></td>
                                    <td><?php echo $data['foto_count']; ?></td>
                                    <td><?php echo $data['total_like']; ?></td>
                                    <td><?php echo $data['total_comment']; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="bg-black text-light d-flex justify-content-center border-top mt-2 br-light fixed-bottom">
        <p><strong>&copy; D'Galeri | Devi Saskia N</strong></p>
    </footer>

    <script type=""></script>
</body>

</html>