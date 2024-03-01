<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if (!isset($_SESSION['level']) || $_SESSION['level'] == "") {
    header("location:../index.php?pesan=info_login");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
                    <a href="user.php" class="btn m-2 text-light">Users</a>
                    <!-- <a href="koleksi-ulasan.php" class="btn text-light">Ulasan Buku</a> -->
                    <a href="generate.php" class="btn m-2 text-light">Laporan Peminjaman</a>
                    <a href="../logout.php" class="btn m-2 text-light">Logout</a>
                </div>
            </div>
        </div>


        <div class="container-fluid"><br>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary mt-3">Laporan Peminjaman</h6>
                </div>
                <div class="card-body">

                    <!-- Form Filter -->
                    <div class="page-content fade-in-up">
                        <div class="ibox">
                            <div class="ibox-head">
                            </div>
                            <div class="ibox-body">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="tanggal_peminjaman">Pilih Tanggal Peminjaman:</label>
                                            <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tanggal_pengembalian">Pilih Tanggal Kembali:</label>
                                            <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian"
                                                class="form-control">
                                        </div>
                                        <div class="py-4">
                                            <button type="submit" class="btn btn-success">Filter</button>
                                        </div>
                                </form>
                                <hr>
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    // ambil tanggal dari form
                                    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
                                    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
                                ?>
                                <div class="container">
                                    <a class="btn btn-success" href="print.php?tanggal_peminjaman=<?php echo $tanggal_peminjaman ?>
                                            &tanggal_pengembalian=<?php echo $tanggal_pengembalian; ?>"
                                        target="_blank">Print Semua</a>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Filter -->

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pijam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status Peminjaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../koneksi.php';
                                $no = 1;
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
                                    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
                                    $query = mysqli_query($koneksi, "SELECT * FROM peminjaman, buku, user WHERE peminjaman.id_user=user.id_user
                                         AND peminjaman.id_buku=buku.id_buku AND tanggal_peminjaman >= '$tanggal_peminjaman' AND 
                                         (tanggal_pengembalian <= '$tanggal_pengembalian')");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr class="text-center">
                                    <td><?php echo $no++; ?>.</td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['judul']; ?></td>
                                    <td><?php echo $row['tanggal_peminjaman']; ?></td>
                                    <td><?php echo $row['tanggal_pengembalian']; ?></td>
                                    <td><?php echo $row['status_peminjaman']; ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-success"
                                            href="print1.php?id_peminjaman=<?php echo $row['id_peminjaman'];
                                                                                                                    ?>&tanggal_peminjaman=<?php echo $tanggal_peminjaman; ?>&tanggal_pengembalian=<?php echo $tanggal_pengembalian; ?>&status_peminjaman=<?php echo $status_peminjaman; ?>"
                                            target="_blank">Print</a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <script>
                        // Ambil elemen input tanggal peminjaman dan tanggal pengembalian
                        var tanggalPeminjaman = document.getElementById('tanggal_peminjaman');
                        var tanggalPengembalian = document.getElementById('tanggal_pengembalian');

                        // Event listener untuk mengubah tanggal pengembalian saat tanggal peminjaman diubah
                        tanggalPeminjaman.addEventListener('change', function() {
                            var tanggalPeminjamanValue = new Date(tanggalPeminjaman.value);
                            var tanggalPengembalianValue = new Date(tanggalPeminjamanValue);
                            tanggalPengembalianValue.setDate(tanggalPeminjamanValue.getDate() + 7);

                            // Format tanggal pengembalian menjadi YYYY-MM-DD
                            var dd = String(tanggalPengembalianValue.getDate()).padStart(2, '0');
                            var mm = String(tanggalPengembalianValue.getMonth() + 1).padStart(2,
                                '0'); // January is 0!
                            var yyyy = tanggalPengembalianValue.getFullYear();

                            var formattedTanggalPengembalian = yyyy + '-' + mm + '-' + dd;
                            tanggalPengembalian.value = formattedTanggalPengembalian;
                        });
                        </script>
                    </div>
                    <?php if ($_SERVER['REQUEST_METHOD'] != 'POST') { ?>
                    <div class="alert alert-sm alert-primary">
                        <center>
                            <strong>Perhatian!</strong> Silakan Filter Laporan Peminjaman
                        </center>
                    </div>
                    <?php } ?>
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