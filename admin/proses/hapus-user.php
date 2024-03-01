<?php 
// menangkap data id yang dikirim dari url
$id_user = $_GET['id_user'];

// menghapus data dari databasee
include '../../koneksi.php';

$query = "DELETE FROM user WHERE id_user = '$id_user'";
$success = mysqli_query ($koneksi, $query);
 
if ($success) {
    echo "
    <script>
    alert('data berhasil dihapus');
    document.location.href = '../user.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('data gagal dihapus');
    document.location.href = '../user.php';
    </script>
    ";
}

?>