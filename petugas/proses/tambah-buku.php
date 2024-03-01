<?php

$id_kategori = $_POST['id_kategori'];
$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun_terbit = $_POST['tahun_terbit'];
$deskripsi = $_POST['deskripsi'];

$image = $_FILES['image']['name'];
$ukuran_file = $_FILES['image']['size'];
$tmp_file = $_FILES['image']['tmp_name'];
$dir_upload = "../../img/";

// Setelah proses upload, pindahkan file ke direktori yang diinginkan
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

// Query untuk insert data ke database
include '../../koneksi.php';
$query = "INSERT INTO buku VALUES('', '$id_kategori', '$judul', '$image', '$penulis', '$penerbit', '$tahun_terbit', '$deskripsi')";
$success = mysqli_query($koneksi, $query);

if ($success) {
    echo "
    <script>
    alert('Berhasil Ditambahkan');
    document.location.href = '../buku.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Data gagal ditambahkan');
    document.location.href = '../buku.php';
    </script>
    ";
}
