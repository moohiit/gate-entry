<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="search.css">
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
    <!-- Main content Start Here -->
    <div class="main-content">
      <div class="form-container">
        <form method="post" class="form">
          <div class="form-row">
            <div class="form-status">
              <label for="status" class="label">Status:</label>
              <select name="status" id="status">
                <option value="Late" id="status" selected>Late</option>
                <option value="Early" id="status">Early</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <label for="name" class="label">Student Name:</label>
            <input type="text" id="name" name="name" class="input" placeholder="Search student" autocomplete="off">
          </div>
          <div class="form-row">
            <input type="submit" value="Search" name="btn">
            <!-- <input type="button" value="Send Mail" name="send_mail"> -->
          </div>
        </form>
      </div>
      <?php
      session_start();

      include '../database.php';
      if (isset($_POST["btn"])) {
        $n = $_POST['name'];
        $status= $_POST['status'];
        $sql = "select * from student where name like '%$n%'";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="card-container">
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["id"] = $row["id"];
            $_SESSION['name'] = $row["name"];
            $_SESSION["department"] = $row["department"];
            $_SESSION["conumber"] = $row["conumber"];
            $_SESSION["status"] = $status
              ?>
            <!-- Card Start here -->
            <a class="card" href="../ReasonForm/reasonForm.php?id=<?php echo $row["id"]; ?>">
              <div class="image">
                <img src="logo.png" alt="Logo" width="100px" height="100px">
              </div>
              <div class="data">
                <p class="id">Uid:
                  <?php echo $row["id"]; ?>
                </p>
                <p class="name">
                  <?php echo $row["name"]; ?>
                </p>
                <p class="conumber">
                  <?php echo $row["conumber"]; ?>
                </p>
                <p class="department">
                  <?php echo $row["department"]; ?>
                </p>
              </div>
            </a>

            <!-- Card End here -->
            <?php
          }
      }
      ?>
      </div>
    </div>
    <!-- Main content Ends Here -->
  </section>
  <!-- Content Ends Here -->
  <!-- Footer start here -->
  <section class="footer">
    <p>&copy; Gate Entry System | Developed by Team XYZ</p>
    <!-- <p><a href="https://github.com/moohiit">Github Code</a></p> -->
  </section>
  <!-- Footer ends Here -->
  <script src="script.js"></script>
</body>

</html>