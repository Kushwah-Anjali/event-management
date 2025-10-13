<!-- jQuery + Select2 (Required Libraries) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  .modal-dialog {
    max-width: 500px;
    margin: 1rem auto;
    display: flex;
    justify-content: center;
    height: auto;
    max-height: 95vh;
  }

  .modal-content {
    border-radius: 15px;
    box-shadow: 0 8px 35px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease;
    background: #ffffff;
    /* white background */
    color: #333;
    /* dark text */
    /* border-radius: 12px; */
    overflow: hidden;
    /* box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
  */
  }

  .modal-content:hover {
    transform: translateY(-2px);
  }

  /* Header */
  .modal-header {
    background: #0d6efd;
    /* bootstrap blue */
    color: #fff;
  }

  .modal-title {
    font-weight: 600;
    font-size: 1.15rem;
  }

  /* Body */
  .modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    max-height: 70vh;
  }

  /* Footer */
  .modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
  }

  /* Step Icons */
  .step-icon {
    width: 45px;
    height: 45px;
    font-size: 1.1rem;
    border-radius: 50%;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
    background: #f8f9fa;
    color: #6c757d;
  }

  .step-icon.active {
    background: #0d6efd;
    color: #fff;
    box-shadow: 0 0 12px rgba(13, 110, 253, 0.5);
  }

  .step-label {
    font-size: 0.7rem;
    color: #6c757d;
  }

  /* Form Elements */
  .form-label {
    font-weight: bold;
    font-size: 0.9rem;
    color: #212529;
    margin-bottom: .5rem !important;
    margin-top: .5rem !important;
  }

  /* Labels with Icons */
  .form-label i {
    color: #0d6efd;
  }

  /* Form Inputs */
  .form-control,
  .form-select {
    padding: 0.5rem 0.75rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    border: 2px solid lightsteelblue;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
  }


  /* Select2 */
  .select2-container--default .select2-selection--single {
    border: 1px solid #ced4da;
    border-radius: 6px;
    height: 38px;
    display: flex;
    align-items: center;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #212529 !important;
    line-height: 36px;
  }

  .select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 6px;
    background: #fff;
  }

  .select2-results__option {
    padding: 8px 12px;
    font-size: 0.9rem;
    color: #212529;
  }

  .select2-results__option--highlighted {
    background: #0d6efd !important;
    color: #fff !important;
  }

  /* Buttons */
  .btn-primary {
    padding: 0.55rem 1.3rem;
    font-weight: 600;
    border-radius: 50px;
  }

  .btn-primary:hover {
    background: #0b5ed7;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
  }

  .btn-success {
    border-radius: 50px;
    padding: 0.55rem 1.3rem;
  }

  .btn-success:hover {
    box-shadow: 0 4px 12px rgba(25, 135, 84, 0.4);
  }

  .btn-secondary {
    background: #6c757d;
    border: none;
    color: #fff;
  }

  .btn-secondary:hover {
    background: #5c636a;
  }

  /* Required field star */
  /* Required Star */
  .required::after {
    content: "*";
    color: #dc3545;
    font-weight: bold;
    margin-left: 2px;
  }

  li.nav-item {
    margin-bottom: 10px;
    margin-right: 10px;
  }

  /* Make Select2 input and dropdown full width */
</style>

