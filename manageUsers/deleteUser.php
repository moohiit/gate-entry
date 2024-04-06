<?php
session_start();
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['role'])) {
  $username = $_POST["username"];

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("DELETE FROM users WHERE username=?");
  $stmt->bind_param("s", $username);
  if ($stmt->execute()) {
    echo "User deleted successfully";
  } else {
    echo "Error deleting user: " . $conn->error;
  }
  $stmt->close();
  $conn->close();
}
?>