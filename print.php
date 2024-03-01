<?php
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peminjaman User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-size: 14px;
    }

    table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #dee2e6;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f8f9fa;
    }
    </style>
</head>

<body>

    <center>
        <h3>Laporan Peminjaman Buku</h3>
    </center>
    <table border="2" class="table table-striped table-bordered">
        <tr class="fw-bold">
            <th>No.</th>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
        </tr>
        <?php 
    include '../koneksi.php';
                $tanggal_peminjaman = $_GET['tanggal_peminjaman'];
                $tanggal_pengembalian = $_GET['tanggal_pengembalian'];

                $no=1;
                $data = mysqli_query($koneksi, "SELECT * FROM peminjaman, buku, user WHERE peminjaman.id_user=user.id_user 
                AND peminjaman.id_buku=buku.id_buku AND tanggal_peminjaman >= '$tanggal_peminjaman' 
                AND (tanggal_pengembalian <= '$tanggal_pengembalian')");
                while ($row = mysqli_fetch_assoc($data)) {
                    $status_peminjaman = $row['status_peminjaman'];
                ?>
        <tr>
            <td><?php echo $no++; ?>.</td>
            <td><?php echo $row['nama_lengkap']; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['tanggal_peminjaman']; ?></td>
            <td><?php echo $row['tanggal_pengembalian']; ?></td>
            <td>
                <?php if ($status_peminjaman == 'dipinjam') { ?>
                <span>Proses</span>
                <?php }elseif ($status_peminjaman == 'dikembalikan') { ?>
                <span>Dikembalikan</span>
                <?php }elseif ($status_peminjaman == 'telat') { ?>
                <span>Telat</span>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <!-- Bootstrap JS and Popper.js (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    window.print();
    </script>
</body>

</html>