<!-- 🌟 Event Modal Form (All Functionality Untouched) -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addEventForm" class="modal-content" method="POST" action="../api/eventApi.php?action=add" enctype="multipart/form-data">

      <!-- 🔷 Modal Header -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="bi bi-calendar-plus me-2"></i> Add New Event
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- 💫 Modal Body -->
      <div class="modal-body">
        <!-- 🌸 Progress Tracker -->
        <div class="text-center mb-3">
          <span id="progressText" class="fw-semibold text-primary">Step 1 of 4</span>
          <div class="progress mt-2" style="height: 6px; border-radius: 5px;">
            <div class="progress-bar bg-primary" id="progressBar" style="width: 25%;"></div>
          </div>
        </div>

        <!-- ✨ Step Tabs -->
        <ul class="nav nav-tabs justify-content-center position-relative mb-4 step-tabs" id="eventTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active step-icon" data-bs-toggle="tab" data-bs-target="#basic" type="button">
              <i class="bi bi-info-circle"></i>
              <div class="step-label">1</div>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link step-icon" data-bs-toggle="tab" data-bs-target="#details" type="button">
              <i class="bi bi-pencil-square"></i>
              <div class="step-label">2</div>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link step-icon" data-bs-toggle="tab" data-bs-target="#image" type="button">
              <i class="bi bi-image"></i>
              <div class="step-label">3</div>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link step-icon" data-bs-toggle="tab" data-bs-target="#doc" type="button">
              <i class="bi bi-file-earmark-text"></i>
              <div class="step-label">4</div>
            </button>
          </li>
        </ul>

        <!-- 🔄 Tab Contents -->
        <div class="tab-content">

          <!-- 📄 Tab 1: Basic Info -->
          <div class="tab-pane fade show active" id="basic" role="tabpanel">
            <input type="hidden" name="event_id" />

            <label class="form-label">
              <i class="fa-solid fa-heading me-1"></i> Event Title <span class="required"></span>
            </label>

            <input name="title" class="form-control" placeholder="Enter title">

            <div>
              <label class="form-label">
                <i class="fa-solid fa-tags me-1"></i> Category <span class="required"></span>
              </label> <select id="categorySelect" name="category" class="form-select">
                <option value="">-- Select Category --</option>
                <?php
                include '/event-management/includes/category.php';
                foreach ($categories as $key => $label): ?>
                  <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">
                <i class="fa-solid fa-align-left me-1"></i> Description
              </label>

              <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
            </div>

            <label class="form-label">
              <i class="fa-solid fa-calendar-days me-1"></i> Date <span class="required"></span>
            </label>

            <input name="date" type="date" class="form-control">
          </div>

          <!-- 📝 Tab 2: Additional Details -->
          <div class="tab-pane fade" id="details" role="tabpanel">

            <label class="form-label">
              <i class="fa-solid fa-user me-1"></i> Author / Organizer <span class="required"></span>
            </label> <input name="author" class="form-control" placeholder="Enter author/organizer">


            <label class="form-label">
              <i class="fa-solid fa-location-dot me-1"></i> Venue <span class="required"></span>
            </label> <input name="venue" class="form-control" placeholder="Enter venue">

            <label class="form-label">
              <i class="fa-solid fa-money-bill-wave me-1"></i> Fees <span class="required"></span>
            </label>
            <input name="fees" class="form-control" placeholder="Enter fees">

            <label class="form-label">
              <i class="fa-solid fa-phone me-1"></i> Contact Number <span class="required"></span>
            </label>
            <input name="contact" class="form-control" placeholder="Enter contact number">
          </div>

          <!-- 📷 Tab 3: Image Upload -->
          <div class="tab-pane fade" id="image" role="tabpanel">

            <label class="form-label">
              <i class="fa-solid fa-image me-1"></i> Select an image <span class="required"></span>
            </label> <input type="file" name="image" class="form-control">
            <!-- Preview of existing image -->
  <div class="mt-2">
    <img id="currentImagePreview" src="" alt="Current Image" width="120" style="border:1px solid #ccc; padding:2px; display:none;">
  </div>
          </div>

          <!-- 📎 Tab 4: Attach Documents -->
          <div class="tab-pane fade" id="doc" role="tabpanel">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="required_docs[]" value="Aadhar_card" id="docAadhar">
              <label class="form-check-label" for="docAadhar">Aadhar Card</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="required_docs[]" value="resume" id="docResume">
              <label class="form-check-label" for="docResume">Resume</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="required_docs[]" value="Marksheet" id="docMarksheet">
              <label class="form-check-label" for="docMarksheet">Marksheet</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="required_docs[]" value="photho" id="docPhoto">
              <label class="form-check-label" for="docPhoto">Photo</label>
            </div>
          </div>

        </div>
      </div>

      <!-- ✅ Modal Footer -->
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary rounded-pill" id="prevBtn" style="display: none;">
          <i class="bi bi-arrow-left-circle me-1"></i> Previous
        </button>

        <div class="ms-auto">
          <button type="button" class="btn btn-primary rounded-pill" id="nextBtn">
            Next <i class="bi bi-arrow-right-circle ms-1"></i>
          </button>


          <button type="submit" class="btn btn-success rounded-pill d-none" id="submitBtn">
            <i class="bi bi-plus-circle me-1"></i> Add Event
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Select2 Activation Script (Modal-safe) -->
<script>
$(document).ready(function() {

  // ====================== Setup ======================
  const tabIds = ['#basic', '#details', '#image', '#doc'];
  const totalSteps = tabIds.length;
  let currentStep = 0;
  let modalMode = 'add'; // default is Add mode

  // Activate Select2
  $('#categorySelect').select2({
    dropdownParent: $('#addEventModal'),
    width: '100%'
  });

  // ====================== Step Validation ======================
  function validateStep(step) {
    let isValid = true;
    let errorMsg = "";

    if (step === 0) { // Basic Info
      const title = $('input[name="title"]').val().trim();
      const category = $('#categorySelect').val();
      const date = $('input[name="date"]').val();
      if (!title) { errorMsg = "Please enter event title"; isValid = false; }
      else if (!category) { errorMsg = "Please select a category"; isValid = false; }
      else if (!date) { errorMsg = "Please select a date"; isValid = false; }

    } else if (step === 1) { // Details
      const author = $('input[name="author"]').val().trim();
      const venue = $('input[name="venue"]').val().trim();
      const fees = $('input[name="fees"]').val().trim();
      const contact = $('input[name="contact"]').val().trim();

      if (!author) { errorMsg = "Author/Organizer is required"; isValid = false; }
      else if (!venue) { errorMsg = "Venue is required"; isValid = false; }
      else if (!fees || isNaN(fees)) { errorMsg = "Fees must be a number"; isValid = false; }
      else if (!/^\d{10}$/.test(contact)) { errorMsg = "Contact must be 10 digits"; isValid = false; }

    } else if (step === 2) { // Image
      const image = $('input[name="image"]').val();
      if (modalMode === 'add' && !image) { // image required only on Add
        errorMsg = "Please upload an image";
        isValid = false;
      }
    }

    if (!isValid) {
      Swal.fire({ icon: "error", title: "Validation Error", text: errorMsg, confirmButtonColor: "#0d6efd" });
    }

    return isValid;
  }

  // ====================== Step Navigation ======================
  function updateStep() {
    const currentTabId = tabIds[currentStep];
    $('.tab-pane').removeClass('show active');
    $('.step-icon').removeClass('active');
    $(`.nav-link[data-bs-target="${currentTabId}"]`).addClass('active');
    $(currentTabId).addClass('show active');

    $('#prevBtn').toggle(currentStep > 0);
    if (currentStep < totalSteps - 1) {
      $('#nextBtn').show();
      $('#submitBtn').hide();
    } else {
      $('#nextBtn').hide();
      $('#submitBtn').show().removeClass('d-none');
    }

    const progressPercent = ((currentStep + 1) / totalSteps) * 100;
    $('#progressText').text(`Step ${currentStep + 1} of ${totalSteps}`);
    $('#progressBar').css('width', `${progressPercent}%`);
  }

  $('#nextBtn').off("click").on("click", function() {
    if (validateStep(currentStep)) {
      if (currentStep < totalSteps - 1) { currentStep++; updateStep(); }
    }
  });

  $('#prevBtn').click(function() {
    if (currentStep > 0) { currentStep--; updateStep(); }
  });

  // ====================== Add Button ======================
  $('#openAddEvent').click(function() {
    modalMode = 'add';
    currentStep = 0;
    updateStep();

    const form = $('#addEventForm')[0];
    form.reset();
    $('#categorySelect').val('').trigger('change');
    $('#addEventModal .modal-title').html(`<i class="bi bi-calendar-plus me-2"></i> Add New Event`);
    $('#submitBtn').html(`<i class="bi bi-plus-circle me-1"></i> Add Event`);
  });

  // ====================== Update Button ======================
  $(document).on('click', '.update-btn', function() {
    modalMode = 'update';
    const id = $(this).data('id');
    const event = window.events.find(ev => ev.id == id); // make sure events array is global

    if (!event) return;

    const form = $('#addEventForm')[0];
    form.reset();

    form.action = `../api/eventApi.php?action=update&id=${id}`;
    form.querySelector("[name='event_id']").value = id;
    form.querySelector("[name='title']").value = event.title || "";
    $('#categorySelect').val(event.category).trigger('change');
    form.querySelector("[name='description']").value = event.description || "";
    form.querySelector("[name='date']").value = event.date || "";
    form.querySelector("[name='author']").value = event.author || "";
    form.querySelector("[name='venue']").value = event.venue || "";
    form.querySelector("[name='fees']").value = event.fees || "";
    form.querySelector("[name='contact']").value = event.contact || "";

    // Required documents
    form.querySelectorAll("input[name='required_docs[]']").forEach(chk => chk.checked = false);
    if(event.required_documents) {
      try {
        const docs = JSON.parse(event.required_documents);
        form.querySelectorAll("input[name='required_docs[]']").forEach(chk => {
          if(docs.includes(chk.value)) chk.checked = true;
        });
      } catch {}
    }

    $('#addEventModal .modal-title').html(`<i class="bi bi-pencil-square me-2"></i> Update Event`);
    $('#submitBtn').html(`<i class="bi bi-save me-1"></i> Update Event`);

    new bootstrap.Modal(document.getElementById("addEventModal")).show();
  });

  // ====================== Form Submit ======================
  $('#addEventForm').on('submit', function(e) {
    if (!validateStep(currentStep)) {
      e.preventDefault();
      return;
    }
  });

  // ====================== Modal Show ======================
  $('#addEventModal').on('show.bs.modal', function() {
    if(modalMode === 'add') {
      currentStep = 0;
      updateStep();
    }
  });

});
</script>
