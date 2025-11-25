<?php
session_start();
include '../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = escapeString($_POST['username']);
    $password = $_POST['password']; // jangan di-escape karena akan pakai password_verify

    // jalankan query
    $qLogin = "SELECT * FROM gallery_user WHERE Username = '$username'";
    $result = mysqli_query($connect, $qLogin) or die(mysqli_error($connect));

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['Password'])) {
            // set session
            $_SESSION['user_id']   = $user['UserID'];
            $_SESSION['username']  = $user['Username'];
            $_SESSION['nama']      = $user['NamaLengkap'];

            // redirect ke index di folder frontend
            header("Location: ../index.php");
            exit();
        } else {
            // kembali ke form login yang ada di frontend/user/login.php
            echo "<script>
                    alert('Password salah!');
                    window.location.href='../user/login.php';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('Username tidak ditemukan!');
                window.location.href='../user/login.php';
              </script>";
        exit();
    }
}
?>
