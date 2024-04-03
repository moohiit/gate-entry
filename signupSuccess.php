<?php
session_start();
unset($_SESSION['loginError']);
?>
<!DOCTYPE html>
<html>

<head>
  <title>User Registration successfully</title>
  <link rel="stylesheet" href="forgotPassword.css">

</head>

<body>
  <div class="card">
    <h2 style="color: #09ff00;">User Registration Successful</h2>
    <p>Your account created successfully. You can now <a
        style="font-size: larger; text-decoration: none; color:darkblue;" href="index.php">login</a> with your login credentials.</p>
    <a id="login-link" style="font-size: larger; text-decoration: none;" href="index.php">login</a>
  </div>
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