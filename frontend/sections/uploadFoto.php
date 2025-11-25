<?php

include __DIR__ . '/../../config/connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "
    <script>
        alert('Harap login terlebih dahulu!'); window.location='./user/login.php';
    </script>";
    exit();
}

// Ambil data album dari database untuk dropdown
$userID = $_SESSION['user_id'];
$qAlbum = "SELECT AlbumID, NamaAlbum FROM gallery_album WHERE UserID = '$userID'";
$result = mysqli_query($connect, $qAlbum);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Unggah Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<main class="flex-grow-1 container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 mt-5 p-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Unggah Foto</h3>
                </div>
                <div class="card-body">
                    <form action="../frontend/action/prosesTambahFoto.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Judul Foto</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Foto</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Pilih Album</label>
                            <select name="album_id" class="form-control">
                                <option value="">Tanpa Album</option>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <option value="<?= $row['AlbumID']; ?>"><?= $row['NamaAlbum']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Foto</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="tombol" class="btn btn-success">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>