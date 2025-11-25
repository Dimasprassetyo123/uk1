<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); // index ada di folder frontend/
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --dark-blue: #0d47a1;
            --light-blue: #e8f0fe;
            --accent-blue: #4285f4;
            --gradient-start: #1e88e5;
            --gradient-end: #0d47a1;
        }
        
        body {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        .blue-theme-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(13, 71, 161, 0.2);
            overflow: hidden;
            position: relative;
            width: 400px;
            padding: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .blue-theme-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(13, 71, 161, 0.25);
        }
        
        .blue-theme-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-blue), var(--dark-blue));
        }
        
        .camera-icon {
            background: var(--primary-blue);
            color: white;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }
        
        .header-text {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .header-text h3 {
            color: var(--dark-blue);
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .header-text p {
            color: #5f6368;
            font-size: 0.95rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #5f6368;
            margin-bottom: 8px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group-text {
            background: var(--light-blue);
            border: 2px solid #dadce0;
            border-right: none;
            border-radius: 8px 0 0 8px;
            color: var(--primary-blue);
        }
        
        .form-control {
            border: 2px solid #dadce0;
            border-left: none;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
            border-color: var(--primary-blue);
        }
        
        .form-control:focus + .input-group-text {
            border-color: var(--primary-blue);
        }
        
        .password-toggle {
            cursor: pointer;
            background: var(--light-blue);
            border: 2px solid #dadce0;
            border-left: none;
            border-radius: 0 8px 8px 0;
            color: #5f6368;
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-blue), var(--dark-blue));
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(26, 115, 232, 0.3);
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, var(--dark-blue), var(--primary-blue));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(26, 115, 232, 0.4);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #dadce0;
        }
        
        .divider span {
            padding: 0 15px;
            color: #5f6368;
            font-size: 0.9rem;
        }
        
        .link-text {
            text-align: center;
            margin-top: 20px;
            color: #5f6368;
        }
        
        .link-text a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .link-text a:hover {
            color: var(--dark-blue);
            text-decoration: underline;
        }
        
        .floating-icon {
            position: absolute;
            font-size: 24px;
            color: rgba(255, 255, 255, 0.15);
            z-index: -1;
        }
        
        .icon-1 {
            top: 10%;
            left: 15%;
        }
        
        .icon-2 {
            top: 70%;
            right: 20%;
        }
        
        .icon-3 {
            bottom: 15%;
            left: 25%;
        }
        
        .icon-4 {
            top: 20%;
            right: 15%;
        }
        
        .icon-5 {
            bottom: 20%;
            right: 25%;
        }
    </style>
</head>
<body>
    <!-- Elemen dekoratif -->
    <i class="floating-icon icon-1 fas fa-camera"></i>
    <i class="floating-icon icon-2 fas fa-images"></i>
    <i class="floating-icon icon-3 fas fa-film"></i>
    <i class="floating-icon icon-4 fas fa-portrait"></i>
    <i class="floating-icon icon-5 fas fa-cloud-upload-alt"></i>

    <div class="blue-theme-card">
        <div class="camera-icon">
            <i class="fas fa-camera"></i>
        </div>
        
        <div class="header-text">
            <h3>Masuk ke Galeri Foto</h3>
            <p>Selamat datang kembali! Silakan masuk ke akun Anda</p>
        </div>

        <form method="POST" action="../action/login.php">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" required placeholder="Nama pengguna">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Kata sandi">
                    <span class="input-group-text password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>
                </div>
            </div>
            
            <button type="submit" name="login" class="btn-login">Masuk</button>
            
            <div class="divider"><span>Atau</span></div>
            
            <p class="link-text">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>