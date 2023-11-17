<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer autoloader
require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';

// Set your email and SMTP server details
$sender_email = "pmohit645@gmail.com";
$smtp_server = "smtp.gmail.com";
$smtp_port = 587;
$smtp_username = "ramangoyal87021@gmail.com";
$smtp_password = "lwscczvcprtjdaqe";

// Database connection details
$host = "localhost";
$dbname = "gate";
$username = "root";
$password = "";

// Check if the form is submitted
if (isset($_POST['send_mail'])) {
  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = $smtp_server;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $smtp_port;

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Student Report';

    // Fetch data from the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Fetch department-wise email addresses
    $deptQuery = $pdo->query("SELECT * FROM department");
    $departments = $deptQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach ($departments as $department) {
      // Fetch data for each department
      $dept = $department['department'];
      $deptEmail = $department['deptEmail'];

      $stmt = $pdo->prepare("SELECT * FROM inqury_data WHERE dprt = :dept AND date = CURRENT_DATE");
      $stmt->bindParam(':dept', $dept);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Build HTML content dynamically for each department
      $html_content = '<html><head><title>Student Report</title></head><body>';
      $html_content .= '<h2>Student Report for ' . $dept . '</h2>';
      $html_content .= '<table border="1">';
      $html_content .= '<tr><th>Name</th><th>Department</th><th>Contact</th><th>Reason</th><th>Status</th><th>Time</th><th>Date</th><th>Photo</th></tr>';

      foreach ($data as $row) {
        $html_content .= '<tr>';
        $html_content .= '<td>' . $row['name'] . '</td>';
        $html_content .= '<td>' . $row['dprt'] . '</td>';
        $html_content .= '<td>' . $row['contact'] . '</td>';
        $html_content .= '<td>' . $row['reason'] . '</td>';
        $html_content .= '<td>' . $row['status'] . '</td>';
        $html_content .= '<td>' . $row['currentime'] . '</td>';
        $html_content .= '<td>' . $row['date'] . '</td>';
        $html_content .= '<td><img width="100" height="100" src="https://avatars.githubusercontent.com/u/109367447?v=4" alt="Photo"></td>';
        $html_content .= '</tr>';
      }

      $html_content .= '</table></body></html>';

      // Set sender and recipients
      $mail->setFrom($sender_email);
      $mail->addAddress($deptEmail);

      // Set email body
      $mail->Body = $html_content;

      // Send the email for each department
      $mail->send();

      // Clear recipients for the next department
      $mail->clearAddresses();
    }
    $_SESSION["mail_status"]="Email has been sent successfully.";
    header("Location: ./mail.php");
    exit;
  } catch (Exception $e) {
    $_SESSION["mail_error"]="Error: {$mail->ErrorInfo}";
    header("Location: ./mail.php");
    exit;
  }
}
?>