<?php
include '../config/connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "
    <script>
        alert('Harap login terlebih dahulu!'); window.location='./user/login.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling untuk memastikan footer di bagian bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1 0 auto;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-light">

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 p-5 mt-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Tambah Album</h3>
                </div>
                <div class="card-body">
                    <form action="../frontend/action/prosesTambahAlbum.php" method="POST">
                        <!-- Nama Album -->
                        <div class="mb-3">
                            <label class="form-label">Nama Album</label>
                            <input type="text" name="nama_album" class="form-control" required>
                        </div>

                        <!-- Deskripsi Album -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="tombol" class="btn btn-success">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Script akan ditambahkan melalui include -->
<?php include 'partial/script.php'; ?>

</body>
</html>