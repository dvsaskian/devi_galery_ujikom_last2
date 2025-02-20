<?php
session_start();
include 'koneksi.php';

$foto_id = $_GET['foto_id'];
$user_id = $_SESSION['user_id'];

$devi_ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$foto_id' AND user_id='$user_id'");

if (mysqli_num_rows($devi_ceksuka) == 1) {
    while ($row = mysqli_fetch_array($devi_ceksuka)) {
        $like_id = $row['like_id'];
        $query = mysqli_query($koneksi, "DELETE FROM like_foto WHERE like_id='$like_id'");
    }
    echo "
        <script>
            location.href='../akun/index.php';
        </script>";
} else {
    $tanggal_like = date('Y-m-d');

    $query = mysqli_query($koneksi, "INSERT INTO like_foto (foto_id, user_id, tanggal_like) 
        VALUES ('$foto_id', '$user_id', '$tanggal_like')");

    if ($query) {

        $foto_query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id = '$foto_id'");
        if ($foto_query) {
            $foto_data = mysqli_fetch_array($foto_query);
            $foto_owner_id = $foto_data['user_id'];
            $judul_foto = $foto_data['judul_foto'];

            $query_user = mysqli_query($koneksi, "SELECT username FROM users WHERE user_id = '$user_id'");
            $user_data = mysqli_fetch_assoc($query_user);
            $username = $user_data['username'];


            if ($foto_owner_id != $user_id) {
                $notif_message_owner = "$username menyukai foto Anda: $judul_foto";
                $tanggal_notifikasi = date('Y-m-d H:i:s');
                $status = 'unread';  

                $notif_query = "INSERT INTO notifikasi (user_id, message, foto_id, send_id, status, tanggal) 
                                VALUES ('$foto_owner_id', '$notif_message_owner', '$foto_id', '$user_id', '$status', '$tanggal_notifikasi')";
                $notif_send = mysqli_query($koneksi, $notif_query);
                
            }
        } else {
            echo "Error fetching foto data: " . mysqli_error($koneksi);
        }

        echo "
        <script>
            alert('Anda berhasil menyukai foto!');
            location.href='../akun/index.php';
        </script>";
    } else {
        echo "Error inserting like: " . mysqli_error($koneksi);
    }
}
?>
