<?php 
session_start();
include 'c/koneksi.php';

$foto_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $foto_per_page; 

$total_foto_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM foto");
$total_foto_result = mysqli_fetch_assoc($total_foto_query);
$total_foto = $total_foto_result['total'];

$total_pages = ceil($total_foto / $foto_per_page);

function time_ago($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes      = round($seconds / 60);           // value 60 is seconds
    $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
    $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+365)/5/12) days * 24 hours * 60 minutes * 60 sec
    $years        = round($seconds / 31553280);     // value 31553280 is (365+365+365+365+365)/5 days * 24 hours * 60 minutes * 60 sec

    if ($seconds <= 60) {
        return "baru saja";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 menit yang lalu";
        } else {
            return "$minutes menit yang lalu";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 jam yang lalu";
        } else {
            return "$hours jam yang lalu";
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return "kemarin";
        } else {
            return "$days hari yang lalu";
        }
    } else if ($weeks <= 4.3)  { // 4.3 == 30/7
        if ($weeks == 1) {
            return "1 minggu yang lalu";
        } else {
            return "$weeks minggu yang lalu";
        }
    } 
       else {
        // return date('d.m ', strtotime($timestamp)) . ', ' . strftime('%d %B %Y', strtotime($timestamp));
        return strftime('%d %B %Y', strtotime($timestamp));
     } 
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D'Galeri Foto</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
 <style>
    body {
        background-color:   #f0f0f0;
    }  

    .truncate {
            white-space: nowrap;       
            overflow: hidden;           
            text-overflow: ellipsis;    
    }
 </style>
</head>

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
                <div class="navbar-nav ms-auto">

                    <a href="register.php" class="btn btn-outline-primary m-2">Daftar</a>
                    <a href="login.php" class="btn btn-outline-success m-2">Masuk</a>

                </div>
            </div>
               </div>
    </nav>

    <div class="container mt-2 mb-5">
        <div class="card bg-bone-white mx-3">
            <div class="row">

                <?php
                $devi_query_foto = mysqli_query($koneksi, "SELECT * FROM foto 
                                                JOIN users ON foto.user_id=users.user_id 
                                                JOIN album ON foto.album_id=album.album_id 
                                                LIMIT $start, $foto_per_page ");

                while ($data = mysqli_fetch_array($devi_query_foto)) {
                    ?>

                    <div class="col-md-3 mt-2 mb-3">
                        <a href="" type="button" data-bs-toggle="modal"
                            data-bs-target="#komentar<?php echo $data['foto_id'] ?>">

                            <div class="card mx-3">
                                <img style="height : 12rem;" src="assets/img/<?php echo $data['lokasi_file'] ?>"
                                    class="card-img-top" alt="" title="<?php echo $data['judul_foto'] ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title truncate"><?php echo $data['judul_foto'] ?></h5><hr>
                            <p class="card-text truncate"><?php echo $data['deskripsi_foto'] ?> </p>
                        </div>
                        <div class="card-footer text-center">
                            <?php
                            $foto_id = $data['foto_id'];
                            
                            ?>

                            <a href="" type="button" data-bs-toggle="modal"
                                data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
                                <i class="bi bi-chat-dots ms-2"></i></a>
                            <?php
                            $devi_jumlahkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$foto_id'");
                            echo mysqli_num_rows($devi_jumlahkomen) . ' Komentar';
                            ?>

                        </div>
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
                                            <img src="assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top"
                                                alt="" title="<?php echo $data['judul_foto'] ?>">
                                        </div>

                                        <div class="col-4">
                                            <div class="m-2">
                                                <div class="overflow-auto">
                                                    <div class="sticky-top">
                                                        <strong><?php echo $data['judul_foto'] ?></strong> <br><hr>
                                                        <span class="badge bg-dark m-2">
                                                            <h6><?php echo $data['nama_lengkap'] ?></h6></span><br>
                                                        <span
                                                            class="badge bg-secondary m-1"><?php echo $data['tanggal_unggah'] ?></span>
                                                        <span
                                                            class="badge bg-warning text-black m-1"><?php echo $data['nama_album'] ?></span>
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
                                                            <?php echo $row['isi_komentar'] ?> <br><small class='text-muted'><?php echo time_ago($row['tanggal_komentar']); ?></small>
                                                        </p>
                                                    <?php } ?>
                                                    <hr>

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
    <footer class="bg-black text-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="assets/js/bootstrap.min.js">

    </script>
</body>

</html>