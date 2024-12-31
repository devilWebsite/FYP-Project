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

// Check if the id is set in the POST request
if (isset($_POST['id'])) {
    $carId = $_POST['id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM carlist WHERE id = ?");
    $stmt->bind_param("i", $carId);

    // Execute the statement
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Close the statement
    $stmt->close();
} else {
    echo 'error';
}

// Close connection
$conn->close();
?>
