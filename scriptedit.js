console.log("Script loaded!");
let currentEventId = null;
let currentCategory = "all";
let currentDateFilter = "";
let currentSearchQuery = "";
// html page will be load here
document.addEventListener("DOMContentLoaded", function () {
  // fetch the event
  fetch("api/eventApi.php?action=get")
    //  res.json()==  turns the response in js arrays
    .then((res) => res.json())
    .then((data) =>
      // “Did I  receive a array of events?
      {
        if (Array.isArray(data)) {
          renderEvents(data);
        } else {
          console.error("Invalid response:", data);
          showAlert("Failed to load events.", "danger");
        }
      }
    )
    .catch((err) => {
      console.error("Fetch error:", err);
      showAlert("Something went wrong while loading events.", "danger");
    });
});
function renderEvents(events) {
  const template = document.querySelector(".card-template");
  const upcoming = document.getElementById("upcomingEvents");
  const today = document.getElementById("todayEvents");
  const past = document.getElementById("pastEvents");
  // arranging in trio one by one
  [upcoming, today, past].forEach((section) => (section.innerHTML = ""));
  const now = new Date();
  const todayDateOnly = Date.UTC(
    now.getFullYear(),
    now.getMonth(),
    now.getDate()
  );
  events.forEach((event) => {
    //  make a clone (copy) the card template with including all inner elements  so we can fill it with real event details
    const clone = template.cloneNode(true);
    clone.classList.remove("d-none", "card-template");
    clone.querySelector(".event-img").src = `uploads/events/${event.image}`;
    clone.querySelector(".event-title").textContent = event.title;
    clone.querySelector(".event-desc").textContent = event.description;
    let { shortDate, fullDate } = formatDate(event.date);
    let dateEl = clone.querySelector(".event-date");
    dateEl.querySelector(".date-highlight").textContent = shortDate;
    dateEl.setAttribute("title", fullDate);

    // for register button creation in events
    const registerBtn = clone.querySelector(".open-register");
    registerBtn.setAttribute("data-event-id", event.id);
    registerBtn.addEventListener("click", () => {
      document.getElementById("modalEventId").value = event.id;
      alreadyRegistered = false;
      document.getElementById("emailInput").value = "";
      document.getElementById("nameInput").value = "";
      document.getElementById("nameInputWrapper").classList.add("d-none");
      document
        .getElementById("alreadyRegisteredMessage")
        .classList.add("d-none", "fade-out");
      document
        .getElementById("alreadyRegisteredMessage")
        .classList.remove("fade-in");
      document.getElementById("emailInputWrapper").classList.remove("d-none");
      document.querySelector(
        "#registerModal button[type='submit']"
      ).disabled = false;
      new bootstrap.Modal(document.getElementById("registerModal")).show();
    });

    // Split the event date into [year, month, day]
    const eventParts = event.date.split("-");

    // Create a clean timestamp using just the date (no time)
    const eventDateOnly = Date.UTC(
      eventParts[0], //year
      eventParts[1] - 1, //month because month start from 0 in js eg august=8 but in js it will 7 so -1 .
      eventParts[2] //day
    );
    if (eventDateOnly > todayDateOnly) {
      upcoming.appendChild(clone);
    } else if (eventDateOnly === todayDateOnly) {
      // registerBtn.style.display = "none";
      today.appendChild(clone);
    } else {
      past.appendChild(clone);
      const newBtn = registerBtn.cloneNode(true); // removes previous listeners
      newBtn.classList.remove("open-register");
      newBtn.classList.add("open-history");
      newBtn.innerHTML = `<i class="bi bi-clock-history"></i>`;
      newBtn.setAttribute("data-event-id", event.id);

      registerBtn.parentNode.replaceChild(newBtn, registerBtn);
    }
  });
}
document.getElementById("emailInput").addEventListener("blur", function () {
  const email = this.value.trim();
  const eventId = document.getElementById("modalEventId").value;
  if (!email || !eventId) return;
  fetch("api/eventApi.php?action=checkEmail", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body:
      "email=" +
      encodeURIComponent(email) +
      "&event_id=" +
      encodeURIComponent(eventId),
  })
    .then((res) => res.json())
    .then((data) => {
      const nameWrapper = document.getElementById("nameInputWrapper");
      const msgBox = document.getElementById("alreadyRegisteredMessage");
      const emailWrapper = document.getElementById("emailInputWrapper");
      const submitBtn = document.querySelector(
        "#registerModal button[type='submit']"
      );

      if (data.status === "found") {
        const registrationData = encodeURIComponent(JSON.stringify(data.data));

        console.log(registrationData);
        window.location.href = `./includes/eventdetails.php?event_id=${encodeURIComponent(
          eventId
        )}&registration=${registrationData}`;

        submitBtn.disabled = true;
      } else {
        alreadyRegistered = false;
        nameWrapper.classList.remove("d-none");
        emailWrapper.classList.remove("d-none");
        msgBox.classList.remove("fade-in");
        msgBox.classList.add("fade-out");
        setTimeout(() => msgBox.classList.add("d-none"), 500);
        submitBtn.disabled = false;
        alert("Now you can enter your name!");
      }
    })
    .catch((err) => console.error("Email check error:", err));
});

