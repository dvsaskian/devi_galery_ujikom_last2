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

    // Ambil data user yang sedang login
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id='$user_id'");
    $data = mysqli_fetch_array($query);

    // Cek apakah ada perubahan foto
    if ($foto == null) {
        // Jika foto tidak diganti, tetap gunakan foto yang lama
        $nama_foto = $data['foto'];
    } else {
        // Jika foto diganti, hapus foto lama dan upload foto baru
        if (is_file('../assets/img/'.$data['foto'])) {
            unlink('../assets/img/'.$data['foto']);
        }
        move_uploaded_file($tmp, $lokasi.$nama_foto);
    }

    // Cek apakah password diubah
    if (empty($password)) {
        // Jika password tidak diubah, gunakan password lama
        $password = $data['password'];
    } else {
        // Jika password diubah, hash password yang baru
        $password = md5($password);
    }

    // Update data user di database
    $sql = mysqli_query($koneksi, "UPDATE users SET username='$username', email='$email', nama_lengkap='$nama', alamat='$alamat', password='$password', foto='$nama_foto' WHERE user_id='$user_id'");

    // Cek apakah query berhasil
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
