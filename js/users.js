
async function loadUsers() {
  try {
    // Fetch users from backend
    const res = await fetch("../api/eventApi.php?action=getuserstable");
    const data = await res.json();

    // Get table body
    const tbody = document.querySelector("#userTable tbody");
    tbody.innerHTML = ""; // Clear existing rows

    if (data.status === "success") {
      // Loop through each user
      data.result.forEach((user, index) => {
        // <-- index added
        // Skip root user
        if (user.role === "root" || user.email === "root@yourdomain.com")
          return;

        // Create table row with Serial Number, Edit & Delete buttons
        const row = `
          <tr>
            <td>${index}</td> <!-- Serial Number -->
                <td>${user.name}</td>
            <td>${user.email}</td>
        
            <td>
              <!-- Edit and Delete Buttons with Font Awesome -->
              <button class="edit-btn btn-neon" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}">
                <i class="fas fa-edit"></i>
              </button>
              <button class="delete-btn btn-neon" data-id="${user.id}">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>
        `;
        tbody.insertAdjacentHTML("beforeend", row);
      });
    } else {
      Swal.fire("⚠️ Error", data.message, "warning"); // Alert if no users found
    }
  } catch (err) {
    console.error("Error:", err);
    Swal.fire("❌ Error", "Failed to fetch users!", "error");
  }
}

const userModal = document.getElementById("userModal");
const userForm = document.getElementById("userForm");
const addUserBtn = document.getElementById("addUserBtn");
const closeModalBtn = document.getElementById("closeModal");
const modalTitle = document.getElementById("modalTitle");
const userIdInput = document.getElementById("userId");
const userNameInput = document.getElementById("userName");
const userEmailInput = document.getElementById("userEmail");
const userPasswordInput = document.getElementById("userPassword");

// Open Add User Modal
addUserBtn.addEventListener("click", () => {
  modalTitle.textContent = "Add User";
  userIdInput.value = "";
  userNameInput.value = "";
  userEmailInput.value = "";
  userPasswordInput.value = "";
  userModal.style.display = "block";
});

// Close Modal
closeModalBtn.addEventListener("click", () => {
  userModal.style.display = "none";
});

// Handle Form Submission
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
      userModal.style.display = "none";
      userForm.reset();
      loadUsers();
    }
  } catch (err) {
    console.error(err);
    Swal.fire("⚠️ Error", "Something went wrong!", "error");
  }
});
// ================================
// EVENT DELEGATION FOR EDIT & DELETE
// ================================
const tbody = document.querySelector("#userTable tbody");

tbody.addEventListener("click", async (e) => {
  const editBtn = e.target.closest(".edit-btn");
  const deleteBtn = e.target.closest(".delete-btn");

  // -------- EDIT USER --------
  if (editBtn) {
    modalTitle.textContent = "Edit User";
    userIdInput.value = editBtn.dataset.id;
    userNameInput.value = editBtn.dataset.name;
    userEmailInput.value = editBtn.dataset.email;
    userPasswordInput.value = "";
    userModal.style.display = "block";
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
        data.status === "success" ? "✅Deleted" : "❌ Error",
        data.message,
        data.status
      );

      loadUsers(); // Reload table after deletion
    }
  }
});

loadUsers();
