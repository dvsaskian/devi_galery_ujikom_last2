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

// Menghitung jumlah notifikasi belum dibaca
$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id = '$user_id' AND status = 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

// Menentukan jumlah foto per halaman
$foto_per_page = 8;

// Mendapatkan halaman saat ini (default ke 1 jika tidak ada di URL)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $foto_per_page; // Menghitung offset foto yang akan ditampilkan

// Menghitung total foto
$total_foto_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM foto");
$total_foto_result = mysqli_fetch_assoc($total_foto_query);
$total_foto = $total_foto_result['total'];

// Menghitung jumlah halaman yang dibutuhkan
$total_pages = ceil($total_foto / $foto_per_page);

// Query untuk mengambil foto dengan batasan
$query_foto = mysqli_query($koneksi, "
    SELECT foto.*, 
           (SELECT COUNT(*) FROM like_foto WHERE foto_id = foto.foto_id) AS like_count,
           (SELECT COUNT(*) FROM komentar_foto WHERE foto_id = foto.foto_id) AS komentar_count
    FROM foto
    ORDER BY like_count DESC, komentar_count DESC
    LIMIT $start, $foto_per_page
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

        <div class="col-4 mb-2">
            <div class="input-group mb-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari ...">
            </div>
            <a href="lihat.php" class="btn btn-primary m-2">Lihat Foto Terfavorit dan Terbaru?</a>

        </div>

        <div class="row">

            <?php while ($data = mysqli_fetch_array($query_foto)) { ?>

                <div class="col-md-3 mt-5">
                    <a href="" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">

                        <div class="card mx-3">
                            <img style="height : 13rem;" src="../assets/img/<?php echo $data['lokasi_file'] ?>"
                                class="card-img-top" alt="" title="<?php echo $data['judul_foto'] ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title truncate"><?php echo $data['judul_foto'] ?></h5>
                        <hr>
                        <p class="card-text truncate"><?php echo $data['deskripsi_foto'] ?> </p>
                        <a href="foto_detail.php?foto_id=<?php echo $data['foto_id']; ?>" class="btn btn-primary">Lihat Foto</a>
                    </div>
                    <div class="card-footer text-center">
                        <!-- Like and Comment buttons -->
                    </div>
                </div>
                </a>

            </div>

            <?php } ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                <?php endif; ?>

                <!-- Menampilkan nomor halaman -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>


    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
