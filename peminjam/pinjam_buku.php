<?php
session_start();
// Periksa apakah 'username' sudah diatur
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
// Gunakan variabel $username pada formulir

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pinjam Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card" style="margin-top: 3rem;">
            <div class="row m-4">
                <?php
                if (isset($_GET['id_buku'])) {
                    $id_buku = $_GET['id_buku'];
                } else {
                    die("Data Tidak Tersedia");
                }
                include '../koneksi.php';
                $query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id_buku'");
                $result = mysqli_fetch_array($query);
                ?>
                <div class="col-sm-7">

                    <h3>From Peminjaman Buku</h3>
                    <form action="proses/tambah_pinjam.php" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"> Nama User </label>
                            <input type="text" name="id_user" class="form-control"
                                value="<?php echo $_SESSION['username']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"> Judul Buku </label>
                            <input type="text" name="judul" class="form-control" value="<?php echo $result['judul']; ?>"
                                readonly>
                            <input type="hidden" name="id_buku" class="form-control"
                                value="<?php echo $result['id_buku']; ?>">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                    <input type="date" name="tanggal_peminjaman" class="form-control" required
                                        id="tanggal_peminjaman" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" class="form-control" required
                                        readonly id="tanggal_pengembalian" aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status_peminjaman" class="form-label"> Status Peminjaman </label>
                            <select class="form-select" name="status_peminjaman" aria-label="Default select example">
                                <option value="" selected disabled>Pilih status peminjaman</option>
                                <option value="dipinjam">Pinjam</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">Pinjam</button>
                            <a href="buku.php" class="btn btn-danger m-2">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="content mt-3 fixed-bottom bg-white">
        <p class="text-center"> Aplikasi Perpustakaan Digital | 2024 </p>
    </div>

    <script>
    // Ambil elemen input tanggal peminjaman dan tanggal pengembalian
    var tanggalPeminjaman = document.getElementById('tanggal_peminjaman');
    var tanggalPengembalian = document.getElementById('tanggal_pengembalian');

    // Event listener untuk mengubah tanggal pengembalian saat tanggal peminjaman diubah
    tanggalPeminjaman.addEventListener('change', function() {
        var tanggalPeminjamanValue = new Date(tanggalPeminjaman.value);
        var tanggalPengembalianValue = new Date(tanggalPeminjamanValue);
        tanggalPengembalianValue.setDate(tanggalPeminjamanValue.getDate() + 3);

        // Format tanggal pengembalian menjadi YYYY-MM-DD
        var dd = String(tanggalPengembalianValue.getDate()).padStart(2, '0');
        var mm = String(tanggalPengembalianValue.getMonth() + 1).padStart(2,
            '0'); // January is 0!
        var yyyy = tanggalPengembalianValue.getFullYear();

        var formattedTanggalPengembalian = yyyy + '-' + mm + '-' + dd;
        tanggalPengembalian.value = formattedTanggalPengembalian;
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>