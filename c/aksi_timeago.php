<?php
function timeAgo($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    
    // Menghitung waktu dalam detik
    $seconds = $time_difference;
    $minutes = round($seconds / 60);      // nilai 60 adalah detik
    $hours = round($seconds / 3600);      // nilai 3600 adalah 60 menit * 60 detik
    $days = round($seconds / 86400);      // nilai 86400 adalah 24 jam * 60 menit * 60 detik

    // Jika selisih waktu kurang dari 24 jam
    if ($days == 0) {
        if ($minutes < 60) {
            return "$minutes minutes ago";
        } else {
            return "$hours hours ago";
        }
    } else {
        // Jika lebih dari 24 jam, tampilkan tanggalnya
        return date('Y-m-d', $time_ago);  // Menggunakan format tanggal tahun-bulan-tanggal
    }
}
?>
