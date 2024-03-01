<?php
$status_peminjaman = $_POST['status_peminjaman'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ambil tanggal dari form
    $tanggal_peminjaman = isset($_POST['tanggal_peminjaman']) ? $_POST['tanggal_peminjaman'] : '';
    $tanggal_pengembalian = isset($_POST['tanggal_pengembalian']) ? $_POST['tanggal_pengembalian'] : '';
    $status_peminjaman = isset($_POST['status_peminjaman']) ? $_POST['status_peminjaman'] : '';
}