<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
    header("location:../index.php?pesan=info_login");
}

include '../koneksi.php';
$id = $_GET['id_buku'];
$query = "SELECT ulasanbuku.*, user.username FROM ulasanbuku 
            JOIN user ON ulasanbuku.id_user = user.id_user 
           WHERE ulasanbuku.id_buku = '$id'";
$ulasan = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <style>
        .bi-star-fill {
            color: orange;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Ulasan Buku</h2>
            </div>
            <div class="card-body">
                <div class="fst-italic fs-6 mb-4">
                    Info : Apabila ingin memberikan ulasan silahkan pinjam buku terlebih dahulu.
                </div>
                <?php if (mysqli_num_rows($ulasan) > 0) { ?>
                    <?php foreach ($ulasan as $u) : ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div>
                                    <h5><?= $u['username']; ?></h5>
                                </div>
                                <div class="small">
                                    <?php
                                    $rating = $u['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div>
                                    <td>Ulasan</td>
                                    <td>:</td>
                                    <td><?= $u['ulasan']; ?></td>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <div class="card">
                        <div class="card-body">
                            buku belum diulas
                        </div>
                    </div>
                <?php } ?>
                <div class="mt-4">
                    <a href="buku.php" class="btn btn-sm btn-primary"><i class="bi bi-arrow-left"></i> kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>