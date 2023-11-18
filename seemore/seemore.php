<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="seemore.css">
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
            <a href="../Search/search.php">Go to Homepage</a>
          </div>
        </div>
        <?php
        exit();
      }
      $department = null;
      if (isset($_GET['id'])) {
        $department = $_GET['id'];
        $fromDate = $_SESSION["fromDate"] ?? null;
        unset($_SESSION['fromDate']);
        $toDate = $_SESSION["toDate"] ?? null;
        unset($_SESSION['toDate']);
      }
      ?>
      <div class="heading">
        <h1>
          <?php echo $department ?>
        </h1>
      </div>
      <div class="table">
        <table>
          <thead>
            <tr>
              <th>Sr.No</th>
              <th>Name</th>
              <th>Department</th>
              <th>Contact No.</th>
              <th>Reason</th>
              <th>Status</th>
              <th>Time</th>
              <th>Date</th>
              <th>Photo</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include '../database.php';

            // Use prepared statements to prevent SQL injection
            if ($fromDate && $toDate) {
              $sql1 = "SELECT * FROM inqury_data WHERE `date` BETWEEN ? AND ? AND dprt=?";
              $stmt1 = $conn->prepare($sql1);
              $stmt1->bind_param("sss", $fromDate, $toDate, $department);
            } else if($fromDate==null && $toDate==null) {
              $sql1 = "SELECT * FROM inqury_data WHERE DATE(`date`) = CURRENT_DATE AND dprt=?";
              $stmt1 = $conn->prepare($sql1);
              $stmt1->bind_param("s", $department);
            }

            // Execute the query
            $stmt1->execute();

            // Get the result set
            $result = $stmt1->get_result();


            $i = 1;
            while ($row = mysqli_fetch_assoc($result)) {
              ?>
              <tr>
                <td>
                  <?php echo $i ?>
                </td>
                <td>
                  <?php echo $row["name"] ?>
                </td>
                <td>
                  <?php echo $row["dprt"] ?>
                </td>
                <td>
                  <?php echo $row["contact"] ?>
                </td>
                <td>
                  <?php echo $row["reason"] ?>
                </td>
                <td>
                  <?php echo $row["status"] ?>
                </td>
                <td>
                  <?php echo $row["currentime"] ?>
                </td>
                <td>
                  <?php echo $row["date"] ?>
                </td>
                <td><img class="table-image" src="logo.png" alt="Photo"></td>
              </tr>
              <?php
              $i++;
            }

            // Close the statement
            $stmt1->close();
            // Close the connection
            $conn->close();
            ?>
          </tbody>
        </table>
      </div>

    </div>
  </section>
  <section class="footer">
    <p>&copy; Gate Entry System | Developed by Team XYZ</p>
    <!-- <p><a href="https://github.com/moohiit">Github Code</a></p> -->
  </section>
  <!-- Content Ends Here -->
  <script src="script.js"></script>
</body>

</html>