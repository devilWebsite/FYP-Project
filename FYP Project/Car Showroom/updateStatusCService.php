<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE carserviceapp SET status = ? WHERE serviceId = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            echo 'Status updated successfully';
        } else {
            echo 'Failed to update status';
        }

        $stmt->close();
    } else {
        echo 'Required data missing';
    }
    $conn->close();
}
?>
