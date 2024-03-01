<?php

session_start();

// Periksa apakah key 'id_user' diatur dalam array $_SESSION 
$id_user =  $_SESSION['id_user'];
$id_buku = $_POST['id_buku'];
$tanggal_peminjaman = date('Y-m-d');
$tanggal_pengembalian = date('Y-m-d', strtotime('+7 days'));

include '../../koneksi.php';
$query = "INSERT INTO peminjaman VALUES ('','$id_user', '$id_buku', '$tanggal_peminjaman', '$tanggal_pengembalian', 'dipinjam')";

$koleksi = mysqli_query($koneksi, "INSERT INTO koleksipribadi VALUES ('', '$id_user', '$id_buku')");
$success = mysqli_query($koneksi, $query);

if ($success) {
    echo "
    <script>
    alert('Buku berhasil dipinjam');
    document.location.href = '../koleksi.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('buku gagal dipinjam');
    document.location.href = '../koleksi.php';
    </script>
    ";
}