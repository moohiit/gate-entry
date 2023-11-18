<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="mail.css">
  <!----===== Boxicons CSS ===== -->
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <title>Gate Management System</title>
</head>

<body>
  <nav class="sidebar">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="logo.png" alt="Logo" />
        </span>

        <div class="text logo-text">
          <span class="name">KCMT</span>
          <span class="profession">Gate Management</span>
        </div>
      </div>

      <i class="bx bx-chevron-right toggle"></i>
    </header>

    <div class="menu-bar">
      <div class="menu">
        <ul class="menu-links">

          <li class="nav-link">
            <a href="../Search/search.php">
              <i class="bx bx-search icon"></i>
              <span class="text nav-text">Search Student</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="../dashboard/dashboard.php">
              <i class="bx bx-home-alt icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>


          <li class="nav-link">
            <a href="../LateEntry/LateEntry.php">
              <i class="bx bx-time icon"></i>
              <span class="text nav-text">Late Entry</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="../EarlyExit/EarlyExit.php">
              <i class="bx bx-stopwatch icon"></i>
              <span class="text nav-text">Early Exit</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="../Analytics/analytics.php">
              <i class="bx bx-bar-chart icon"></i>
              <span class="text nav-text">Analytics</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="../mail/mail.php">
              <i class="bx bx-mail-send icon"></i>
              <span class="text nav-text">Send Report</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="../logout.php">
            <i class="bx bx-log-out icon"></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>
      </div>
    </div>
  </nav>
  <section class="navbar">
    <h1 id="heading" class="">Gate Management System</h1>
  </section>
  <!-- Content Goes Here -->
  <section class="home">
    <!-- Main content Start Here -->
    <div class="main-content">
      <?php
      session_start();

      // Check if the user is an admin
      if ($_SESSION['role'] !== 'admin') {
        ?>
        <div class=access-denied>
          <?php
          echo "<div>You do not have permission to access this page.</div>";
          // You may also redirect to a limited access page or the login page.
          ?>
          <div>
            <a style="text-decoration: none;" href="../Search/search.php">Go to Homepage</a>
          </div>
        </div>
        <?php
        exit();
      }
      ?>
      <div class="form-container">
        <h1>Send Today's Report</h1>
        <h3>To</h3>
        <h2>Head of Department</h2>
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
            echo '<div class="alert" ><p  style="color: green;">' . $_SESSION['mail_status'] . '</p></div>';
            unset($_SESSION['mail_status']);
          }
          if (isset($_SESSION['mail_error'])) {
            echo '<div class="alert" ><p  style="color: red;">' . $_SESSION['mail_error'] . '</p></div>';
            unset($_SESSION['mail_error']);
          }
          ?>
        </div>
      </div>
    </div>
    <!-- Main content Ends Here -->
  </section>
  <!-- Content Ends Here -->
  <!-- Footer start here -->
  <section class="footer">
    <p>&copy; Gate Entry System | Developed by Team XYZ</p>
    <!-- <p><a href="https://github.com/moohiit">Github Code</a></p> -->
  </section>
  <!-- Footer ends Here -->
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
  <script src="script.js"></script>
</body>

</html>