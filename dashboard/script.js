// Add this code at the end of your existing script.js file
const toggleBtn = document.querySelector(".sidebar header .toggle");
const sidebar = document.querySelector(".sidebar");

const addCloseClassOnce = () => {
  sidebar.classList.add("close");
  toggleBtn.removeEventListener("click", addCloseClassOnce);
};

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

// Check if the initial screen width is less than or equal to a certain breakpoint (e.g., 768 pixels)
if (window.innerWidth <= 768) {
  addCloseClassOnce();
}

// Add a resize event listener to handle changes in screen width
window.addEventListener("resize", () => {
  // Check if the current screen width is less than or equal to the breakpoint
  if (window.innerWidth <= 768) {
    // Add the "close" class only once
    addCloseClassOnce();
  } else {
    // Remove the "close" class when the screen size is larger than the breakpoint
    sidebar.classList.remove("close");
  }
});
