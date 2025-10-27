<!-- 🌌 FOOTER -->
<footer class="footer text-light py-5 position-relative">
  <div class="container">
    <div class="row gy-5 text-center text-md-start">
      
      <!-- Explore -->
      <div class="col-12 col-md-4">
        <h5 class="fw-semibold mb-4">Explore</h5>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="/index.php" class="footer-link"><i class="fa-solid fa-house me-2"></i>Home</a></li>
          <li><a href="/includes/contact.php" class="footer-link"><i class="fa-solid fa-phone me-2"></i>Contact</a></li>
        </ul>
      </div>

      <!-- Quick Info -->
      <div class="col-12 col-md-4">
        <h5 class="fw-semibold mb-4">Quick Info</h5>
        <ul class="list-unstyled d-flex flex-column gap-2">
          <li><a href="#" class="footer-link"><i class="fa-solid fa-file-contract me-2"></i>Terms</a></li>
          <li><a href="#" class="footer-link"><i class="fa-solid fa-user-shield me-2"></i>Privacy</a></li>
          <li><a href="/includes/contact.php" class="footer-link"><i class="fa-solid fa-circle-question me-2"></i>Help Center</a></li>
        </ul>
      </div>

      <!-- Social -->
      <div class="col-12 col-md-4">
        <h5 class="fw-semibold mb-4">Stay Connected</h5>
        <div class="d-flex justify-content-center justify-content-md-start gap-3 flex-wrap">
          <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>

    <hr class="border-light opacity-25 mt-5">

    <div class="text-center small text-secondary mt-3">
      © 2025 <span class="text-gradient fw-semibold">Eventify</span>.
      Made with <span class="heart">❤</span> by <strong>Anjali</strong>
    </div>
  </div>

  <!-- 🔝 Back to Top -->
  <button id="backToTop" class="btn btn-gradient rounded-circle shadow">
    <i class="fa-solid fa-arrow-up"></i>
  </button>

  <!-- 🌐 Floating Social Buttons -->
  <div class="social-floating">
    <a href="https://facebook.com" target="_blank" class="social-btn fb"><i class="fab fa-facebook-f"></i></a>
    <a href="https://instagram.com" target="_blank" class="social-btn insta"><i class="fab fa-instagram"></i></a>
    <a href="https://linkedin.com" target="_blank" class="social-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://wa.me/1234567890" target="_blank" class="social-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
  </div>
</footer>

<script>
  const backToTop = document.getElementById("backToTop");
  window.addEventListener("scroll", () => {
    backToTop.style.opacity = window.scrollY > 200 ? "1" : "0";
  });
  backToTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
</script>

<style>
/* 🌌 FOOTER BASE */
.footer {
  background: linear-gradient(135deg, #0a0a2a, #111343, #1e1149);
  font-size: 0.95rem;
}

/* 🌈 LINKS */
.footer-link {
  color: #abadaf;
  text-decoration: none;
  transition: 0.3s ease;
  display: inline-flex;
  align-items: center;
}
.footer-link:hover {
  color: #fff;
  transform: translateX(4px);
}

/* ✨ TEXT EFFECT */
.text-gradient {
  background: linear-gradient(90deg, #ec4899, #8b5cf6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* 💬 SOCIAL ICONS */
.social-icon {
  background-color: rgba(255, 255, 255, 0.1);
  padding: 10px;
  border-radius: 50%;
  color: #fff;
  transition: 0.3s ease;
}
.social-icon:hover {
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  transform: scale(1.1);
}

/* 🚀 BACK TO TOP */
.btn-gradient {
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  color: #fff;
  width: 45px;
  height: 45px;
  border: none;
  position: fixed;
  bottom: 25px;
  left: 25px;
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  transition: all 0.4s ease;
  z-index: 1000;
}
.btn-gradient:hover {
  transform: scale(1.1);
}

/* 🌐 FLOATING BUTTONS */
.social-floating {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  z-index: 2000;
}
.social-btn {
  width: 45px;
  height: 45px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  color: #fff;
  transition: 0.3s;
}
.fb { background: #1877f2; }
.insta { background: #e4405f; }
.linkedin { background: #0077b5; }
.whatsapp { background: #25d366; }

/* 📱 RESPONSIVE */
@media (max-width: 768px) {
  .footer h5 {
    margin-top: 1rem;
  }
  .social-floating {
    right: 10px;
    bottom: 10px;
  }
  .btn-gradient {
    left: 10px;
    bottom: 10px;
  }
}
</style>
