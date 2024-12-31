<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$serviceId = $name = $email = $carPlateNo = $carBrand = $carModel = $status = $carYear = $services = $remark = $serviceCenter = $appointmentDate = $appointmentTime = "";
$name_err = $email_err = $carPlateNo_err = $carBrand_err = $carModel_err = $status_err = $carYear_err = $services_err = $remark_err = $serviceCenter_err = $appointmentDate_err = $appointmentTime_err = "";

// Check if service ID is provided via GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $serviceId = $_GET['id'];

    // Fetch data from the database based on service ID
    $sql = "SELECT * FROM carserviceapp WHERE serviceId = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $serviceId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Retrieve individual field values
                $name            = $row["name"];
                $email           = $row["email"];
                $carPlateNo      = $row["carPlateNo"];
                $carModel        = $row["carModel"];
                $carYear         = $row["carYear"];
                $services        = $row["services"]; 
                $status          = $row["status"];
                $serviceCenter   = $row["serviceCenter"];
                $appointmentDate = $row["appointmentDate"];
                $appointmentTime = $row["appointmentTime"];
                $remark          = $row["remark"];

            } else {
                echo "No records found.";
                exit();
            }
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
            exit();
        }
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
        exit();
    }
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceId = $_POST['serviceId'];

    // Validate name
    $input_name = trim($_POST["name"] ?? "");
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } else {
        $name = $input_name;
    }

    // Validate email
    $input_email = trim($_POST["email"] ?? "");
    if (empty($input_email)) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) { // Email format validation
        $email_err = "Please enter a valid email address.";
    } else {
        $email = $input_email;
    }

    // Validate carPlateNo
    $input_carPlateNo = trim($_POST["carPlateNo"] ?? "");
    if (empty($input_carPlateNo)) {
        $carPlateNo_err = "Please enter a car plate no.";
    } else {
        $carPlateNo = $input_carPlateNo;
    }

    // Validate carModel
    $input_carModel = trim($_POST["carModel"] ?? "");
    if (empty($input_carModel)) {
        $carModel_err = "Please enter a car model.";
    } else {
        $carModel = $input_carModel;
    }

    // Validate carYear
    $input_carYear = trim($_POST["carYear"] ?? "");
    if (empty($input_carYear)) {
        $carYear_err = "Please enter a car year.";
    } elseif (!is_numeric($input_carYear) || strlen($input_carYear) != 4) { // Check if it's a valid 4-digit year
        $carYear_err = "Please enter a valid 4-digit year.";
    } else {
        $carYear = $input_carYear;
    }

    // Validate services
    $input_services = trim($_POST["services"] ?? "");
    if (empty($input_services)) {
        $services_err = "Please select at least one service.";
    } else {
        $services = $input_services;
    }

    // Validate remark
    $input_remark = trim($_POST["remark"] ?? "");
    $remark = $input_remark; // Assign the input remark value to the remark variable

    // Validate serviceCenter
    $input_serviceCenter = trim($_POST["serviceCenter"] ?? "");
    if (empty($input_serviceCenter)) {
        $serviceCenter_err = "Please enter a service center.";
    } else {
        $serviceCenter = $input_serviceCenter;
    }

    // Validate status
    $input_status = trim($_POST["status"] ?? "");
    if (empty($input_status)) {
        $status_err = "Please choose status.";
    } else {
        $status = $input_status;
    }

    // Validate appointmentDate
    $input_appointmentDate = trim($_POST["appointmentDate"] ?? "");
    if (empty($input_appointmentDate)) {
        $appointmentDate_err = "Please select an appointment date.";
    } else {
        // Perform further validation if needed (e.g., format)
        $appointmentDate = $input_appointmentDate;
    }

    // Validate appointmentTime
    $input_appointmentTime = trim($_POST["appointmentTime"] ?? "");
    if (empty($input_appointmentTime)) {
        $appointmentTime_err = "Please select an appointment time.";
    } else {
        // Perform further validation if needed (e.g., format)
        $appointmentTime = $input_appointmentTime;
    }

    // Check input errors before updating the database
    if (empty($name_err) && empty($email_err) && empty($carPlateNo_err) && empty($carBrand_err) && empty($carModel_err) && empty($carYear_err) && empty($status_err) && empty($services_err) && empty($serviceCenter_err) && empty($appointmentDate_err) && empty($appointmentTime_err) && empty($remark_err)) {
        // Prepare an update statement
        $sql = "UPDATE carserviceapp SET name=?, email=?, carPlateNo=?, carBrand=?, carModel=?, carYear=?, services=?, remark=?, status=?, serviceCenter=?, appointmentDate=?, appointmentTime=? WHERE serviceId=?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssisissssssi", $name, $email, $carPlateNo, $carBrand, $carModel, $carYear, $services, $remark, $status, $serviceCenter, $appointmentDate, $appointmentTime, $serviceId);
        
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: manageCarService.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later. Error: " . $stmt->error;
            }
        } else {
            echo "Error preparing SQL statement: " . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Car Service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body{
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Appointment Form</h2>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>" readonly>
            <span class="text-danger"><?= $name_err;?></span>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>">
            <span class="text-danger"><?= $email_err;?></span>
        </div>
        <div class="form-group">
            <label>Car Plate No</label>
            <input type="text" name="carPlateNo" class="form-control" value="<?= htmlspecialchars($carPlateNo); ?>" readonly>
            <span class="text-danger"><?= $carPlateNo_err;?></span>
        </div>
        <div class="form-group">
            <label>Car Model</label>
            <input type="text" name="carModel" class="form-control" value="<?= htmlspecialchars($carModel); ?>" readonly>
            <span class="text-danger"><?= $carModel_err;?></span>
        </div>
        <div class="form-group">
            <label>Car Year</label>
            <input type="text" name="carYear" class="form-control" value="<?= htmlspecialchars($carYear); ?>" readonly>
            <span class="text-danger"><?= $carYear_err;?></span>
        </div>
        <div class="form-group">
            <label>Services</label>
            <input type="text" name="services" class="form-control" value="<?= htmlspecialchars($services); ?>" readonly>
            <span class="text-danger"><?= $services_err;?></span>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Pending" <?= ($status === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Resolved" <?= ($status === 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
            </select>
            <span class="text-danger"><?= $status_err; ?></span>
        </div>
        <div class="form-group">
            <label for="serviceCenter">Service Center</label>
            <select name="serviceCenter" id="serviceCenter" class="form-control">
                <option value="Rawang" <?= ($serviceCenter === 'Rawang') ? 'selected' : ''; ?>>Rawang</option>
                <option value="Puncak Alam" <?= ($serviceCenter === 'Puncak Alam') ? 'selected' : ''; ?>>Puncak Alam</option>
            </select>
            <span class="text-danger"><?= $serviceCenter_err; ?></span>
        </div>
        <div class="form-group">
            <label>Select Appointment Date</label>
            <input type="date" name="appointmentDate" class="form-control" value="<?= htmlspecialchars($appointmentDate); ?>">
            <span class="text-danger"><?= $appointmentDate_err;?></span>
        </div>
        <div class="form-group">
            <label>Select Appointment Time</label>
            <select name="appointmentTime" class="form-control">
                <?php
                $timeSlots = [
                    "09:00 - 10:00",
                    "10:00 - 11:00",
                    "11:00 - 12:00",
                    "13:00 - 14:00",
                    "14:00 - 15:00",
                    "15:00 - 16:00",
                    "16:00 - 17:00",
                    "17:00 - 18:00",
                    "18:00 - 19:00"
                ];
                
                foreach ($timeSlots as $slot) {
                    $selected = ($slot == $appointmentTime) ? "selected" : "";
                    echo "<option value=\"$slot\" $selected>$slot</option>";
                }
                ?>
            </select>
            <span class="text-danger"><?= $appointmentTime_err; ?></span>
        </div>

        <div class="form-group">
            <label>Remark</label>
            <textarea name="remark" class="form-control <?php echo (!empty($remark_err)) ? 'is-invalid' : ''; ?>" style="height: 150px; width: 95%; margin-top: 6px; font-size: 16px;"><?php echo htmlspecialchars($remark); ?></textarea>
            <span class="invalid-feedback"><?php echo $remark_err;?></span>
        </div>

        <input type="hidden" name="serviceId" value="<?= $serviceId; ?>">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="manageCarService.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
