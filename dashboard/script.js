
// Add this code at the end of your existing script.js file
const toggleBtn = document.querySelector(".sidebar header .toggle");
const sidebar = document.querySelector(".sidebar");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

// Add this script in your existing script.js file or create a new one
$(document).ready(function () {
  $(".bx-menu-alt-left").click(function () {
    $(".mobile-sidebar").toggleClass("open");
  });

  $(".close-icon").click(function () {
    $(".mobile-sidebar").removeClass("open");
  });
});
