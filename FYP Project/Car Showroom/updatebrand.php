<?php
// Database credentials
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

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand_id = $_POST['id'];
    $new_status = $_POST['new_status'];

    // Update status in the database
    $query = "UPDATE brandlist SET status='$new_status' WHERE id='$brand_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to manageBrand.php after successful update
        header("Location: manageBrand.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

// Fetching data from the database
$query = "SELECT id, name, imagePath, status FROM brandlist";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed.");
}

// Displaying data in the admin panel
echo '<h2>Updated Brand List</h2>';
echo '<div class="header-container">';
echo '<a href="manageBrand.php" style="float: right;" class="previous-page-button">Previous Page</a>';
echo '</div>';

echo "<hr>";
echo "<table>";
echo "<tr><th>Name</th><th>Image</th><th>Status</th><th>Update Status</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['name']."</td>";
    // Update the src attribute to point to the correct image file
    echo "<td><img src='assets/images1/".$row['imagePath']."' alt='Brand Image' style='width:120px; height:100px;'></td>"; // Set image size to 80px by 80px
    echo "<td>".$row['status']."</td>";
    echo "<td><form method='post'>";
    echo "<input type='hidden' name='id' value='".$row['id']."'>";
    echo "<select name='new_status'>";
    echo "<option value='Active'".($row['status'] == 'Active' ? ' selected' : '').">Active</option>";
    echo "<option value='Inactive'".($row['status'] == 'Inactive' ? ' selected' : '').">Inactive</option>";
    echo "</select>";
    echo "<input type='submit' value='Update'>";
    echo "<button onclick=\"window.location.href='manageBrand.php'\">Cancel</button>";
    echo "</form></td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";




// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Brand list</title>
    <link rel="stylesheet" href="">
    <style>

        .previous-page-button {
            margin-right: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
        }


h2{
    margin-top: 30px;
    margin-left: 10%;
    margin-right: auto;
}


table,hr {
    width: 80%;
    border-collapse: collapse;
    margin-top: 20px;
    margin-left: auto;
    margin-right: auto;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

img {
    max-width: 100px;
}
body{
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

</body>
</html>
