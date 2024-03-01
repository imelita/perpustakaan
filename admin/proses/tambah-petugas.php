<?php 
include '../../koneksi.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']);
$email = $_POST['email'];
$nama_lengkap = $_POST['nama_lengkap'];
$alamat = $_POST['alamat'];

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Jika email tidak valid, kembalikan ke halaman tambah-petugas.php dengan pesan kesalahan
    header("location:../tambah-petugas.php?pesan_daftar=gagal_email");
    exit(); // Hentikan eksekusi script
}

$checkQuery = "SELECT * FROM user WHERE username = ? OR email = ?";
$stmt = mysqli_prepare($koneksi, $checkQuery);
mysqli_stmt_bind_param($stmt, "ss", $username, $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Jika username atau email sudah ada dalam database, kembalikan ke halaman tambah-petugas.php dengan pesan kesalahan
    header("location:../tambah-petugas.php?pesan_daftar=gagal_daftar");
    exit(); // Hentikan eksekusi script
} else {
    // Jika username dan email unik, maka masukkan data ke database
    $insertQuery = "INSERT INTO user VALUES (NULL, ?, ?, ?, ?, ?, 'petugas')";
    $stmt = mysqli_prepare($koneksi, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $email, $nama_lengkap, $alamat);
    mysqli_stmt_execute($stmt);

    // Mengalihkan halaman kembali ke user.php dengan pesan sukses
    echo "
    <script>
    alert('Petugas berhasil ditambahkan');
    document.location.href = '../user.php';
    </script>
    ";
}

// Tutup statement dan koneksi database
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>