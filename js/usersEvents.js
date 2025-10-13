document.addEventListener("DOMContentLoaded", () => {
  let events = [];
  let currentPage = 1;
  let rowsPerPage = 5;
  let sortField = null,
    sortAsc = true;

  function isDateInPast(dateValue) {
    const d = parseDateString(dateValue);
    if (!d) return false;
    d.setHours(0, 0, 0, 0);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return d < today;
  }

    // --- Helpers for date comparison ---
  function parseDateString(dateValue) {
    if (!dateValue) return null;
    dateValue = dateValue.trim();

    // Handles YYYY-MM-DD format (your events are like this)
    let ymd = dateValue.match(/^(\d{4})-(\d{2})-(\d{2})$/);
    if (ymd)
      return new Date(parseInt(ymd[1]), parseInt(ymd[2]) - 1, parseInt(ymd[3]));

    // fallback
    let d = new Date(dateValue);
    return isNaN(d.getTime()) ? null : d;
  }
  // ---------------- Fetch user info ----------------
  fetch("../api/eventApi.php?action=getUser", { credentials: "same-origin" })
    .then((res) => res.json())
    .then((data) => {
      const nameEl = document.querySelector("#userInfo .user-name");
      const emailEl = document.querySelector("#userInfo .user-email");
      if (data.status === "success") {
        nameEl.textContent = `Welcome ${data.name}`;
        emailEl.textContent = `(${data.email})`;
      } else {
        nameEl.textContent = "User not logged in.";
        emailEl.textContent = "";
      }
    });

  // ---------------- Fetch Events ----------------
  function fetchEvents() {
    fetch("../api/eventApi.php?action=getUserEvents", {
      credentials: "same-origin",
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success" && Array.isArray(data.events)) {
          events = data.events;
          renderTable();
        } else {
          document.getElementById(
            "eventsTable"
          ).innerHTML = `<p class="text-muted p-3">No events found.</p>`;
        }
      });
  }
  fetchEvents();

  // ---------------- Render Table ----------------
  function renderTable() {
    const table = document.getElementById("eventsTable");
    table.innerHTML = `
      <thead>
        <tr>

          <th data-sort="serial">S.No</th>
          <th data-sort="title">Title</th>
          <th data-sort="category">Category</th>
          <th data-sort="description">Description</th>
          <th data-sort="date">Date</th>
          <th data-sort="author">Author</th>
          <th data-sort="venue">Venue</th>
          <th>Image</th>
          <th data-sort="fees">Fees</th>
          <th data-sort="contact">Contact</th>
          <th>Documents</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    `;

    let filtered = applySearch(events);

    // Sorting
    if (sortField) {
      filtered.sort((a, b) => {
        let valA = a[sortField] ?? "",
          valB = b[sortField] ?? "";
        return sortAsc
          ? valA.toString().localeCompare(valB)
          : valB.toString().localeCompare(valA);
      });
    }

    // Pagination
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = filtered.slice(start, start + rowsPerPage);

    const tbody = table.querySelector("tbody");
    tbody.innerHTML = "";
    if (pageData.length === 0) {
      tbody.innerHTML = `
    <tr>
      <td colspan="12" class="text-center text-muted p-3">
        No events found.
      </td>
    </tr>
  `;
    } else {
      pageData.forEach((event, index) => {
        let docsHtml = "";
        if (event.required_documents) {
          try {
            const docs = JSON.parse(event.required_documents);
            docsHtml = docs
              .map(
                (doc) => `
            <div class="form-check">
              <input class="form-check-input" type="checkbox" checked disabled>
              <label class="form-check-label">${doc}</label>
            </div>
          `
              )
              .join("");
          } catch {
            docsHtml = `<span class="text-muted">Invalid data</span>`;
          }
        }

        const tr = document.createElement("tr");

        // Determine if this event date is past — if yes, add the class to highlight
        tr.dataset.date = event.date || "";

        // 👇 Highlight if past
        if (isDateInPast(event.date)) {
          tr.classList.add("past-row");
        }

        tr.innerHTML = `
        <td>${start + index + 1}</td>
        <td>${event.title}</td>
        <td>${event.category || ""}</td>
        <td>${event.description || "----"}</td>
     <td>${formatDate(event.date)}</td>

        <td>${event.author || ""}</td>
        <td>${event.venue || ""}</td>
        <td>
          ${
            event.image
              ? `<img src="../uploads/events/${event.image}" width="60" height="40">`
              : "No Image"
          }
        </td>
        <td>${event.fees || "Free"}</td>
        <td>${event.contact || ""}</td>
        <td>${docsHtml || " ---"}</td>
     <td>
  ${
    isDateInPast(event.date)
      ? `<button class="btn btn-sm btn-outline-secondary history-btn" data-id="${
          event.id
        }"
        data-title="${escapeHtml(event.title)}"
        data-date="${event.date}"
         data-category="${escapeHtml(event.category)}"
       data-description="${escapeHtml(event.description)}"
        data-author="${escapeHtml(event.author)}"
        data-venue="${escapeHtml(event.venue)}"
        data-image="${event.image}"
        data-fees="${event.fees}"
        data-contact="${event.contact}">
      
           <i class="bi bi-clock-history"></i>
         </button>`
      : `<button class="btn btn-sm btn-outline-primary update-btn" data-id="${event.id}">
           <i class="bi bi-pencil-square"></i>
         </button>`
  }
  <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${
    event.id
  }">
    <i class="bi bi-trash"></i>
  </button>
</td>

      `;
        tbody.appendChild(tr);
      });
    }
    renderPagination(filtered.length);
    bindTableActions();
  }

  // ---------------- Search ----------------
  function applySearch(arr) {
    const term = document.getElementById("searchBox").value.toLowerCase();
    if (!term) return arr;
    return arr.filter((ev) =>
      Object.values(ev).join(" ").toLowerCase().includes(term)
    );
  }
  document.getElementById("searchBox").addEventListener("input", () => {
    currentPage = 1;
    renderTable();
  });

  // ---------------- Rows per page ----------------
  document.getElementById("rowsPerPage").addEventListener("change", (e) => {
    rowsPerPage = parseInt(e.target.value);
    currentPage = 1;
    renderTable();
  });

  // ---------------- Pagination ----------------
  function renderPagination(total) {
    const pages = Math.ceil(total / rowsPerPage);
    const ul = document.getElementById("pagination");
    ul.innerHTML = "";

    for (let i = 1; i <= pages; i++) {
      const li = document.createElement("li");
      li.className = "page-item " + (i === currentPage ? "active" : "");
      li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
      li.addEventListener("click", (e) => {
        e.preventDefault();
        currentPage = i;
        renderTable();
      });
      ul.appendChild(li);
    }
  }

  // ---------------- Sorting ----------------
  document.addEventListener("click", (e) => {
    if (e.target.closest("th[data-sort]")) {
      const th = e.target.closest("th");
      const field = th.getAttribute("data-sort");
      if (sortField === field) {
        sortAsc = !sortAsc;
      } else {
        sortField = field;
        sortAsc = true;
      }
      renderTable();
    }
  });

  // ---------------- Bind Table Actions (Delete / Update / Add) ----------------
  function bindTableActions() {
    // 🗑 Delete
    document.querySelectorAll(".delete-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        const id = btn.dataset.id;

        Swal.fire({
          title: "Are you sure?",
          text: "This event will be permanently deleted!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (!result.isConfirmed) return;

          fetch(`../api/eventApi.php?action=delete&id=${id}`, {
            method: "POST",
            credentials: "same-origin",
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                fetchEvents();

                Swal.fire({
                  icon: "success",
                  title: "Deleted!",
                  text: "The event was removed successfully.",
                  timer: 2000,
                  showConfirmButton: false,
                });
              } else {
                Swal.fire("Error", data.message || "Delete failed.", "error");
              }
            });
        });
      });
    });

    // ✏ Update
    document.querySelectorAll(".update-btn").forEach((btn) => {
      btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const event = events.find((ev) => ev.id == id);
        if (!event) return;

        const form = document.getElementById("addEventForm");
        form.reset();

        // Switch to update mode
        form.action = `../api/eventApi.php?action=update&id=${id}`;
        form.querySelector("[name='event_id']").value = id;
        form.querySelector("[name='title']").value = event.title || "";
        $("#categorySelect").val(event.category).trigger("change");

        form.querySelector("[name='description']").value =
          event.description || "";
        form.querySelector("[name='date']").value = event.date || "";
        form.querySelector("[name='author']").value = event.author || "";
        form.querySelector("[name='venue']").value = event.venue || "";
        form.querySelector("[name='fees']").value = event.fees || "";
        form.querySelector("[name='contact']").value = event.contact || "";
const preview = document.getElementById("currentImagePreview");
if (event.image) {
  preview.src = `../uploads/events/${event.image}`;
  preview.style.display = "block"; // show only in update
} else {
  preview.style.display = "none";
}


        // Docs checkboxes
        form
          .querySelectorAll("input[name='required_docs[]']")
          .forEach((chk) => (chk.checked = false));
        if (event.required_documents) {
          try {
            const docs = JSON.parse(event.required_documents);
            form
              .querySelectorAll("input[name='required_docs[]']")
              .forEach((chk) => {
                if (docs.includes(chk.value)) chk.checked = true;
              });
          } catch {}
        }

        // Change modal title & button
        document.querySelector(
          "#addEventModal .modal-title"
        ).innerHTML = `<i class="bi bi-pencil-square me-2"></i> Update Event`;
        document.getElementById(
          "submitBtn"
        ).innerHTML = `<i class="bi bi-save me-1"></i> Update Event`;

        // Open modal
        const modal = new bootstrap.Modal(
          document.getElementById("addEventModal")
        );
        modal.show();
      });
    });
