<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $password = md5($_POST['password']);
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $lokasi = '../assets/img/';
    $nama_foto = rand().'-'.$foto;

    if ($foto == null) {
        $sql = mysqli_query($koneksi, "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat' WHERE user_id='$user_id'");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id='$user_id'");
        $data = mysqli_fetch_array($query);
        
        if (is_file('../assets/img/'.$data['foto'])) {
            unlink('../assets/img/'.$data['foto']);
        }

        move_uploaded_file($tmp, $lokasi.$nama_foto);

        $sql = mysqli_query($koneksi, "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat', foto='$nama_foto' WHERE user_id='$user_id'");
    }

    if (!empty($password)) {
        $sql = mysqli_query($koneksi, "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat', password='$password', foto='$nama_foto' WHERE user_id='$user_id'");
    }

    if ($sql) {
        echo "
        <script>
            alert('Profil berhasil diperbarui!');
            location.href='../admin/profile.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Terjadi kesalahan saat memperbarui profil!');
            location.href='../admin/profile.php';
        </script>";
    }
}
?>
