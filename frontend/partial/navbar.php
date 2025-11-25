<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file saat ini
?>

<!-- navbar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<nav class="site-nav">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <p class="logo m-0 float-start"><i class="fa-solid fa-home"></i> Beranda</p>
                <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">
                    <li class="<?= ($current_page == 'index.php') ? 'active' : '' ?>"><a href="index.php"><i class="fa-solid fa-home"></i> Home</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="<?= ($current_page == 'index2.php') ? 'active' : '' ?>"><a href="index2.php"><i class="fa-solid fa-images"></i> Upload Album</a></li>
                        <li class="<?= ($current_page == 'index3.php') ? 'active' : '' ?>"><a href="index3.php"><i class="fa-solid fa-table"></i> Data Galeri</a></li>
                        <li><a href="./action/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                    <?php else: ?>
                        <li class="<?= ($current_page == 'login.php') ? 'active' : '' ?>"><a href="./user/login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
                        <li class="<?= ($current_page == 'register.php') ? 'active' : '' ?>"><a href="./user/register.php"><i class="fa-solid fa-user-plus"></i> Register</a></li>
                    <?php endif; ?>
                </ul>

                <a href="#"
                    class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
                    data-toggle="collapse"
                    data-target="#main-navbar">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
/* Background navbar */
.site-nav {
    background: #2cafebff; /* biru muda */
    padding: 10px 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

/* Logo */
.site-navigation .logo {
    font-size: 20px;
    font-weight: bold;
    color: #3bb4f2; /* biru muda */
}

/* Menu utama */
.site-navigation .site-menu li {
    display: inline-block;
    margin-left: 20px;
}

.site-navigation .site-menu li a {
    color: #1a1a1a; /* teks gelap */
    font-weight: 500;
    text-decoration: none;
    transition: 0.3s;
}

/* Hover dan active menu */
.site-navigation .site-menu li a:hover,
.site-navigation .site-menu li.active a {
    color: #3bb4f2; /* biru muda */
}

/* Icon */
.site-navigation .site-menu li a i {
    margin-right: 6px;
    color: #3bb4f2; /* ikon biru muda */
}

/* Burger menu (mobile) */
.burger span,
.burger::before,
.burger::after {
    background: #2cafebff; /* biru muda */
}

/* Mobile menu */
.site-mobile-menu {
    background: #2cafebff;
}
.site-mobile-menu a {
    color: #1a1a1a;
}
.site-mobile-menu a:hover {
    color: #3bb4f2;
}
</style>
