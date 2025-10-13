<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<head>
  <title>Home - Event Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="./css/style.css">
</head>
<!-- 🌟 HERO SECTION -->
<section class="hero-section d-flex align-items-center">
  <div class="container text-center">
    <p class="hero-caption">Celebrate • Connect • Create</p>
    <h1 class="hero-title">Your Event, Your Way</h1>
    <p class="hero-subcaption">Discover, Experience, and Make Memories</p>
    <a href="#event-section" class="hero-btn">Explore Events</a>
  </div>
</section>

<section class="welcome-area">
  <!-- Left Content -->
  <div class="welcome-text">
    <h6>WELCOME TO</h6>
    <h1>EVENT MANAGEMENT</h1>
    <p>
      Manage, plan, and organize your events seamlessly.
      From college fests to workshops and hackathons,
      everything in one place – simple, modern, and efficient.
    </p>
    <a href="./includes/contact.php" class="btn-started">Contact US →</a>
  </div>

  <!-- Right Content -->
  <div class="welcome-image">
    <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">

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
<!-- 🌟 Customer Feedback Section -->
<section id="feedback" class="feedback-section">
  <div class="container">
    <h2 class="section-title">💬What Our Customers Say</h2>
    <p class="section-subtitle">Real experiences from people who trusted us with their events</p>

    <div class="feedback-wrapper">
      <!-- Feedback Card 1 -->
      <div class="feedback-card">
        <div class="feedback-text">
          "Amazing experience! The team managed everything smoothly and the event went beyond expectations."
        </div>
        <div class="feedback-user">
          <img src="https://i.pravatar.cc/80?img=12" alt="User 1" class="user-img">
          <div>
            <h4>Rohit Sharma</h4>
            <span>Corporate Client</span>
          </div>
        </div>
      </div>

      <!-- Feedback Card 2 -->
      <div class="feedback-card">
        <div class="feedback-text">
          "Very professional and supportive. I loved how they customized everything for our college fest."
        </div>
        <div class="feedback-user">
          <img src="https://i.pravatar.cc/80?img=32" alt="User 2" class="user-img">
          <div>
            <h4>Anjali Mehta</h4>
            <span>College Event</span>
          </div>
        </div>
      </div>

      <!-- Feedback Card 3 -->
      <div class="feedback-card">
        <div class="feedback-text">
          "Top-notch service and great coordination. Highly recommend for weddings and private functions."
        </div>
        <div class="feedback-user">
          <img src="https://i.pravatar.cc/80?img=44" alt="User 3" class="user-img">
          <div>
            <h4>Rahul Verma</h4>
            <span>Wedding Client</span>
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