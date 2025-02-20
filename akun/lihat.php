<?php
session_start();
include '../c/koneksi.php';

$user_id = $_SESSION['user_id'];
if ($_SESSION['status'] != 'login') {
    echo "
    <script>
        alert('Anda Belum Login !');
        location.href='../index.php';
    </script>";
}

$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id = '$user_id' AND status = 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

//buat like dan komentar
$query_favorit = mysqli_query($koneksi, "
    SELECT foto.*, 
           (SELECT COUNT(*) FROM like_foto WHERE foto_id = foto.foto_id) AS like_count,
           (SELECT COUNT(*) FROM komentar_foto WHERE foto_id = foto.foto_id) AS komentar_count
    FROM foto
    ORDER BY like_count DESC, komentar_count DESC
    LIMIT 3
");

//buat foto terbaru
$query_terbaru = mysqli_query($koneksi, "
    SELECT foto.* 
    FROM foto
    WHERE DATE(foto.tanggal_unggah) = CURDATE() OR DATE(foto.tanggal_unggah) = CURDATE() - INTERVAL 1 DAY
    ORDER BY foto.tanggal_unggah DESC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'Galeri Foto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
    .position-relative {
        position: relative;
    }

    .position-absolute {
        position: absolute;
    }

    .translate-middle {
        transform: translate(-50%, -50%);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem;
    }

    .bg-danger {
        background-color: #dc3545;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<body class="bg-black">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
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
                    <a href="album.php" class="nav-link m-2">Album</a>
                    <a href="foto.php" class="nav-link m-2">Foto</a>
                    <a href="galeri.php" class="btn btn-secondary m-2">Galeriku</a>
                    <a href="notifikasi.php" class="nav-link m-2 position-relative">
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

    <div class="container mt-3 mb-5">

        <div class="d-flex justify-content-center align-items-center mt-5">
            <div class="card" style="width: 28rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">Ingin Melihat Foto Terfavorit dan Terbaru?</h5>
                    <p class="card-text text-center">Untuk melihat Foto-foto hari ini, dapat dilihat melalui tautan berikut!.</p>
                    <div class="d-flex justify-content-center gap-5">
                        <button class="btn btn-warning toggle-photo mt-3 ms-4 pd-5" data-target="#favoritContainer">Terfavorit</button>
                        <button class="btn btn-info toggle-photo mt-3" data-target="#terbaruContainer">Terbaru</button>
                     </div>
                    
                </div>
            </div>
        </div>


        <div class="collapse mt-3 mb-5" id="favoritContainer">
            <div class="row">
            <h5 align="center" class="mt-3 mb-3 text-light">Foto Like dan Komen Terbanyak</h5>
                <?php while ($data = mysqli_fetch_array($query_favorit)) { ?>
                    <div class="col-md-3 mt-3">
                        <div class="card">
                            <img style="height : 13rem;" src="../assets/img/<?php echo $data['lokasi_file'] ?>"
                                class="card-img-top" alt="" title="<?php echo $data['judul_foto'] ?>">
                            <div class="card-body">
                                <h5 class="card-title truncate"><?php echo $data['judul_foto'] ?></h5>
                                <p class="card-text truncate"><?php echo $data['deskripsi_foto'] ?></p>
                                <p><strong>Likes:</strong> <?php echo $data['like_count'] ?> | 
                                    <strong>Komentar:</strong> <?php echo $data['komentar_count'] ?>
                                </p>
                                <a href="foto_detail.php?foto_id=<?php echo $data['foto_id']; ?>" class="btn btn-primary">Lihat Foto</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="collapse mt-3 mb-5" id="terbaruContainer">
            <div class="row">
                <h5 align="center" class="mt-3 mb-3 text-light">Foto Terbaru</h5>
                <?php while ($data = mysqli_fetch_array($query_terbaru)) { ?>
                    <div class="col-md-3 mt-3">
                        <div class="card">
                            <img style="height : 13rem;" src="../assets/img/<?php echo $data['lokasi_file'] ?>"
                                class="card-img-top" alt="" title="<?php echo $data['judul_foto'] ?>">
                            <div class="card-body">
                                <h5 class="card-title truncate"><?php echo $data['judul_foto'] ?></h5>
                                <p class="card-text truncate"><?php echo $data['deskripsi_foto'] ?></p>
                                <a href="foto_detail.php?foto_id=<?php echo $data['foto_id']; ?>" class="btn btn-primary">Lihat Foto</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>

    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script>
        // Ambil semua tombol yang akan menampilkan atau menyembunyikan foto
        document.querySelectorAll('.toggle-photo').forEach(button => {
            button.addEventListener('click', function() {
                // Ambil elemen konten yang terkait dengan tombol
                const target = document.querySelector(this.getAttribute('data-target'));

                // Periksa apakah konten sudah terbuka atau belum
                if (target.classList.contains('collapse')) {
                    // Jika belum terbuka, tampilkan konten
                    target.classList.remove('collapse');
                } else {
                    // Jika sudah terbuka, sembunyikan konten
                    target.classList.add('collapse');
                }
            });
        });

    </script>

</body>
</html>
