<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include 'header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/login.css">

<div class="login-wrapper">
  <div class="card login-card">
    <h4 class="fw-bold text-center">
      <i class="fas fa-right-to-bracket me-1"></i> Login
    </h4>
    <form id="loginForm" method="POST">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>
      <div class="input-group mb-4">
        <span class="input-group-text"><i class="fas fa-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-paper-plane me-2"></i> Login
      </button>
    </form>
  </div>
</div>


<script src="../js/login.js"></script>
<?php include 'footer.php' ?>
