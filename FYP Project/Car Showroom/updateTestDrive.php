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
$testDriveId = $name = $phoneNumber = $appointmentDate = $appointmentTime = $remark = "";
$name_err = $phoneNumber_err = $appointmentDate_err = $appointmentTime_err = $remark_err = "";

// Check if test drive ID is provided via GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $testDriveId = $_GET['id'];

    // Fetch data from the database based on test drive ID
    $sql = "SELECT testDriveId, name, phoneNumber, appointmentDate, appointmentTime, remark FROM testdriveapp WHERE testDriveId = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $testDriveId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Retrieve individual field values
                $testDriveId = $row["testDriveId"]; // Assign testDriveId
                $name = $row["name"];
                $phoneNumber = $row["phoneNumber"];
                $appointmentDate = $row["appointmentDate"];
                $appointmentTime = $row["appointmentTime"];
                $remark = $row['remark'];
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
    $testDriveId = $_POST['testDriveId'];

    // Validate name
    $input_name = trim($_POST["name"] ?? "");
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } else {
        $name = $input_name;
    }

    // Validate phone number
    $input_phoneNumber = trim($_POST["phoneNumber"] ?? "");
    if (empty($input_phoneNumber)) {
        $phoneNumber_err = "Please enter a phone number.";
    } else {
        $phoneNumber = $input_phoneNumber;
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

    // Validate remark
    $input_remark = trim($_POST["remark"] ?? "");
    $remark = $input_remark; // Assign the input remark value to the remark variable

    // Check input errors before updating the database
    if (empty($name_err) && empty($phoneNumber_err) && empty($appointmentDate_err) && empty($appointmentTime_err) && empty($remark_err)) {
        // Prepare an update statement
        $sql = "UPDATE testdriveapp SET name=?, phoneNumber=?, appointmentDate=?, appointmentTime=?, remark=? WHERE testDriveId=?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssi", $name, $phoneNumber, $appointmentDate, $appointmentTime, $remark, $testDriveId);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: manageTestDrives.php");
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
    <title>Update Test Drive</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
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
            <span class="text-danger"><?= $name_err; ?></span>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phoneNumber" class="form-control" value="<?= htmlspecialchars($phoneNumber); ?>">
            <span class="text-danger"><?= $phoneNumber_err; ?></span>
        </div>
        <div class="form-group">
            <label>Select Appointment Date</label>
            <input type="date" name="appointmentDate" class="form-control" value="<?= htmlspecialchars($appointmentDate); ?>">
            <span class="text-danger"><?= $appointmentDate_err; ?></span>
        </div>
        <div class="form-group">
            <label>Select Appointment Time</label>
            <select name="appointmentTime" class="form-control">
                <?php
                $timeSlots = [
                    "09:00-11:00",
                    "11:00-13:00",
                    "13:00-15:00",
                    "15:00-17:00"
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

        <input type="hidden" name="testDriveId" value="<?= htmlspecialchars($testDriveId); ?>">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="manageTestDrives.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
