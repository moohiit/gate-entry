<?php
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
        $department = null;
        if (isset($_GET['id'])) {
          $department = $_GET['id'];
          $fromDate = $_SESSION["fromDate"] ?? null;
          // unset($_SESSION['fromDate']);
          $_SESSION['from'] = $fromDate;
          $toDate = $_SESSION["toDate"] ?? null;
          // unset($_SESSION['toDate']);
          $_SESSION['to'] = $toDate;
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
                <!-- <th>Sr.No</th> -->
                <th>Student ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Year</th>
                <th>Contact No.</th>
                <th>Warnings</th>
                <th>Photo</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Use prepared statements to prevent SQL injection
              if ($fromDate && $toDate) {
                $sql1 = "SELECT student_id, name, dprt AS department, year, contact, COUNT(*) as warnings, photo_url FROM inqury_data WHERE `date` BETWEEN ? AND ? AND dprt=? GROUP BY student_id";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("sss", $fromDate, $toDate, $department);
              } else if ($fromDate == null && $toDate == null) {
                $sql1 = "SELECT student_id, name, dprt AS department, year, contact, COUNT(*) as warnings, photo_url FROM inqury_data WHERE month(`date`) = month(CURRENT_DATE) AND dprt=? GROUP BY student_id";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("s", $department);
              }

              // Execute the query
              $stmt1->execute();

              // Get the result set
              $result = $stmt1->get_result();
              // $i = 1;
              while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                  <!-- <td>
                    <?php //echo $i ?>
                  </td>-->
                  <td> 
                    <?php
                    $id = $row['student_id'];
                    echo $row["student_id"] ?>
                  </td>
                  <td>
                    <a href="studentDetails.php?id=<?php echo $id ?>" style="color:blue;"><?php echo $row['name'] ?></a>
                  </td>
                  <td>
                    <?php echo $row["department"] ?>
                  </td>
                  <td>
                    <?php echo $row["year"] ?>
                  </td>
                  <td>
                    <?php echo $row["contact"] ?>
                  </td>
                  <td>
                    <?php echo $row["warnings"] >= 4 ? "100rs Fine" : $row["warnings"]; ?>
                  </td>
                  <td><img class="table-image" src="<?php echo $row["photo_url"] ?>" alt="Photo"></td>
                </tr>
                <?php
                // $i++;
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