<?php 
// menangkap data id yang dikirim dari url
$id_kategori = $_GET['id_kategori'];

// menghapus data dari databasee
include '../../koneksi.php';

$query = "DELETE FROM kategoribuku WHERE id_kategori = '$id_kategori'";
$success = mysqli_query ($koneksi, $query);
 
if ($success) {
    echo "
    <script>
    alert('data berhasil dihapus');
    document.location.href = '../kategori-buku.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('data gagal dihapus');
    document.location.href = '../kategori-buku.php';
    </script>
    ";
}

?>