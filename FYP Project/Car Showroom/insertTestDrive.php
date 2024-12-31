<?php

// Enable error reporting for debugging
error_reporting(E_ALL);

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
 
// Define variables and initialize with empty values
$testdriveId = $name = $phoneNumber = $appointmentDate = $appointmentTime = "";
$name_err = $phoneNumber_err = $appointmentDate_err = $appointmentTime_err = "";
 
    // Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name))
    {
        $name_err = "Please enter a name.";
    }
    elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $name_err = "Please enter a valid name.";
    }
    else
    {
        $name = $input_name;
    }

    // Validate phone number
    $input_phoneNumber = trim($_POST["phoneNumber"]);
    if(empty($input_phoneNumber))
    {
        $phoneNumber_err = "Please enter a phone number.";
    }
    elseif(!filter_var($input_phoneNumber, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{10}$/"))))
    {
        $phoneNumber_err = "Please enter a valid phone number.";
    }
    else
    {
        $phoneNumber = $input_phoneNumber;
    }

    // Validate appointment date
    $input_appointmentDate = trim($_POST["appointmentDate"]);
    if(empty($input_appointmentDate))
    {
        $appointmentDate_err = "Please enter the appointment date.";     
    } 
    else
    {
        $appointmentDate = $input_appointmentDate;
    }

    // Validate appointment time
    $input_appointmentTime = trim($_POST["appointmentTime"]);
    if(empty($input_appointmentTime))
    {
        $appointmentTime_err = "Please enter the appointment time.";     
    } 
    else
    {
        $appointmentTime = $input_appointmentTime;
    }
    
    // Check input errors before inserting in database
if(empty($name_err) && empty($phoneNumber_err) && empty($appointmentDate_err) && empty($appointmentTime_err)) {
    // Prepare an insert statement
    $sql = "INSERT INTO testdriveapp (testdriveId, name, phoneNumber, appointmentDate, appointmentTime) VALUES (?,?,?,?,?)";
     
    if($stmt = mysqli_prepare($conn, $sql))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issss", $testdriveId, $name, $phoneNumber, $appointmentDate, $appointmentTime);
        
        // Set parameters
        $testdriveId         = $testdriveId;
        $name              = $name;
        $phoneNumber       = $phoneNumber;
        $appointmentDate   = $appointmentDate;
        $appointmentTime   = $appointmentTime;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records created successfully. Redirect to landing page
            header("location: manageTestDrives.php");
            exit();
        }
        else
        {
            echo "Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Insert Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
   <!-- add style css -->
   <link rel="stylesheet" href="css/css-create-style.css">

   <style>
    body{
            background-color: #f2f2f2;
        }
        
</style>

</head>

<body>
<div class="container">
    <div class="signup-form">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Insert Record</h2>
                </div>
                <p>Please fill this form and submit to add appointment details to the database.</p>
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?= (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $name; ?>">
                        <span class="help-block"><?= $name_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($phoneNumber_err)) ? 'has-error' : ''; ?>">
                        <label>Phone Number</label>
                        <input type="text" name="phoneNumber" class="form-control" value="<?= $phoneNumber; ?>">
                        <span class="help-block"><?= $phoneNumber_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($appointmentDate_err)) ? 'has-error' : ''; ?>">
                        <label>Appointment Date</label>
                        <input type="date" name="appointmentDate" class="form-control" value="<?= $appointmentDate; ?>">
                        <span class="help-block"><?= $appointmentDate_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($appointmentTime_err)) ? 'has-error' : ''; ?>">
                        <label>Appointment Time</label>
                        <input type="time" name="appointmentTime" class="form-control" value="<?= $appointmentTime; ?>">
                        <span class="help-block"><?= $appointmentTime_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Insert New Record">
                    <a href="manageTestDrives.php" class="btn btn-default" style="color:red;">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div>
</body>
</html>