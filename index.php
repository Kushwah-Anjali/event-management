<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<head>
  <title>Home - Event Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="./css/style.css">
</head>
<!-- 🌟 HERO SECTION -->
<section class="hero-section d-flex flex-column justify-content-center align-items-center text-center vh-100">
  <div class="container">
    <p class="hero-caption">Celebrate • Connect • Create</p>
    <h1 class="hero-title">Your Event, Your Way</h1>
    <p class="hero-subcaption">Discover, Experience, and Make Memories</p>
    <a href="#event-section" class="btn hero-btn mt-3">Explore Events</a>
  </div>
</section>

<section class="welcome-area py-5 text-light" style="background-color:#0d0d4d;">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-6">
        <h6 class="text-uppercase text-pink fw-semibold">Welcome To</h6>
        <h1 class="fw-bold">Event Management</h1>
        <p>Manage, plan, and organize your events seamlessly</p>
        <a href="./includes/contact.php" class="btn btn-started mt-3">Contact Us →</a>
      </div>
      <div class="col-lg-6 text-center">
        <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Event" class="img-fluid rounded-3 shadow-lg">
      </div>
    </div>
  </div>
</section>



<section class="events-section" id="event-section">
  <div class="container my-5 ">
    <div class="row">
      <div id="eventsContainer" class="mt-5">
        <div class="events-filter-section text-center mb-5">
          <h2 class="filter-heading mb-4">Filter Your Events</h2>
          <div class="d-flex justify-content-center gap-3 flex-wrap" id="eventFilters">
            <button class="btn" data-target="upcomingEvents">Upcoming</button>
            <button class="btn" data-target="todayEvents">Today</button>
            <button class="btn" data-target="pastEvents">Past</button>
            <button class="btn" data-target="all">Show All</button>
          </div>
        </div>

        <!-- Event Sections (for reference) -->
        <div id="upcomingEvents" class="row g-4 mb-5"></div>
        <div id="todayEvents" class="row g-4 mb-5"></div>
        <div id="pastEvents" class="row g-4"></div>
        <div class="col-md-6 col-lg-4 mb-4 d-flex card-template d-none">
          <div class="card card-event shadow-sm w-100 border-0 rounded-4 position-relative overflow-hidden">
            <!-- Full Background Image -->
            <img src="" class="card-img-top event-img rounded-4" alt="Event image">

            <!-- Overlay Content -->
            <div class="card-body overlay d-flex flex-column justify-content-end">
              <h5 class="card-title fw-bold event-title text-white mb-1">Event Title</h5>
              <p class="card-text event-desc text-light small mb-1">Description here...</p>

              <!-- 📅 Date Circle -->
              <p class="event-date mb-0">
                <span class="date-highlight">Date</span>
              </p>

              <!-- 🔘 Register Button -->
              <button class="btn btn-register open-register" data-event-id="">
                <i class="bi bi-pencil-square"></i>
              </button>
            </div>
          </div>
        </div>


      </div>


    </div>
    <!-- 🔔 Alert Container -->
    <div id="alertContainer"
      class="position-fixed top-0 start-50 translate-middle-x p-3"
      style="z-index: 1100; width: max-content; max-width: 90vw;">
    </div>
  </div>
</section>
<section class="feedback-section py-5 text-light text-center" style="background-color:#0d0d2d;">
  <div class="container">
    <h2 class="section-title mb-3">💬 What Our Customers Say</h2>
    <p class="section-subtitle mb-5">Real experiences from people who trusted us with their events</p>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feedback-card h-100 p-4 rounded-4 shadow-lg bg-white text-dark">
          <p class="feedback-text">"Amazing experience! The team managed everything smoothly and the event went beyond expectations." </p>
          <div class="d-flex align-items-center mt-3">
            <img src="https://i.pravatar.cc/80?img=12" class="rounded-circle me-3" width="55" height="55">
            <div>
              <h5 class="mb-0">Rohit Sharma</h5>
              <small class="text-primary">Corporate Client</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feedback-card h-100 p-4 rounded-4 shadow-lg bg-white text-dark">
          <p class="feedback-text">"Very professional and supportive. I loved how they customized everything for our college fest."
          </p>
          <div class="d-flex align-items-center mt-3">
            <img src="https://i.pravatar.cc/80?img=32" class="rounded-circle me-3" width="55" height="55">
            <div>
              <h5 class="mb-0">Anjali Mehta</h5>
              <small class="text-primary">College Event</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feedback-card h-100 p-4 rounded-4 shadow-lg bg-white text-dark">
          <p class="feedback-text"> "Top-notch service and great coordination. Highly recommend for weddings and private functions."
          </p>
          <div class="d-flex align-items-center mt-3">
            <img src="https://i.pravatar.cc/80?img=44" class="rounded-circle me-3" width="55" height="55">
            <div>
              <h5 class="mb-0">Rahul Verma</h5>
              <small class="text-primary">Wedding Client</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<?php include 'includes/register.php' ?>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="scriptedit.js"></script>
<?php include 'includes/footer.php' ?>