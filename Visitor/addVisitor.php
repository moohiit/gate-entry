<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="addVisitor.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gate Entry System</title>
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name" style="margin-left:1px"><img src="../logo.png" alt="KCMT" /></span>
      <h5>Gate Entry System</h5>
    </div>
    <ul class="nav-links">
      <?php
      // Check if the user is an admin
      if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'hod') {
        ?>
        <li class="nav-link">
          <a href="../dashboard/dashboard.php">
            <i class="bx bx-home-alt icon"></i>
            <span class="text nav-text">Dashboard</span>
          </a>
        </li>
      <?php } ?>
      <li class="nav-link">
        <a href="../Search/search.php">
          <i class="bx bx-search icon"></i>
          <span class="text nav-text">Search Student</span>
        </a>
      </li>
      <?php
      if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'hod') {
        ?>
        <li class="nav-link">
          <a href="../addStudent/addStudent.php">
            <i class="bx bx-user-plus icon"></i>
            <span class="text nav-text">Add Student</span>
          </a>
        </li>
      <?php } ?>
      <?php
      // Check if the user is an admin
      if ($_SESSION['role'] == 'admin') {
        ?>
        <li class="nav-link">
          <a href="../Analytics/analytics.php">
            <i class="bx bx-bar-chart icon"></i>
            <span class="text nav-text">Analytics</span>
          </a>
        </li>
    
        <li class="nav-link">
          <a href="../Visitor/Visitor.php">
            <i class='bx bx-group icon'></i>
            <span class="text nav-text">Visitor Section</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="../mail/mail.php">
            <i class="bx bx-mail-send icon"></i>
            <span class="text nav-text">Send Report</span>
          </a>
        </li>
      <?php } ?>
      <li class="log_out nav-link">
        <a href="../logout.php">
          <i class='bx bx-log-out bx-fade-left-hover'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <!-- Navbar start Here -->
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Visitor Section</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">
        <div class="form-container">
          <form action="add.php" class="form" method="post" enctype="multipart/form-data">
            <h2 class="form-heading">Visitor Details</h2>
            <div class="form-row">
              <label for="name">Name</label>
              <input type="text" name="name">
            </div>
            <div class="form-row">
              <label for="mobile">Mobile No.</label>
              <input type="text" name="mobile" id="mobile" required>
              <small id="mobileError" style="color: red;" class="form-error"></small>
            </div>
            <div class="form-row">
              <label for="reason">Reason</label>
              <input type="text" name="reason">
            </div>
            <div class="form-row">
              <input type="submit" value="submit" class="btn" name="submit">
            </div>
          </form>

        </div>
      </div>
      <!-- Main Content Ends Here -->
    </div>
    <footer>
      <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    </footer>
  </section>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var mobileInput = document.getElementById('mobile');
      var mobileError = document.getElementById('mobileError');

      mobileInput.addEventListener('input', function () {
        validateMobileNumber();
      });

      function validateMobileNumber() {
        var mobileRegex = /^[0-9]{10}$/;
        var mobileValue = mobileInput.value;

        if (!mobileRegex.test(mobileValue)) {
          mobileError.textContent = 'Invalid mobile number. Please enter a 10-digit number.';
          mobileInput.setCustomValidity('Invalid mobile number');
        } else {
          mobileError.textContent = '';
          mobileInput.setCustomValidity('');
        }
      }
    });
  </script>
  <script src="../scripts.js"></script>
</body>

</html>