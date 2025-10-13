<?php include 'header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../css/contact.css">

<section id="contact" class="contact-section">
  <div class="container">
    <h2 class="section-title">📩 Get in Touch</h2>
    <p class="section-subtitle">We’d love to hear from you. Drop us a message or find us at our office!</p>

    <div class="contact-wrapper">
      <!-- Contact Form -->
      <form id="contactForm" class="contact-form shadow-sm">
        <div class="form-group">
          <label for="name" class="form-label required">
            <i class="fas fa-user text-muted"></i> Full Name
          </label>
          <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" required>
        </div>

        <div class="form-group">
          <label for="email" class="form-label required">
            <i class="fas fa-envelope text-muted"></i> Email Address
          </label>
          <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required>
        </div>

        <div class="form-group">
          <label for="message" class="form-label required">
            <i class="fas fa-comment-dots text-muted"></i> Message
          </label>
          <textarea id="message" name="message" rows="5" class="form-control" placeholder="Write your message here..." required></textarea>
        </div>

        <button type="submit" class="btn-submit w-100">
          <i class="fas fa-paper-plane me-2"></i> Send Message
        </button>
      </form>

      <!-- Contact Info -->
      <div class="contact-info shadow-sm">
        <h3><i class="fas fa-map-marker-alt me-2 text-muted"></i> Our Office</h3>
        <p>123 Event Street, Mumbai, India</p>

        <h3><i class="fas fa-phone-alt me-2 text-muted"></i> Phone</h3>
        <p>+91 98765 43210</p>

        <h3><i class="fas fa-envelope-open-text me-2 text-muted"></i> Email</h3>
        <p>support@eventmanager.com</p>

        <!-- Google Map -->
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.11610093658!2d72.7410997924083!3d19.082197839262697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b63fef0f2b9b%3A0x3bcf3f9f6e7b45bb!2sMumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1691311234567"
            width="100%" height="220" style="border:0;" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="../js/contact.js"></script>
<?php include 'footer.php'; ?>
