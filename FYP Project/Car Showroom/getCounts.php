<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Query to count new test drive appointments
$sqlTestDrive = "SELECT COUNT(*) as count FROM testdriveapp";
$resultTestDrive = $conn->query($sqlTestDrive);

$countTestDrive = 0;
if ($resultTestDrive && $resultTestDrive->num_rows > 0) {
    $rowTestDrive = $resultTestDrive->fetch_assoc();
    $countTestDrive = $rowTestDrive['count'];
}

// Query to count new car service appointments
$sqlCarService = "SELECT COUNT(*) as count FROM carserviceapp";
$resultCarService = $conn->query($sqlCarService);

$countCarService = 0;
if ($resultCarService && $resultCarService->num_rows > 0) {
    $rowCarService = $resultCarService->fetch_assoc();
    $countCarService = $rowCarService['count'];
}

$conn->close();

// Return JSON response with both counts
$response = [
    'testDrive' => $countTestDrive,
    'carService' => $countCarService
];

echo json_encode($response);
?>
