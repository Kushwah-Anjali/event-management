document.getElementById("contactForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("../api/eventApi.php?action=sendMessage", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "Message Sent!",
          text: "We’ll get back to you soon.",
          confirmButtonColor: "#3085d6",
        });
        document.getElementById("contactForm").reset();
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: data.error || "Something went wrong. Please try again.",
        });
      }
    })
    .catch(() => {
      Swal.fire({
        icon: "error",
        title: "Server Error",
        text: "Unable to send message right now.",
      });
    });
});
