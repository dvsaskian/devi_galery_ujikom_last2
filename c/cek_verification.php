<?php
session_start();
include '../c/koneksi.php'; 

if (isset($_POST['verif'])) {
    $user_id = $_POST['user_id']; 
    $username = $_POST['username']; 
    $verifikasi = 1;

    $sql = mysqli_query($koneksi, "UPDATE users SET verifikasi = $verifikasi WHERE user_id = $user_id");

    if ($sql) {
        echo "<script>
            alert('Verifikasi $username Berhasil !');
            location.href='../admin/user_verification.php';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan dalam proses verifikasi!');
            location.href='../admin/user_verification.php';
        </script>";
    }
}

if (isset($_POST['tolak'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];

    $sql = mysqli_query($koneksi, "DELETE FROM users WHERE user_id = $user_id");

    if ($sql) {
        echo "<script>
            alert('Akun $username telah ditolak dan dihapus!');
            location.href='../admin/user_verification.php';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan dalam proses penghapusan!');
            location.href='../admin/user_verification.php';
        </script>";
    }
}

if (isset($_POST['hapus'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];

        $sql = mysqli_query($koneksi, "DELETE FROM users WHERE user_id = $user_id");

        if ($sql) {
            echo "<script>
                alert('Akun $username telah ditolak, dihapus, terkait dihapus!');
                location.href='../admin/user_verification.php';
            </script>";
        } else {
            echo "<script>
                alert('Terjadi kesalahan dalam proses penghapusan akun!');
                location.href='../admin/user_verification.php';
            </script>";
        }
    } 


?>


