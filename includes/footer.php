
<!-- 🌌 FOOTER -->
<footer class="custom-footer">
  <div class="footer-container">
    
    <!-- Explore -->
    <div class="footer-column">
      <h4>Explore</h4>
      <ul>
        <li><a href="/index.php"><i class="fa-solid fa-house"></i> Home</a></li>
         <!-- <li><a href="#"><i class="fa-solid fa-calendar-days"></i> Events</a></li> -->
        <li><a href="/includes/contact.php"><i class="fa-solid fa-phone"></i> Contact</a></li>
      </ul>
    </div>

    <!-- Quick Info -->
    <div class="footer-column">
      <h4>Quick Info</h4>
      <ul>
        <li><a href="#"><i class="fa-solid fa-file-contract"></i> Terms</a></li>
        <li><a href="#"><i class="fa-solid fa-user-shield"></i> Privacy</a></li>
        <li><a href="/includes/contact.php"><i class="fa-solid fa-circle-question"></i> Help Center</a></li>
        
      </ul>
    </div>

    <!-- Social -->
    <div class="footer-column social-column">
      <h4>Stay Connected</h4>
      <div class="social-icons">
        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

  </div>

  <!-- Footer Bottom -->
 

  <div class="footer-bottom">
    <p>© 2025 <span>Eventify</span>. Made with <span class="heart">❤</span> by <strong>Anjali</strong></p>
  </div>
  
</footer>
  <!-- 🔝 Back to Top Button -->
<div id="backToTop" title="Back to Top">
  <i class="fa-solid fa-arrow-up"></i>
</div>
<!-- Floating Social Media Buttons -->
<div class="social-floating">
  <a href="https://facebook.com" target="_blank" class="social-btn fb"><i class="fab fa-facebook-f"></i></a>
  <a href="https://instagram.com" target="_blank" class="social-btn insta"><i class="fab fa-instagram"></i></a>
  <a href="https://linkedin.com" target="_blank" class="social-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
  <a href="https://wa.me/1234567890" target="_blank" class="social-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
</div>

<script>
  const backToTop = document.getElementById("backToTop");

  // Show button after scrolling down
  window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
      backToTop.classList.add("show");
    } else {
      backToTop.classList.remove("show");
    }
  });

  // Smooth scroll to top
  backToTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
</script>

</body>

</html>
