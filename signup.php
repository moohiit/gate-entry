<?php
// Start session
session_start();

// Assuming you have already established a database connection
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $mobile = $_POST["mobile"];
  $role = $_POST["role"];
  $department = $_POST["department"];
  $password = $_POST["password"];

  // Check if user already exists
  $check_query = "SELECT * FROM users WHERE username='$email'";
  $result = mysqli_query($conn, $check_query);
  if (mysqli_num_rows($result) > 0) {
    $_SESSION["signupError"] = "Error: User already exists!";
    header("Location: signup.php"); // Redirect back to signup page
    exit();
  }

  // Create SQL query to insert data into the users table
  $sql = "INSERT INTO users (fullname, username, mobile, role,department, password) VALUES ('$name', '$email', '$mobile', '$role', '$department', '$password')";

  if (mysqli_query($conn, $sql)) {
    // Redirect to a success page
    header("Location: signupSuccess.php");
    mysqli_close($conn);
    exit();
  } else {
    $_SESSION["signupError"] = "Error: " . $sql . "<br>" . mysqli_error($conn);
    header("Location: signup.php"); // Redirect back to signup page
    exit();
  }

}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="signup.css">
</head>

<body>
  <div class="card">
    <form method="post" class="signup-form">
      <h2>Sign Up</h2>
      <?php
      if (isset($_SESSION["signupError"])) {
        ?>
        <h4 style="color: red;">
          <?php echo $_SESSION["signupError"]; ?>
        </h4>
        <?php
      }
      ?>
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="tel" name="mobile" placeholder="Mobile" pattern="[0-9]{10}" required>
      <select id="role" name="role" required>
        <option value="">Select a role</option>
        <option value="faculty">Faculty</option>
        <option value="hod">Head of Department</option>
        <option value="admin">Admin</option>
      </select>
      <select name="department" required>
        <option value="select">Select Department</option>
        <?php
        $sql = "SELECT * from department";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <option value="<?php echo $row["department"] ?>">
            <?php echo $row["department"] ?>
          </option>
          <?php
        }
        ?>
      </select>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>
  </div>


  <footer>
    <p>&copy; Gate Entry System <br> Developed by Mohit Patel and Raman Goyal</p>
    <p>Contact us
    <ul>
      <li><a href="https://github.com/moohiit"><i class="fab fa-github"></i> GitHub</a></li>
      <li><a href="https://www.linkedin.com/in/mohit-patel-51338a245"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
      <li><a href="mailto:pmohit645@gmail.com"><i class="far fa-envelope"></i> Email</a></li>
    </ul>
    </p>
  </footer>
</body>

</html>