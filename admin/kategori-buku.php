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
    <title>Admin</title>
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
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary mt-3">Data Kategori Buku</h6>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-sm btn-success" href="" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-plus-lg"></i> Tambah Kategori Buku</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                include('../koneksi.php');
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
                while ($row = mysqli_fetch_array($query)) {
                ?>

                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['nama_kategori']; ?></td>
                                    <td>
                                        <a href="" data-bs-toggle="modal"
                                            data-bs-target="#modalEditKategori<?php echo $row['id_kategori']; ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <a href="proses/hapus-kategori.php?id_kategori=<?php echo $row['id_kategori']; ?>"
                                            onclick="return confirm('yakin untuk dihapus?');"
                                            class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>

                                <?php  } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

        <!-- modal tambah buku -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori Buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="proses/tambah-kategori.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kategori" class="mb-2">Nama Kategori</label>
                                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                                    placeholder="Masukkan Kategori Buku">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- modal edit buku -->
        <?php

    $data = "SELECT * FROM kategoribuku WHERE id_kategori ";
    $result = mysqli_query($koneksi, $data);
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <div class="modal fade" id="modalEditKategori<?= $row['id_kategori']; ?>" tabindex="-1"
            aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalEditkategoriLabel">Edit Data Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="proses/edit-kategori.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id_kategori" id="id_kategori" class="form-control"
                                    value="<?= $row['id_kategori']; ?>">
                                <label for="nama_kategori" class="mb-2">Nama Kategori</label>
                                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                                    placeholder="Masukkan Kategori Buku" value="<?= $row['nama_kategori']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Edit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <!-- footer -->
        <div class="content mt-3 fixed-bottom ">
            <p class="text-center text-white" style="background-color: #007bff;"> Aplikasi Perpustakaan Digital
                | 2024 </p>
        </div>

        <?php
    }
    ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

</body>

</html>