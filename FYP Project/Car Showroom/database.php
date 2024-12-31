<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS inquiry (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) NOT NULL,
    dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) AUTO_INCREMENT=4011250";

if (mysqli_query($conn, $sql)) {
    echo "Table inquiry created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
