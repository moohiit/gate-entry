<!-- Admin-only code here -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="dashboard.css">
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
      <h1>
        <p>Welcome,
          <?php echo $_SESSION['username']; ?>!
        </p>
      </h1>
      <div class="heading">
        <h1>Dashboard</h1>
      </div>

      <div class="dashboard">
        <div class="tab">
          <div class="tab-content">
            <h1>
              <center>Today's Report</center>
            </h1>
            <div class="content">
              <p>Total Late Entry: <span>
                  <?php
                  // Create connection
                  include '../database.php';
                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }
                  //select only all student number whose status is late
                  $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE date=CURRENT_DATE AND status='Late';";
                  $result = mysqli_query($conn, $sql);
                  $row = $result->fetch_assoc();
                  echo $row["count"];
                  $entryCount = $row["count"];
                  ?>
                </span>
              </p>
              <p>
                Total Early Exit: <span>
                  <?php
                  // Create connection
                  include '../database.php';
                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }
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
          </div>
          <div class="pie-chart">
            <canvas id="myPieChart" width="300" height="300"></canvas>
            <script>
              // Get the counts from your PHP code
              var lateEntryCount = <?php echo $entryCount; ?>;
              var earlyExitCount = <?php echo $exitCount; ?>;

              // Get the canvas element
              var ctx = document.getElementById("myPieChart").getContext("2d");

              // Create a pie chart
              var myPieChart = new Chart(ctx, {
                type: "pie",
                data: {
                  labels: ["Late Entry", "Early Exit"],
                  datasets: [{
                    data: [lateEntryCount, earlyExitCount],
                    backgroundColor: ['#283618',
                      '#ccd5ae'],
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
              <center>Monthly Summary Report</center>
            </h1>
            <div class="content">
              <p>
                Total Late Entry:
                <span>
                  <?php
                  // Create connection
                  include '../database.php';
                  //select only all student number whose status is late
                  $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE date > CURDATE() - INTERVAL 1 MONTH AND date <= CURDATE() AND status='Late';";
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
                  $sql = "SELECT COUNT(*) as count FROM inqury_data WHERE date > CURDATE() - INTERVAL 1 MONTH AND date <= CURDATE() AND status='Early';";
                  $result = mysqli_query($conn, $sql);
                  $row = $result->fetch_assoc();
                  echo $row["count"];
                  $exitCount1 = $row["count"];
                  ?>
                </span>
              </p>
            </div>
          </div>
          <div class="pie-chart">
            <canvas id="myPieChart1" width="300" height="300"></canvas>
            <script>
              // Get the counts from your PHP code
              var lateEntryCount1 = <?php echo $entryCount1; ?>;
              var earlyExitCount1 = <?php echo $exitCount1; ?>;

              // Get the canvas element
              var ctx1 = document.getElementById("myPieChart1").getContext("2d");

              // Create a pie chart
              var myPieChart = new Chart(ctx1, {
                type: "doughnut",
                data: {
                  labels: ["Late Entry", "Early Exit"],
                  datasets: [{
                    data: [lateEntryCount1, earlyExitCount1],
                    backgroundColor: ['#ef233c',
                      '#f1faee'],
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
          </div>
          <div class="pie-chart">
            <canvas id="myPieChart2" width="300" height="300"></canvas>
            <script>
              // Get the counts from your PHP code
              var lateEntryCount2 = <?php echo $entryCount2; ?>;
              var earlyExitCount2 = <?php echo $exitCount2; ?>;

              // Get the canvas element
              var ctx2 = document.getElementById("myPieChart2").getContext("2d");

              // Create a pie chart
              var myPieChart = new Chart(ctx2, {
                type: "polarArea",
                data: {
                  labels: ["Late Entry", "Early Exit"],
                  datasets: [{
                    data: [lateEntryCount2, earlyExitCount2],
                    backgroundColor: ['#1b4965',
                      '#cae9ff'],
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
      </div>
    </div>
  </section>
  <!-- Content Ends Here -->
  <section class="footer">
    <p>&copy; Gate Entry System | Developed by Team XYZ</p>
    <!-- <p><a href="https://github.com/moohiit">Github Code</a></p> -->
  </section>
  <script src="script.js"></script>
</body>

</html>