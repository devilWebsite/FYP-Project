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
    $sql = "DELETE FROM brandlist WHERE id = ?"; // Make sure the column name matches your database schema
    if($stmt = mysqli_prepare($conn, $sql)) // Use $conn, not $connection
    {
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_POST['id']);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        {
            // Records deleted successfully. Redirect to landing page
            header("location:manageBrand.php");
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
        header("location:error3.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="inquiry.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        body{
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this record?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="manageBrand.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>