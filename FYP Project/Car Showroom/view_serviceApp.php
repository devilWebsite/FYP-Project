<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"])))
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
    
    // Prepare a SELECT statement
    $sql = "SELECT * FROM carserviceapp WHERE serviceId = ?";
    
    if($stmt = $conn->prepare($sql))
    {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute())
        {
            $result = $stmt->get_result();
    
            if($result->num_rows == 1)
            {
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $serviceId       = $row["serviceId"];
                $name            = $row["name"];
                $email           = $row["email"];
                $carPlateNo      = $row["carPlateNo"];
                $carBrand        = $row["carBrand"];
                $carModel        = $row["carModel"];
                $carYear         = $row["carYear"];
                $services        = $row["services"];
                $remark          = $row["remark"];
                $serviceCenter   = $row["serviceCenter"];
                $appointmentDate = $row["appointmentDate"];
                $appointmentTime = $row["appointmentTime"];
                $status = $row["status"];
            
            }
            else
            {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error1.php");
                exit();
            }
        }
        else
        {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $conn->close();
}
else
{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error1.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="inquiry.css">
    <style type="text/css">
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
                    <h2>View Record</h2>
                    <hr>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Appointment Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Car Plate No</th>
                            <th>Car Brand</th>
                            <th>Car Model</th>
                            <th>Car Year</th>
                            <th>Services</th>
                            <th>Remark</th>
                            <th>Service Center</th>
                            <th>Appointment Date </th>
                            <th>Appointment Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $row["serviceId"]; ?></td>
                            <td><?= $row["name"]; ?></td>
                            <td><?= $row["email"]; ?></td>
                            <td><?= $row["carPlateNo"]; ?></td>
                            <td><?= $row["carBrand"]; ?></td>
                            <td><?= $row["carModel"]; ?></td>
                            <td><?= $row["carYear"]; ?></td>
                            <td><?= $row["services"]; ?></td>
                            <td><?= $row["remark"]; ?></td>
                            <td><?= $row["serviceCenter"]; ?></td>
                            <td><?= $row["appointmentDate"]; ?></td>
                            <td><?= $row["appointmentTime"]; ?></td>
                            <td><?= $row["status"]; ?></td>
                        </tr>
                    </tbody>
                </table>
                <p><a href="manageCarService.php" class="btn btn-outline-primary">Back</a></p>
            </div>
        </div>        
    </div>
</div>

</body>
</html>