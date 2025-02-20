<?php
include 'koneksi.php';

$username       = $_POST['username'];
$password       = md5($_POST['password']);
$email          = $_POST['email'];
$nama_lengkap   = $_POST['nama_lengkap'];
$alamat         = $_POST['alamat'];
$foto           = $_FILES['foto']['name']; 
$tmp_foto       = $_FILES['foto']['tmp_name'];
$lokasi_foto    = '../assets/img/';

$nama_foto = rand() . '-' . $foto;

$devi_cekusername = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($devi_cekusername) > 0) {
    echo "
    <script>
        alert('Username sudah digunakan, Silahkan pilih username lain !');
        location.href='../register.php';
    </script>";
} else {
    move_uploaded_file($tmp_foto, $lokasi_foto . $nama_foto);

    $sql = mysqli_query($koneksi, "INSERT INTO users (username, password, email, nama_lengkap, alamat, foto, role_id, verifikasi) 
    VALUES ('$username', '$password', '$email', '$nama_lengkap', '$alamat', '$nama_foto', 2, 0)");

    if ($sql) {
        echo "
        <script>
            alert('Pendaftaran akun berhasil');
            location.href='../login.php';
        </script>";
    }  else {
        echo "Pendaftaran Gagal";
    }
}
?>
