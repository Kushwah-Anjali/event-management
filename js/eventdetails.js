// Run code only after the page content (DOM) is fully loaded
document.addEventListener("DOMContentLoaded", () => {
  // Prevent file input click from closing modal or triggering parent events
  document.addEventListener("click", function (e) {
    if (e.target.type === "file") {
      e.stopPropagation();
    }
  });

  // Get registration and event ID values from the page URL
  const params = new URLSearchParams(window.location.search);
  const registrationData = params.get("registration");
  const eventId = params.get("event_id");

  let userEmail = "";
  let uploadedDocs = {};
  let uploadedDocNames = [];
  let requiredDocs = [];

  // 🌸 Common fetchDocs function
  async function fetchDocs(email, eventId) {
    try {
      const res = await fetch(
        `../api/eventApi.php?action=getUploadedDocs&email=${encodeURIComponent(
          email
        )}&event_id=${eventId}`
      );
      const data = await res.json();

      if (data.status === "success") {
        uploadedDocs = data.uploadedDocs;
        uploadedDocNames = Object.keys(uploadedDocs);
      } else {
        uploadedDocs = {};
        uploadedDocNames = [];
      }

     
    } catch (err) {
      console.error("Error fetching uploaded docs:", err);
      uploadedDocs = {};
      uploadedDocNames = [];
    }
  }

  // 🌸 Parse registration data
  if (registrationData) {
    try {
      const data = JSON.parse(decodeURIComponent(registrationData));
      const reg = Array.isArray(data) ? data[0] : data;

      document.getElementById("displayName").textContent = reg.name || "";
      document.getElementById("displayEmail").textContent = reg.email || "";
 document.getElementById("displayDate").textContent =
  formatDate(reg.registered_at);

      userEmail = reg.email || "";

      if (userEmail && eventId) {
        // ✅ Load uploaded docs initially
        fetchDocs(userEmail, eventId);
      }
    } catch (err) {
      console.error("Failed to parse registration data:", err);
    }
  }

  // 🌸 Fetch event details
  if (eventId) {
    fetch(
      `../api/eventApi.php?action=get&event_id=${encodeURIComponent(eventId)}`
    )
      .then((res) => res.json())
      .then((event) => {
        if (event && event.id) {
          // Fill event details
          document.getElementById("eventTitle").textContent = event.title || "";
      document.getElementById("eventDate").textContent =
  formatDate(event.date);
          document.getElementById("eventVenue").textContent = event.venue || "";
          document.getElementById("eventDescription").textContent =
            event.description || "";
          document.getElementById("eventAuthor").textContent =
            event.author || "";
          document.getElementById("eventFees").textContent = event.fees || "";
          document.getElementById("eventContact").textContent =
            event.contact || "";

          document.getElementById("eventImage").src = event.image
            ? `../uploads/events/${event.image}`
            : "default.jpg";

          // ✅ Convert required_documents into array
          if (Array.isArray(event.required_documents)) {
            requiredDocs = event.required_documents;
          } else if (typeof event.required_documents === "string") {
            try {
              requiredDocs = JSON.parse(event.required_documents);
              if (!Array.isArray(requiredDocs)) requiredDocs = [];
            } catch (e) {
              console.warn(
                "⚠️ required_documents not valid JSON:",
                event.required_documents
              );
              requiredDocs = [];
            }
          }

          // 🌸 Build the document checklist function
          function buildChecklist() {
            const checklistContainer = document.getElementById(
              "documentChecklistContainer"
            );
            checklistContainer.innerHTML = "";

            requiredDocs.forEach((doc) => {
              const isUploaded = uploadedDocNames.includes(doc);
              const currentFile = uploadedDocs[doc] || "";

              const item = document.createElement("div");
              item.className =
                "doc-item border rounded p-3 mb-3 bg-light shadow-sm";

              item.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <input class="form-check-input me-2" type="checkbox" id="doc_${doc}" 
                          ${isUploaded ? "checked" : ""}>
                    <label class="form-check-label fw-semibold" for="doc_${doc}">
                      ${doc}
                    </label>
                    ${
                      currentFile
                        ? `<span class="badge bg-success ms-2">📄 ${currentFile}</span>`
                        : ""
                    }
                  </div>
                  <div>
                    <input type="file" class="form-control d-none" name="documents[${doc}]">
                    <button type="button" class="btn ${
                      isUploaded ? "btn-warning" : "btn-primary"
                    } btn-sm toggle-upload">
                      ${isUploaded ? "🔄 Update" : "⬆️ Upload"}
                    </button>
                  </div>
                </div>
              `;

              checklistContainer.appendChild(item);

              const fileInput = item.querySelector("input[type=file]");
              const btn = item.querySelector(".toggle-upload");
              const checkbox = item.querySelector(`#doc_${doc}`);

              btn.addEventListener("click", () => {
                checkbox.checked = true;
                fileInput.click();
              });

              fileInput.addEventListener("change", () => {
                if (fileInput.files.length > 0) {
                  btn.textContent = "✅ Ready to Upload";
                  btn.classList.remove("btn-primary", "btn-warning");
                  btn.classList.add("btn-success");
                }
              });
            });
          }

          // Initial build
          buildChecklist();

          // 🌸 Attach submit handler
          const form = document.getElementById("documentUploadForm");
          form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            formData.append("event_id", eventId);
            formData.append("email", userEmail);

            try {
              const res = await fetch(
                "../api/eventApi.php?action=updateDocuments",
                {
                  method: "POST",
                  body: formData,
                }
              );

              const result = await res.json();

              if (result.status === "success") {
                Swal.fire(
                  "Uploaded!",
                  "Documents uploaded successfully 💖",
                  "success"
                );

                await fetchDocs(userEmail, eventId);
                buildChecklist();
              } else {
                Swal.fire("Oops!", result.message || "Upload failed", "error");
              }
            } catch (err) {
              console.error("Upload error:", err);
              Swal.fire("Error", "Something went wrong", "error");
            }
          });
        }
      })
      .catch((err) => console.error("Error fetching event details:", err));
  }
});
function formatDate(isoDate) {
  if (!isoDate) return "";
  const dateObj = new Date(isoDate);

  const day = String(dateObj.getDate()).padStart(2, "0");
  const month = String(dateObj.getMonth() + 1).padStart(2, "0");
  const year = dateObj.getFullYear();

  return `${day}-${month}-${year}`; // Example: 15-09-2025
}
