<?php

$id_user = $_POST['id_user'];
$username = $_POST['username'];
$email = $_POST['email'];
$nama_lengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];
$level = $_POST['level'];

include '../../koneksi.php';
$query = "UPDATE user SET username='$username', email='$email', nama_lengkap='$nama_lengkap', alamat='$alamat', level='$level' WHERE id_user='$id_user'";
$success = mysqli_query($koneksi, $query);

if ($success) {
    echo "
    <script>
    alert('User berhasil diubah');
    document.location.href = '../user.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('User gagal ditambahkan');
    document.location.href = '../user.php';
    </script>
    ";
}

?>