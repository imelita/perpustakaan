<?php

$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['nama_kategori'];

include '../../koneksi.php';
$query = "UPDATE kategoribuku SET id_kategori='$id_kategori', nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'";
$success = mysqli_query($koneksi, $query);

if ($success) {
    echo "
    <script>
    alert('Data berhasil diubah');
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