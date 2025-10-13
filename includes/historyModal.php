<div class="modal fade" id="pastHistoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-primary">

      <!-- Header -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="bi bi-clock-history me-2"></i> Add Past Event History
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form id="historyForm" enctype="multipart/form-data" method="POST" action="../api/eventApi.php?action=saveOrUpdateEventHistory">

          <!-- Hidden Event ID -->
          <input type="hidden" name="event_id" id="historyEventId">

          <!-- Event Info (readonly) -->
          <div class="alert alert-primary py-2">
            <strong id="historyEventTitle"></strong>
            (<span id="historyEventDate"></span>)
          </div>
          <!-- inside your modal body, below the title/date alert -->
          <div id="historyEventExtra" class="mb-3 small text-muted"></div>

          <!-- Summary -->
          <div class="mb-3">
            <label class="form-label">Event Summary <span class="text-danger">*</span></label>
            <textarea name="summary" class="form-control border-primary" rows="3" required></textarea>
          </div>
          <!-- Existing Photos -->
          <div id="existingPhotos" class="mb-2 d-flex flex-wrap"></div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Upload Photos</label>
            <input type="file" name="photos[]" class="form-control border-primary" multiple>
          </div>

          <div id="existingVideos" class="mb-2 d-flex flex-wrap"></div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Upload Videos</label>
            <input type="file" name="videos[]" class="form-control border-primary" multiple>
          </div>



          <!-- Success Highlights -->
          <div class="mb-3">
            <label class="form-label">Success Highlights</label>
            <textarea name="highlights" class="form-control border-primary" rows="2"></textarea>
          </div>

          <!-- Stats -->
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Total Attendees</label>
              <input type="number" name="attendees" class="form-control border-primary" min="0">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Speakers/Guests</label>
              <input type="text" name="guests" class="form-control border-primary">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Budget Used (₹)</label>
              <input type="number" name="budget" class="form-control border-primary" step="0.01" min="0">
            </div>
          </div>

          <!-- Lessons Learned -->
          <div class="mb-3">
            <label class="form-label">Lessons Learned</label>
            <textarea name="lessons" class="form-control border-primary" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">long summary</label>
            <textarea name="long_summary" class="form-control border-primary" rows="5"></textarea>
          </div>

          <!-- Submit -->
          <div class="text-end">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-upload me-2"></i> Save History
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<script>
  // Preview newly selected photos and videos in the modal
const historyForm = document.getElementById('historyForm');
const photosInput = historyForm.querySelector('input[name="photos[]"]');
const videosInput = historyForm.querySelector('input[name="videos[]"]');
const existingPhotos = document.getElementById('existingPhotos');
const existingVideos = document.getElementById('existingVideos');

// Utility to clear and show previews
function previewFiles(input, container, type) {
    container.innerHTML = ''; // Clear previous previews

    for (let file of input.files) {
        if (type === 'photo') {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'img-thumbnail me-2 mb-2';
            img.style.height = '80px';
            container.appendChild(img);
        } else if (type === 'video') {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.className = 'me-2 mb-2';
            video.style.height = '80px';
            container.appendChild(video);
        }
    }
}

// Event listeners for file selection
photosInput.addEventListener('change', () => previewFiles(photosInput, existingPhotos, 'photo'));
videosInput.addEventListener('change', () => previewFiles(videosInput, existingVideos, 'video'));

</script>