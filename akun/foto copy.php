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

        body {
            margin-bottom: 160px;
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
  
<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card mt-2">
                <div class="card-header">Tambah Foto</div>
                <div class="card-body">
                    <form action="../c/aksi_foto.php" method="post" enctype="multipart/form-data">
                        <label class="form-label mt-2">Judul Foto</label>
                        <input type="text" name="judul_foto" class="form-control" id="" required>
                        <label class="form-label mt-2">Deskripsi</label>
                        <textarea type="text" class="form-control" name="deskripsi_foto" id="" required></textarea>
                        <label class="form-label mt-2">Album</label>
                        <select class="form-control" name="album_id" id="album" required>
                            <option value="" disabled selected>Silahkan Pilih !</option>
                            <?php
                            $devi_album = mysqli_query($koneksi, "SELECT * FROM album WHERE user_id='$user_id'");

                            while ($data_album = mysqli_fetch_array($devi_album)) {
                                ?>
                                <option value="<?php echo $data_album['album_id']; ?>">
                                    <?php echo $data_album['nama_album']; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <label class="form-label mt-2">Foto</label>
                        <input type="file" name="lokasi_file" class="form-control" id="" required>
                        <div class="row col-5">
                            <button type="submit" class="btn btn-primary btn-sm mt-3" name="tambah">Tambah Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header">
                    <h3>Data Galeri Foto</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table owerflow-auto">
                            <thead class="table-dark" align="center">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Album</th>
                                    <!-- <th>Tanggal</th> -->
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $user_id = $_SESSION['user_id'];
                                $sql = mysqli_query($koneksi, "SELECT foto.*, album.nama_album FROM foto 
                                JOIN album ON foto.album_id = album.album_id
                                WHERE foto.user_id='$user_id'");

                                while ($data = mysqli_fetch_array($sql)) {
                                    ?>

                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?php echo $data['judul_foto']; ?></td>
                                    <td><?php echo $data['deskripsi_foto']; ?></td>
                                    <td><?php echo $data['nama_album']; ?></td>
                                    <!-- <td><?php echo $data['tanggal_unggah']; ?></td> -->
                                    <td><img src="../assets/img/<?php echo $data['lokasi_file']; ?>" alt=""
                                            width="100px"></td>
                                    <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['foto_id']; ?>"> <i class="bi bi-pencil"></i> Edit</button>

                                        <div class="modal fade" id="edit<?php echo $data['foto_id']; ?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">

                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Data
                                                        </h5>
                                                        <button type="button" class="btn-close" id=""
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../c/aksi_foto.php" method="post"
                                                            enctype="multipart/form-data">
                                                            <input type="hidden" name="foto_id"
                                                                value="<?php echo $data['foto_id']; ?>">

                                                            <label class="form-label mt-2">Judul Foto</label>
                                                            <input type="text" name="judul_foto" class="form-control" value="<?php echo $data['judul_foto']; ?>"
                                                                required>
                                                            <label class="form-label mt-2">Deskripsi</label>
                                                            <textarea type="text" class="form-control"  rows="4" cols="50"
                                                                name="deskripsi_foto" required><?php echo $data['deskripsi_foto']; ?></textarea>
                                                            <label class="form-label mt-2">Album</label>
                                                            <select class="form-control" name="album_id" id="album">
                                                                <option value="" type="disabled"  selected>Silahkan Pilih !
                                                                </option>
                                                                <?php
                                                                $devi_album = mysqli_query($koneksi, "SELECT * FROM album WHERE user_id='$user_id'");

                                                                while ($data_album = mysqli_fetch_array($devi_album)) {
                                                                    ?>
                                                                    <option 
                                                                        <?php if($data_album['album_id'] == $data['album_id']) 
                                                                        {?> selected="selected" <?php } ?>
                                                                            value="<?php echo $data_album['album_id']; ?>">
                                                                        <?php echo $data_album['nama_album']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <label class="form-label mt-2">Foto</label>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                <img src="../assets/img/<?php echo $data['lokasi_file']; ?>" alt=""
                                                                width="100px">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="form-label mt-2">Ganti Foto</label>
                                                                    <input type="file" name="lokasi_file" class="form-control">
                                                                </div>
                                                            </div>

                                                            
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="edit" class="btn btn-warning">Edit
                                                            Data</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapus<?php echo $data['foto_id']; ?>"><i class="bi bi-trash"></i> Hapus</button>

                                        <div class="modal fade" id="hapus<?php echo $data['foto_id']; ?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">

                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">Hapus Data
                                                        </h5>
                                                        <button type="button" class="btn-close" id=""
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../c/aksi_foto.php" method="post">
                                                            <input type="hidden" name="foto_id"
                                                                value="<?php echo $data['foto_id']; ?>">
                                                            Apakah Anda yakin ingin menghapus data
                                                            <strong><?php echo $data['judul_foto']; ?> ?</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="hapus" class="btn btn-danger">Hapus
                                                            Data</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#detail<?php echo $data['foto_id']; ?>"><i class="bi bi-eye"></i> Detail</button>

                                        <div class="modal fade" id="detail<?php echo $data['foto_id']; ?>"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="exampleModalLabel">Detail Data
                                                        </h5>
                                                        <button type="button" class="btn-close" id=""
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../c/aksi_album.php" method="post">
                                                            <input type="hidden" name="foto_id"
                                                                value="<?php echo $data['foto_id']; ?>">

                                                        <label class="form-label mt-2">Judul Foto</label>
                                                        <input type="text" name="judul_foto" class="form-control" value="<?php echo $data['judul_foto']; ?>" readonly>
                                                        <label class="form-label mt-2">Deskripsi</label>
                                                        <textarea type="text" class="form-control" rows="5" cols="50" name="deskripsi_foto" id="" readonly><?php echo $data['deskripsi_foto']; ?></textarea>
                                                        <label class="form-label mt-2">Album</label>
                                                        <input type="text" class="form-control" value="<?php echo $data['nama_album']; ?>" readonly>
                                                        <label class="form-label mt-2">Tanggal Unggah</label>
                                                        <input type="text" class="form-control" value="<?php echo $data['tanggal_unggah']; ?>" readonly>

                                                        <label class="form-label mt-2">Foto</label>
                                                        <div class="mb-3">
                                                            <img src="../assets/img/<?php echo $data['lokasi_file']; ?>" alt="" width="100px">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="foto.php" type="submit" name="detail"
                                                            class="btn btn-primary">Kembali</a>

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

    <footer class="bg-light text-black d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js">

    </script>
</body>

</html>