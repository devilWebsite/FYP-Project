<?php
// Assuming you have already connected to your MySQL database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  
  // Update email in the database for the logged-in user (username assumed to be retrieved elsewhere)
  $username = "admin_username"; // Replace with actual admin username
  $sql = "UPDATE adminlogin SET email='$email' WHERE username='$username'";
  
  if ($conn->query($sql) === TRUE) {
    echo "Email updated successfully";
  } else {
    echo "Error updating email: " . $conn->error;
  }
}

$conn->close();
?>
