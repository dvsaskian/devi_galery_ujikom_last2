<?php
session_start();
include 'koneksi.php';

// Ambil data yang diperlukan
$foto_id = $_POST['foto_id'];
$user_id = $_SESSION['user_id'];
$devi_isi_komentar = $_POST['isi_komentar'];
$devi_tanggal_komen = date('Y-m-d');

// Escape komentar untuk menghindari masalah SQL injection dan karakter khusus
$devi_isi_komentar = mysqli_real_escape_string($koneksi, $devi_isi_komentar);

// Ambil pemilik foto (user_id yang mengunggah foto)
$query_foto = mysqli_query($koneksi, "SELECT user_id, judul_foto FROM foto WHERE foto_id = '$foto_id'");
$foto_data = mysqli_fetch_assoc($query_foto);
$foto_owner_id = $foto_data['user_id'];
$judul_foto = $foto_data['judul_foto'];

// Masukkan komentar ke database
$query = mysqli_query($koneksi, "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) 
            VALUES ('$foto_id', '$user_id', '$devi_isi_komentar', '$devi_tanggal_komen')");

// Cek apakah komentar berhasil dimasukkan
if ($query) {
    // Kirim notifikasi ke pengirim komentar (user_id)
    $notif_message_sender = "Anda baru saja berkomentar: $devi_isi_komentar";
    mysqli_query($koneksi, "INSERT INTO notifikasi (user_id, message) VALUES ('$user_id', '$notif_message_sender')");

    // Kirim notifikasi ke pemilik foto
    $notif_message_owner = "$user_id baru saja mengomentari foto '$judul_foto': $devi_isi_komentar";
    mysqli_query($koneksi, "INSERT INTO notifikasi (user_id, message) VALUES ('$foto_owner_id', '$notif_message_owner')");

    // Tampilkan notifikasi untuk pengirim komentar
    echo "
    <script>
        alert('Anda baru saja menambahkan komentar: $devi_isi_komentar');
        location.href='../akun/index.php';
    </script>";
} else {
    echo "<script>
            alert('Terjadi kesalahan. Coba lagi nanti.');
            location.href='../akun/index.php';
          </script>";
}
?>
