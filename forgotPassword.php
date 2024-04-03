<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer autoloader
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the email is provided
  if (isset($_POST["email"])) {
    // Generate OTP
    $otp = mt_rand(100000, 999999);

    // Send OTP to the user's email
    $email = $_POST["email"];
    $subject = "Password Reset OTP";
    $message = "Your OTP for password reset is: $otp";

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; // SMTP server
      $mail->SMTPAuth = true;
      $mail->Username = 'ramangoyal87021@gmail.com'; // SMTP username
      $mail->Password = 'lwscczvcprtjdaqe'; // SMTP password
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      // // Set your email and SMTP server details
      // $sender_email = "pmohit645@gmail.com";
      // $smtp_server = "smtp.gmail.com";
      // $smtp_port = 587;
      // $smtp_username = "ramangoyal87021@gmail.com";
      // $smtp_password = "lwscczvcprtjdaqe";


      //Recipients
      $mail->setFrom('admin@ourwebprojects.site', 'Gate Management System');
      $mail->addAddress($email); // Add a recipient

      // Content
      $mail->isHTML(false);
      $mail->Subject = $subject;
      $mail->Body = $message;

      $mail->send();

      // Store OTP in session
      $_SESSION["otp"] = $otp;
      $_SESSION["email"] = $email;

      // Redirect to verify OTP page
      header("Location: verify_otp.php");
      exit;
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Forget Password</title>
  <link rel="stylesheet" href="forgotPassword.css">
</head>

<body>
  <form method="post" class="card">
    <h2>Forgot Password</h2>
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send OTP</button>
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