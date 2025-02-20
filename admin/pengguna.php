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


if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $userid =  $_SESSION['user_id'];
}
// $sql = mysqli_query($koneksi, "SELECT * FROM users WHERE verifikasi = 1");
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

<body>

<nav class="navbar navbar-expand-lg bg-black">
    <div class="container">
        <a class="navbar-brand text-light" href="index.php">
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
                <a href="user_verification.php" class="btn btn-warning m-2">User Verification</a>
                <a href="pengguna.php" class="btn btn-success m-2">Data Pengguna</a>
                <a href="../c/aksi_logout.php" class="btn btn-outline-danger m-2">Keluar</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-header">
                    <h3>Data Pengguna</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-dark" align="center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody  align="center">
                            <?php
                            $no = 1;
                            $sql = mysqli_query($koneksi, "SELECT * FROM users join role ON users.role_id = role.role_id WHERE verifikasi = 1 ");

                            if (!$sql) {
                                die('Query Error: ' . mysqli_error($koneksi));
                            }

                            while ($data = mysqli_fetch_array($sql)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?php echo $data['nama_lengkap']; ?></td>
                                    <td><?php echo $data['username']; ?></td>
                                    <td><?php echo $data['nama_role']; ?></td>
                                    <td class="text-primary"><strong>Berhasil</strong></td>
                                    <!-- <td>
                                            <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['user_id']; ?>"><i class="bi bi-pencil"></i> Edit</button>

                                            <div class="modal fade" id="edit<?php echo $data['user_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h5>
                                                            <button type="button" class="btn-close" id="" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="../c/aksi_pengguna.php" method="post">
                                                                <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
                                                                <label for="form-label">Username</label>
                                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>" required>
                                                                <label for="password">Ganti Password </label>
                                                                <small class="text-muted"> <i>(Kosongkan jika tidak ingin mengganti) </i></small>
                                                                <input type="password" class="form-control" id="password" name="password">
                                                                <label for="form-label">Nama Lengkap</label>
                                                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" required>
                                                                <label for="form-label">Email</label>
                                                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $data['email']; ?>" required>
                                                                <label class="form-label mt-2">Alamat</label>
                                                                <textarea class="form-control" name="alamat" required><?php echo $data['alamat']; ?></textarea>
                                                                <label for="alamat">Role</label>
                                                                <select name = "role"  class="form-control" id="form-role"  required>
                                                                    <option value="" disabled selected>Silahkan Pilih !</option>
                                                                    <option value="1">Admin</option>
                                                                    <option value="2">User</option>
                                                                </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit" class="btn btn-warning">Edit Data</button>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                 -->
                                    <td>
                                        <form action="../c/cek_verification.php" method="POST" class="d-inline">
                                            <input type="hidden" name="user_id" value="<?=$data['user_id']?>">
                                            <input type="hidden" name="username" value="<?=$data['username']?>">
                                            <input type="submit" value="Hapus" name="hapus" class="btn btn-danger px-4 py-2 mx-auto bg-500 text-white text-sm font-semibold rounded" data-toggle='tooltip' title='Hapus Akun'>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-black text-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
    <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

</body>

</html>
