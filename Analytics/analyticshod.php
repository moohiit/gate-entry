<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../index.php");
  exit();
}
include '../database.php';
// // Unset the session variables first
// unset($_SESSION['fromDate']);
// unset($_SESSION['toDate']);
// Initialize $fromDate and $toDate
$fromDate = null;
$toDate = null;
if (isset($_POST["btn"])) {
  $fromDate = $_POST['from'] ?? null;
  $toDate = $_POST['to'] ?? null;
}

// // Set new values for the session variables
// $_SESSION['fromDate'] = $fromDate;
// $_SESSION['toDate'] = $toDate;
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
  <link rel="stylesheet" href="analytics.css">

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
      // Check if the user is an hod
      if ($_SESSION['role'] == 'hod') {
        ?>
        <li class="nav-link">
          <a href="../Analytics/analyticshod.php">
            <i class="bx bx-bar-chart icon"></i>
            <span class="text nav-text">Analytics</span>
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
        <span class="dashboard">Analytics</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">

        <div class="heading">
          <h1>Analytics</h1>
        </div>

        <div class="dashboard-container">
          <form class="form" method="post">
            <div class="form-row">
              <label for="from">From:</label>
              <input id="from" type="date" name="from">
            </div>
            <div class="form-row">
              <label for="to">To:</label>
              <input id="to" type="date" name="to">
            </div>
            <div class="form-row">
              <input type="submit" class="btn" name="btn">
            </div>
          </form>
          <?php
          $username = $_SESSION['username'];
          // Prepare the SQL query
          $sql = "SELECT department FROM users WHERE username = ?";
          $stmt = $conn->prepare($sql);

          // Bind parameters
          $stmt->bind_param("s", $username);

          // Execute the query
          $stmt->execute();

          // Bind the result variables
          $stmt->bind_result($department);

          // Fetch the result
          $stmt->fetch();

          // Close the statement
          $stmt->close();
          ?>
          <div class="tab">
            <div class="tab-content">
              <h1>
                <center>
                  <?php echo $department ?>
                </center>
              </h1>
              <div class="content">
                <div class="content-row">
                  <p>Total Late Entry: <span>
                      <?php
                      // Create connection
                      include '../database.php';
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }
                      // Use prepared statements to prevent SQL injection
                      if ($fromDate && $toDate) {
                        $sql1 = "SELECT COUNT(*) as count FROM inqury_data WHERE `date` BETWEEN ? AND ? AND status='Late' AND dprt=?";
                      } else {
                        $sql1 = "SELECT COUNT(*) as count FROM inqury_data WHERE `date` = CURRENT_DATE AND status='Late' AND dprt=?";
                      }

                      // Prepare and bind the statement
                      $stmt1 = $conn->prepare($sql1);
                      if ($fromDate && $toDate) {
                        $stmt1->bind_param("sss", $fromDate, $toDate, $department);
                      } else {
                        $stmt1->bind_param("s", $department);
                      }

                      // Execute the query
                      $stmt1->execute();

                      // Bind the result variable
                      $stmt1->bind_result($count);

                      // Fetch the result
                      $stmt1->fetch();

                      // Output the result
                      echo $count;
                      $entryCount = $count;
                      // Close the statement
                      $stmt1->close();

                      // Close the connection
                      $conn->close();
                      ?>
                    </span>
                  </p>
                  <p>Total Early Exit: <span>
                      <?php
                      // Create connection
                      include '../database.php';
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }
                      //select only all student number whose status is late
                      if ($fromDate && $toDate) {
                        $sql1 = "SELECT COUNT(*) as count FROM inqury_data WHERE `date` BETWEEN ? AND ? AND status='Early' AND dprt=?";
                      } else {
                        $sql1 = "SELECT COUNT(*) as count FROM inqury_data WHERE `date` = CURRENT_DATE AND status='Early' AND dprt=?";
                      }

                      // Prepare and bind the statement
                      $stmt1 = $conn->prepare($sql1);
                      if ($fromDate && $toDate) {
                        $stmt1->bind_param("sss", $fromDate, $toDate, $department);
                      } else {
                        $stmt1->bind_param("s", $department);
                      }

                      // Execute the query
                      $stmt1->execute();

                      // Bind the result variable
                      $stmt1->bind_result($count);

                      // Fetch the result
                      $stmt1->fetch();

                      // Output the result
                      echo $count;
                      // Close the statement
                      $stmt1->close();
                      $exitCount = $count;
                      // Close the connection
                      $conn->close();
                      ?>
                    </span>
                  </p>
                </div>
                <div class="content-row">
                  <p>Total Other Checking Count: <span>
                      <?php
                      // Create connection
                      include '../database.php';
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }
                      //select only all student number whose status is late
                      if ($fromDate && $toDate) {
                        $sql1 = "SELECT COUNT(*) as count FROM inqury_data WHERE `date` BETWEEN ? AND ? AND status NOT IN ('Late', 'Early') AND dprt=?";
                      } else {
                        $sql1 = "SELECT COUNT(*) as count FROM inqury_data WHERE `date` = CURRENT_DATE AND status NOT IN ('Late', 'Early') AND dprt=?";
                      }

                      // Prepare and bind the statement
                      $stmt1 = $conn->prepare($sql1);
                      if ($fromDate && $toDate) {
                        $stmt1->bind_param("sss", $fromDate, $toDate, $department);
                      } else {
                        $stmt1->bind_param("s", $department);
                      }

                      // Execute the query
                      $stmt1->execute();

                      // Bind the result variable
                      $stmt1->bind_result($count);

                      // Fetch the result
                      $stmt1->fetch();

                      // Output the result
                      echo $count;
                      // Close the statement
                      $stmt1->close();
                      $otherCount = $count;
                      // Close the connection
                      $conn->close();
                      ?>
                    </span>
                  </p>
                </div>
              </div>
            </div>
            <div class="pie-chart">
              <canvas id="<?php echo $department ?>" width="300" height="300"></canvas>
              <script>
                // Get the counts from your PHP code
                var lateEntryCount = <?php echo $entryCount; ?>;
                var earlyExitCount = <?php echo $exitCount; ?>;
                var otherCount = <?php echo $otherCount; ?>;

                // Get the canvas element
                var ctx1 = document.getElementById("<?php echo $department ?>").getContext("2d");

                // Create a pie chart
                var myPieChart = new Chart(ctx1, {
                  type: "doughnut",
                  data: {
                    labels: ["Late Entry", "Early Exit", "Other Reason"],
                    datasets: [{
                      data: [lateEntryCount, earlyExitCount, otherCount],
                      backgroundColor: ['#ef233c', '#ccd5ae', '#0C356A'],
                    }],
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                      position: "bottom",
                    },
                  },
                });
              </script>
            </div>
            <div class="see-more">
              <a
                href="../seemore/seemore.php?id=<?php echo $department; ?>&fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">See
                More</a>
            </div>
          </div>

        </div>
      </div>
      <!-- Main Content Ends Here -->
    </div>
    <footer>
      <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    </footer>
  </section>
  <script src="../scripts.js"></script>
</body>

</html>