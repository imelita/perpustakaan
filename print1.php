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
    <div class="container mt-4">
        <h2 class="mb-4" align="center">Laporan Peminjaman User</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kelas</th>
                    <th>Nama Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data Peminjaman Buku -->
                <?php
                $id_peminjaman = $_GET['id_peminjaman'];
                $tanggal_peminjaman = $_GET['tanggal_peminjaman'];
                $tanggal_pengembalian = $_GET['tanggal_pengembalian'];

                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM peminjaman, buku, user WHERE peminjaman.id_user=user.id_user AND peminjaman.id_buku=buku.id_buku AND tanggal_peminjaman >= '$tanggal_peminjaman' AND (tanggal_pengembalian <= '$tanggal_pengembalian') AND id_peminjaman = '$id_peminjaman'");
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
                        <span>Dipinjam</span>
                        <?php } elseif ($status_peminjaman == 'dikembalikan') { ?>
                        <span>Dikembalikan</span>
                        <?php } elseif ($status_peminjaman == 'telat') { ?>
                        <span>Telat</span>
                        <?php } ?>
                    </td> -->
                </tr>
                <?php } ?>
                <!-- Tambahkan baris data sesuai dengan kebutuhan -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    window.print();
    </script>
</body>

</html>