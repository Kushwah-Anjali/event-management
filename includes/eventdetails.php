<?php include './header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Event Details</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/eventdetails.css">
</head>

<body>
  <div class="container mt-5 mb-5">

    <!-- Registration Details -->
    <div class="card shadow-sm modern-reg-card mb-4">
      <div class="card-header bg-gradient-primary">
        <i class="bi bi-person-check-fill me-2"></i> Registration Details
      </div>

      <div class="card-body d-flex justify-content-between flex-wrap">
        <!-- Left: Name & Email -->
        <div class="left-info">
          <p>
            <i class="bi bi-person-fill text-primary fs-5"></i>
            <strong>Name:</strong> <span id="displayName">Anju Sharma</span>
          </p>
          <p>
            <i class="bi bi-envelope-fill text-success fs-5"></i>
            <strong>Email:</strong> <span id="displayEmail">anju@example.com</span>
          </p>
        </div>

        <!-- Right: Date & Document -->
        <div class="right-info">
          <p>
            <i class="bi bi-calendar-event-fill text-warning fs-5"></i>
            <strong>Date:</strong> <span id="displayDate">11 Aug 2025</span>
          </p>

          <button class="document-btn"
            id="eventDocument"
            title="View Documents"
            aria-label="View Documents"
            data-bs-toggle="modal"
            data-bs-target="#documentUploadModal">
            <i class="bi bi-paperclip me-2"></i> Documents
          </button>
        </div>
      </div>
    </div>

    <!-- Event Details -->
    <div class="card event-card shadow-lg border-0">
      <!-- Image -->
      <div class="event-header">
        <img id="eventImage" src="" alt="Event Image">
        <div class="event-overlay p-3">
          <h2 id="eventTitle">Sample Event Title</h2>
        </div>
      </div>

      <!-- Text Details -->
      <div class="card-body event-details">
        <div class="row gy-3">
          <div class="col-md-6 d-flex align-items-center">
            <div class="icon-heading">
              <i class="bi bi-card-text text-secondary fs-4"></i>
              <strong>Description:</strong>
            </div>
            <span id="eventDescription" class="aside">This is a sample event description.</span>
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <div class="icon-heading">
              <i class="bi bi-cash-stack text-success fs-4"></i>
              <strong>Fees:</strong>
            </div>
            <span id="eventFees" class="aside">₹500</span>
          </div>

          <div class="col-md-6 d-flex align-items-center">
            <div class="icon-heading">
              <i class="bi bi-telephone-fill text-warning fs-4"></i>
              <strong>Contact:</strong>
            </div>
            <span id="eventContact"class="aside"></span>
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <div class="icon-heading">
              <i class="bi bi-calendar-check-fill text-danger fs-4"></i>
              <strong>Held On:</strong>
            </div>
            <span id="eventDate"class="aside"></span>
          </div>

          <div class="col-md-6 d-flex align-items-center">
            <div class="icon-heading">
              <i class="bi bi-geo-alt-fill text-info fs-4"></i>
              <strong>Venue:</strong>
            </div>
            <span id="eventVenue" class="aside"></span>
          </div>
          <div class="col-md-6 d-flex align-items-center">
            <div class="icon-heading">
              <i class="bi bi-person-fill text-primary fs-4"></i>
              <strong>Author:</strong>
            </div>
            <span id="eventAuthor" class="aside">Admin</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include './DocumentModal.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/eventdetails.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include './footer.php'; ?>
