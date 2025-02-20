<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $lokasi = '../assets/img/';
    $nama_foto = rand().'-'.$foto;

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id='$user_id'");
    $data = mysqli_fetch_array($query);

    if ($foto == null) {
        $nama_foto = $data['foto'];
    } else {
        if (is_file('../assets/img/'.$data['foto'])) {
            unlink('../assets/img/'.$data['foto']);
        }
        move_uploaded_file($tmp, $lokasi.$nama_foto);
    }

    if (empty($password)) {
        $password = $data['password'];
    } else {
        $password = md5($password);
    }

    $sql = mysqli_query($koneksi, "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat', password='$password', foto='$nama_foto' WHERE user_id='$user_id'");

    if ($sql) {
        echo "
        <script>
            alert('Profil berhasil diperbarui!');
            location.href='../akun/profile.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Terjadi kesalahan saat memperbarui profil!');
            location.href='../akun/profile.php';
        </script>";
    }
}
?>
