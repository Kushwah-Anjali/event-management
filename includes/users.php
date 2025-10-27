<?php
include 'header.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<div class="container-fluid  min-vh-100 py-5">
  <div class="container">
    <h1 class="text-center mb-5 fw-bold">User Management</h1>

    <!-- User Table Card -->
    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle text-center mb-0">
          <thead class="table-primary">
            <tr>
              <th scope="col">S.No</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody id="userTableBody">
            <!-- Dynamic Rows -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Buttons -->
    <div class="text-center mt-4">
      <button id="addUserBtn" class="btn btn-primary px-4 me-2">
        <i class="bi bi-person-plus-fill me-1"></i> Add User
      </button>
      <button id="logoutBtn" class="btn btn-danger px-4">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </button>
    </div>
  </div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title fw-semibold" id="userModalLabel">Add User</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="userForm" class="p-3">
        <input type="hidden" name="admin_key" value="mySecretKey123">
        <input type="hidden" id="userId" name="id">
        <input type="hidden" name="role" value="admin">

        <div class="mb-3">
          <label class="form-label fw-semibold">Name</label>
          <input type="text" id="userName" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input type="email" id="userEmail" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Password</label>
          <input type="password" id="userPassword" name="password" class="form-control" placeholder="Leave blank to keep current">
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-success px-4 me-2">
            <i class="bi bi-check-circle me-1"></i> Save
          </button>
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/login.js"></script>
<script src="../js/users.js"></script>

<?php include 'footer.php'; ?>