document.addEventListener("click", function (e) {
  const btn = e.target.closest(".open-history");
  if (!btn) return;

  const eventId = btn.getAttribute("data-event-id");

  // ✅ Redirect to history page with event id
  window.location.href = `../includes/historyview.php?id=${eventId}`;
});

// 🌸 Registration Form Submit Handler
document
  .getElementById("registerForm")
  .addEventListener("submit", function (e) {
    e.preventDefault(); // ❌ Form ke default reload ko rok liya

    const nameInput = document.getElementById("nameInput");

    // 🔒 Already registered case handle
    if (alreadyRegistered) {
      // Agar pehle se registered hai toh name required mat karo
      nameInput.removeAttribute("required");
      showAlert("You are already registered with this email.", "warning");
      return; // Aur yahin ruk jao
    } else {
      // Agar nayi registration hai toh name compulsory banao
      nameInput.setAttribute("required", "required");
    }

    // 🌸 Collect form data
    const formData = new FormData(this);

    // Event ID modal se le lo (hidden field hoga)
    const eventId = document.getElementById("modalEventId").value;

    // 🚀 Backend ko call karte hain
    fetch("api/eventApi.php?action=register", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json()) // Response ko JSON banaya
      .then((data) => {
        if (data.status === "success") {
          // ✅ Registration successful case

          // 🎁 Encode registration data object (name, email, etc.)
          const registrationData = encodeURIComponent(
            JSON.stringify(data.data)
          );

          // 🌸 User ko redirect karo details page par
          window.location.href = `./includes/eventdetails.php?event_id=${encodeURIComponent(
            eventId
          )}&registration=${registrationData}`;
        } else {
          // ❌ Backend se failure aaya
          showAlert("Registration failed. Try again.", "danger");
        }
      })
      .catch((err) => {
        // 🛑 Agar fetch me error aaya
        console.error("Registration error:", err);
        showAlert("Something went wrong. Please try again.", "danger");
      });
  });

// ✨ Utility Functions
function clearEventSections() {
  document.getElementById("upcomingEvents").innerHTML = "";
  document.getElementById("todayEvents").innerHTML = "";
  document.getElementById("pastEvents").innerHTML = "";
}
function showErrorMessage() {
  showAlert("Something went wrong while fetching data.", "danger");
}
function scrollToEvents() {
  const eventContainer = document.getElementById("eventsContainer");
  if (eventContainer) {
    eventContainer.scrollIntoView({ behavior: "smooth", block: "start" });
  }
}
function showAlert(message, type = "success") {
  const alertBox = document.createElement("div");
  alertBox.className = `alert alert-${type} alert-dismissible fade show text-center shadow-lg`;
  alertBox.role = "alert";
  alertBox.style.minWidth = "300px";
  alertBox.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;
  document.getElementById("alertContainer").appendChild(alertBox);

  setTimeout(() => {
    alertBox.classList.remove("show");
    alertBox.classList.add("fade");
    setTimeout(() => alertBox.remove(), 500);
  }, 3000);
}

// Helper function for formatting
function formatDate(dateString) {
  let date = new Date(dateString);

  let day = String(date.getDate()).padStart(2, "0");
  let monthsShort = [
    "JAN",
    "FEB",
    "MAR",
    "APR",
    "MAY",
    "JUN",
    "JUL",
    "AUG",
    "SEP",
    "OCT",
    "NOV",
    "DEC",
  ];
  let monthsFull = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  let monthShort = monthsShort[date.getMonth()];
  let monthFull = monthsFull[date.getMonth()];
  let year = date.getFullYear();

  // Short format
  let shortDate = `${day} ${monthShort}`;
  // Full format
  let fullDate = `${day} ${monthFull} ${year}`;

  return { shortDate, fullDate };
} // 1️⃣ Select all buttons
const buttons = document.querySelectorAll("#eventFilters button");

// 2️⃣ Add click listener to each button
buttons.forEach((btn) => {
  btn.addEventListener("click", () => {
    const target = btn.getAttribute("data-target");

    // 3️⃣ Loop through all sections and show/hide
    const sections = ["upcomingEvents", "todayEvents", "pastEvents"];
    sections.forEach((id) => {
      if (target === "all") {
        document.getElementById(id).style.display = "flex"; // show all
      } else {
        document.getElementById(id).style.display =
          id === target ? "flex" : "none";
      }
    });

    buttons.forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
  });
});

const form = document.querySelector("#addEventModal");

form.addEventListener("submit", function (e) {
  // get date value from input
  const dateInput = form.querySelector("[name='date']");
  let dateVal = dateInput.value; // "2025-09-12"

  if (dateVal) {
    const [year, month, day] = dateVal.split("-");
    // convert to DD/MM/YYYY
    dateInput.value = `${day}/${month}/${year}`;
  }
});
