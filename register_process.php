<?php
session_start();
// Connect to the database
include './database.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get user input from the registration form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the username is already taken
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  // Username is already taken, set an error message and redirect back to the registration page
  $_SESSION['signupError'] = "Username already taken.";
  header('Location: index.php');
} else {
  // Insert the new user into the database
  $query = "INSERT INTO users (username, password) VALUES (?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();

  // Redirect to the login page after successful registration
  header('Location: index.php');
}

$stmt->close();
$conn->close();
?>