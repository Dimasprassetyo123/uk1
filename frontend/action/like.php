<?php
session_start();
include '../../config/connection.php'; // perbaikan path

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

$fotoID = intval($_GET['id']);
$userID = $_SESSION['user_id'];

// cek apakah sudah like
$qCheck = "SELECT * FROM gallery_likefoto WHERE FotoID=$fotoID AND UserID=$userID";
$result = mysqli_query($connect, $qCheck);  

if (mysqli_num_rows($result) > 0) {
    // sudah like → hapus (unlike)
    $qDelete = "DELETE FROM gallery_likefoto WHERE FotoID=$fotoID AND UserID=$userID";
    mysqli_query($connect, $qDelete);
} else {
    // belum like → insert
    $qInsert = "INSERT INTO gallery_likefoto (FotoID, UserID, TanggalLike) VALUES ($fotoID, $userID, CURDATE())";
    mysqli_query($connect, $qInsert);
}

// balik ke halaman sebelumnya
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
