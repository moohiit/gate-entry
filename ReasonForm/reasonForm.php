<?php
ob_start();
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
  <link rel="stylesheet" href="reasonForm.css">
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
        <span class="dashboard">Student Info</span>
      </div>
    </nav>
    <!-- Navbar ends Here -->
    <div class="home-content">
      <!-- Main Content Goes Here   -->
      <div class="main-content">
        <?php
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
        }
        ?>

        <div class="form-container">
          <?php
          $sql = "SELECT * from student where id='{$id}'";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $student_id  = $row['id'];
            $photo = $row['photo_url'];
            ?>
            <form class="form" method="post">
              <h2 class="form-heading">Student Details</h2>
              <div class="form-row">
                <label for="name">Name:</label>
                <input type="text" name="name" value='<?php echo strtoupper($row["name"]); ?>' readonly>
              </div>
              <div class="form-row">
                <label for="dprt">Department:</label>
                <input type="text" name="dprt" value="<?php echo strtoupper($row['department']); ?>" readonly>
              </div>
              <div class="form-row">
                <label for="year">Year:</label>
                <input type="text" name="year" value="<?php echo strtoupper($row['year']); ?>" readonly>
              </div>
              <div class="form-row">
                <label for="num">Mobile No:</label>
                <input type="text" name="num" value="<?php echo $row['conumber']; ?>" readonly>
              </div>
              <div class="form-row">
                <label for="status">Status:</label>
                <select name="status" id="issue">
                  <option value="Late">Late Entry</option>
                  <option value="Early">Early Exit</option>
                </select>
              </div>
              <div class="form-row">
                <label for="reason">Reason:</label>
                <textarea name="reason"></textarea>
              </div>
              <div class="form-row">
                <label for="author">Authorised By:</label>
                <select name="author" id="author">
                  <option value="Gate Incharge">Gate Incharge</option>
                  <option value="Proctor">Proctor Sir</option>
                  <option value="HOD">HOD Sir</option>
                  <option value="D.G. Sir">D.G. Sir</option>
                </select>
              </div>
              <div class="form-row">
                <input type="submit" class="btn" name="btn">
              </div>
            </form>
          </div>
          <?php
          }
          if (isset($_POST["btn"])) {
            $name = $_POST['name'];
            $dept = $_POST['dprt'];
            $year = $_POST['year'];
            $num = $_POST['num'];
            $status = $_POST['status'];
            $reason = $_POST['reason'];
            $author = $_POST['author'];
            //Inserting the data into database
            $sql = "INSERT INTO inqury_data(student_id,name,dprt,year,contact,reason,authorisedBy,status,photo_url) values('{$student_id}','{$name}','{$dept}','{$year}','{$num}','{$reason}','{$author}','{$status}','{$photo}')";
            $result = mysqli_query($conn, $sql);
            header('Location: ../success/success.php');
            ob_end_flush();
          }
          ?>
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