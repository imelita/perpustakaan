<?php 
// koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']);
$email = $_POST['email'];
$nama_lengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];

// Query untuk memeriksa keberadaan username dan email
$checkQuery = "SELECT * FROM user WHERE username = ? OR email = ?";
$stmt = mysqli_prepare($koneksi, $checkQuery);
mysqli_stmt_bind_param($stmt, "ss", $username, $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Jika username atau email sudah ada dalam database
    header("location:daftar.php?pesan_register=gagal_register");
} else {
    // Jika username dan email unik, maka masukkan data ke database
    $insertQuery = "INSERT INTO user VALUES (NULL, ?, ?, ?, ?, ?, 'peminjam')";
    $stmt = mysqli_prepare($koneksi, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $email, $nama_lengkap, $alamat);
    mysqli_stmt_execute($stmt);

    // Mengalihkan halaman kembali ke index.php dengan pesan sukses
    header("location:index.php?pesan=info_daftar");
}

// Tutup statement dan koneksi database
mysqli_stmt_close($stmt);
mysqli_close($koneksi);