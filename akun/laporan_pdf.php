<?php
session_start();
include '../c/koneksi.php';
include('../pdf/fpdf.php');

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "
        <script>
            alert('Anda Belum Login !');
            location.href='../index.php';
        </script>";
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "
        <script>
            alert('User ID tidak ditemukan!');
            location.href='../index.php';
        </script>";
    exit;
}

$user_id = $_SESSION['user_id'];


$notif_count_query = mysqli_query($koneksi, "SELECT COUNT(*) as unread_count FROM notifikasi WHERE user_id ='$user_id' AND status= 'unread'");
$notif_count_result = mysqli_fetch_assoc($notif_count_query);
$unread_count = $notif_count_result['unread_count'];

$query_user = mysqli_query($koneksi, "SELECT nama_lengkap FROM users WHERE user_id = '$user_id'");
$data_user = mysqli_fetch_assoc($query_user);
$nama_lengkap = $data_user['nama_lengkap'];

$sql = mysqli_query($koneksi, "
    SELECT f.foto_id, f.judul_foto, f.tanggal_unggah, f.lokasi_file, u.username, u.nama_lengkap, 
           COUNT(DISTINCT n.send_id) AS like_count, 
           COUNT(kf.foto_id) AS comment_count
    FROM foto f
    LEFT JOIN users u ON f.user_id = u.user_id
    LEFT JOIN notifikasi n ON f.foto_id = n.foto_id
    LEFT JOIN komentar_foto kf ON f.foto_id = kf.foto_id
    WHERE f.user_id = '$user_id'
    GROUP BY f.foto_id
    ORDER BY like_count DESC, comment_count DESC
");

$sql = mysqli_query($koneksi, "
    SELECT f.foto_id, f.judul_foto, f.tanggal_unggah, f.lokasi_file, 
        (SELECT COUNT(*) FROM like_foto WHERE foto_id = f.foto_id) AS like_count, 
        (SELECT COUNT(*) FROM komentar_foto WHERE foto_id = f.foto_id) AS comment_count
    FROM foto f
    WHERE f.user_id = '$user_id'
    ORDER BY like_count DESC, comment_count DESC
");


if (!$sql) {
    die('Query Error: ' . mysqli_error($koneksi));
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(200, 10, "Laporan D'Galeri Foto", 0, 1, 'C');
$pdf->Ln(10);

$pdf->Cell(200, 10, 'Tanggal: ' . date('d-m-Y'), 0, 1, 'L');
$pdf->Cell(200, 10, 'Pengguna: ' . $nama_lengkap, 0, 1, 'L');
$pdf->Ln(10);

$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(60, 10, 'Judul', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tanggal Unggah', 1, 0, 'C');
$pdf->Cell(30, 10, 'Like', 1, 0, 'C');
$pdf->Cell(30, 10, 'Komentar', 1, 1, 'C');

$no = 1;
while ($data = mysqli_fetch_array($sql)) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(60, 10, $data['judul_foto'], 1, 0, 'C');
    $pdf->Cell(30, 10, $data['tanggal_unggah'], 1, 0, 'C');
    $pdf->Cell(30, 10, $data['like_count'], 1, 0, 'C');
    $pdf->Cell(30, 10, $data['comment_count'], 1, 1, 'C');
}

$pdf->Output('D', 'Laporan_Galeri_' . date('d-m-Y') . '.pdf'); 
exit;
?>
