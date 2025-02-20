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
                    <a href="profile.php" class="btn btn-warning m-2">Profile</a>
                    <a href="../c/aksi_logout.php" class="btn btn-outline-danger m-2">Keluar</a>

                </div>
            </div>
        </div>
    </nav>


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">Tambah Album</div>
                    <div class="card-body">
                        <form action="../c/aksi_album.php" method="post">
                            <label class="form-label">Nama Album</label>
                            <input type="text" name="nama_album" class="form-control" id="" required>
                            <label class="form-label mt-2">Deskripsi</label>
                            <textarea type="text" class="form-control" name="deskripsi" id="" required></textarea>

                            <div class="row col-5">
                            <button type="submit" class="btn btn-primary btn-sm  mt-3" name="tambah">Tambah Album</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">
                        <h3>Data Album</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table owerflow-auto">
                                <thead class="table-dark" align="center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Album</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $user_id = $_SESSION['user_id'];
                                    $sql = mysqli_query($koneksi, "SELECT * FROM album WHERE user_id='$user_id'");

                                    while ($data = mysqli_fetch_array($sql)) {
                                    ?>


                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?php echo $data['nama_album']; ?></td>
                                            <td><?php echo $data['deskripsi']; ?></td>
                                            <td><?php echo $data['tanggal_dibuat']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['album_id']; ?>"><i class="bi bi-pencil"></i> Edit</button>

                                                <div class="modal fade" id="edit<?php echo $data['album_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h5>
                                                                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="../c/aksi_album.php" method="post">
                                                                    <input type="hidden" name="album_id" value="<?php echo $data['album_id']; ?>">
                                                                    <label class="form-label">Nama Album</label>
                                                                    <input type="text" name="nama_album" class="form-control" value="<?php echo $data['nama_album']; ?>" required>
                                                                    <label class="form-label mt-2">Deskripsi</label>
                                                                    <textarea class="form-control" name="deskripsi" required><?php echo $data['deskripsi']; ?></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit" class="btn btn-warning" data-toggle='tooltip' title='Edit' >Edit Data</button>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--  -->
                                                <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['album_id']; ?>"><i class="bi bi-trash"></i> Hapus</button>

                                                <div class="modal fade" id="hapus<?php echo $data['album_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h5>
                                                                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="../c/aksi_album.php" method="post">
                                                                    <input type="hidden" name="album_id" value="<?php echo $data['album_id']; ?>">
                                                                    Apakah Anda yakin ingin menghapus data <strong><?php echo $data['nama_album']; ?> ?</strong>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="hapus" class="btn btn-danger" data-toggle='tooltip' title='Hapus'>Hapus Data</button>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--  -->
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detail<?php echo $data['album_id']; ?>"><i class="bi bi-eye"></i> Detail</button>

                                                <div class="modal fade" id="detail<?php echo $data['album_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fs-5" id="exampleModalLabel">Detail Data</h5>
                                                                <button type="button" class="btn-close" id="" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="../c/aksi_album.php" method="post">
                                                                <input type="hidden" name="album_id" value="<?php echo $data['album_id']; ?>">
                                                                    <label class="form-label">Nama Album</label>
                                                                    <input type="text" name="nama_album" class="form-control" value="<?php echo $data['nama_album']; ?>" readonly>
                                                                    <label class="form-label mt-2">Deskripsi</label>
                                                                    <textarea class="form-control" name="deskripsi" readonly><?php echo $data['deskripsi']; ?></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="album.php" type="submit" name="detail" class="btn btn-primary">Kembali</a>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



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
    </div>

    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js">

    </script>
</body>

</html>