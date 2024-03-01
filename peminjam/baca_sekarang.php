<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=info_login");
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top: 5rem;">
        <div class="card ">
            <div class="row m-4">
                <?php
                include '../koneksi.php';
                if (isset($_GET['id_buku'])) {
                    $id_buku = $_GET['id_buku'];
                } else {
                    die("Error, Data Tidak Ditemukan");
                }
                $query = mysqli_query($koneksi, "SELECT buku.*, kategoribuku.nama_kategori FROM buku
                            LEFT JOIN kategoribuku ON buku.id_kategori=kategoribuku.id_kategori 
                            WHERE buku.id_buku='$id_buku'");
                $result = mysqli_fetch_array($query);
                ?>
                <div class="text-center">
                    <img src="../img/<?php echo $result['image']; ?>" height="250" alt="">
                </div>
                <div class="text-center" style="margin-top: 5rem;">
                    <h2><?php echo $result['judul']; ?></h2>
                    <br>
                    <table>
                        <tr>
                            <td>
                                <h5><?php echo $result['deskripsi']; ?></h5>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <a href="koleksi.php" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>