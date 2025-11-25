<?php include 'partial/header.php'; ?>

<body>
  <div id="page-wrapper">
    <?php include 'partial/navbar.php'; ?>

    <main id="content">
      <?php include 'sections/uploadFoto.php'; ?>
    </main>

    <?php include 'partial/footer.php'; ?>
  </div>

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
