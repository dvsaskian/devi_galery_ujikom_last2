<?php
session_start();
include '../c/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "Session tidak ditemukan!";
    exit;
}

$user_id = $_SESSION['user_id'];

// Update status semua notifikasi menjadi "read"
$query = "UPDATE notifikasi SET status = 'read' WHERE user_id = '$user_id' AND status = 'unread'";
if (mysqli_query($koneksi, $query)) {
    echo "Semua notifikasi telah ditandai sebagai dibaca.";
} else {
    echo "Gagal memperbarui notifikasi: " . mysqli_error($koneksi);
}
?>
