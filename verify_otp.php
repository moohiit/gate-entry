<?php
session_start();

// Check if OTP is generated
if (!isset($_SESSION["otp"])) {
  // Redirect to forget password page if OTP is not generated
  header("Location: forget_password.php");
  exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verify OTP
  if ($_POST["otp"] == $_SESSION["otp"]) {
    // OTP verified successfully, redirect to reset password page
    header("Location: resetPassword.php");
    exit;
  } else {
    // Invalid OTP, display error message
    $error = "Invalid OTP, please try again.";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Verify OTP</title>
  <link rel="stylesheet" href="forgotPassword.css">

</head>

<body>
  <form method="post" class="card">
  <h2>Verify OTP</h2>
  <?php if (isset($error)) { ?>
    <p class="error">
      <?php echo $error; ?>
    </p>
  <?php } ?>
    <label>OTP:</label>
    <input type="text" name="otp" required>
    <button type="submit">Verify OTP</button>
  </form>
  <footer>
    <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    <p>Contact us
    <ul>
      <li><a href="https://github.com/moohiit"><i class="fab fa-github"></i> GitHub</a></li>
      <li><a href="https://www.linkedin.com/in/mohit-patel-51338a245"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
      <li><a href="mailto:pmohit645@gmail.com"><i class="far fa-envelope"></i> Email</a></li>
    </ul>
    </p>
  </footer>
</body>

</html>