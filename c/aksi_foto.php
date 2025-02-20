<?php
session_start();
include 'koneksi.php';

    if (isset($_POST['tambah'])) {
        $judul_foto     = $_POST['judul_foto'];
        $deskripsi      = $_POST['deskripsi_foto'];
        $tanggal        = date('Y-m-d');
        $foto           = $_FILES['lokasi_file']['name'];
        $tmp            = $_FILES['lokasi_file']['tmp_name'];
        $lokasi         = '../assets/img/';
        $nama_foto      = rand().'-'.$foto;

        move_uploaded_file($tmp, $lokasi.$nama_foto);

        $album_id       = $_POST['album_id'];
        $user_id        = $_SESSION['user_id'];
    
        $sql = mysqli_query($koneksi, "INSERT INTO foto (judul_foto, deskripsi_foto, tanggal_unggah, lokasi_file, album_id, user_id) 
        VALUES ('$judul_foto', '$deskripsi', '$tanggal', '$nama_foto', '$album_id', '$user_id')");
    

        if ($sql) {
            echo "
            <script>
                alert('Tambah Foto Berhasil');
                location.href='../akun/foto.php';
            </script>";
        }  else {
            echo "Gagal Menambah Data";
        }
    }

    if (isset($_POST['edit'])) {
            $foto_id        = $_POST['foto_id'];
            $judul_foto     = $_POST['judul_foto'];
            $deskripsi      = $_POST['deskripsi_foto'];
            $tanggal        = date('Y-m-d');
            $foto           = $_FILES['lokasi_file']['name'];
            $tmp            = $_FILES['lokasi_file']['tmp_name'];
            $lokasi         = '../assets/img/';
            $nama_foto      = rand().'-'.$foto;
            $album_id       = $_POST['album_id'];
            $user_id        = $_SESSION['user_id'];
        
            if ($foto ==  null) {
                $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi', tanggal_unggah='$tanggal', album_id='$album_id' WHERE foto_id='$foto_id'");
        
            } else {
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$foto_id'");
                $data = mysqli_fetch_array($query);
                if (is_file('../assets/img/'.$data['lokasi_file'])) {
                    unlink('../assets/img/'.$data['lokasi_file']);
                }
        
                move_uploaded_file($tmp, $lokasi.$nama_foto);
                $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judul_foto', deskripsi_foto='$deskripsi', tanggal_unggah='$tanggal', lokasi_file='$nama_foto', album_id='$album_id' WHERE foto_id='$foto_id'");
            }
        
            echo "
            <script>
                alert('Data Berhasil Di Ubah');
                location.href='../akun/foto.php';
            </script>";
    }

    if (isset($_POST['hapus'])) {
            $foto_id = $_POST['foto_id'];
            $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$foto_id'");
            $data = mysqli_fetch_array($query);
                if (is_file('../assets/img/'.$data['lokasi_file'])) {
                    unlink('../assets/img/'.$data['lokasi_file']);
                }

            $query = mysqli_query($koneksi, "DELETE FROM foto WHERE foto_id='$foto_id'");

            echo "
            <script>
                alert('Data Berhasil Di Hapus!');
                location.href='../akun/foto.php';
            </script>";

        
    }
        
        

?>