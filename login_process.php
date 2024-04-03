<?php
session_start();

// Connect to the database
include './database.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the user input from the form
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Check if the user exists in the database
$query = "SELECT id, username,fullname, password, role, status FROM users WHERE username = ? AND password = ? AND role = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $username, $password, $role);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
  // Fetch user details including role
  $stmt->bind_result($userId, $username, $fullname, $password, $role, $status);
  $stmt->fetch();

  // Successful login, set a session variable

  $_SESSION['fullname'] = $fullname;
  $_SESSION['username'] = $username;
  $_SESSION['role'] = $role;

  if ($status=='active') {
    // Redirect based on user's role
    if ($role == 'admin') {
      header('Location: ./dashboard/dashboard.php'); // Adjust the path accordingly
    } else {
      header('Location: ./Search/search.php');
    }
    }else{
        // Invalid login, set an error message and redirect back to the login page
        $_SESSION['loginError'] = "Your account is not activated. <br/> Please contact Administrator";
        header('Location: index.php');
    }
} else {
  // Invalid login, set an error message and redirect back to the login page
  $_SESSION['loginError'] = "Invalid username or password.";
  header('Location: index.php');
}

$stmt->close();
$conn->close();
?>