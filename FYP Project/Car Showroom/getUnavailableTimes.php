<?php
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $sql = "SELECT appointmentTime FROM carserviceapp WHERE appointmentDate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $unavailableTimes = [];

    while ($row = $result->fetch_assoc()) {
        $unavailableTimes[] = $row['appointmentTime'];
    }

    echo json_encode(['unavailableTimes' => $unavailableTimes]);
}

$conn->close();
?>

