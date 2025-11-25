<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;

            /* trik utama */
            display: flex;
            flex-direction: column;
        }

        /* Konten biar dorong footer */
        .content {
            flex: 1;
        }

        /* Footer */
        .site-footer {
            background: linear-gradient(135deg, #2cafeb 0%, #1a73e8 100%);
            color: white;
            padding: 30px 0 20px;
            box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin-top: auto; /* biar nempel bawah */
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo i {
            color: #ffde59;
        }

        .footer-text {
            margin-bottom: 15px;
            font-size: 16px;
            max-width: 600px;
            line-height: 1.6;
        }

        .footer-copyright {
            font-size: 14px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .footer-credits {
            font-size: 14px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <!-- konten dummy biar kelihatan kalau kosong -->
    <div class="content"></div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <i class="fas fa-camera"></i>
                    <span>Galeri Foto</span>
                </div>
                
                <div class="footer-text">
                    Temukan dan bagikan momen terindah Anda dengan komunitas fotografi terbaik.
                </div>
                
                <div class="footer-copyright">
                    Hak Cipta &copy; <span id="current-year">2025</span>. Semua Hak Dilindungi.
                </div>
                
                <div class="footer-credits">
                    Dibuat dengan <i class="fas fa-heart" style="color: #ff5252;"></i> oleh Dimas Prassetyo
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
