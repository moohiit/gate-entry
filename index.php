<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>Gate Entry System</title>
  <!-- Add this line to include FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <div class="login-container">
    <form action="../login_process.php" method="post" class="login-form">
      <h1>Login</h1>
      <?php if (isset($_SESSION['loginError'])) {
        $error = $_SESSION['loginError'];
        echo '<p style="color: red;">' . $error . '</p>';
      } ?>
      <!-- <label for="username">Username:</label> -->
      <input type="text" id="username" name="username" placeholder="Username">

      <!-- <label for="password">Password:</label> -->
      <input type="password" id="password" name="password" placeholder="Password">

      <div class="role-row">
        <div class="column">
          <label for="admin">Admin</label>
          <input type="radio" name="role" id="admin" class="role" value="admin" required>
        </div>
        <div class="column"><label for="hod">HOD</label>
          <input type="radio" name="role" id="hod" class="role" value="hod" required>
        </div>
        <div class="column"><label for="gatekeeper">GateKeeper</label>
          <input type="radio" name="role" id="gatekeeper" class="role" value="gatekeeper" required>
        </div>
        <div class="column"><label for="student">Student</label>
          <input type="radio" name="role" id="student" class="role" value="student" required>
        </div>
      </div>
      <button type="submit">Login</button>
      <!-- Forgot Password and Signup Links -->
      <div style="margin-top: 5px;">
        <a class="forget-password" href="forgotPassword.php" >Forgot Password?</a>
        <span style="color: #104891;" >|</span>
        <a class="signup-button" href="signup.php" ">Sign Up</a>
      </div>
    </form>
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