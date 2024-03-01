<?php
include('../../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah id_peminjaman disertakan dalam permintaan POST
    if (isset($_POST['id_peminjaman']) && isset($_POST['status_peminjaman'])) {
        $id_peminjaman = $_POST['id_peminjaman'];
        $status_peminjaman = $_POST['status_peminjaman'];

        // Lakukan update status peminjaman di database
        $query = "UPDATE peminjaman SET status_peminjaman = '$status_peminjaman'
         WHERE id_peminjaman = $id_peminjaman";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "
            <script>
            alert('buku berhasil dikembalikan');
            document.location.href = '../koleksi.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert('buku gagal dikembalikan');
            document.location.href = '../koleksi.php';
            </script>
            ";
        }
    } else {
        echo "ID peminjaman atau status peminjaman tidak disertakan dalam permintaan POST.";
    }
} else {
    echo "Permintaan harus menggunakan metode POST.";
}