<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="success.css">
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
      <li class="nav-link">
        <a href="../Search/search.php">
          <i class="bx bx-search icon"></i>
          <span class="text nav-text">Search Student</span>
        </a>
      </li>

      <li class="nav-link">
        <a href="../addStudent/addStudent.php">
          <i class="bx bx-add-to-queue icon"></i>
          <span class="text nav-text">Add Student</span>
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
        <span class="dashboard">Gate Entry System</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">
      <div class="success-message">
        <h2>Form Submitted Successfully!</h2>
        <a href="../Search/search.php" class="back-button">Back to Search</a>
      </div>
    </div>
      <!-- Main Content Ends Here -->
    </div>
    <!-- <footer>
      <p>&copy; Gate Entry System <br> Developed by Team XYZ</p>
    </footer> -->
  </section>
<script src="../scripts.js"></script>
</body>
</html>