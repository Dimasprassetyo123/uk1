<?php
session_start();
include '../../config/connection.php';
include '../../config/escapeString.php';

if (isset($_POST['tombol'])) {
    $judulFoto     = escapeString($_POST['judul']);
    $deskripsiFoto = escapeString($_POST['deskripsi']);
    $albumID       = !empty($_POST['album_id']) ? escapeString($_POST['album_id']) : "NULL";
    $userID        = $_SESSION['user_id'];

    $fotoTmp  = $_FILES['foto']['tmp_name'];
    $fotoName = time() . "_" . basename($_FILES['foto']['name']);

    // LANGSUNG simpan ke folder storages/foto/ (tanpa mkdir)
    $targetFile = __DIR__ . "/../../storages/foto/" . $fotoName;

    if (move_uploaded_file($fotoTmp, $targetFile)) {
        $qInsert = "INSERT INTO gallery_foto 
            (FotoID, JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID)
            VALUES (NULL, '$judulFoto', '$deskripsiFoto', CURDATE(), '$fotoName', " . ($albumID ?: "NULL") . ", '$userID')";

        if (mysqli_query($connect, $qInsert)) {
            echo "<script>
                alert('Foto berhasil ditambahkan');
                window.location.href='../index.php';
            </script>";
        } else {
            echo "Error database: " . mysqli_error($connect);
        }
    } else {
        echo "Gagal upload foto! Pastikan folder storages/foto sudah ada dan bisa ditulisi.";
    }
}
