<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .removeFavorite {
        font-size: 22px;
        background-color: transparent;
        border: none;
        color: black;
        cursor: pointer;
        transition: color 0.3s ease; /* Smooth transition for color change */
    }

    .removeFavorite:hover {
        color: #ba0202; /* Leaf green color on hover */
    }
    </style>
</head>
<body>
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

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT id, productImg, carType, engine FROM favourites WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="favoriteItem" data-id="' . htmlspecialchars($row['id']) . '">';
            echo '<div class="favoriteContainer">';
            echo '<img src="' . htmlspecialchars($row['productImg']) . '" alt="" style="width: 200px; height: 150px;">';
            echo '<a href="viewProduct.php?id=' . htmlspecialchars($row['id']) . '" style="font-size: 15px; display: inline; margin-left: 10px;">' . htmlspecialchars($row['carType']) . ' ' . htmlspecialchars($row['engine']) . '</a>'; 
            echo '</div>';
            echo '<button class="removeFavorite" style="font-size: 15.5px;">Remove</button>';
            echo '</div>';
            echo '<hr>';
        }
    } else {
        echo 'No favorites found.';
    }    

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request.';
}
?>


</body>
</html>