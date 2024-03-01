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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

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

        <div class="container-fluid">
            <br>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary mt-3">Koleksi Peminjaman</h6>
                    <!-- <div class="d-flex justify-content-end">
                            <a href="print.php" class="btn btn-sm btn-success"><i class="bi bi-printer">Cetak Data</i></a>
                            <a  href="print.php" ></a>
                            </div> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status Peminjaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('../koneksi.php');
                                $no = 1;
                                $id_user = $_SESSION['id_user']; // Ambil id_user dari session

                                $query = mysqli_query($koneksi, "SELECT * FROM peminjaman, buku, user 
                                 WHERE peminjaman.id_user = user.id_user 
                                 AND peminjaman.id_buku = buku.id_buku 
                                 AND peminjaman.id_user = $id_user 
                                 ORDER BY tanggal_peminjaman ASC");

                                while ($row = mysqli_fetch_array($query)) {
                                    if ($row['status_peminjaman'] == 'dipinjam') {
                                        $color = "text-bg-success";
                                    } elseif ($row['status_peminjaman'] == 'dikembalikan') {
                                        $color = "text-bg-warning";
                                    } elseif ($row['status_peminjaman'] == 'telat') {
                                        $color = "text-bg-danger";
                                    }

                                    $tanggal_pengembalian = strtotime($row['tanggal_pengembalian']);
                                    $tanggal_sekarang = strtotime(date('Y-m-d'));
                                    if ($tanggal_pengembalian < $tanggal_sekarang && $row['status_peminjaman'] != 'dikembalikan') {
                                        // Jika tanggal pengembalian telah lewat dan status belum dikembalikan, maka status diubah menjadi "telat"
                                        mysqli_query($koneksi, "UPDATE peminjaman SET status_peminjaman = 'telat' WHERE id_peminjaman = '" . $row['id_peminjaman'] . "'");
                                        $row['status_peminjaman'] = 'telat'; // Update status peminjaman untuk ditampilkan
                                        $color = "text-bg-danger btn-sm"; // Update warna
                                    }
                                ?>

                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['judul']; ?></td>
                                    <td><?php echo $row['tanggal_peminjaman']; ?></td>
                                    <?php if ($row['status_peminjaman'] == 'telat') { ?>
                                    <td class="text text-danger"><?php echo $row['tanggal_pengembalian']; ?></td>
                                    <?php } else { ?>
                                    <td><?php echo $row['tanggal_pengembalian']; ?></td>
                                    <?php } ?>
                                    <td><span
                                            class="badge rounded-pill <?= $color; ?>"><?php echo $row['status_peminjaman']; ?></span>
                                    </td>
                                    <td>
                                        <a href="" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailGenerate<?php echo $row['id_peminjaman']; ?>"
                                            class="btn btn-secondary btn-sm">detail</a>
                                        <?php
                                            if ($row['status_peminjaman'] != 'dikembalikan') {
                                            ?><a href="" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#updateStatus<?= $row['id_peminjaman']; ?>">status</a>
                                        <?php
                                            } elseif ($row['status_peminjaman'] == 'dikembalikan') {
                                            ?>
                                        <a href="proses/hapus-koleksi.php?id_peminjaman=<?php echo $row['id_peminjaman']; ?>"
                                            onclick="return confirm('yakin untuk dihapus?');"
                                            class="btn btn-danger btn-sm">hapus</a>

                                        <?php
                                            }
                                            ?>
                                        <?php
                                            if ($row['status_peminjaman'] != 'dikembalikan') {
                                            ?>
                                        <a href="baca_sekarang.php?id_buku=<?php echo $row['id_buku']; ?>"
                                            class="btn btn-primary my-2 btn-sm">Baca Sekarang</a>
                                        <?php
                                            }
                                            ?>
                                    </td>
                                </tr>

                                <?php  } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

        <!-- modal detail buku -->
        <?php
        $data = "SELECT * FROM peminjaman, user, buku WHERE peminjaman.id_user=user.id_user AND peminjaman.id_buku=buku.id_buku ORDER BY tanggal_peminjaman ASC";
        $result = mysqli_query($koneksi, $data);
        while ($row = mysqli_fetch_array($result)) {
        ?>
        <div class="modal fade" id="modalDetailGenerate<?= $row['id_peminjaman']; ?>" tabindex="-1"
            aria-labelledby="modalDetailGenerateLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDetailGenerateLabel"><i
                                class="bi bi-journal-bookmark-fill"></i> Detail Laporan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="../img/<?= $row['image']; ?>" alt="" width="200">
                                </div>
                                <div class="col-md-8">
                                    <form action="">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <label for="" class="col-form-label">Peminjam :</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <label for=""
                                                    class="col-form-label"><?= $row['nama_lengkap']; ?></label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <label for="" class="col-form-label">Judul Buku :</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <label for="" class="col-form-label"><?= $row['judul']; ?></label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <label for="" class="col-form-label">Tanggal Peminjaman :</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <label for=""
                                                    class="col-form-label"><?= $row['tanggal_peminjaman']; ?></label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <label for="" class="col-form-label">Tanggal Pengembalian :</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <label for=""
                                                    class="col-form-label"><?= $row['tanggal_pengembalian']; ?></label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <label for="" class="col-form-label">Status Peminjaman :</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <label for=""
                                                    class="col-form-label"><?= $row['status_peminjaman']; ?></label>
                                            </div>
                                        </div>
                                        <?php
                                            if ($row['status_peminjaman'] == "telat") {
                                            ?>
                                        <div class="row mb-3">
                                            <label for="telat" class="col-form-label text text-danger">Buku harus di
                                                kembalikan, apabila tidak segera di kembalikan anda akan terkena
                                                denda</label>
                                        </div>
                                        <?php
                                            }
                                            ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="ulasan.php?id_buku=<?php echo $row['id_buku']; ?>" class="btn btn-warning">Ulasan</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- modal edit status -->
        <?php
        $data = "SELECT * FROM peminjaman, user, buku WHERE peminjaman.id_user=user.id_user AND peminjaman.id_buku=buku.id_buku ORDER BY tanggal_peminjaman ASC";
        $result = mysqli_query($koneksi, $data);
        while ($row = mysqli_fetch_array($result)) {
        ?>
        <div class="modal fade" id="updateStatus<?= $row['id_peminjaman']; ?>" tabindex="-1"
            aria-labelledby="updateStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateStatusLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="proses/edit-status.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id_peminjaman"
                                    value="<?= $row['id_peminjaman']; ?>">
                                <label for="exampleInputEmail1" class="form-label">Kembalikan buku</label>
                                <select name="status_peminjaman" id="status_peminjaman" class="form-control" required>
                                    <option value="dikembalikan">dikembalikan</option>
                                </select>
                                <?php
                                    if ($row['status_peminjaman'] == "telat") {
                                    ?>
                                <div id="emailHelp" class="text text-danger fst-italic form-text">tolong segera
                                    dikembalikan</div>

                                <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">kembalikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>


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