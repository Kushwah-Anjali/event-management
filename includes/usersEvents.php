<?php
// session_start();
include './header.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// Disable cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>

<?php include '../addEventsModal.php'; ?>
<?php include 'historyModal.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Events</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../css/usersEvents.css">
</head>

<body>

  <div class="container mt-4 content-box mb-5">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <div id="userInfo" class="mb-0 fw-bold">
        <h1 class="user-name"><i class="fa-solid fa-user me-2"></i>Loading name...</h1>
        <h5 class="user-email"><i class="fa-solid fa-envelope me-1"></i>Loading email...</h5>
      </div>

      <div class="d-flex gap-2 flex-wrap">
        <!-- Add Event -->
        <a href="#addEventModal" class="btn btn-warning shadow" id="openAddEvent" data-bs-toggle="modal">
          <i class="bi bi-calendar-plus me-2"></i> Add Event
        </a>
        <!-- Logout -->
        <button id="logoutBtn" class="btn btn-danger shadow">
          <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
      </div>
    </div>

    <hr class="mb-4 text-dark opacity-25" />

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 toolbar">
      <h3 class="mb-0" id="event">
        <i class="fa-solid fa-calendar-days me-2"></i> Your Events
      </h3>

      <div class="d-flex gap-2 flex-wrap align-items-center">
        <!-- Rows Per Page -->
        <select id="rowsPerPage" class="form-select form-select-sm w-auto">
          <option value="5" selected>5 rows</option>
          <option value="10">10 rows</option>
          <option value="20">20 rows</option>
        </select>

        <!-- Search -->
        <div class="input-group input-group-sm" style="min-width: 200px;">
          <span class="input-group-text bg-white border-end-0">
            <i class="fa-solid fa-magnifying-glass text-muted"></i>
          </span>
          <input type="text" id="searchBox" class="form-control border-start-0" placeholder="Search...">
        </div>
      </div>
    </div>


    <!-- Table -->
    <div class="table-responsive shadow-sm rounded">
      <table id="eventsTable" class="table table-striped table-hover align-middle"></table>
    </div>

    <!-- Pagination -->
    <nav class="mt-3">
      <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>

  </div>

  <script type="module" src="../js/login.js"></script>
  <script type="module" src="../js/usersEvents.js"></script>
</body>

</html>
<?php include './footer.php'; ?>