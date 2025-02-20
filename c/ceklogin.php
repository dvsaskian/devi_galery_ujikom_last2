<?php
session_start();
include 'koneksi.php';

    if (isset($_POST['login'])) {
    $username       = $_POST['username'];
    $password       = md5($_POST['password']);

    $devi_username = mysqli_real_escape_string($koneksi, $username);
    $devi_password = mysqli_real_escape_string($koneksi, $password);

    $sql = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$devi_username' AND password='$devi_password'");

    $cek = mysqli_num_rows($sql);

    
    if ($cek > 0) {
        $data = mysqli_fetch_array($sql);

        if ($data['verifikasi'] == 0) {

            echo "
            <script>
                alert('Akun Harus Verifikasi Terlebih Dahulu!');
                location.href='../login.php';
            </script>";
            exit();
        }

        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role_id'] = $data['role_id'];
        $_SESSION['status'] = 'login';

        if ($_SESSION['role_id'] == 1) {
            echo "
            <script>
                alert('Anda Berhasil Login');
                location.href='../admin/index.php';
            </script>";
        } elseif ($_SESSION['role_id'] == 2) {
            echo "
            <script>
                alert('Anda Berhasil Login');
                location.href='../akun/index.php';
            </script>";
        }
    } else {
        echo "
        <script>
            alert('Username atau Password salah !');
            location.href='../login.php';
        </script>";
        header("location:../login.php?pesan=gagal");
    }
}
?>
