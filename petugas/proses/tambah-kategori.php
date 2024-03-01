<?php

$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['nama_kategori'];

include '../../koneksi.php';
$query = "INSERT INTO kategoribuku VALUES('', '$nama_kategori')";
$success = mysqli_query($koneksi, $query);

if ($success) {
    echo "
    <script>
    alert('Berhasil Ditambahkan');
    document.location.href = '../kategori-buku.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('data gagal ditambahkan');
    document.location.href = '../kategori-buku.php';
    </script>
    ";
}

?>