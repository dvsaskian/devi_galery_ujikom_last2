<?php
session_start();
include '../c/koneksi.php';
include '../c/aksi_timeago.php';

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
 

$notif_query = mysqli_query($koneksi, "SELECT n.*, f.lokasi_file, f.judul_foto, u.username 
                                        FROM notifikasi n
                                        JOIN foto f ON n.foto_id = f.foto_id
                                        JOIN users u ON n.send_id = u.user_id
                                        WHERE n.user_id = '$user_id' 
                                        AND n.status = 'unread' ORDER BY n.tanggal DESC");
                                    

$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id = '$user_id' AND status = 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

function time_ago($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes      = round($seconds / 60);           
    $hours        = round($seconds / 3600);           
    $days         = round($seconds / 86400);           
    $weeks        = round($seconds / 604800);           
    $months       = round($seconds / 2629440);           
    $years        = round($seconds / 31553280);           

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
    <title>Notifikasi - D'Galeri Foto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .notification-card {
            border-radius: 10px;
            transition: 0.3s;
            background-color: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .notification-card:hover {
            background-color: #e9ecef;
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
        .card-body {
            padding: 0.75rem;
        }
    </style>
</head>
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

    <div class="container mt-4">
        <h2 class="mb-3 text-white">Notifikasi</h2>
        <div class="row">
            <div class="col-6">
                <div class="d-flex justify-content-start">
                <button id="markRead" class="btn btn-primary mb-3"  data-toggle='tooltip' title='Bersihkan Notifikasi'>Tandai Semua Telah Dibaca</button> 
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end ms-auto">
                    <a href="notifikasi_read.php" class="btn btn-success mb-3 ms-5"  data-toggle='tooltip' title='Lihat Notifikasi'>
                    Notifikasi Telah Dibaca
                    </a>
                </div>
            </div>
        </div>

        <div class="row col-12 m-1">
            <?php if (mysqli_num_rows($notif_query) > 0) { ?>
                <div class="list-group">
                    <?php while ($notif = mysqli_fetch_array($notif_query)) { ?>
                        <div class="card notification-card mb-2">
                            <div class="card notification-card mb-2">
                                <div class="card-body d-flex align-items-center">
                                    <div class="col-1">
                                        <img src='../assets/img/<?php echo $notif['lokasi_file']; ?>' class='rounded me-3' width='50' height='50'>
                                    </div>
                                    <div class="col-10">
                                        <div>
                                            <strong><?php echo $notif['username']; ?></strong> <?php echo str_replace($notif['username'], '', $notif['message']); ?>
                                            <br><small class='text-muted'><?php echo $notif['tanggal']; ?></small>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                    <a href='foto_detail.php?foto_id=<?php echo $notif['foto_id']; ?>' class='btn btn-sm btn-primary ms-auto'>Lihat Foto</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class='alert alert-warning text-center'>Tidak ada notifikasi baru.</div>
            <?php } ?>
        </div>
    </div>
    
    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>
    
    <script type="text/javascript" src="../assets/js/bootstrap.min.js">

    </script>

    <script>
        document.getElementById('markRead').addEventListener('click', function() {
            fetch('../c/tandai_read.php', { method: 'POST' })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                });
        });
    </script>
</body>
</html>
