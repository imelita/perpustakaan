<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

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

        <div class="container" style="margin-top: 3rem;">

            <div class="row">
                <style>
                .bi-star-fill {
                    color: orange;
                }

                .row {
                    color: black;
                    gap: 15px;
                    margin-bottom: 10px;
                }
                </style>

                <h2>Pilihan Buku</h2>

                <!-- Form pencarian -->
                <form action="" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari judul buku...">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>

                <?php
                include '../koneksi.php';
                // Proses filter pencarian
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    // Pastikan untuk melarutkan nilai input untuk menghindari serangan SQL Injection
                    $search = mysqli_real_escape_string($koneksi, $search);

                    // Query untuk mencari buku berdasarkan judul
                    $query = "SELECT * FROM buku WHERE judul LIKE '%$search%' ORDER BY id_buku ASC";
                } else {
                    // Query untuk menampilkan semua buku jika tidak ada pencarian
                    $query = "SELECT * FROM buku ORDER BY id_buku ASC";
                }

                $data = mysqli_query($koneksi, $query);

                while ($d = mysqli_fetch_array($data)) {
                    $id_buku = $d['id_buku']; // Ambil id_buku untuk digunakan dalam query rating

                    // Query untuk mengambil rating hanya untuk buku tertentu
                    $queryRating = "SELECT rating FROM ulasanbuku WHERE id_buku = $id_buku";
                    $resultRating = mysqli_query($koneksi, $queryRating);

                    $totalRating = 0;
                    $jumlahRating = 0;

                    // Loop untuk menghitung jumlah total rating dan jumlah rating
                    while ($rowRating = mysqli_fetch_assoc($resultRating)) {
                        $totalRating += $rowRating['rating'];
                        $jumlahRating++;
                    }

                    // Hitung rata-rata rating
                    if ($jumlahRating > 0) {
                        $rataRata = $totalRating / $jumlahRating;
                    } else {
                        $rataRata = 0; // Menghindari pembagian oleh nol
                    }
                ?>
                <div class="card" style="width: 15rem;">
                    <img src="../img/<?= $d['image'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h4 class="card-title"><a
                                href="detail.php?id_buku=<?= $d['id_buku']; ?>"><?= $d['judul']; ?></a>
                        </h4>
                        <p class="fw-semibold">Rating:
                            <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rataRata) {
                                        echo '<span class="bi bi-star-fill"></span>';
                                    } else {
                                        echo '<span class="bi bi-star"></span>';
                                    }
                                }
                                ?>
                        </p>
                        <p class="fw-semibold">Tahun terbit : <?= $d['tahun_terbit']; ?></p>
                        <div>
                            <a href="ulasan_buku_detail.php?id_buku=<?= $d['id_buku']; ?>"
                                class="btn btn-warning text-dark">Ulasan</a>
                            <!-- pinjam buku -->
                            <?php
                                $check_pinjam = "SELECT * FROM peminjaman WHERE id_buku = '{$d['id_buku']}' AND status_peminjaman = 'dipinjam'";
                                $result_pinjam = mysqli_query($koneksi, $check_pinjam);
                                if (mysqli_num_rows($result_pinjam) == 0) {
                                ?>
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalEditBuku<?= $d['id_buku']; ?>"
                                class="btn btn-info text-dark">Pinjam</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

            <?php
            $data = "SELECT * FROM buku, kategoribuku WHERE buku.id_kategori=kategoribuku.id_kategori ORDER BY id_buku ASC";
            $result = mysqli_query($koneksi, $data);
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="modal fade" id="modalEditBuku<?= $row['id_buku']; ?>" tabindex="-1"
                aria-labelledby="modalEditBukuLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalEditBukuLabel">Yakin ingin meminjam?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="proses/tambah_pinjam.php" method="post">
                            <div class="modal-body">
                                <div class="form-group mt-2">
                                    <input type="text" name="id_buku" id="id_buku" class="form-control"
                                        value="<?= $row['id_buku']; ?>" hidden>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" name="id_user" id="id_user" class="form-control"
                                        placeholder="Masukkan Nama id_user Buku" value="<?= $_SESSION['username']; ?>"
                                        hidden>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                        class="form-control" hidden>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                        class="form-control" hidden>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" name="status_peminjaman" class="form-control" value="dipinjam"
                                        hidden>
                                </div>
                                <button type="submit" class="btn btn-primary">Pinjam</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>

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