<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Adjust the query to your needs. Here, I'm assuming you want to count all rows in the testdriveapp table.
$sql = "SELECT COUNT(*) as count FROM testdriveapp";
$result = $conn->query($sql);

$count = 0;
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
}

$conn->close();

// Return JSON response with the count
$response = [
    'testDrive' => $count,
    'carService' => 0 // Assuming you want to include carService as well; adjust as necessary
];

echo json_encode($response);
?>



