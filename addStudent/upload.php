<?php
// Include the database connection file
include '../database.php';
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../index.php");
  exit();
}

if (isset($_POST["submit"])) {
  // Check if the resized image data is received from the client-side JavaScript
  if (isset($_POST["resizedImageData"])) {
    // ImgBB API endpoint
    $imgbbApiUrl = "https://api.imgbb.com/1/upload";

    // Set your ImgBB API key
    $apiKey = "1ada3b3c96d91d229518a4bb06c14452";

    // Get the received resized image data
    $resizedImageData = $_POST["resizedImageData"];

    // Convert the base64 image data to binary
    $binaryImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $resizedImageData));

    // Create a unique name for the image to avoid overwriting
    $uniqueName = uniqid("image_") . ".jpeg"; // Assuming you want JPEG format

    // Prepare the cURL request to ImgBB API
    $imgbbRequest = curl_init($imgbbApiUrl);
    $imgbbImageData = [
      'key' => $apiKey,
      'image' => base64_encode($binaryImageData),
      'name' => $uniqueName,
    ];
    curl_setopt($imgbbRequest, CURLOPT_POST, 1);
    curl_setopt($imgbbRequest, CURLOPT_POSTFIELDS, $imgbbImageData);
    curl_setopt($imgbbRequest, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($imgbbRequest, CURLOPT_FAILONERROR, true);

    // Execute cURL request
    $imgbbResult = curl_exec($imgbbRequest);
    $imgbbHttpStatus = curl_getinfo($imgbbRequest, CURLINFO_HTTP_CODE);
    curl_close($imgbbRequest);

    // Decode the JSON response
    $imgbbResponse = json_decode($imgbbResult, true);

    // Check if the upload was successful
    if ($imgbbHttpStatus == 200 && isset($imgbbResponse['data']['url'])) {
      $imageUrl = $imgbbResponse['data']['url'];

      // Assuming you have form fields for name, department, year, and mobile
      $name = $_POST['name'];
      $department = $_POST['dprt'];
      $year = $_POST['year'];
      $mobile = $_POST['mobile'];

      // SQL query to insert data into the "student" table
      $sql = "INSERT INTO student (name, department, year, conumber, photo_url) VALUES ('$name', '$department', '$year', '$mobile', '$imageUrl')";

      // Execute the query
      $queryResult = $conn->query($sql);
      if ($queryResult === TRUE) {
        $_SESSION['success'] = "Image uploaded successfully and data saved in the database.";
        // Redirect to success page or handle as needed
        header("Location: success.php");
        exit();
      } else {
        $_SESSION['status'] = "Error saving data in the database: " . $conn->error . " (Query: $sql)";
        // Redirect to addStudent page with an error message
        header("Location: addStudent.php");
        exit();
      }
    } else {
      $_SESSION['status'] = "Error uploading image to ImgBB. HTTP Status: $imgbbHttpStatus";
      // Redirect to addStudent page with an error message
      header("Location: addStudent.php");
      exit();
    }
  } else {
    // This block is executed when the form is submitted without using JavaScript
    $_SESSION['status'] = "Please select an image to upload.";
    // Redirect to addStudent page with an error message
    header("Location: addStudent.php");
    exit();
  }
}
?>