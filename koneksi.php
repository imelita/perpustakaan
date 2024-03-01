<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "perpus_ukk1";

$koneksi = mysqli_connect("localhost", "root", "", "perpus_ukk1");

//cek koneksi
if (mysqli_connect_errno()) {
    echo "koneksi database gagal: " . mysqli_connect_error();
}