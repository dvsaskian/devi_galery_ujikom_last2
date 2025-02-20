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


if (isset($_GET['id'])) {
    $foto_id = $_GET['foto_id'];
    $user_id = $_SESSION['user_id'];
    $tanggal = date('Y-m-d');

    $query = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id = '$foto_id', user_id = '$user_id', tanggal_like= '$tanggal'");
    if (mysqli_num_rows($query) == 0) {
        mysqli_query($koneksi, "INSERT INTO like_foto (foto_id, user_id, tanggal_like) VALUES ('$foto_id', '$user_id', '$tanggal')");
    }
    header("Location: index.php"); 
}
?>
