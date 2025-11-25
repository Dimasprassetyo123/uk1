<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/connection.php';
include '../config/escapeString.php';

$qFoto = "SELECT
    t1.FotoID,
    t1.JudulFoto,
    t1.DeskripsiFoto,
    t1.LokasiFile,
    t1.TanggalUnggah,
    t2.NamaAlbum,
    t3.Username
FROM gallery_foto AS t1
LEFT JOIN gallery_album AS t2 ON t1.AlbumID = t2.AlbumID 
LEFT JOIN gallery_user AS t3 ON t1.UserID = t3.UserID
WHERE t1.IsPrivate = 0
ORDER BY t1.TanggalUnggah DESC";


$result = mysqli_query($connect, $qFoto);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --gray: #95a5a6;
            --accent: #e74c3c;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        #page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .gallery-container {
            flex: 1;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
        }

        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 15px;
        }

        .header-section {
            text-align: center;
            padding: 40px 0 30px;
            position: relative;
        }

        .header-section h1 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
            letter-spacing: -0.5px;
            position: relative;
            display: inline-block;
        }

        .header-section h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .header-section p {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .post-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .post-header {
            display: flex;
            align-items: center;
            padding: 20px 20px 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            overflow: hidden;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
            text-decoration: none;
            font-size: 16px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-time {
            font-size: 13px;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 3px;
        }

        .post-content {
            padding: 0 20px 15px;
        }

        .post-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 8px;
            color: var(--dark);
            line-height: 1.4;
        }

        .album-info {
            font-size: 14px;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .album-info i {
            font-size: 13px;
        }

        .post-description {
            font-size: 15px;
            color: #555;
            margin-bottom: 16px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-image-container {
            position: relative;
            overflow: hidden;
            margin: 0 0 15px;
        }

        .post-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .post-card:hover .post-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.4) 0%, transparent 70%);
            opacity: 0;
            transition: var(--transition);
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
            padding: 20px;
        }

        .post-card:hover .image-overlay {
            opacity: 1;
        }

        .view-detail-btn {
            background: rgba(255, 255, 255, 0.9);
            color: var(--dark);
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .view-detail-btn:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .post-stats {
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            margin: 0 20px 15px;
            font-size: 14px;
            color: var(--gray);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-item i {
            font-size: 15px;
        }

        .post-actions {
            display: flex;
            justify-content: space-between;
            padding: 0 20px 20px;
            gap: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex: 1;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            border-radius: 10px;
            color: var(--gray);
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            background: #f8f9fa;
            border: 1px solid #eee;
            flex: 1;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
            border-color: var(--primary);
        }

        .action-btn i {
            margin-right: 8px;
            font-size: 15px;
        }

        .like-active {
            background: rgba(52, 152, 219, 0.1);
            color: var(--primary);
            border-color: rgba(52, 152, 219, 0.2);
        }

        .no-posts {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
            grid-column: 1 / -1;
        }

        .no-posts i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .no-posts p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Share Button Styles - Diperbaiki */
        .share-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            border-radius: 10px;
            color: var(--gray);
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            background: #f8f9fa;
            border: 1px solid #eee;
            min-width: 60px;
        }

        .share-btn:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
        }

        .share-container {
            position: relative;
        }

        .share-dropdown {
            position: absolute;
            bottom: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            padding: 10px;
            z-index: 100;
            display: none;
            flex-direction: column;
            gap: 8px;
            min-width: 150px;
            margin-bottom: 10px;
        }

        .share-dropdown.show {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .share-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            color: var(--dark);
            text-decoration: none;
        }

        .share-option:hover {
            background: #f8f9fa;
        }

        .share-option i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .whatsapp-option { color: #25D366; }
        .facebook-option { color: #3b5998; }
        .instagram-option { color: #E1306C; }
        .tiktok-option { color: #000000; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .header-section h1 {
                font-size: 2.2rem;
            }

            .header-section p {
                font-size: 1rem;
            }

            .post-image {
                height: 240px;
            }

            .post-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .action-buttons {
                width: 100%;
            }
            
            .share-container {
                width: 100%;
            }
            
            .share-btn {
                width: 100%;
                justify-content: center;
            }
            
            .share-dropdown {
                left: 0;
                right: 0;
                width: 100%;
            }
        }

        /* Floating action button for mobile */
        .floating-action {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(52, 152, 219, 0.3);
            z-index: 100;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-size: 24px;
        }

        .floating-action:hover {
            transform: translateY(-3px) scale(1.05);
            background: var(--primary-dark);
            box-shadow: 0 6px 25px rgba(52, 152, 219, 0.4);
        }

        @media (max-width: 768px) {
            .floating-action {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="gallery-container p-5 mt-5">
        <div class="header-section">
            <h1>Galeri Foto</h1>
            <p>Jelajahi koleksi foto terbaru dari komunitas kami</p>
        </div>

        <div class="gallery-grid">
            <?php if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    $nama_album = $row['NamaAlbum'] ?? 'Tanpa Album';
                    $lokasi_file = '../storages/foto/' . $row['LokasiFile'];
                    $user_initials = strtoupper(substr($row['NamaLengkap'] ?? $row['Username'], 0, 1));

                    $post_date = date('d F Y', strtotime($row['TanggalUnggah']));

                    $qLike = "SELECT COUNT(*) as total_like FROM gallery_likefoto WHERE FotoID=" . $row['FotoID'];
                    $like_result = mysqli_query($connect, $qLike);
                    $like_data = mysqli_fetch_assoc($like_result);
                    $total_like = $like_data['total_like'];

                    $qComment = "SELECT COUNT(*) as total_comment FROM gallery_komentarfoto WHERE FotoID=" . $row['FotoID'];
                    $comment_result = mysqli_query($connect, $qComment);
                    $comment_data = mysqli_fetch_assoc($comment_result);
                    $total_comment = $comment_data['total_comment'];

                    $user_like = false;
                    if (isset($_SESSION['user_id'])) {
                        $qCheck = "SELECT * FROM gallery_likefoto WHERE FotoID=" . $row['FotoID'] . " AND UserID=" . $_SESSION['user_id'];
                        $check_result = mysqli_query($connect, $qCheck);
                        $user_like = mysqli_num_rows($check_result) > 0;
                    }
                    
                    // URL untuk berbagi
                    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                    $share_url = urlencode($base_url . "/sections/detaileFoto.php?id=" . $row['FotoID']);
                    $share_title = urlencode($row['JudulFoto']);
                    $share_text = urlencode("Lihat foto menarik ini: " . $row['JudulFoto']);
            ?>
                    <div class="post-card">
                        <div class="post-header">
                            <div class="user-avatar"><?= $user_initials ?></div>
                            <div class="user-info">
                                <span class="user-name"><?= $row['NamaLengkap'] ?? $row['Username'] ?></span>
                                <div class="post-time">
                                    <i class="far fa-clock"></i>
                                    <span><?= $post_date ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="post-content">
                            <div class="post-title"><?= htmlspecialchars($row['JudulFoto']) ?></div>
                            <div class="album-info">
                                <i class="fas fa-folder"></i>
                                <span><?= htmlspecialchars($nama_album) ?></span>
                            </div>
                            <?php if (!empty($row['DeskripsiFoto'])): ?>
                                <div class="post-description"><?= htmlspecialchars($row['DeskripsiFoto']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="post-image-container">
                            <a href="sections/detaileFoto.php?id=<?= $row['FotoID'] ?>" style="display: block;">
                                <img src="<?= htmlspecialchars($lokasi_file) ?>" class="post-image" alt="<?= htmlspecialchars($row['JudulFoto']) ?>"
                                    onerror="this.src='https://via.placeholder.com/400x280?text=Gambar+Tidak+Ditemukan'">
                            </a>
                            <div class="image-overlay">
                                <a href="sections/detaileFoto.php?id=<?= $row['FotoID'] ?>" class="view-detail-btn">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>

                        <div class="post-stats">
                            <div class="stat-item">
                                <i class="fas fa-heart"></i>
                                <span><?= $total_like ?> Suka</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-comment"></i>
                                <span><?= $total_comment ?> Komentar</span>
                            </div>
                        </div>

                        <div class="post-actions">
                            <div class="action-buttons">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <div class="action-btn <?= $user_like ? 'like-active' : '' ?>" onclick="likePhoto(<?= $row['FotoID'] ?>)">
                                        <i class="fas fa-thumbs-up"></i> Suka
                                    </div>
                                <?php else: ?>
                                    <div class="action-btn" onclick="checkLogin()">
                                        <i class="fas fa-thumbs-up"></i> Suka
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="sections/detaileFoto.php?id=<?= $row['FotoID'] ?>" class="action-btn">
                                        <i class="fas fa-comment"></i> Komentar
                                    </a>
                                <?php else: ?>
                                    <div class="action-btn" onclick="checkLogin()">
                                        <i class="fas fa-comment"></i> Komentar
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Tombol Share - Diperbaiki -->
                            <div class="share-container">
                                <div class="share-btn" onclick="toggleShareDropdown(this)">
                                    <i class="fas fa-share-alt"></i> 
                                </div>
                                <div class="share-dropdown">
                                    <a href="https://wa.me/?text=<?= $share_text ?> - <?= $share_url ?>" target="_blank" class="share-option whatsapp-option">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>" target="_blank" class="share-option facebook-option">
                                        <i class="fab fa-facebook"></i> Facebook
                                    </a>
                                    <a href="https://www.instagram.com/" target="_blank" class="share-option instagram-option" onclick="shareToInstagram('<?= $share_url ?>', '<?= $share_title ?>')">
                                        <i class="fab fa-instagram"></i> Instagram
                                    </a>
                                    <a href="https://www.tiktok.com/" target="_blank" class="share-option tiktok-option" onclick="shareToTikTok('<?= $share_url ?>', '<?= $share_title ?>')">
                                        <i class="fab fa-tiktok"></i> TikTok
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <div class="no-posts">
                    <i class="far fa-folder-open"></i>
                    <p>Tidak ada foto yang ditemukan.</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <p><a href="./user/login.php" style="color: var(--primary);">Login</a> untuk mengunggah foto pertama</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index1.php" class="floating-action">
            <i class="fas fa-plus"></i>
        </a>
    <?php endif; ?>

    <script>
        function checkLogin() {
            alert('Anda harus login terlebih dahulu!');
            window.location.href = './user/login.php';
        }

        function likePhoto(photoId) {
            window.location.href = 'action/like.php?id=' + photoId;
        }

        function toggleShareDropdown(button) {
            const dropdown = button.nextElementSibling;
            const isShowing = dropdown.classList.contains('show');
            
            // Tutup semua dropdown lainnya
            document.querySelectorAll('.share-dropdown.show').forEach(item => {
                if (item !== dropdown) {
                    item.classList.remove('show');
                }
            });
            
            // Toggle dropdown saat ini
            if (!isShowing) {
                dropdown.classList.add('show');
            } else {
                dropdown.classList.remove('show');
            }
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.share-container')) {
                document.querySelectorAll('.share-dropdown.show').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });

        function shareToInstagram(url, title) {
            alert('Untuk berbagi ke Instagram, salin link berikut: ' + decodeURIComponent(url));
            // Di perangkat mobile, ini akan membuka aplikasi Instagram
            window.open('instagram://library?AssetPath=' + encodeURIComponent(url), '_blank');
        }

        function shareToTikTok(url, title) {
            alert('Untuk berbagi ke TikTok, salin link berikut: ' + decodeURIComponent(url));
            // Di perangkat mobile, ini akan membuka aplikasi TikTok
            window.open('tiktok://', '_blank');
        }
    </script>
</body>

</html>