// After rendering all event cards
document.querySelectorAll(".history-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    const id = btn.dataset.id;  /*btn.dataset.id is the event’s unique ID (like 101, 102…).*/
    openHistoryModal(id);   // This opens modal
  });
});

    // ➕ Add new
    const addBtn = document.getElementById("openAddEvent");
    if (addBtn) {
      addBtn.addEventListener("click", () => {
        const form = document.getElementById("addEventForm");
        // 1️⃣ Reset all form fields
        form.reset();

        // 2️⃣ Reset the hidden event_id field (very important!)
        form.querySelector("[name='event_id']").value = "";

        form.action = "../api/eventApi.php?action=add";

        document.querySelector(
          "#addEventModal .modal-title"
        ).innerHTML = `<i class="bi bi-calendar-plus me-2"></i> Add New Event`;
        document.getElementById(
          "submitBtn"
        ).innerHTML = `<i class="bi bi-plus-circle me-1"></i> Add Event`;
      });
    }
  }
  // ---------------- Global Form Submit (Add + Update) ----------------
  document
    .getElementById("addEventForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const form = this;
      const formData = new FormData(form);

      const title = this.querySelector('input[name="title"]').value.trim();
      const category = this.querySelector("#categorySelect").value;
      // const description = this.querySelector('#eventDescription').value.trim();
      const date = this.querySelector('input[name="date"]').value;
      const author = this.querySelector('input[name="author"]').value;
      const venue = this.querySelector('input[name="venue"]').value;
      const fees = this.querySelector('input[name="fees"]').value;
      const contact = this.querySelector('input[name="contact"]').value;
      const image = this.querySelector('input[name="image"]').value;
      if (
        !title ||
        !category ||
        !date ||
        !author ||
        !venue ||
        !fees ||
        !contact ||
        !image
      ) {
        Swal.fire({
          icon: "warning",
          title: "Missing Fields",
          text: "Please fill all required fields before submitting.",
          confirmButtonColor: "#0d6efd",
        });
        return;
      }

      fetch(form.action, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            bootstrap.Modal.getInstance(
              document.getElementById("addEventModal")
            ).hide();
            fetchEvents();

            Swal.fire({
              icon: "success",
              title: form.action.includes("update") ? "Updated!" : "Added!",
              text: form.action.includes("update")
                ? "The event was updated successfully."
                : "New event added successfully.",
              timer: 2000,
              showConfirmButton: false,
            });

            form.reset();
            form.action = "../api/eventApi.php?action=add"; // Reset to Add
          } else {
            Swal.fire(
              "Error",
              data.message || "Something went wrong.",
              "error"
            );
          }
        })
        .catch(() =>
          Swal.fire("Error", "Server error while saving event.", "error")
        );
    });

  const historyForm = document.getElementById("historyForm");

  historyForm.addEventListener("submit", function (e) {
    e.preventDefault(); // prevent normal form submission

    const formData = new FormData(historyForm);

    fetch(historyForm.action, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => {
        const [status, message] = data.split("|");

        Swal.fire({
          icon: status === "success" ? "success" : "error",
          title: message,
          timer: 2000,
          showConfirmButton: false,
        });

        // If success, reset form & close modal
        if (status === "success") {
          historyForm.reset();
          const modalEl = document.getElementById("pastHistoryModal");
          const modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();
        }
      })
      .catch((err) => {
        console.error(err);
        Swal.fire({
          icon: "error",
          title: "Something went wrong!",
          timer: 2000,
          showConfirmButton: false,
        });
      });
  });
});
function openHistoryModal(eventId) {
  fetch(`../api/eventApi.php?action=getEventsWithHistory`)
    .then(res => res.json())
    .then(events => {
      // Find the specific event
      const event = events.find(e => String(e.id) === String(eventId));
      if (!event) {
        Swal.fire("Error", "Event not found!", "error");
        return;
      }

      const modal = document.getElementById("pastHistoryModal");
      const form = document.getElementById("historyForm");

      // Fill readonly info
      form.querySelector("#historyEventId").value = event.id || "";
      document.getElementById("historyEventTitle").textContent = event.title || "";
      document.getElementById("historyEventDate").textContent = formatDate(event.date);

      // Prefill text fields
      const fields = ["summary","highlights","attendees","guests","budget","long_summary","lessons"];
      let hasHistory = fields.some(name => event[name] && String(event[name]).trim() !== "");

      if (hasHistory) {
        setModalMode(modal, form, "update");
        fields.forEach(name => {
          const input = form.querySelector(`[name=${name}]`);
          if (input) input.value = event[name] || "";
        });
      } else {
        setModalMode(modal, form, "save");
        fields.forEach(name => {
          const input = form.querySelector(`[name=${name}]`);
          if (input) input.value = "";
        });
      }

      // Prefill media directly
      if (event.media_links) {
        let media;
        try { media = JSON.parse(event.media_links); } 
        catch(e) { media = {photos: [], videos: []}; }

        const photosContainer = document.getElementById("existingPhotos");
        const videosContainer = document.getElementById("existingVideos");

        photosContainer.innerHTML = "";
        (media.photos || []).forEach(src => {
          const img = document.createElement("img");
          img.src = src.replace("../", ""); // adjust if needed
          img.className = "img-thumbnail me-2 mb-2";
          img.style.height = "80px";
          photosContainer.appendChild(img);
        });

        videosContainer.innerHTML = "";
        (media.videos || []).forEach(src => {
          const video = document.createElement("video");
          video.src = src.replace("../", ""); // adjust if needed
          video.controls = true;
          video.style.height = "80px";
          video.className = "me-2 mb-2";
          videosContainer.appendChild(video);
        });
      }

      // Show the modal
      new bootstrap.Modal(modal).show();
    })
    .catch(err => {
      console.error("Error fetching events:", err);
      Swal.fire("Error", "Something went wrong!", "error");
    });
}


function setModalMode(modal, form, mode) {
  const submitBtn = form.querySelector("button[type=submit]");
  if (mode === "update") {
    submitBtn.innerHTML = `<i class="bi bi-upload me-2"></i> Update History`;
    submitBtn.classList.remove("btn-success");
    submitBtn.classList.add("btn-warning");
  } else {
    submitBtn.innerHTML = `<i class="bi bi-upload me-2"></i> Save History`;
    submitBtn.classList.remove("btn-warning");
    submitBtn.classList.add("btn-success");
  }
}

function formatDate(isoDate) {
  if (!isoDate) return "";
  const dateObj = new Date(isoDate);

  const day = String(dateObj.getDate()).padStart(2, "0");
  const month = String(dateObj.getMonth() + 1).padStart(2, "0");
  const year = dateObj.getFullYear();

  return `${day}-${month}-${year}`; // 15-09-2025
}
// Small helper to avoid XSS when inserting into DOM attributes/html
function escapeHtml(str) {
  if (!str) return "";
  return String(str)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}
