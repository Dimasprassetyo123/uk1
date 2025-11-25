<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../config/connection.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['foto_id'], $_POST['isi_komentar'])) {
    $foto_id = intval($_POST['foto_id']);
    $isi_komentar = trim($_POST['isi_komentar']);
    $user_id = $_SESSION['user_id'];

    if ($isi_komentar === '') {
        header("Location: ../sections/detaileFoto.php?id=$foto_id&error=Komentar kosong#comments-$foto_id");
        exit();
    }

    $isi_komentar = mysqli_real_escape_string($connect, $isi_komentar);

    $sql = "INSERT INTO gallery_komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar)
            VALUES ('$foto_id', '$user_id', '$isi_komentar', NOW())";

    if (mysqli_query($connect, $sql)) {
        header("Location: ../sections/detaileFoto.php?id=$foto_id&success=1#comments-$foto_id");
    } else {
        header("Location: ../sections/detaileFoto.php?id=$foto_id&error=Gagal menambahkan komentar#comments-$foto_id");
    }
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
