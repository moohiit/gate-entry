<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../index.php");
  exit();
}
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
  <link rel="stylesheet" href="studentReport.css">
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
        <a href="./studentProfile.php">
          <i class="bx bx-user icon"></i>
          <span class="text nav-text">Student Profile</span>
        </a>
      </li>
      
      <li class="nav-link">
        <a href="./studentReport.php">
          <i class="bx bx-bar-chart icon"></i>
          <span class="text nav-text">Student Report</span>
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
        if (isset($_SESSION['username'])) {
          $email = $_SESSION['username'];
          // Prepare the SQL query
          $sql = "SELECT id FROM student WHERE email = ?";

          // Prepare and bind parameters
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $email);

          // Execute the query
          $stmt->execute();

          // Bind the result variables
          $stmt->bind_result($id);

          // Fetch the result
          $stmt->fetch();

          // Close the statement
          $stmt->close();

        }
        ?>
        <div class="heading">
          <h1>
            Student Report
          </h1>
        </div>
        <div class="table">
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
          // Initialize $fromDate and $toDate
          $fromDate = null;
          $toDate = null;
          if (isset($_POST["btn"])) {
            $fromDate = $_POST['from'] ?? null;
            $toDate = $_POST['to'] ?? null;
          }
          ?>
          <table>

            <thead>
              <tr>
                <th>Sr.No</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Use prepared statements to prevent SQL injection
              if ($fromDate && $toDate) {
                $sql1 = "SELECT status, reason, date, currentime FROM inqury_data WHERE `date` BETWEEN ? AND ? AND student_id=?";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("sss", $fromDate, $toDate, $id);
              } else if ($fromDate == null && $toDate == null) {
                $sql1 = "SELECT status, reason, date, currentime FROM inqury_data WHERE month(`date`) = month(CURRENT_DATE) AND student_id=?";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("s", $id);
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
                    <?php if ($row["status"] == "Late") {
                      echo "Late Entry";
                    } elseif ($row["status"] == "Early") {
                      echo "Early Exit";
                    } else {
                      echo $row["status"];
                    } ?>
                  </td>
                  <td>
                    <?php echo $row["reason"] ?>
                  </td>
                  <td>
                    <?php echo $row["date"] ?>
                  </td>
                  <td>
                    <?php echo $row["currentime"] ?>
                  </td>
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
      <!-- Main Content Ends Here -->
    </div>
    <footer>
      <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    </footer>
  </section>
  <script src="../scripts.js"></script>
</body>

</html>