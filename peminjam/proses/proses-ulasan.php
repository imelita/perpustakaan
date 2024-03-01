<?php

session_start();

$id_user = $_SESSION['id_user'];
$id_buku = $_POST['id_buku'];
$rating = $_POST['rating'];
$ulasan = $_POST['ulasan'];

include '../../koneksi.php';
$query = "INSERT INTO ulasanbuku VALUES ('', '$id_user', '$id_buku', '$ulasan', '$rating')";
$data = mysqli_query($koneksi, $query);

if ($data) {
    echo "
    <script>
    alert('buku berhasil diberikan ulasan');
    document.location.href = '../koleksi.php';
    </script>
    ";
} else {
    echo " 
    <script>
    alert('buku gagal diberikan ulasan');
    document.location.href = '../koleksi.php';
    </script>
    ";
}
