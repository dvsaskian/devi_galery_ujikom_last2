
<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

if (isset($_GET['like_foto_id'])) {
    $foto_id = $_GET['like_foto_id'];

    $query = mysqli_query($koneksi, "SELECT f.user_id AS foto_owner_id, f.judul_foto, f.lokasi_file, u.username 
                                      FROM foto f 
                                      JOIN users u ON u.user_id = f.user_id 
                                      WHERE f.foto_id = '$foto_id'");
    $foto_data = mysqli_fetch_assoc($query);
    $foto_owner_id = $foto_data['foto_owner_id'];
    $judul_foto = $foto_data['judul_foto'];
    $foto_path = "../assets/img/" . $foto_data['lokasi_file']; 
    $username = $foto_data['username'];

    if ($foto_owner_id != $user_id) {
        $notif_message = "$username menyukai postingan Anda: '$judul_foto'"; // Tidak membawa $user_id lagi

        $insert_notif = mysqli_query($koneksi, "INSERT INTO notifikasi (user_id, message, foto_id, send_id, status) 
                                        VALUES ('$foto_owner_id', '$notif_message', '$foto_id', '$user_id', 'unread')");

        if (!$insert_notif) {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}

if (isset($_GET['komentar_foto_id']) && isset($_GET['isi_komentar'])) {
    $foto_id = $_GET['komentar_foto_id'];
    $isi_komentar = $_GET['isi_komentar'];
 die($isi_komentar);
 exit;

    $query = mysqli_query($koneksi, "SELECT f.user_id AS foto_owner_id, f.judul_foto, f.lokasi_file, u.username 
                                      FROM foto f 
                                      JOIN users u ON u.user_id = f.user_id 
                                      WHERE f.foto_id = '$foto_id'");
    $foto_data = mysqli_fetch_assoc($query);
    $foto_owner_id = $foto_data['foto_owner_id'];
    $judul_foto = $foto_data['judul_foto'];
    $foto_path = "../assets/img/" . $foto_data['lokasi_file']; 
    $username = $foto_data['username'];

    if ($foto_owner_id != $user_id) {
        $notif_message = "$username mengomentari postingan Anda: '$judul_foto' - $isi_komentar"; // Tidak membawa $user_id lagi

        $insert_notif = mysqli_query($koneksi, "INSERT INTO notifikasi (user_id, message, foto_id, send_id, status) 
                                        VALUES ('$foto_owner_id', '$notif_message', '$foto_id', '$user_id', 'unread')");

        if (!$insert_notif) {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>

