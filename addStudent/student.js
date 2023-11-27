document.addEventListener('DOMContentLoaded', (event) => {
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const captureButton = document.getElementById('captureButton');
  const cameraPhotoInput = document.getElementById('cameraPhotoInput');
  const filePhotoInput = document.getElementById('filePhoto');
  
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(stream) {
        video.srcObject = stream;
      })
      .catch(function(error) {
        console.error('Error accessing webcam:', error);
      });

    captureButton.addEventListener('click', function() {
      canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
      const imageData = canvas.toDataURL('image/jpeg');
      cameraPhotoInput.value = imageData;
      alert('Photo captured!');
    });
  } else {
    console.error('Webcam not supported on this browser.');
  }

  filePhotoInput.addEventListener('change', function() {
    const fileInput = this;
    const file = fileInput.files[0];
    
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const imageData = e.target.result;
        cameraPhotoInput.value = imageData;
        alert('File photo selected!');
      };
      reader.readAsDataURL(file);
    }
  });
});
