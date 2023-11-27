<?php
// Start session
session_start();
// Connect to the database
include '../database.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
  if (isset($_FILES["image"])) {
    // ImgBB API endpoint
    $imgbbApiUrl = "https://api.imgbb.com/1/upload";

    // Set your ImgBB API key
    $apiKey = "1ada3b3c96d91d229518a4bb06c14452";

    // File details
    $fileName = $_FILES["image"]["name"];
    $fileTempName = $_FILES["image"]["tmp_name"];

    // Create a unique name for the image to avoid overwriting
    $uniqueName = uniqid("image_") . "_" . $fileName;

    // Prepare the cURL request to ImgBB API
    $imgbbRequest = curl_init($imgbbApiUrl);
    $imgbbImageData = [
      'key' => $apiKey,
      'image' => base64_encode(file_get_contents($fileTempName)),
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
        //header to success
        header("Location: success.php");
        exit();
      } else {
        $_SESSION['status'] = "Error saving data in the database: " . $conn->error . " (Query: $sql)";
        header("Location: addStudent.php");
      }
    } else {
      $_SESSION['status'] = "Error uploading image to ImgBB. HTTP Status: $imgbbHttpStatus";
      header("Location: addStudent.php");
    }

    // Close the database connection
    $conn->close();
    exit();
  } else {
    $_SESSION['status'] = "Please select an image to upload.";
    header("Location: addStudent.php");
  }
}
?>