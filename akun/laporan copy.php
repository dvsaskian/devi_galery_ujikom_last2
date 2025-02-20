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


$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id ='$user_id' AND status= 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

$query_user = mysqli_query($koneksi, "SELECT nama_lengkap FROM users WHERE user_id = '$user_id'");
$data_user = mysqli_fetch_assoc($query_user);
$nama_lengkap = $data_user['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - D'Galeri Foto</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/nmp/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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

        .truncate {}

        .no-print {
            display: none;
        }

        @media print {
            .no-print {
                display: none;
            }
            .print-btn {
                display: none;
            }
            thead {
                background-color:black ; 
                color: #f8f8f8 ;
            }
        }


    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header">
                        <h3 align="center">Laporan D'Galeri Foto</h3>
                        <p align="center">
                            Tanggal : <?php echo date('d-m-Y'); ?> | Pengguna : <?php echo $nama_lengkap; ?>
                        </p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="table-dark" align="center">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Tanggal Unggah</th>
                                    <th>Jumlah Like</th>
                                    <th>Jumlah Komentar</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                    $sql = mysqli_query($koneksi, "
                                    SELECT f.foto_id, f.judul_foto, f.tanggal_unggah, f.lokasi_file, u.username, u.nama_lengkap, 
                                        COUNT(DISTINCT lf.user_id) AS like_count,
                                        COUNT(kf.foto_id) AS comment_count
                                    FROM foto f
                                    LEFT JOIN users u ON f.user_id = u.user_id
                                    LEFT JOIN like_foto lf ON f.foto_id = lf.foto_id
                                    LEFT JOIN komentar_foto kf ON f.foto_id = kf.foto_id
                                    WHERE f.user_id = '$user_id'
                                    GROUP BY f.foto_id
                                    ORDER BY like_count DESC, comment_count DESC
                                    ");

                                if (!$sql) {
                                    die('Query Error: ' . mysqli_error($koneksi));
                                }

                                $no = 1;
                                while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <img src="../assets/img/<?php echo $data['lokasi_file']; ?>" alt="Foto" style="width:80px;">
                                        </td>
                                        <td><?php echo $data['judul_foto']; ?></td>
                                        <td><?php echo $data['tanggal_unggah']; ?></td>
                                        <td><?php echo $data['like_count']; ?></td>
                                        <td><?php echo $data['comment_count']; ?></td>
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

    <footer class="bg-light d-flex justify-content-center border-top mt-2 br-light fixed-bottom">
        <p><strong>&copy; D'Galeri | Devi Saskia N</strong></p>
    </footer>

    <div class="text-center mt-3">
        <button class="btn btn-success print-btn" onclick="window.print()">Print Laporan</button>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
