<?php
session_start();

// Check if OTP is verified
if (!isset($_SESSION["otp"]) || !isset($_SESSION["email"])) {
  // Redirect to forget password page if OTP or email is not verified
  header("Location: forget_password.php");
  exit;
}

// Include database connection file
include_once ("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve new password from the form
  $new_password = $_POST["new_password"];

  // // Hash the new password
  // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

  // Retrieve email from session
  $email = $_SESSION["email"];

  // Update password in the database
  $sql = "UPDATE users SET password='$new_password' WHERE username='$email'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    // Password updated successfully, redirect to password reset successful page
    header("Location: password_reset_success.php");
    exit;
  } else {
    // Error updating password
    $error = "Error updating password. Please try again.";
  }
  // Clear session variables
  unset($_SESSION["otp"]);
  unset($_SESSION["email"]);
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Reset Password</title>
  <link rel="stylesheet" href="forgotPassword.css">
</head>

<body>
  <form method="post" class="card">
  <h2>Reset Password</h2>
  <?php if (isset($error)) { ?>
    <p>
      <?php echo $error; ?>
    </p>
  <?php } ?>
    <label>New Password:</label>
    <input type="password" name="new_password" required>
    <button type="submit">Reset Password</button>
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