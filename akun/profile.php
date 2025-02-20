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


$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id = '$user_id' AND status = 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

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
    <?php
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id='$user_id'");
        $data = mysqli_fetch_array($query);
    ?>
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card p-4">
                    <h4 class="text-center">Profile</h4>
                    <hr class="text-primary">
                    <form action="../c/aksi_profile_baru.php" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="image d-flex flex-column justify-content-center align-items-center">
                                <!-- <img src="../assets/img/<?php echo $data['foto']; ?>" height="120" width="120" class="rounded-circle mb-3" title="<?php echo $data['username']; ?>" /> -->
                                <img src="../assets/img/<?php echo ($data['foto'] && file_exists('../assets/img/'.$data['foto'])) ? $data['foto'] : 'blankk.png'; ?>" height="120" width="120" class="rounded-circle mb-3" title="<?php echo $data['username']; ?>" />

                                <div class="form-group mb-3">
                                    <label for="foto">Ganti Foto Profil</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="<?php echo $data['username']; ?>" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Ganti Password </label>
                                    <small class="text-muted"> <i>(Kosongkan jika tidak ingin mengganti) </i></small>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo $data['email']; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama_lengkap"
                                        value="<?php echo $data['nama_lengkap']; ?>" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="4"
                                        required><?php echo $data['alamat']; ?></textarea>
                                </div>
                            </div>

                            
                            <div class="d-flex flex-wrap text-right">
                                <button type="submit" name="submit" class="btn btn-primary me-2 mb-2">SIMPAN</button>
                                <a class='btn btn-danger me-2 mb-2' data-toggle='tooltip' title='Kembali' href='index.php'
                                    onclick="return confirm('Apa anda yakin meninggalkan halaman ini?')">KEMBALI</span></a>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js">

    </script>
</body>

</html>