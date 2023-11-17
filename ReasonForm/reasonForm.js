document.addEventListener("DOMContentLoaded", function() {
  const photoInput = document.getElementById("photo");
  const capturedPhoto = document.getElementById("captured-photo");
  const captureButton = document.getElementById("capture-button");

  // Function to handle photo capture from camera
  captureButton.addEventListener("click", function() {
    if (photoInput) {
      photoInput.click();
    }
  });

  // Function to display the captured photo
  photoInput.addEventListener("change", function() {
    const file = photoInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        capturedPhoto.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
});
