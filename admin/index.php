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

$foto_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $foto_per_page; 

$total_foto_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM foto");
$total_foto_result = mysqli_fetch_assoc($total_foto_query);
$total_foto = $total_foto_result['total'];

$total_pages = ceil($total_foto / $foto_per_page);

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
    .truncate {
            white-space: nowrap;       
            overflow: hidden;           
            text-overflow: ellipsis;    
    }
</style>



<body class="bg-black">

    <nav class="navbar navbar-expand-lg bg-light">
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

        <div class="col-4 mb-2">
            <div class="input-group mb-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari ...">
            </div>

        </div>

        <div class="row">

            <?php
            $devi_query_foto = mysqli_query($koneksi, "SELECT * FROM foto 
                                            JOIN users ON foto.user_id=users.user_id 
                                            JOIN album ON foto.album_id=album.album_id LIMIT $start, $foto_per_page  ");

                                            

            while ($data = mysqli_fetch_array($devi_query_foto)) {
                ?>

                <div class="col-md-3 mt-5">
                    <a href="" type="button" data-bs-toggle="modal"
                        data-bs-target="#komentar<?php echo $data['foto_id'] ?>">

                        <div class="card mx-3">
                            <img style="height : 13rem;" src="../assets/img/<?php echo $data['lokasi_file'] ?>"
                                class="card-img-top" alt="" title="<?php echo $data['judul_foto'] ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title truncate"><?php echo $data['judul_foto'] ?></h5><hr>
                        <p class="card-text truncate"><?php echo $data['deskripsi_foto'] ?> </p>
                        <a href="foto_detail.php?foto_id=<?php echo $data['foto_id']; ?>" class="btn btn-primary">Lihat Foto</a>
                    </div>
                    <!-- <div class="card-footer text-center">
                        <?php
                        $foto_id = $data['foto_id'];

                        $devi_like_count = mysqli_query($koneksi, "SELECT COUNT(*) as like_count FROM like_foto WHERE foto_id='$foto_id'");
                        $like_count = mysqli_fetch_array($devi_like_count)['like_count'];
                        
                        $devi_ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id='$user_id' ");
                        if (mysqli_num_rows($devi_ceksuka) == 0) { ?>
                            <a href="../c/aksi_like.php?foto_id=<?php echo $data['foto_id']; ?>" type="submit"
                                name="batal_suka"><i class="bi bi-heart"></i></a>
                        <?php } else { ?>
                            <a href="../c/aksi_like.php?foto_id=<?php echo $data['foto_id']; ?>" type="submit" name="suka"><i
                                    class="bi bi-heart-fill"></i></a>
                        <?php }

                        $devi_like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id='$user_id'");
                        // echo mysqli_num_rows($devi_like), ' Suka';
                        
                        echo $like_count . ' Suka';
                        ?>

                        <a href="" type="button" data-bs-toggle="modal"
                            data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
                            <i class="bi bi-chat-dots ms-2"></i></a>
                        <?php
                        $devi_jumlahkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$foto_id'");
                        echo mysqli_num_rows($devi_jumlahkomen) . ' Komentar';
                        ?>

                    </div> -->
                </div>
                </a>
                <div class="modal fade" id="komentar<?php echo $data['foto_id'] ?>" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fs-5" id="exampleModalLabel"> Detail Foto
                                </h5>
                                <button type="button" class="btn-close" id="" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-8">
                                        <img src="../assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top"
                                            alt="" title="<?php echo $data['judul_foto'] ?>">
                                    </div>

                                    <div class="col-4">
                                        <div class="m-2">
                                            <div class="overflow-auto">
                                                <div class="sticky-top">
                                                    <h5><?php echo $data['judul_foto'] ?></h5><hr>
                                                    <span class="badge bg-dark m-2"><h6><?php echo $data['nama_lengkap'] ?></h6>
                                                        </span><br>
                                                    <span
                                                        class="badge bg-secondary m-2"><?php echo $data['tanggal_unggah'] ?></span>
                                                    <span
                                                        class="badge bg-warning text-black m-2"><?php echo $data['nama_album'] ?></span>
                                                </div>
                                                <hr>
                                                <p align="left">
                                                    <?php echo $data['deskripsi_foto'] ?>
                                                </p>
                                                <hr>
                                                <?php
                                                $foto_id = $data['foto_id'];
                                                $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto JOIN users On komentar_foto.user_id=users.user_id WHERE komentar_foto.foto_id='$foto_id'");
                                                while ($row = mysqli_fetch_array($komentar)) {
                                                    ?>
                                                    <p align="left">
                                                        <strong><?php echo $row['nama_lengkap'] ?> </strong>
                                                        <?php echo $row['isi_komentar'] ?>
                                                    </p>
                                                <?php } ?>
                                                <hr>
                                                <div class="sticky-bottom">
                                                    <form action="../c/aksi_komentar.php" method="POST">
                                                        <div class="input-group">
                                                            <input type="hidden" name="foto_id"
                                                                value="<?php echo $data['foto_id'] ?>">
                                                            <input type="text" name="isi_komentar" class="form-control"
                                                                placeholder="Tambah Komentar">
                                                            <div class="input-group-prepend m-2">
                                                                <button type="submit" name="kirim_komentar"
                                                                    class="btn btn-outline-success">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <?php } ?> 
        </div>

        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination mb-5">
                <?php if ($page > 1): ?>
                    <li class="page-item ">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                <?php endif; ?>

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


    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.col-md-3');

            cards.forEach(function (card) {
                let title = card.querySelector('.card-title').textContent.toLowerCase();
                let description = card.querySelector('.card-text').textContent.toLowerCase();
                
                if (title.includes(filter) || description.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
    </script>

    

</body>

</html>