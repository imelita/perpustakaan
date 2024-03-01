<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
    .card {
        width: 60rem;
    }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center container my-5">
        <div class="card">
            <div class="card-header">
                <h2>Tambah Petugas</h2>
            </div>
            <div class="card-body">
                <?php
                // Periksa apakah ada pesan kesalahan yang diterima dari URL
                if (isset($_GET['pesan_daftar'])) {
                    $pesan_daftar = $_GET['pesan_daftar'];
                    if ($pesan_daftar == "gagal_daftar") {
                        $pesan = "Gagal mendaftar. Username atau email sudah digunakan.";
                    } elseif ($pesan_daftar == "gagal_email") {
                        $pesan = "Gagal mendaftar. Email tidak valid.";
                    }
                    // Tampilkan pesan kesalahan
                    // echo '<div class="alert alert-danger" role="alert">' . $pesan . '</div>';
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    '. $pesan .'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
            ?>

                <form method="post" action="proses/tambah-petugas.php">
                    <div class="form-group mt-3">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control mt-2" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control mt-2" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control mt-2" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control mt-2" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="alamat">Alamat</label>
                        <div class="form-floating mt-2">
                            <textarea class="form-control" placeholder="Alamat Anda" id="alamat" name="alamat"
                                style="height: 100px" required></textarea>
                            <label for="alamat">Alamat Anda</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end form-group mt-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>


    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>