<!-- 🌸 Document Upload Modal -->
<style>
  /* 🌟 Modal Content */
  #documentUploadModal .modal-content {
    border-radius: 1.25rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    animation: fadeInUp 0.5s ease;
  }

  /* 🌈 Modal Header Gradient */
  #documentUploadModal .modal-header {
    background: linear-gradient(90deg, #ec4899, #8b5cf6);
    color: #fff;
    border: none;
    padding: 16px 20px;
  }

  #documentUploadModal .modal-title {
    font-size: 1.25rem;
    font-weight: 600;
  }

  /* 📋 Document checklist items */
  .doc-item {
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 12px 16px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255, 255, 255, 0.06);
    transition: all 0.25s ease;
  }

  .doc-item:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }

  /* 📂 File input styling */
  .doc-item input[type="file"] {
    flex: 1;
    font-size: 0.9rem;
    color: #ddd;
  }

  .doc-item input[type="file"]::-webkit-file-upload-button {
    background: linear-gradient(90deg, #ec4899, #8b5cf6);
    border: none;
    color: #fff;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s ease;
  }

  .doc-item input[type="file"]::-webkit-file-upload-button:hover {
    background: linear-gradient(90deg, #8b5cf6, #ec4899);
  }

  /* 🚀 Footer Buttons */
  #documentUploadModal .modal-footer {
    border: none;
    padding: 16px 20px;
  }

  #documentUploadModal .btn {
    border-radius: 0.75rem;
    font-weight: 500;
    transition: all 0.25s ease;
  }

  #documentUploadModal .btn-primary {
    background: linear-gradient(90deg, #ec4899, #8b5cf6);
    border: none;
    color: #fff;
  }

  #documentUploadModal .btn-primary:hover {
    background: linear-gradient(90deg, #8b5cf6, #ec4899);
    transform: translateY(-2px);
    box-shadow: 0 0 12px rgba(236, 72, 153, 0.8);
  }

  #documentUploadModal .btn-outline-secondary {
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #fff;
  }

  #documentUploadModal .btn-outline-secondary:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
  }

  /* ✨ Fade In Animation */
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
          <h5 class="modal-title fw-bold" id="documentUploadLabel">
            📑 Upload Required Documents
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div  class="modal-body">
          <div id="documentChecklistContainer" class="row g-3">
            <!-- ✅ Dynamic checklist items will be injected here -->
          </div>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="event_id" id="uploadEventId">
        <input type="hidden" name="email" id="uploadEmail">

        <!-- Modal Footer -->
        <div class="modal-footer d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-outline-secondary btn-danger px-4" data-bs-dismiss="modal">
            ❌ Cancel
          </button>
          <button type="submit" class="btn btn-primary px-4">
            🚀 Upload
          </button>
        </div>
      </form>
      <!-- Form End -->

    </div>
  </div>
</div>