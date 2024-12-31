<?php
// process delete operation after confirmation
if(isset($_POST['id']) && !empty($_POST['id']))
{
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
    
    // Prepare a delete statement
    $sql = "DELETE FROM carserviceapp WHERE serviceId = ?"; // Make sure the column name matches your database schema
    if($stmt = mysqli_prepare($conn, $sql)) // Use $conn, not $connection
    {
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_POST['id']);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        {
            // Records deleted successfully. Redirect to landing page
            header("location:manageCarService.php");
            exit();
        }
        else
        {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
}  
else
{
    // Assume this is meant to check if the 'id' GET parameter is not set or empty
    if(empty(trim($_GET['id'])))
    {
        // Redirect to an error page if the 'id' parameter is missing
        header("location:error1.php");
        exit();
    }
}
?>
