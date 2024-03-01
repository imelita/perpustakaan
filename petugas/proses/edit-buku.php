<?php

$id_buku = $_POST['id_buku'];
$id_kategori = $_POST['id_kategori'];
$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$deskripsi = $_POST['deskripsi'];

if ($_FILES['image']['name']) {
    $image = $_FILES['image']['name'];
    $ukuran_file = $_FILES['image']['size'];
    $tmp_file = $_FILES['image']['tmp_name'];
    $dir_upload = "../../img/";

    $upload = move_uploaded_file($tmp_file, $dir_upload . $image);

    if (!$upload) {
        echo "
        <script>
        alert('Gagal upload gambar.');
        document.location.href = '../buku.php';
        </script>
        ";
        exit();
    }
} else {
    $image = $_POST['gambar_lama'];
}

// Query untuk update data ke database
include '../../koneksi.php';
$query = "UPDATE buku SET id_kategori='$id_kategori',  judul='$judul', image='$image', penulis='$penulis', penerbit='$penerbit', tahun_terbit='$tahun_terbit', deskripsi='$deskripsi' WHERE id_buku='$id_buku'";
$success = mysqli_query($koneksi, $query);


if ($success) {
    echo "
    <script>
    alert('Data berhasil diubah');
    document.location.href = '../buku.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('data gagal ditambahkan');
    document.location.href = '../buku.php';
    </script>
    ";
}