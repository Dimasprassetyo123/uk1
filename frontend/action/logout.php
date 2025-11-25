
<?php
session_start();
include '../app.php';

// hapus semua session
session_unset();
session_destroy();

// redirect ke HOME (index di folder frontend)
echo "<script>
        alert('Anda telah keluar!');
        window.location.href='../index.php';
    </script>";
exit();
