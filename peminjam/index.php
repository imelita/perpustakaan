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
    <title>Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="content mt-3">
            <div class="card bg-primary bg-gradient text-center">
                <div class="card-body">
                    <a href="index.php" class="btn text-light">Dashboard</a>
                    <a href="buku.php" class="btn text-light">Buku</a>
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Kategori
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        include '../koneksi.php';
                        $no = 1;
                        $data = "SELECT * FROM kategoribuku";
                        $result = mysqli_query($koneksi, $data);
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                        <li><a class="dropdown-item"
                                href="kategori.php?nama_kategori=<?php echo $row['nama_kategori']; ?>"><?= $row['nama_kategori']; ?></a>
                        </li>
                        <?php } ?>
                    </ul> <a href="koleksi.php" class="btn text-light">Koleksi</a>
                    <a href="../logout.php" class="btn text-light">Logout</a>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <?php
                        include '../koneksi.php';
                        $dp = mysqli_query($koneksi, "SELECT COUNT(*) total FROM koleksipribadi");
                        $rp = mysqli_fetch_assoc($dp);
                        ?>
                        <div class="card-body bg-primary-subtle text-center">
                            <h3>Koleksi Buku</h3>
                            <h2> <?php echo $rp['total']; ?> </h2>
                            <hr>
                            <a href="koleksi.php" class="btn btn-dark btn-sm">Lihat Data</a>
                        </div>
                    </div>
                </div>

                <div class="content mt-3">
                    <div class="card">
                        <div class="card-body mt-4">
                            <table class="table table-striped">
                                <p>Halo <b><?php echo $_SESSION['username']; ?></b> Anda telah login sebagai
                                    <b><?php echo $_SESSION['level']; ?></b>.
                                </p>
                                <tr>
                                    <td width="200">Nama</td>
                                    <td width="1">:</td>
                                    <td><?php echo $_SESSION['username']; ?></td>
                                </tr>
                                <tr>
                                    <td width="200">Level User</td>
                                    <td width="1">:</td>
                                    <td><?php echo $_SESSION['level']; ?></td>
                                </tr>
                                <tr>
                                    <td width="200">tanggal Login</td>
                                    <td width="1">:</td>
                                    <td><?php echo date('l, d m Y'); ?></td>
                                </tr>
                            </table>
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
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
                crossorigin="anonymous"></script>

</body>

</html>