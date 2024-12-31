<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];

  // Prepare and bind
  $stmt = $conn->prepare("DELETE FROM inquiry WHERE id = ?");
  $stmt->bind_param("i", $id);

  // Execute the statement
  if ($stmt->execute()) {
    // Redirect back to the page
    header("Location: /path-to-your-page.php"); // Replace with the actual path to your page
    exit();
  } else {
    echo "Error deleting record: " . $conn->error;
  }

  $stmt->close();
}

$conn->close();
?>
