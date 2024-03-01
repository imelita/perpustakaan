<?php 
// menangkap data id yang dikirim dari url
$id_peminjaman = $_GET['id_peminjaman'];

// menghapus data dari databasee
include '../../koneksi.php';

$query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'";
$success = mysqli_query ($koneksi, $query);
 
if ($success) {
    echo "
    <script>
    alert('data berhasil dihapus');
    document.location.href = '../koleksi.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('data gagal dihapus');
    document.location.href = '../koleksi.php';
    </script>
    ";
}

?>