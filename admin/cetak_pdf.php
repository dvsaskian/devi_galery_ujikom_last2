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

// Ambil data untuk laporan
$query = mysqli_query($koneksi, "
    SELECT u.username, a.nama_album,
        COUNT(DISTINCT f.foto_id) AS foto_count, 
        SUM(IFNULL(lf.like_count, 0)) AS total_like,
        SUM(IFNULL(kf.comment_count, 0)) AS total_comment
    FROM album a
    JOIN foto f ON a.album_id = f.album_id
    LEFT JOIN users u ON f.user_id = u.user_id
    LEFT JOIN (
        SELECT foto_id, COUNT(*) AS like_count
        FROM like_foto
        GROUP BY foto_id
    ) lf ON f.foto_id = lf.foto_id
    LEFT JOIN (
        SELECT foto_id, COUNT(*) AS comment_count
        FROM komentar_foto
        GROUP BY foto_id
    ) kf ON f.foto_id = kf.foto_id
    GROUP BY a.album_id, u.username
    ORDER BY total_like DESC, total_comment DESC
");

if (!$query) {
    die('Query Error: ' . mysqli_error($koneksi));
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, "LAPORAN DATA - D'Galeri", 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(200, 5, "==============================================", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Tanggal: ' . date('d-m-Y'), 0, 0, 'L'); 
$pdf->Cell(100, 10, 'Administrator: ' . $nama_lengkap, 0, 1, 'L');
$pdf->Ln(8);

$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(255, 204, 153);
$pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Username', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Nama Album', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Jumlah Foto', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Jumlah Like', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Jumlah Komentar', 1, 1, 'C', true);

$no = 1;
while ($data = mysqli_fetch_array($query)) {
    $pdf->SetFont('Arial', '', 8);
    
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(50, 8, $data['username'], 1, 0, 'C');
    $pdf->Cell(45, 8, $data['nama_album'], 1, 0, 'C');
    $pdf->Cell(25, 8, $data['foto_count'], 1, 0, 'C');
    $pdf->Cell(30, 8, $data['total_like'], 1, 0, 'C');
    $pdf->Cell(30, 8, $data['total_comment'], 1, 1, 'C');
}

$pdf->Output('D', 'Laporan_Data_Galeri_' . date('d-m-Y') . '.pdf');
exit;
?>
