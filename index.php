<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>KCMT GATE LOGIN</title>
  <link rel="stylesheet" href="./index.css">

</head>

<body>
  <div class="full-body">
    <div class="wrapper">
      <div class="title-text">
        <div class="title login">GATE ENTRY SYSTEM</div>
      </div>
      <!-- Add this code inside the <body> tag -->
      <?php
      session_start();
      if (isset($_SESSION['loginError'])) {
        echo '<div class="alert" ><p  style="color: red;">' . $_SESSION['loginError'] . '</p></div>';
        unset($_SESSION['loginError']);
      }
      ?>
      <div class="form-container">
        <div class="form-inner">
          <form action="login_process.php" method="post" class="login">
            <div class="field">
              <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="field">
              <input name="password" type="password" placeholder="Password" required>
            </div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Login">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="./index.js"></script>
</body>
</html>
