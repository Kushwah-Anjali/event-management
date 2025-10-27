<!-- 🌸 Document Upload Modal -->
<style>
  #documentUploadModal .modal-content {
    border-radius: 1rem;
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.4);
    animation: fadeInUp 0.5s ease;
  }

  #documentUploadModal .modal-header {
    background: linear-gradient(90deg, #ec4899, #8b5cf6);
    color: #fff;
    border: none;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(15px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<div class="modal fade" id="documentUploadModal" tabindex="-1" aria-labelledby="documentUploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Form Start -->
      <form id="documentUploadForm" enctype="multipart/form-data" method="POST">

        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title fw-semibold">
            📑 Upload Required Documents
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle text-center table-borderless" id="documentChecklistContainer">
              <thead class="table-light">
                <tr>
                  <th scope="col" class="text-start">Document Name</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- ✅ Dynamic checklist rows will be injected here by JS -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="event_id" id="uploadEventId">
        <input type="hidden" name="email" id="uploadEmail">

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
            ❌ Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            🚀 Upload
          </button>
        </div>
      </form>
      <!-- Form End -->

    </div>
  </div>
</div>
