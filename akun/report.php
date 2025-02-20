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

$query_favorit = mysqli_query($koneksi, "
    SELECT foto.*, 
           (SELECT COUNT(*) FROM like_foto WHERE foto_id = foto.foto_id) AS like_count,
           (SELECT COUNT(*) FROM komentar_foto WHERE foto_id = foto.foto_id) AS komentar_count
    FROM foto
    ORDER BY like_count DESC, komentar_count DESC
    LIMIT 3
");

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

<script>
    let optionsVisitorsProfile  = {
	series: absensi_chart,
	labels: ['Like', 'Komen'],
	colors: ['#435ebe','#FFA500'],
	chart: {
		type: 'donut',
		width: '100%',
		height:'350px'
	},
	legend: {
		position: 'bottom'
	},
	plotOptions: {
		pie: {
			donut: {
				size: '30%'
			}
		}
	}
}

</script>

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
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Statistik Report</h4>    
                        <p class="card-text text-center">Untuk melihat Report, dapat dilihat melihat disini!.</p>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div>
            </div>
        </div>

                   


    </div>

    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>

    <script>
        document.querySelectorAll('.toggle-photo').forEach(button => {
            button.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));

                if (target.classList.contains('collapse')) {
                    target.classList.remove('collapse');
                } else {
                    target.classList.add('collapse');
                }
            });
        });

    </script>

</body>
</html>
