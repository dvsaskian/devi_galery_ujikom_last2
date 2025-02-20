<?php
session_start();
include '../c/koneksi.php';

$user_id = $_SESSION['user_id'];

if ($_SESSION['status'] != 'login') {
    echo "
    <script>
        alert('Anda Belum Login!');
        location.href='../index.php';
    </script>";
}

if (isset($_GET['foto_id'])) {
    $foto_id = $_GET['foto_id'];

    $cek_simpan = mysqli_query($koneksi, "SELECT * FROM simpan_foto WHERE foto_id='$foto_id' AND user_id='$user_id'");
    if (mysqli_num_rows($cek_simpan) == 0) {
        $query = "INSERT INTO simpan_foto (user_id, foto_id) VALUES ('$user_id', '$foto_id')";
        if (mysqli_query($koneksi, $query)) {
            echo "
            <script>
                alert('Foto berhasil disimpan ke galeri!');
                location.href='../akun/simpan_foto.php';
            </script>";
        } else {
            echo "
            <script>
                alert('Gagal menyimpan foto!');
                location.href='../akun/simpan_foto.php';
            </script>";
        }
    } else {
        echo "
        <script>
            alert('Foto sudah ada di galeri Anda!');
            location.href='../akun/simpan_foto.php';
        </script>";
    }
} else {
    echo "
    <script>
        alert('Foto tidak ditemukan!');
        location.href='../user/galeri.php';
    </script>";
}
?>
