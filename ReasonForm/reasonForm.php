<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="reasonForm.css">
  <!----===== Boxicons CSS ===== -->
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />

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
  <section class="home">
    <!-- Content Goes Here -->
    <div class="main-content">
      <?php
      session_start();
      include '../database.php';
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
      }
      $status = $_SESSION["status"]
        ?>

      <div class="form-container">
        <?php
        $sql = "SELECT * from student where id='{$id}'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <form class="form" method="post">
            <h2 class="form-heading">Student Details</h2>
            <div class="form-row">
              <label for="name">Name</label>
              <input type="text" name="name" value='<?php echo strtoupper($row["name"]); ?>' readonly>
            </div>
            <div class="form-row">
              <label for="dprt">Department</label>
              <input type="text" name="dprt" value="<?php echo strtoupper($row['department']); ?>" readonly>
            </div>
            <div class="form-row">
              <label for="num">Number</label>
              <input type="text" name="num" value="<?php echo $row['conumber']; ?>" readonly>
            </div>
            <div class="form-row">
              <label for="reason">Reason</label>
              <textarea name="reason"></textarea>
            </div>
            <div class="form-row">
              <label for="status">Status</label>
              <input type="text" name="status" value="<?php echo $status == 'Late' ? 'Late Entry' : 'Early Exit'; ?>" readonly>
            </div>
            <div class="form-row">
              <input type="submit" class="btn" name="btn">
            </div>
          </form>
        </div>
      <?php
        }
        include '../database.php';
        if (isset($_POST["btn"])) {
          $name = $_POST['name'];
          $dept = $_POST['dprt'];
          $num = $_POST['num'];
          $reason = $_POST['reason'];
          $status = $_SESSION['status'];
        
          //Inserting the data into database
          $sql = "INSERT INTO inqury_data(name,dprt,contact,reason,status) values('{$name}','{$dept}','{$num}','{$reason}','{$status}')";
          $result = mysqli_query($conn, $sql);
          header('Location: ../success/success.php');
        }
        ?>
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