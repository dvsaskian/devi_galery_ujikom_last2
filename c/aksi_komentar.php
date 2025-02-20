

<?php
session_start();
include 'koneksi.php';

$foto_id = $_POST['foto_id'];
$user_id = $_SESSION['user_id'];
$isi_komentar = mysqli_real_escape_string($koneksi, $_POST['isi_komentar']);
$tanggal_komen = date('Y-m-d H:i:s');

$query_foto = mysqli_query($koneksi, "SELECT user_id, judul_foto FROM foto WHERE foto_id = '$foto_id'");
$foto_data = mysqli_fetch_assoc($query_foto);
$foto_owner_id = $foto_data['user_id'];
$judul_foto = $foto_data['judul_foto'];

$query_user = mysqli_query($koneksi, "SELECT username FROM users WHERE user_id = '$user_id'");
$user_data = mysqli_fetch_assoc($query_user);
$username = $user_data['username'];


$query = mysqli_query($koneksi, "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) 
            VALUES ('$foto_id', '$user_id', '$isi_komentar', '$tanggal_komen')");
if ($query) {
    if ($foto_owner_id != $user_id) {

        $notif_message_owner = "$username mengomentari foto '$judul_foto': $isi_komentar";
        $notif_message_owner = mysqli_real_escape_string($koneksi, $notif_message_owner); 
        $notif_sql = mysqli_query($koneksi, "INSERT INTO notifikasi (user_id, send_id, foto_id, message, status) 
                                VALUES ('$foto_owner_id', '$user_id', '$foto_id', '$notif_message_owner', 'unread')");
    }
if ($notif_sql) {

    $query_komen_lain = mysqli_query($koneksi, "SELECT DISTINCT user_id FROM komentar_foto WHERE foto_id = '$foto_id' AND user_id != '$user_id' AND user_id != '$foto_owner_id'");
    
    while ($komen_user = mysqli_fetch_assoc($query_komen_lain)) {
        $komen_user_id = $komen_user['user_id'];
        $notif_message_komen = "$username juga mengomentari foto '$judul_foto': $isi_komentar";
        $notif_message_komen = mysqli_real_escape_string($koneksi, $notif_message_komen);
        
        $notif_sql2 =mysqli_query($koneksi, "INSERT INTO notifikasi (user_id, send_id, foto_id, message, status) 
                                VALUES ('$komen_user_id', '$user_id', '$foto_id', '$notif_message_komen', 'unread')");
    }

    echo "
    <script>
        alert('Komentar berhasil ditambahkan.');
        location.href='../akun/index.php';
    </script>";
}
} else {
    echo "<script>
            alert('Terjadi kesalahan. Coba lagi nanti.');
            location.href='../akun/index.php';
          </script>";
}
?>
