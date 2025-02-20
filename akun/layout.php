
<style>
    /* .navbar {
            background-image: linear-gradient(to right, #9b59b6, #ffffff, #ff69b4); 
    }

    footer {
        background-image: linear-gradient(to right, #9b59b6, #ffffff, #ff69b4); 
    } */

    .nav-link {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .nav-link:hover {
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7); 
    }
    .content {
            flex-grow: 1;
        }

        footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
</style>


    <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <h3><strong>D'Galery</strong></h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
                    <div class="navbar-nav me-auto">
                        <a href="index.php" class="btn btn-secondary m-2">Beranda</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="album.php" class="nav-link m-2">Album</a>
                        <a href="foto.php" class="nav-link m-2">Foto</a>
                        <a href="galeri.php" class="btn btn-secondary m-2">Galeriku</a>
                        <a href="notifikasi.php" class="nav-link m-2 position-relative">
                            Notifikasi <i class="bi bi-bell"></i>
                            <?php if ($unread_count > 0) { ?>
                                <span class="top-0 start-100 translate-middle badge rounded-circle bg-danger  w-auto h-auto">
                                    <?php echo $unread_count; ?>
                                </span>
                            <?php } ?>
                        </a>
                        <a href="laporan.php" class="btn btn-info m-2">Laporan</a>
                        <a href="data_laporan.php" class="btn btn-info m-2">Laporan Galeri</a>
                        <a href="profile.php" class="btn btn-warning m-2">Profile</a>
                        <a href="../c/aksi_logout.php" class="btn btn-outline-danger m-2">Keluar</a>

                    </div>
                </div>
            </div>
        </nav>


    <footer class="bg-light d-flex justify-content-center border-top mt-3 br-light fixed-bottom">
        <p><strong>&copy; D'Galery | Devi Saskia N</strong></p>
    </footer>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js">
</script>
   