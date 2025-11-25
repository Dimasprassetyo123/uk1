<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../config/connection.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "
    <script>
        alert('Harap login terlebih dahulu!'); window.location='./user/login.php';
    </script>";
    exit();
}

// Ambil FotoID dari URL
if (!isset($_GET['id'])) {
    die("Foto tidak ditemukan.");
}

$fotoId = intval($_GET['id']);

// Query untuk ambil detail foto
$qFoto = "SELECT 
    t1.FotoID, 
    t1.JudulFoto, 
    t1.DeskripsiFoto, 
    t1.LokasiFile, 
    t1.TanggalUnggah,
    t2.NamaAlbum,
    t3.Username,
    t3.NamaLengkap
FROM gallery_foto AS t1
LEFT JOIN gallery_album AS t2 ON t1.AlbumID = t2.AlbumID 
LEFT JOIN gallery_user AS t3 ON t1.UserID = t3.UserID
WHERE t1.FotoID = $fotoId";

$result = mysqli_query($connect, $qFoto);
$foto = mysqli_fetch_assoc($result);

if (!$foto) {
    die("Foto tidak ditemukan.");
}

// Query untuk mengambil komentar
$qKomentar = "SELECT 
    t1.IsiKomentar,
    t1.TanggalKomentar,
    t2.Username,
    t2.NamaLengkap
FROM gallery_komentarfoto AS t1
LEFT JOIN gallery_user AS t2 ON t1.UserID = t2.UserID
WHERE t1.FotoID = $fotoId
ORDER BY t1.TanggalKomentar DESC";

$komentarResult = mysqli_query($connect, $qKomentar);

// Query untuk cek like
$user_like = false;
if (isset($_SESSION['user_id'])) {
    $qCheckLike = "SELECT * FROM gallery_likefoto WHERE FotoID = $fotoId AND UserID = " . $_SESSION['user_id'];
    $checkLikeResult = mysqli_query($connect, $qCheckLike);
    $user_like = mysqli_num_rows($checkLikeResult) > 0;
}

// Query untuk jumlah like
$qLikeCount = "SELECT COUNT(*) as total_like FROM gallery_likefoto WHERE FotoID = $fotoId";
$likeCountResult = mysqli_query($connect, $qLikeCount);
$likeCountData = mysqli_fetch_assoc($likeCountResult);
$total_like = $likeCountData['total_like'];

