<?php
// session_start();
include 'header.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<style>
  .add-user-page {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-color: #151853;
  min-height: 100vh;
  padding: 20px; 
  }

  h1 {
    text-align: center;
    color: #fff;
    margin-bottom: 30px;
    font-size: 2rem;
  }

  table {
    width: 80%;
    margin: 0 auto;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  }

  thead {
    background: blueviolet;
    color: #fff;
  }

  th,
  td {
    padding: 14px 16px;
    text-align: center;
    font-size: 15px;
  }

  tbody tr:nth-child(even) {
    background: #f9f9f9;
  }

  tbody tr:hover {
    background: #eaf4ff;
    transition: 0.2s ease-in-out;
  }

  th {
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  td {
    color: #555;
  }

  button {
    cursor: pointer;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    font-size: 14px;
  }

  .edit-btn,
  .delete-btn {
    background: none;
    color: palevioletred;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    transition: 0.3s;
    box-shadow: 0 0 3px #ff79c6;
  }

  .edit-btn:hover,
  .delete-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 5px #ff79c6, 0 0 11px #ff4db8;
  }


  /* Responsive */
  @media (max-width: 768px) {
    table {
      width: 95%;
      font-size: 14px;
    }

    th,
    td {
      padding: 10px;
    }
  }

  /* Modal Styles */
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
  }

  .modal-content {
    background: #fff;
    width: 400px;
    margin: 100px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    position: relative;
  }

  .modal h2 {
    margin-bottom: 15px;
  }

  .modal input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
  }

  .modal button {
    margin-top: 10px;
  }

  .modal .save-btn {
    background: #28a745;
    color: #fff;
  }

  .modal .cancel-btn {
    background: #dc3545;
    color: #fff;
    margin-left: 10px;
  }
</style>
<div class="add-user-page">
  <h1>User Management</h1>

  <!-- User Table -->
  <table id="userTable">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Rows will be inserted dynamically -->
    </tbody>
  </table>

  <!-- Add User Button -->
  <div style="text-align:center; margin-top:20px;">
    <button id="addUserBtn" style="padding:10px 20px; background:blueviolet; color:#fff; border-radius:6px; font-size:16px;">
      Add User
    </button>
    <button id="logoutBtn" class="btn btn-danger shadow">
      <i class="bi bi-box-arrow-right me-1"></i> Logout
    </button>
  </div>

  <!-- Add/Edit User Modal -->
  <div id="userModal" class="modal">
    <div class="modal-content">
      <h2 id="modalTitle">Add User</h2>
      <form id="userForm">
        <input type="hidden" name="admin_key" value="mySecretKey123">
        <input type="hidden" id="userId" name="id">
        <div>
          <label>Name:</label>
          <input type="text" id="userName" name="name" required>
        </div>
        <div>
          <label>Email:</label>
          <input type="email" id="userEmail" name="email" required>
        </div>
        <div>
          <label>Password:</label>
          <input type="password" id="userPassword" name="password" placeholder="Leave blank to keep current">
        </div>
        <input type="hidden" name="role" value="admin">
        <button type="submit" class="save-btn">Save</button>
        <button type="button" id="closeModal" class="cancel-btn">Cancel</button>
      </form>
    </div>
  </div>

</div>



<script src="../js/login.js"></script>
<script src="../js/users.js"></script>

<?php include 'footer.php'; ?>