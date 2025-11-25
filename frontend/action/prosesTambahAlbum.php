<?php
session_start();
include '../../config/connection.php';

if (isset($_POST['tombol'])) {
    $nama_album = mysqli_real_escape_string($connect, $_POST['nama_album']);
    $deskripsi  = mysqli_real_escape_string($connect, $_POST['deskripsi']);
    $user_id    = $_SESSION['user_id'];

    $query = "INSERT INTO gallery_album (NamaAlbum, Deskripsi, TanggalDibuat, UserID) 
            VALUES ('$nama_album', '$deskripsi', CURDATE(), '$user_id')";

    if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Album berhasil ditambahkan!');
            window.location='../index1.php';
          </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan album: ". mysqli_error($connect) ."');
                window.history.back();
              </script>";
    }
}
?>
