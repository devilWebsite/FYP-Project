<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if (isset($_POST['appointmentId']) && isset($_POST['appointmentType']) && isset($_POST['newDate']) && isset($_POST['newTime'])) {
    $appointmentId = $_POST['appointmentId'];
    $appointmentType = $_POST['appointmentType'];
    $newDate = $_POST['newDate'];
    $newTime = $_POST['newTime'];

    if ($appointmentType == "carService") {
        $query = "UPDATE carserviceapp SET appointmentDate = ?, appointmentTime = ? WHERE serviceId = ?";
    } else if ($appointmentType == "testDrive") {
        $query = "UPDATE testdriveapp SET appointmentDate = ?, appointmentTime = ? WHERE testDriveId = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $newDate, $newTime, $appointmentId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Appointment rescheduled successfully";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to reschedule appointment";
    }

    $stmt->close();
} elseif (isset($_POST['appointmentId']) && isset($_POST['appointmentType'])) {
    $appointmentId = $_POST['appointmentId'];
    $appointmentType = $_POST['appointmentType'];

    if ($appointmentType == "carService") {
        $query = "SELECT serviceId, name, appointmentDate, appointmentTime, services, serviceCenter FROM carserviceapp WHERE serviceId = ?";
    } else if ($appointmentType == "testDrive") {
        $query = "SELECT testDriveId, name, appointmentDate, appointmentTime FROM testdriveapp WHERE testDriveId = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['success'] = true;
        $response['data'] = $result->fetch_assoc();
    } else {
        $response['success'] = false;
        $response['message'] = "No appointment found";
    }

    $stmt->close();
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request";
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
