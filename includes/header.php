<?php
// Start session for login checks
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title><?= $pageTitle ?? 'Eventify' ?></title>  -->

  <!-- Common CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css">
  <link rel="stylesheet" href="../css/footer.css">
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  

  <!-- Page-specific CSS -->
  <?php
  if (!empty($pageCss)) {
      foreach ($pageCss as $css) {
          echo '<link rel="stylesheet" href="'.$css.'">';
      }
  }
  ?>
</head>
<body > <!-- adjust this margin for sticky header -->

<header class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="/index.php">
      <img src="/premium_photo-1681400545953-0ba00cfa7926-removebg-preview.png" alt="Logo" class="logo-img">
    </a>

    <!-- Navbar Toggler -->
    <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="toggler-icon"></span>
      <span class="toggler-icon"></span>
      <span class="toggler-icon"></span>
    </button>

    <!-- Nav Links -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav gap-4 px-3 align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="/index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/includes/contact.php">Contact</a>
        </li>
        <li class="nav-item dropdown" id="authSection">
          <a class="nav-link" href="/includes/login.php">
            <i class="bi bi-person-circle fs-4"></i> Login
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Highlight current page in navbar
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link').forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>