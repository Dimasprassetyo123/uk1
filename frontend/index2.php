<?php include 'partial/header.php'; ?>

<body class="d-flex flex-column min-vh-100">
  <?php include 'partial/navbar.php'; ?>

  <main id="content" class="flex-grow-1">
    <?php include 'sections/uploadAlbum.php'; ?>
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
