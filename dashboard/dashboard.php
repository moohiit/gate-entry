<?php
ob_start();
session_start();
include '../database.php';
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
  <link rel="stylesheet" href="dashboard.css">
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
        <?php
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
        } else {
          ?>
          <h1>
            <p>Welcome,
              <?php echo $_SESSION['username']; ?>!
            </p>
          </h1>
          <div class="heading">
            <h1>Dashboard</h1>
          </div>

          <div class="dashboard-container">
            <div class="tab">
              <div class="tab-content">
                <h1>
                  <center>Today's Report</center>
                </h1>
                <div class="content">
                  <div class="content-row">
                    <p>Total Late Entry: <span>
                        <?php
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE date=CURRENT_DATE AND status='Late';";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $entryCount = $row["count"];
                        ?>
                      </span>
                    </p>
                    <p>Total Early Exit: <span>
                        <?php
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE date=CURRENT_DATE AND status='Early';";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $exitCount = $row["count"];
                        ?>
                      </span>
                    </p>
                  </div>
                  <div class="content-row">
                    <p>Total Other Checking Count: <span>
                        <?php
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE date=CURRENT_DATE AND status NOT IN ('Late', 'Early');";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $otherCount = $row["count"];
                        ?>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="pie-chart">
                <canvas id="myPieChart" width="300" height="300"></canvas>
                <script>
                  // Get the counts from your PHP code
                  var lateEntryCount = <?php echo $entryCount; ?>;
                  var earlyExitCount = <?php echo $exitCount; ?>;
                  var otherCount = <?php echo $otherCount; ?>;

                  // Get the canvas element
                  var ctx = document.getElementById("myPieChart").getContext("2d");

                  // Create a pie chart
                  var myPieChart = new Chart(ctx, {
                    type: "pie",
                    data: {
                      labels: ["Late Entry", "Early Exit", "Other Reason"],
                      datasets: [{
                        data: [lateEntryCount, earlyExitCount, otherCount],
                        backgroundColor: ['#ef233c',
                          '#ccd5ae', '#0C356A'],
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
            </div>
            <div class="tab">
              <div class="tab-content">
                <h1>
                  <center>Monthly Summary Report</center>
                </h1>
                <div class="content">
                  <div class="content-row">
                    <p>
                      Total Late Entry:
                      <span>
                        <?php
                        // Create connection
                        include '../database.php';
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE()) AND status='Late';";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $entryCount1 = $row["count"];
                        ?>
                      </span>
                    </p>
                    <p>
                      Total Early Exit: <span>
                        <?php
                        // Create connection
                        include '../database.php';
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE()) AND status='Early';";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $exitCount1 = $row["count"];
                        ?>
                      </span>
                    </p>
                  </div>
                  <div class="content-row">
                    <p>Total Other Checking Count: <span>
                        <?php
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE()) AND status NOT IN ('Late', 'Early');";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $otherCount1 = $row["count"];
                        ?>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="pie-chart">
                <canvas id="myPieChart1" width="300" height="300"></canvas>
                <script>
                  // Get the counts from your PHP code
                  var lateEntryCount1 = <?php echo $entryCount1; ?>;
                  var earlyExitCount1 = <?php echo $exitCount1; ?>;
                  var otherCount1 = <?php echo $otherCount1; ?>;

                  // Get the canvas element
                  var ctx1 = document.getElementById("myPieChart1").getContext("2d");

                  // Create a pie chart
                  var myPieChart = new Chart(ctx1, {
                    type: "doughnut",
                    data: {
                      labels: ["Late Entry", "Early Exit", "Other Reason"],
                      datasets: [{
                        data: [lateEntryCount1, earlyExitCount1, otherCount1],
                        backgroundColor: ['#ef233c',
                          '#ccd5ae', '#0C356A'],
                        // borderColor: ['black'],
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
            </div>
            <div class="tab">
              <div class="tab-content">
                <h1>
                  <center>Yearly Summary Report</center>
                </h1>
                <div class="content">
                  <div class="content-row">
                    <p>
                      Total Late Entry:
                      <span>
                        <?php
                        // Create connection
                        include '../database.php';
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE YEAR(date) = YEAR(CURDATE()) AND status='Late';";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $entryCount2 = $row["count"];
                        ?>
                      </span>
                    </p>
                    <p>
                      Total Early Exit: <span>
                        <?php
                        // Create connection
                        include '../database.php';
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE YEAR(date) = YEAR(CURDATE()) AND status='Early';";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $exitCount2 = $row["count"];
                        ?>
                      </span>
                    </p>
                  </div>
                  <div class="content-row">
                    <p>Total Other Checking Count: <span>
                        <?php
                        //select only all student number whose status is late
                        $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE YEAR(date) = YEAR(CURDATE()) AND status NOT IN ('Late', 'Early');";
                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_assoc();
                        echo $row["count"];
                        $otherCount2 = $row["count"];
                        ?>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="pie-chart">
                <canvas id="myPieChart2" width="300" height="300"></canvas>
                <script>
                  // Get the counts from your PHP code
                  var lateEntryCount2 = <?php echo $entryCount2; ?>;
                  var earlyExitCount2 = <?php echo $exitCount2; ?>;
                  var otherCount2 = <?php echo $otherCount2; ?>;

                  // Get the canvas element
                  var ctx2 = document.getElementById("myPieChart2").getContext("2d");
                  // Create a bar chart
                  var myBarChart = new Chart(ctx2, {
                    type: "bar",
                    data: {
                      labels: ["Late Entry", "Early Exit", "Other Reason"],
                      datasets: [{
                        data: [lateEntryCount2, earlyExitCount2, otherCount2],
                        backgroundColor: ['#ef233c', '#ccd5ae', '#0C356A'],
                      }],
                    },
                    options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      legend: {
                        display: true, // Set to true to display the legend
                        position: "bottom",
                      },
                    },
                  });
                </script>
              </div>
            </div>
          </div>
        <?php } ?>
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