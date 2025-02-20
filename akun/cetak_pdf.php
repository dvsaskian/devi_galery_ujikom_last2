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

// $sql = mysqli_query($koneksi, "
//     SELECT f.foto_id, f.judul_foto, f.tanggal_unggah, f.lokasi_file, u.username, u.nama_lengkap, 
//            COUNT(DISTINCT n.send_id) AS like_count, 
//            COUNT(kf.foto_id) AS comment_count
//     FROM foto f
//     LEFT JOIN users u ON f.user_id = u.user_id
//     LEFT JOIN notifikasi n ON f.foto_id = n.foto_id
//     LEFT JOIN komentar_foto kf ON f.foto_id = kf.foto_id
//     WHERE f.user_id = '$user_id'
//     GROUP BY f.foto_id
//     ORDER BY like_count DESC, comment_count DESC
// ");


$sql = mysqli_query($koneksi, "
    SELECT f.foto_id, f.judul_foto, f.tanggal_unggah, f.lokasi_file, a.nama_album, 
        (SELECT COUNT(*) FROM like_foto WHERE foto_id = f.foto_id) AS like_count, 
        (SELECT COUNT(*) FROM komentar_foto WHERE foto_id = f.foto_id) AS comment_count
    FROM foto f
    JOIN album a ON f.album_id = a.album_id
    WHERE f.user_id = '$user_id'
    ORDER BY like_count DESC, comment_count DESC
");



if (!$sql) {
    die('Query Error: ' . mysqli_error($koneksi));
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, "LAPORAN DATA FOTO", 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(200, 5, "==============================================", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Tanggal: ' . date('d-m-Y'), 0, 0, 'L'); 
$pdf->Cell(100, 10, 'Pengguna: ' . $nama_lengkap, 0, 1, 'L');
$pdf->Ln(8);

$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(5); 


$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Judul', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Nama Album', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Like', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Komentar', 1, 1, 'C', true);

$no = 1;
while ($data = mysqli_fetch_array($sql)) {
    $pdf->SetFont('Arial', '', 8);
    
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(50, 8, $data['judul_foto'], 1, 0, 'C');
    $pdf->Cell(45, 8, $data['nama_album'], 1, 0, 'C'); 
    $pdf->Cell(25, 8, $data['tanggal_unggah'], 1, 0, 'C');
    $pdf->Cell(30, 8, $data['like_count'], 1, 0, 'C');
    $pdf->Cell(30, 8, $data['comment_count'], 1, 1, 'C');
}



$pdf->Output('D', 'Laporan_Galeri_'.$nama_lengkap.'_' . date('d-m-Y') . '.pdf'); 
exit;
?>
