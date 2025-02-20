<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
$username       = $_POST['username'];
$password       = md5($_POST['password']);
$email          = $_POST['email'];
$nama_lengkap   = $_POST['nama_lengkap'];
$alamat         = $_POST['alamat'];
$role           = $_POST['role_id'];

$devi_cekusername = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($devi_cekusername) > 0) {
    echo "
    <script>
        alert('Username sudah ada, Silahkan pilih username lain !');
        location.href='../register.php';
    </script>";
} else {
    $sql = mysqli_query($koneksi, "INSERT INTO users (username, password, email, nama_lengkap, alamat, role_id) 
                               VALUES ('$username', '$password', '$email', '$nama_lengkap', '$alamat', '$role')");

        if ($sql) {
            echo "
            <script>
                alert('Pendaftaran akun berhasil');
                location.href='../admin/pengguna.php';
            </script>";
        }  else {
            echo "Pendaftaran Gagal";
        }
} }

if (isset($_POST['edit'])) {
    $username       = $_POST['username'];
    $email          = $_POST['email'];
    $nama           = $_POST['nama_lengkap'];
    $alamat         = $_POST['alamat'];
    $password       = md5($_POST['password']);
    $role           = $_POST['role_id'];


    if (!empty($password)) {
        // $password = password_hash($password, PASSWORD_DEFAULT); // Gunakan password_hash untuk hashing
        $query = "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat', password='$password' WHERE user_id='$user_id'";
    } else {
        $query = "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat' WHERE user_id='$user_id'";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "
        <script>
            alert('Profil berhasil diperbarui!');
            location.href='../admin/pengguna.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Terjadi kesalahan!');
            location.href='../admin/pengguna.php';
        </script>";
    }
}

if (isset($_POST['hapus'])) {
    $user_id = $_POST['user_id'];

    $sql = mysqli_query($koneksi, "DELETE FROM users WHERE user_id='$user_id'");

    if ($sql) {
        echo "
        <script>
            alert('Akun Berhasil Dihapus');
            location.href='../admin/pengguna.php';
        </script>";
    } else {
        echo "Gagal Menghapus Data";
    }
}


?>