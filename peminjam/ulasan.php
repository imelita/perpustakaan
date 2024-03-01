<?php
session_start();
// Periksa apakah 'username' sudah diatur
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
// Gunakan variabel $username pada formulir
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    `
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <title>Ulasan Buku</title>
</head>

<body>

    <div class="wrapper">
        <?php
        include '../koneksi.php';
        if (isset($_GET['id_buku'])) {
            $id_buku = $_GET['id_buku'];
        } else {
            die("Error, Data Tidak Ditemukan");
        }
        $query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id_buku'");
        $data = mysqli_fetch_array($query);
        ?>
        <h3>Ulasan buku - <?= $data['judul'] ?></h3>
        <form action="proses/proses-ulasan.php" method="post">
            <div class="rating">
                <!-- Input rating dengan name yang sesuai -->
                <input type="number" name="rating" hidden>
                <i class='bx bx-star star' style="--i: 0;"></i>
                <i class='bx bx-star star' style="--i: 1;"></i>
                <i class='bx bx-star star' style="--i: 2;"></i>
                <i class='bx bx-star star' style="--i: 3;"></i>
                <i class='bx bx-star star' style="--i: 4;"></i>
            </div>
            <div class="mb-3">
                <!-- Input id_user yang sesuai -->
                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>" class="form-control">
            </div>
            <div class="mb-3">
                <!-- Input id_buku yang sesuai -->
                <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>" class="form-control">
            </div>
            <textarea name="ulasan" cols="30" rows="5" placeholder="ulasan buku yang kamu berikan..."></textarea>

            <div class="btn-group">
                <button type="submit" class="btn submit">Submit</button>
                <a href="koleksi.php" class="btn cancel">Cancel</a>
            </div>
        </form>
    </div>


    <script src="assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>