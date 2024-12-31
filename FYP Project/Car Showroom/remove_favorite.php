<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

if (isset($_POST['id'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM favourites WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);

    if ($stmt->execute()) {
        echo 'Favorite removed successfully!';
    } else {
        echo 'Failed to remove favorite.';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request.';
}
?>
