<?php
session_start();
include 'koneksi.php';

    if (isset($_POST['tambah'])) {
        $nama_album     = $_POST['nama_album'];
        $deskripsi      = $_POST['deskripsi'];
        $tanggal        = date('Y-m-d');
        $user_id        = $_SESSION['user_id'];
    

        $sql = mysqli_query($koneksi, "INSERT INTO album (nama_album, deskripsi, tanggal_dibuat, user_id) 
                VALUES ('$nama_album', '$deskripsi', '$tanggal', '$user_id')");

        if ($sql) {
            echo "
            <script>
                alert('Tambah Album Berhasil');
                location.href='../akun/album.php';
            </script>";
        }  else {
            echo "Gagal Menambah Data";
        }
    }

    
        if (isset($_POST['edit'])) {
            $album_id       = $_POST['album_id'];
            $nama_album     = $_POST['nama_album'];
            $deskripsi      = $_POST['deskripsi'];
            $tanggal        = date('Y-m-d');
            $user_id        = $_SESSION['user_id'];
        
            if (!empty($nama_album) && !empty($deskripsi)) {
                $sql = mysqli_query($koneksi, "UPDATE album SET nama_album='$nama_album', deskripsi='$deskripsi', tanggal_dibuat='$tanggal' WHERE album_id='$album_id'");
        
                if ($sql) {
                    echo "
                    <script>
                        alert('Data Berhasil Di Ubah');
                        location.href='../akun/album.php';
                    </script>";
                } else {
                    echo "Gagal Mengubah Data";
                }
            } else {
                echo "Nama Album atau Deskripsi tidak boleh kosong.";
            }
        }


    if (isset($_POST['hapus'])) {
        $album_id = $_POST['album_id'];
    
        $sql = mysqli_query($koneksi, "DELETE FROM album WHERE album_id='$album_id'");
    
        if ($sql) {
            echo "
            <script>
                alert('Album Berhasil Dihapus');
                location.href='../akun/album.php';
            </script>";
        } else {
            echo "Gagal Menghapus Data";
        }
    }
    
        

?>