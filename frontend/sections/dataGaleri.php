<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/connection.php';
include '../config/escapeString.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "
    <script>
        alert('Harap login terlebih dahulu!'); window.location='./user/login.php';
    </script>";
    exit();
}

// Cek jika ada request toggle private/public
if (isset($_GET['toggle_id'])) {
    $fotoId = intval($_GET['toggle_id']);

    // Ambil status sekarang
    $qGet = "SELECT IsPrivate FROM gallery_foto WHERE FotoID = $fotoId";
    $res = mysqli_query($connect, $qGet);
    $data = mysqli_fetch_assoc($res);

    if ($data) {
        $newStatus = $data['IsPrivate'] == 1 ? 0 : 1;
        mysqli_query($connect, "UPDATE gallery_foto SET IsPrivate = $newStatus WHERE FotoID = $fotoId");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua data foto
$qFoto = "SELECT
    t1.FotoID,
    t1.JudulFoto,
    t1.DeskripsiFoto,
    t1.LokasiFile,
    t1.TanggalUnggah,
    t1.IsPrivate,
    t2.NamaAlbum,
    t3.Username,
    t3.NamaLengkap
FROM gallery_foto AS t1
LEFT JOIN gallery_album AS t2 ON t1.AlbumID = t2.AlbumID 
LEFT JOIN gallery_user AS t3 ON t1.UserID = t3.UserID
ORDER BY t1.TanggalUnggah DESC";

$result = mysqli_query($connect, $qFoto);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Tabel Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        thead.custom-header th {
            background-color: #0d6efd !important;
            color: white !important;
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Data Tabel Galeri Foto</h2>

        <table id="tabelGaleri" class="table table-bordered table-striped">
            <thead class="custom-header">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Album</th>
                    <th>Pengunggah</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0):
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        $nama_album = $row['NamaAlbum'] ?? 'Tanpa Album';
                        $lokasi_file = '../storages/foto/' . $row['LokasiFile'];
                        $post_date = date('d-m-Y', strtotime($row['TanggalUnggah']));
                        $isPrivate = $row['IsPrivate'] == 1;
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['JudulFoto']) ?></td>
                            <td><?= htmlspecialchars($row['DeskripsiFoto']) ?></td>
                            <td><?= htmlspecialchars($nama_album) ?></td>
                            <td><?= htmlspecialchars($row['NamaLengkap'] ?? $row['Username']) ?></td>
                            <td><?= $post_date ?></td>
                            <td class="text-center">
                                <?php if ($isPrivate): ?>
                                    <span class="badge bg-secondary">Private</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Public</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <img src="<?= htmlspecialchars($lokasi_file) ?>" alt="foto" width="80" height="60"
                                    onerror="this.src='https://via.placeholder.com/80x60?text=No+Image'">
                            </td>
                            <td>
                                <a href="sections/detaileFoto.php?id=<?= $row['FotoID'] ?>" class="btn btn-sm btn-primary">Detail</a>
                                <a href="?toggle_id=<?= $row['FotoID'] ?>" class="btn btn-sm <?= $isPrivate ? 'btn-success' : 'btn-secondary' ?>">
                                    <?= $isPrivate ? 'Jadikan Public' : 'Jadikan Private' ?>
                                </a>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data foto</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JS DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelGaleri').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 20, 50],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "›",
                        "previous": "‹"
                    }
                }
            });
        });
    </script>
</body>
</html>
