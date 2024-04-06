<?php
session_start();
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['role'])) {
  $status = $_POST["status"];
  $username = $_POST["username"];

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("UPDATE users SET status=? WHERE username=?");
  $stmt->bind_param("ss", $status, $username);
  if ($stmt->execute()) {
    echo "Status updated successfully";
  } else {
    echo "Error updating status: " . $conn->error;
  }
  $stmt->close();
  $conn->close();
}
?>