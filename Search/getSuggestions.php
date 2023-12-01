<?php
include '../database.php';

if (isset($_GET['query'])) {
  $query = $_GET['query'];

  $sql = "SELECT name FROM student WHERE name LIKE '%$query%' LIMIT 5";
  $result = mysqli_query($conn, $sql);

  $suggestions = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $suggestions[] = $row['name'];
  }

  echo json_encode($suggestions);
}
?>