// Path file
$lokasi_file = '../../storages/foto/' . $foto['LokasiFile'];
$nama_album = $foto['NamaAlbum'] ?? 'Tanpa Album';
$user_initials = strtoupper(substr($foto['NamaLengkap'] ?? $foto['Username'], 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto - <?= htmlspecialchars($foto['JudulFoto']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #2c3e50;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding: 20px;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
        }

        .back-btn {
            background: #6c757d;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        .photo-title {
            font-weight: 600;
            font-size: 1.5rem;
            color: #2c3e50;
        }

        .content {
            display: flex;
            flex-direction: column;
        }

        .photo-container {
            width: 100%;
            height: 400px;
            overflow: hidden;
            position: relative;
            background: #000;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .details {
            padding: 24px;
            background: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 16px;
        }

        .user-details {
            flex: 1;
        }

        .username {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .album-info {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .description {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .description p {
            line-height: 1.6;
            color: #495057;
        }

        .stats {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            padding: 12px 0;
            border-bottom: 1px solid #eaeaea;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-item i {
            font-size: 1.2rem;
        }

        .like-count {
            color: #e74c3c;
        }

        .comments-section {
            background: white;
            padding: 24px;
            border-top: 1px solid #eaeaea;
        }

        .comments-header {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .comments-list {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column-reverse;
        }

        .comment {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 12px;
            transition: background 0.3s ease;
        }

        .comment:hover {
            background: #e9ecef;
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fd746c 0%, #ff9068 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
        }

        .comment-author {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .comment-text {
            color: #495057;
            line-height: 1.5;
            margin-bottom: 4px;
        }

        .comment-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .no-comments {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }

        .comment-form {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .comment-input {
            flex: 1;
            padding: 14px 20px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            outline: none;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .comment-input:focus {
            border-color: #667eea;
        }

        .send-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .send-btn:hover {
            transform: scale(1.05);
        }

        .login-prompt {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 20px;
        }

        .login-prompt a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-prompt a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 12px;
            }
            
            .photo-container {
                height: 300px;
            }
            
            .details {
                padding: 16px;
            }
            
            .comments-section {
                padding: 16px;
            }
            
            .comment-form {
                flex-direction: column;
                gap: 8px;
            }
            
            .send-btn {
                width: 100%;
                border-radius: 25px;
                height: 45px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <button class="back-btn" onclick="goBack()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h1 class="photo-title"><?= htmlspecialchars($foto['JudulFoto']) ?></h1>
            <div style="width: 40px;"></div>
        </div>

        <div class="content">
            <div class="photo-container">
                <img src="<?= $lokasi_file ?>" alt="<?= htmlspecialchars($foto['JudulFoto']) ?>"
                     onerror="this.src='https://via.placeholder.com/800x400?text=Gambar+Tidak+Ditemukan'">
            </div>

            <div class="details">
                <div class="user-info">
                    <div class="avatar"><?= $user_initials ?></div>
                    <div class="user-details">
                        <div class="username"><?= htmlspecialchars($foto['NamaLengkap'] ?? $foto['Username']) ?></div>
                        <div class="album-info">Album: <?= htmlspecialchars($nama_album) ?></div>
                    </div>
                </div>

                <?php if (!empty($foto['DeskripsiFoto'])): ?>
                <div class="description">
                    <p><?= $foto['DeskripsiFoto'] ?></p>
                </div>
                <?php endif; ?>

                <div class="stats">
                    <div class="stat-item like-count">
                        <i class="fas fa-heart"></i>
                        <span><?= $total_like ?> Suka</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-comment"></i>
                        <span><?= mysqli_num_rows($komentarResult) ?> Komentar</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-calendar"></i>
                        <span><?= date('d M Y', strtotime($foto['TanggalUnggah'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="comments-section">
            <div class="comments-header">
                <i class="fas fa-comments"></i>
                <span>Komentar</span>
            </div>

            <div class="comments-list">
                <?php if (mysqli_num_rows($komentarResult) > 0): ?>
                    <?php 
                    mysqli_data_seek($komentarResult, 0);
                    while ($komentar = mysqli_fetch_assoc($komentarResult)):
                        $comment_initials = strtoupper(substr($komentar['NamaLengkap'] ?? $komentar['Username'], 0, 1));
                        $comment_time = date('d M Y', strtotime($komentar['TanggalKomentar']));
                    ?>
                        <div class="comment">
                            <div class="comment-avatar"><?= $comment_initials ?></div>
                            <div class="comment-content">
                                <div class="comment-author"><?= htmlspecialchars($komentar['NamaLengkap'] ?? $komentar['Username']) ?></div>
                                <div class="comment-text"><?= htmlspecialchars($komentar['IsiKomentar']) ?></div>
                                <div class="comment-time"><?= $comment_time ?></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-comments">
                        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="comment-form" action="../action/komentar.php" method="POST">
                    <input type="hidden" name="foto_id" value="<?= $fotoId ?>">
                    <input type="text" class="comment-input" name="isi_komentar" placeholder="Tulis komentar menarik..." required>
                    <button type="submit" class="send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            <?php else: ?>
                <div class="login-prompt">
                    <p><a href="../user/login.php">Login</a> untuk menambahkan komentar</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function checkLogin() {
            alert('Anda harus login terlebih dahulu!');
            window.location.href = '../user/login.php';
        }

        function likePhoto(photoId) {
            <?php if (isset($_SESSION['user_id'])): ?>
                window.location.href = '../action/like.php?id=' + photoId;
            <?php else: ?>
                checkLogin();
            <?php endif; ?>
        }

        // Auto-scroll ke atas komentar (karena komentar terbaru di atas)
        window.addEventListener('load', function() {
            const commentsList = document.querySelector('.comments-list');
            commentsList.scrollTop = 0;
        });
    </script>
</body>

</html>