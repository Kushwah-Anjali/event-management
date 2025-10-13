document.addEventListener("DOMContentLoaded", () => {
  // --- Fallback Notification Helper ---
  function notify({ icon = "info", title = "", text = "", timer = null }) {
    if (window.Swal && typeof Swal.fire === "function") {
      const opts = { icon, title, text };
      if (timer) {
        opts.timer = timer;
        opts.showConfirmButton = false;
      }
      return Swal.fire(opts);
    } else {
      alert((title ? title + ": " : "") + text);
      return Promise.resolve();
    }
  }

  // --- LOGIN HANDLER ---
 const form = document.getElementById("loginForm");

if (form) {
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("../api/eventApi.php?action=login", {
      method: "POST",
      body: formData,
      credentials: "same-origin",
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success" && data.result) {
          notify({
            icon: "success",
            title: "Login Successful",
            text: data.message || "Welcome!",
            timer: 1500,
          }).then(() => {
            // Clear form after successful login
            form.reset();

            // Role-based redirect
            if (data.result.role === "root") {
              window.location.href = "../includes/users.php";
            } else {
              window.location.href = "../includes/usersEvents.php";
            }
          });
        } else {
          notify({
            icon: "error",
            title: "Login Failed",
            text: data.message || "Invalid credentials",
          });
        }
      })
      .catch((err) => {
        console.error("Login error:", err);
        notify({
          icon: "error",
          title: "Error",
          text: "Something went wrong. Please try again.",
        });
      });
  });
}

  // --- LOGOUT HANDLER ---
  const logoutBtn = document.getElementById("logoutBtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
      fetch("../api/eventApi.php?action=logout", {
        method: "POST",
        credentials: "same-origin",
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            window.location.href = "../includes/login.php";
          } else {
            notify({
              icon: "error",
              title: "Logout Failed",
              text: data.message || "Unable to logout",
            });
          }
        })
        .catch((err) => {
          console.error("Logout error:", err);
          notify({
            icon: "error",
            title: "Error",
            text: "Something went wrong. Please try again.",
          });
        });
    });
  }
});
