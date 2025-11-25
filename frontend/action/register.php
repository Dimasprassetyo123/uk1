<?php
session_start();
include '../app.php'; // karena file ini di folder action, naik 1 level

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email    = mysqli_real_escape_string($connect, $_POST['email']);
    $nama     = mysqli_real_escape_string($connect, $_POST['nama']);
    $alamat   = mysqli_real_escape_string($connect, $_POST['alamat']);

    // cek username
    $checkUser = "SELECT * FROM gallery_user WHERE Username = '$username'";
    $resultUser = mysqli_query($connect, $checkUser);

    if (mysqli_num_rows($resultUser) > 0) {
        echo "<script>
                alert('Username sudah dipakai!');
                window.location.href='../user/register.php';
              </script>";
        exit();
    }

    // cek email
    $checkEmail = "SELECT * FROM gallery_user WHERE Email = '$email'";
    $resultEmail = mysqli_query($connect, $checkEmail);

    if (mysqli_num_rows($resultEmail) > 0) {
        echo "<script>
                alert('Email sudah dipakai!');
                window.location.href='../user/register.php';
              </script>";
        exit();
    }

    // insert user baru
    $query = "INSERT INTO gallery_user (Username, Password, Email, NamaLengkap, Alamat)
              VALUES ('$username', '$password', '$email', '$nama', '$alamat')";
    if (mysqli_query($connect, $query)) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href='../user/login.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan: ".mysqli_error($connect)."');
                window.location.href='../user/register.php';
              </script>";
    }
}
