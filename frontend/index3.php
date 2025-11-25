<?php include 'partial/header.php'; ?>

<body>
    <?php include 'partial/navbar.php'; ?>

    <main class="container mt-5 p-5">
        <?php include 'sections/dataGaleri.php'; ?>
    </main>

    <?php include 'partial/footer.php'; ?>

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <?php include 'partial/script.php'; ?>
</body>

</html>