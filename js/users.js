// ================================
// Load Users
// ================================
async function loadUsers() {
  try {
    const res = await fetch("../api/eventApi.php?action=getuserstable");
    const data = await res.json();
    const tbody = document.querySelector("#userTableBody");
    tbody.innerHTML = "";

    if (data.status === "success") {
      data.result.forEach((user, index) => {
        if (user.role === "root" || user.email === "root@yourdomain.com")
          return;

        const row = `
          <tr>
            <td>${index + 1}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>
              <button class="btn btn-sm btn-outline-primary edit-btn me-2" 
                data-id="${user.id}" 
                data-name="${user.name}" 
                data-email="${user.email}" 
                data-bs-toggle="tooltip" title="Edit">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger delete-btn" 
                data-id="${user.id}" 
                data-bs-toggle="tooltip" title="Delete">
                <i class="bi bi-trash3-fill"></i>
              </button>
            </td>
          </tr>
        `;
        tbody.insertAdjacentHTML("beforeend", row);
      });
    } else {
      tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted py-3">No users found</td></tr>`;
    }
  } catch (err) {
    console.error("Error:", err);
    Swal.fire("❌ Error", "Failed to fetch users!", "error");
  }
}

// ================================
// Modal Elements
// ================================
const userForm = document.getElementById("userForm");
const userModalEl = document.getElementById("userModal");
const modalTitle = document.getElementById("userModalLabel");
const userIdInput = document.getElementById("userId");
const userNameInput = document.getElementById("userName");
const userEmailInput = document.getElementById("userEmail");
const userPasswordInput = document.getElementById("userPassword");

// Bootstrap modal instance
const userModal = new bootstrap.Modal(userModalEl);

// ================================
// Add User Modal
// ================================
document.getElementById("addUserBtn").addEventListener("click", () => {
  modalTitle.textContent = "Add User";
  userIdInput.value = "";
  userNameInput.value = "";
  userEmailInput.value = "";
  userPasswordInput.value = "";
  userModal.show();
});

// ================================
// Handle Form Submission
// ================================
userForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(userForm);
  const action = userIdInput.value ? "updateUser" : "addUser";

  try {
    const res = await fetch(`../api/eventApi.php?action=${action}`, {
      method: "POST",
      body: formData,
    });

    const data = await res.json();

    Swal.fire(
      data.status === "success" ? "✅ Success" : "❌ Error",
      data.message,
      data.status
    );

    if (data.status === "success") {
      userModal.hide();
      userForm.reset();
      loadUsers();
    }
  } catch (err) {
    console.error(err);
    Swal.fire("⚠️ Error", "Something went wrong!", "error");
  }
});

// ================================
// Edit & Delete Delegation
// ================================
document.querySelector("#userTableBody").addEventListener("click", async (e) => {
  const editBtn = e.target.closest(".edit-btn");
  const deleteBtn = e.target.closest(".delete-btn");

  // -------- EDIT USER --------
  if (editBtn) {
    modalTitle.textContent = "Edit User";
    userIdInput.value = editBtn.dataset.id;
    userNameInput.value = editBtn.dataset.name;
    userEmailInput.value = editBtn.dataset.email;
    userPasswordInput.value = "";
    userModal.show();
  }

  // -------- DELETE USER --------
  if (deleteBtn) {
    const id = deleteBtn.dataset.id;

    const confirmDelete = await Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
    });

    if (confirmDelete.isConfirmed) {
      const formData = new FormData();
      formData.append("admin_key", "mySecretKey123");
      formData.append("id", id);

      const res = await fetch("../api/eventApi.php?action=deleteUser", {
        method: "POST",
        body: formData,
      });

      const data = await res.json();

      Swal.fire(
        data.status === "success" ? "✅ Deleted" : "❌ Error",
        data.message,
        data.status
      );

      loadUsers();
    }
  }
});

loadUsers();
