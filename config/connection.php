<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'uk1';

    $connect = mysqli_connect($hostname, $username, $password, $database);

// Cek koneksi
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>