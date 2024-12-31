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
$serviceId = $name = $email = $phoneNumber = $carPlateNo = $carBrand = $carModel =$carYear = $services = $remark = $serviceCenter = $appointmentDate = $appointmentTime = "";
$name_err = $email_err = $phoneNumber_err = $carPlateNo_err = $carBrand_err = $carModel_err = $carYear_err = $services_err = $remark_err = $serviceCenter_err = $appointmentDate_err = $appointmentTime_err = "";
 
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

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email))
    {
        $email_err = "Please enter an email.";
    }
    elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL))
    {
        $email_err = "Please enter a valid email.";
    }
    else
    {
        $email = $input_email;
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

    // Validate car plate number
    $input_carPlateNo = trim($_POST["carPlateNo"]);
    if(empty($input_carPlateNo))
    {
        $carPlateNo_err = "Please enter the car plate number.";     
    } 
    elseif(!filter_var($input_carPlateNo, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[A-Z0-9\s]+$/i"))))
    {
        $carPlateNo_err = "Please enter a valid car plate number.";
    }
    else
    {
        $carPlateNo = $input_carPlateNo;
    }

    // Validate car brand
    $input_carBrand = trim($_POST["carBrand"]);
    if(empty($input_carBrand))
    {
        $carBrand_err = "Please enter the car brand.";     
    } 
    else
    {
        $carBrand = $input_carBrand;
    }

    // Validate car model
    $input_carModel = trim($_POST["carModel"]);
    if(empty($input_carModel))
    {
        $carModel_err = "Please enter the car model.";     
    } 
    else
    {
        $carModel = $input_carModel;
    }

    // Validate car year
    $input_carYear = trim($_POST["carYear"]);
    if(empty($input_carYear))
    {
        $carYear_err = "Please enter the car year.";     
    } 
    elseif(!ctype_digit($input_carYear))
    {
        $carYear_err = "Please enter a valid car year.";
    }
    else
    {
        $carYear = $input_carYear;
    }

    // Validate services
    $input_services = isset($_POST["services"]) ? $_POST["services"] : [];
    if(empty($input_services))
    {
        $services_err = "Please select at least one service.";     
    } 
    else
    {
        // Convert array of services into a comma-separated string
        $services = implode(', ', $input_services);
    }

    // Validate remark
    $input_remark = trim($_POST["remark"]);
    if(empty($input_remark))
    {
        $remark_err = "Please enter a remark.";     
    } 
    else
    {
        $remark = $input_remark;
    }

    // Validate service center
    $input_serviceCenter = trim($_POST["serviceCenter"]);
    if(empty($input_serviceCenter))
    {
        $serviceCenter_err = "Please select a service center.";     
    } 
    else
    {
        $serviceCenter = $input_serviceCenter;
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
if(empty($name_err) && empty($email_err) && empty($phoneNumber_err) && empty($carPlateNo_err) && empty($carBrand_err) && empty($carModel_err) && empty($carYear_err) && empty($services_err) && empty($remark_err) && empty($serviceCenter_err) && empty($appointmentDate_err) && empty($appointmentTime_err)) {
    // Prepare an insert statement
    $sql = "INSERT INTO carserviceapp (serviceId, name, email, phoneNumber, carPlateNo, carBrand, carModel, carYear, services, remark, serviceCenter, appointmentDate, appointmentTime) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
     
    if($stmt = mysqli_prepare($conn, $sql))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issssssisssss", $serviceId, $name, $email, $phoneNumber, $carPlateNo, $carBrand, $carModel, $carYear, $services, $remark, $serviceCenter, $appointmentDate, $appointmentTime);
        
        // Set parameters
        $serviceId         = $serviceId;
        $name              = $name;
        $email             = $email;
        $phoneNumber       = $phoneNumber;
        $carPlateNo        = $carPlateNo;
        $carBrand          = $carBrand;
        $carModel          = $carModel;
        $carYear           = $carYear;
        $services          = $services;
        $remark            = $remark;
        $serviceCenter     = $serviceCenter;
        $appointmentDate   = $appointmentDate;
        $appointmentTime   = $appointmentTime;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records created successfully. Redirect to landing page
            header("location: manageCarService.php");
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
                    <div class="form-group <?= (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $email; ?>">
                        <span class="help-block"><?= $email_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($phoneNumber_err)) ? 'has-error' : ''; ?>">
                        <label>Phone Number</label>
                        <input type="text" name="phoneNumber" class="form-control" value="<?= $phoneNumber; ?>">
                        <span class="help-block"><?= $phoneNumber_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($carPlateNo_err)) ? 'has-error' : ''; ?>">
                        <label>Car Plate No</label>
                        <input type="text" name="carPlateNo" class="form-control" value="<?= $carPlateNo; ?>">
                        <span class="help-block"><?= $carPlateNo_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($carBrand_err)) ? 'has-error' : ''; ?>">
                        <label>Car Brand</label>
                        <input type="text" name="carBrand" class="form-control" value="<?= $carBrand; ?>">
                        <span class="help-block"><?= $carBrand_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($carModel_err)) ? 'has-error' : ''; ?>">
                        <label>Car Model</label>
                        <input type="text" name="carModel" class="form-control" value="<?= $carModel; ?>">
                        <span class="help-block"><?= $carModel_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($carYear_err)) ? 'has-error' : ''; ?>">
                        <label>Car Year</label>
                        <input type="number" name="carYear" class="form-control" value="<?= $carYear; ?>">
                        <span class="help-block"><?= $carYear_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($services_err)) ? 'has-error' : ''; ?>">
                    <label>Services</label>
                    <select name="services[]" multiple class="form-control">
                        <option value="periodic-maintenance">Periodic Maintenance</option>
                        <option value="brake-system">Brake System</option>
                        <option value="battery">Battery</option>
                        <option value="tyreService">Tyre Service</option>
                        <option value="airconPollenFil">Aircon Pollen Filter</option>
                        <option value="inspection">20-point inspection</option>
                        <option value="airconSystem">Aircon System</option>
                        <option value="suspension">Suspension</option>
                        <option value="generalService">General Service</option>
                        <option value="others">Others</option>
                    </select>
                    <span class="help-block"><?= $services_err;?></span>
                </div>
                    <div class="form-group <?= (!empty($remark_err)) ? 'has-error' : ''; ?>">
                        <label>Remark</label>
                        <textarea name="remark" class="form-control"><?= $remark; ?></textarea>
                        <span class="help-block"><?= $remark_err;?></span>
                    </div>
                    <div class="form-group <?= (!empty($serviceCenter_err)) ? 'has-error' : ''; ?>">
                        <label>Service Center</label>
                        <select name="serviceCenter" class="form-control">
                            <option value="Rawang">Rawang</option>
                            <option value="Puncak Alam">Puncak Alam</option>
                        </select>
                        <span class="help-block"><?= $serviceCenter_err;?></span>
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
                    <a href="manageCarService.php" class="btn btn-default" style="color:red;">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div>
</body>
</html>