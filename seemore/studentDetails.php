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
  <link rel="stylesheet" href="seemore.css">
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
        <span class="dashboard">Gate Entry System</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">
        <?php
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $fromDate = $_GET["fromDate"] ?? null;
          $toDate = $_GET["toDate"] ?? null;
        }
        ?>
        <div class="heading">
          <h1>
            Student Report
          </h1>
        </div>
        <div class="form-container">
          <?php
          $sql = "SELECT * from student where id='{$id}'";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $student_id = $row['id'];
            $photo = $row['photo_url'];
            ?>
            <form class="form">
              <h2 class="form-heading">Student Details</h2>
              <div>
                <img class="table-image" src="<?php echo $photo; ?>" alt="Photo">
              </div>
              <div>
                <div class="form-row">
                  <label for="name">Name:</label>
                  <p><?php echo strtoupper($row["name"]); ?></p>
                </div>
                <div class="form-row">
                  <label for="dprt">Department:</label>
                  <p><?php echo strtoupper($row['department']); ?></p>
                </div>
                <div class="form-row">
                  <label for="year">Year:</label>
                  <p><?php echo strtoupper($row['year']); ?></p>
                </div>
                <div class="form-row">
                  <label for="num">Number:</label>
                  <p><?php echo $row['conumber']; ?></p>
                </div>
              </div>
            </form>
          <?php } ?>
        </div>
        <div class="table">
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
                    <?php if($row["status"]=="Late"){
                      echo "Late Entry";
                    }elseif($row["status"]=="Early"){
                      echo "Early Exit";
                    } else {
                      echo $row["status"];} ?>
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