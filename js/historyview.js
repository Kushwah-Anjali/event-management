// historyview.js

const API_URL = "../api/eventApi.php"; // Your API endpoint

document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("history-container");
  const params = new URLSearchParams(window.location.search);
  const eventId = params.get("id");

  // If no ID is passed
  if (!eventId) {
    container.innerHTML = `<div class="alert alert-warning">No event ID provided.</div>`;
    return;
  }

  // Fetch event data
  fetch(`${API_URL}?id=${eventId}`)
    .then((res) => res.json())
    .then((event) => {
      if (!event || !event.id) {
        container.innerHTML = `<div class="alert alert-warning">Event not found.</div>`;
        return;
      }
      container.innerHTML = buildEventHistoryCard(event);

      // Re-observe fade-ins after content is added
      const faders = document.querySelectorAll(".fade-in");
      faders.forEach((fader) => observer.observe(fader));
    })
    .catch((err) => {
      console.error("Fetch Error:", err);
      container.innerHTML = `<div class="alert alert-danger">Failed to load event.</div>`;
    });
});

// Build Event Card
function buildEventHistoryCard(event) {
  // Parse media_links
  let photosHTML = "";
  let videosHTML = "";
  if (event.media_links) {
    try {
      const media = JSON.parse(event.media_links);
      (media.photos || []).forEach((src) => {
        photosHTML += `<div class="col-4 col-md-3 mb-2">
                                <img src="${src}" class="img-fluid rounded shadow-sm" alt="photo">
                               </div>`;
      });
      (media.videos || []).forEach((src) => {
        videosHTML += `<div class="col-6 col-md-4 mb-2">
                                 <video src="${src}" controls class="w-100 rounded shadow-sm"></video>
                               </div>`;
      });
    } catch (e) {
      /* ignore parse errors */
    }
  }

  return `
    <section class="event-card-section container mb-5 fade-in">

      <p><span class="badge-category">${event.category || "General"}</span></p>

      <div class="event-card row g-0 shadow-lg rounded">

        <!-- Left: Image -->
        <div class="col-md-5 position-relative">
          <div class="event-img-wrapper h-100">
            <img src="../uploads/events/${event.image || "placeholder.jpg"}" 
                 alt="${event.title}" 
                 class="event-img rounded-start">
            <div class="event-overlay d-flex flex-column align-items-start p-3">
              <span class="event-date-box mb-2">
                <i class="bi bi-calendar"></i> ${event.date}
              </span>
              <h2 class="event-title">${event.title}</h2>
            </div>
          </div>
        </div>

        <!-- Right: Details -->
        <div class="col-md-7">
          <div class="event-details h-100 d-flex flex-column justify-content-center p-4">
            <h4 class="mb-3">Event Details</h4>
            <p><strong>Summary:</strong> ${event.summary || "N/A"}</p>
            <p><strong>Venue:</strong> ${event.venue || "N/A"}</p>
            <p><strong>Organizer:</strong> ${event.author || "N/A"}</p>
            <p><strong>Contact:</strong> ${event.contact || "N/A"}</p>
            <p><strong>Highlights:</strong> ${event.highlights || "N/A"}</p>
          </div>
        </div>
      </div>

      <!-- Media Section -->
      <div class="row mt-4 g-3">
        ${
          photosHTML
            ? `<div class="col-12">
                          <h5>Photos</h5>
                          <div class="row g-2">${photosHTML}</div>
                        </div>`
            : ""
        }

        ${
          videosHTML
            ? `<div class="col-12 mt-3">
                          <h5>Videos</h5>
                          <div class="row g-2">${videosHTML}</div>
                        </div>`
            : ""
        }
      </div>

      <!-- Stats + Lessons -->
      <div class="row mt-4 g-4">
        <div class="col-md-6">
          <div class="info-box">
            <h5>Description</h5>
            <p>${event.description || "No description provided."}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <h5>Long Summary</h5>
            <p>${event.long_summary || "No summary provided."}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <h5>Status</h5>
            <ul>
              <li><strong>Attendees:</strong> ${event.attendees || 0}</li>
              <li><strong>Guests:</strong> ${event.guests || "N/A"}</li>
              <li><strong>Budget:</strong> ₹${event.budget || 0}</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="info-box mt-4">
        <h5>Lessons Learned</h5>
        <p>${event.lessons || "No lessons documented."}</p>
      </div>
    </section>
    `;
}

// Fade-in on scroll
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("visible");
    }
  });
});
