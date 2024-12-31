<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username']) && isset($_POST['id'])) {
    $username = $_SESSION['username'];
    $id = $_POST['id'];

    // Fetch car details from carlist table
    $sql = "SELECT id, productImg, carType, engine FROM carlist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
        $productImg = $car['productImg'];
        $carType = $car['carType'];
        $engine = $car['engine'];
        $added_date = date('Y-m-d H:i:s');

        // Insert into favourites table
        $insert_sql = "INSERT INTO favourites (id, productImg, carType, engine, added_date, username) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("isssss", $id, $productImg, $carType, $engine, $added_date, $username);

        if ($insert_stmt->execute()) {
            echo 'Car added to favourites successfully!';
        } else {
            echo 'Failed to add car to favourites.';
        }
    } else {
        echo 'Car not found.';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Login to account to saved your favourite car.';
}
?>
