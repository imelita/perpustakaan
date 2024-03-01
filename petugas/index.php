<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=info_login");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <div class="content mt-3">
            <div class="card bg-primary bg-gradient text-center">
                <div class="card-body">
                    <a href="index.php" class="btn m-2 text-light">Dashboard</a>
                    <a href="kategori-buku.php" class="btn m-2 text-light">Kategori Buku</a>
                    <a href="buku.php" class="btn m-2 text-light">Buku</a>
                    <a href="generate.php" class="btn m-2 text-light">Laporan Peminjaman</a>
                    <a href="../logout.php" class="btn m-2 text-light">Logout</a>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <?php
                        include '../koneksi.php';
                        $dp = mysqli_query($koneksi, "SELECT COUNT(*) total FROM kategoribuku");
                        $a = mysqli_fetch_assoc($dp);
                        ?>
                        <div class="card-body bg-primary-subtle text-center">
                            <h3> Kategori Buku </h3>
                            <h2> <?php echo $a['total']; ?> </h2>
                            <hr>
                            <a href="kategori-buku.php" class="btn btn-dark btn-sm">Lihat Data</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <?php
                        include '../koneksi.php';
                        $dp = mysqli_query($koneksi, "SELECT COUNT(*) total FROM buku");
                        $rp = mysqli_fetch_assoc($dp);
                        ?>
                        <div class="card-body bg-primary-subtle text-center">
                            <h3> Data Buku </h3>
                            <h2> <?php echo $rp['total']; ?> </h2>
                            <hr>
                            <a href="buku.php" class="btn btn-dark btn-sm">Lihat Data</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card">
                        <?php
                        include '../koneksi.php';
                        $dp = mysqli_query($koneksi, "SELECT COUNT(*) total FROM peminjaman");
                        $c = mysqli_fetch_assoc($dp);
                        ?>
                        <div class="card-body bg-primary-subtle text-center">
                            <h3> Peminjaman </h3>
                            <h2> <?php echo $c['total']; ?> </h2>
                            <hr>
                            <a href="generate.php" class="btn btn-dark btn-sm">Lihat Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="card">
                <div class="card-body">
                    <p>Halo <b><?php echo $_SESSION['username']; ?></b> Anda telah login sebagai
                        <b><?php echo $_SESSION['level']; ?></b>.
                    </p>
                </div>
            </div>
        </div>

        <!-- footer -->
        <div class="content mt-3 fixed-bottom ">
            <p class="text-center text-white" style="background-color: #007bff;"> Aplikasi Perpustakaan Digital
                | 2024 </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

</body>

</html>