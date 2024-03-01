<?php 
// Menangkap data id yang dikirim dari URL
$id_buku = $_GET['id_buku'];

// Menghapus data dari database
include '../../koneksi.php';

// Periksa apakah buku belum dipinjam
$cek_buku = "SELECT * FROM peminjaman WHERE id_buku = $id_buku AND status_peminjaman = 'dipinjam'";
$result = mysqli_query($koneksi, $cek_buku);

// Jika buku belum dipinjam, hapus dari database
if (mysqli_num_rows($result) == 0) {
    $query = "DELETE FROM buku WHERE id_buku = '$id_buku'";
    $success = mysqli_query($koneksi, $query);
    
    if ($success) {
        echo "
        <script>
        alert('Data buku berhasil dihapus');
        window.location.href = '../buku.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Gagal menghapus data buku');
        window.location.href = '../buku.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
    alert('Buku sedang dipinjam, tidak dapat dihapus');
    window.location.href = '../buku.php';
    </script>
    ";
}
?>