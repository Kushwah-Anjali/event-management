<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/register.css" />
  <title>Register for Event</title>
</head>

<body>
  <!-- 🌟 Registration Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="registerForm" class="modal-content p-2 rounded-3 shadow" method="POST" action="api/eventApi.php?action=register" enctype="multipart/form-data" novalidate>

        <!-- 🔒 Hidden: Event ID -->
        <input type="hidden" name="event_id" id="modalEventId" value="<?= $event_id ?>" />

        <!-- 💙 Modal Header -->
        <div class="modal-header bg-primary text-white rounded-top">
          <h5 class="modal-title">
            <i class="bi bi-calendar-plus me-2"></i> Register here
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- 💬 Modal Body -->
        <div class="modal-body">
          <!-- 🧾 Already Registered Message -->
          <div id="alreadyRegisteredMessage" class="d-none mb-3">
            <div class="p-3 border border-success rounded-3 bg-white shadow-sm">
              <div class="d-flex align-items-center text-success mb-2">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <h6 class="mb-0">You are already registered with this email.</h6>
              </div>
              <hr class="my-2" />
              <p class="mb-1"><strong>Name:</strong> <span id="displayName" class="text-dark"></span></p>
              <p class="mb-0"><strong>Email:</strong> <span id="displayEmail" class="text-dark"></span></p>
            </div>
          </div>

          <!-- 📧 Email Input -->
         <div id="emailInputWrapper" class="mb-3">
  <label for="emailInput" class="form-label">
    <i class="fa-regular fa-envelope me-1 text-primary"></i>Email
  </label>
  <input type="email" class="form-control" placeholder="Enter your Email" id="emailInput" name="email" required />
</div>

<!-- 👩‍💼 Name Input -->
<div id="nameInputWrapper" class="mb-3 d-none">
  <label for="nameInput" class="form-label">
    <i class="fa-regular fa-user me-2 text-primary"></i> Name
  </label>
  <input type="text" class="form-control" id="nameInput" name="name" required />
</div>

        </div>
        <!-- ⬇️ Below name input -->
        <div id="uploadFieldsContainer" class="mb-3 d-none">
          <!-- file fields will be added here by JS -->
          <input type="hidden" id="requiredDocsJson" value="" />
        </div>

        <!-- 📩 Modal Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>

      </form>
    </div>
  </div>
</body>

</html>