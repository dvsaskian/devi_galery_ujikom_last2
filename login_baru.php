<!DOCTYPE html>
<html lang="en">

<head>
    
<title>Login | D'Galeri</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="style_sidebar.css">
    <link rel="stylesheet" href="./bootstrap-5.3.0-dist/css/bootstrap.min.css">

    <title>Login</title>
</head>

<body class="bg-ligth d-flex align-items-center justify-content-center m-5">

    <?php
    session_start();

    include 'c/koneksi.php';

    if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
        echo "<script>window.location.href='index.php'</script>";
    }
    ?>

    <div class="login">
        <h4 class="text-center">
            LOGIN </h4>

        <div class="ket">
            <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "gagal") {
                    echo '<div class="alert alert-danger" role="alert">
              Login gagal, Username atau Password salah!
              </div>';
                } elseif ($_GET['pesan'] == "logout") {
                    echo '<div class="alert alert-info" role="alert">
              Anda telah berhasil logout
              </div>';
                } else {
                    echo '<div class="alert alert-info" role="alert">
              Anda harus login untuk mengakses halaman tersebut
              </div>';
                }

            }
            ?>
        </div>
    
        

        <form action="c/ceklogin.php" method="post">
            <div class="form-group was-validated">
                <label class="form-label" for="username">Username</label>
                <input class="form-control" type="text" name="username" required>
            </div>
            <div class="form-group was-validated" style="margin-bottom: 10px">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <input type='submit' class="btn btn-dark w-100" name="login" value="Login">
            </a>
        </form>
        <hr>
        <p>Belum punya akun? <a href="register.php">Register dahulu!</a></p>


    </div>
</body>

</html>