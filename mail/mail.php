<?php
session_start();
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
  <link rel="stylesheet" href="mail.css">
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
      if ($_SESSION['role'] == 'admin') {
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
      <li class="nav-link">
        <a href="../addStudent/addStudent.php">
          <i class="bx bx-user-plus icon"></i>
          <span class="text nav-text">Add Student</span>
        </a>
      </li>
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
      <?php } ?>
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
        <span class="dashboard">Send Mail</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">
          <div class="form-container">
            <h3>Send Today's Report</h3>
            <h6>To</h6>
            <h4>Head of Department</h4>
            <form method="post" id="mailForm" action="deptMail.php" class="form">
              <div class="form-row">
                <input type="submit" value="Send Mail" name="send_mail">
              </div>
            </form>
            <div id="loader" style="display: none; ">
              <img src="loader.gif" style="width: 100px; height: 100px;" alt="Loader">
              <p>Sending Mail...</p>
            </div>
            <div id="statusMessages">
              <?php
              if (isset($_SESSION['mail_status'])) {
                echo '<div class="alert alert-success"><p>' . $_SESSION['mail_status'] . '</p></div>';
                unset($_SESSION['mail_status']);
              }
              if (isset($_SESSION['mail_error'])) {
                echo '<div class="alert alert-error"><p>' . $_SESSION['mail_error'] . '</p></div>';
                unset($_SESSION['mail_error']);
              }
              ?>
            </div>

          </div>
      </div>
      <!-- Main Content Ends Here -->
    </div>
    <footer>
      <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    </footer>
  </section>
  <script>
    document.getElementById('mailForm').addEventListener('submit', function () {
      // Show loader when the form is submitted
      document.getElementById('loader').style.display = 'block';
      document.getElementById('mailForm').style.display = 'none';

    });

    // Function to hide the loader when mail status is obtained
    function hideLoader() {
      document.getElementById('loader').style.display = 'none';
    }

    // Check for mail status and hide loader accordingly
    <?php
    if (isset($_SESSION['mail_status']) || isset($_SESSION['mail_error'])) {
      echo 'hideLoader();';
    }
    ?>
  </script>
  <script src="../scripts.js"></script>
</body>

</html>