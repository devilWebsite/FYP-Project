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
$inquiryId = $name = $email = $subject = $message = $status = $remark = "";
$name_err = $email_err = $status_err = $remark_err = "";

// Check if inquiry ID is provided via GET request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $inquiryId = $_GET['id'];

    // Fetch data from the database based on inquiry ID
    $sql = "SELECT id, name, email, subject, message, status, remark FROM inquiry WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $inquiryId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $email = $row['email'];
                $subject = $row['subject'];
                $message = $row['message'];
                $status = $row['status'];
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
    $inquiryId = $_POST['inquiryId'];

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

    // Validate status
    $input_status = trim($_POST["status"] ?? "");
    $valid_statuses = ['Pending', 'In-Progress', 'Resolved']; // Define valid status options
    if (empty($input_status)) {
        $status_err = "Please select the status.";
    } elseif (!in_array($input_status, $valid_statuses)) { // Check if status is valid
        $status_err = "Please select a valid status.";
    } else {
        $status = $input_status;
    }

    // Validate remark
    $input_remark = trim($_POST["remark"] ?? "");
    $remark = $input_remark; // Assign the input remark value to the remark variable

    // Check input errors before updating the database
    if (empty($name_err) && empty($email_err) && empty($status_err)) {
        // Prepare an update statement
        $sql = "UPDATE inquiry SET name=?, email=?, status=?, remark=? WHERE id=?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssi", $name, $email, $status, $remark, $inquiryId);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: manageInquiries.php");
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
    <title>Update Inquiry</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Inquiry</h2>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>">
            <span class="text-danger"><?= $name_err; ?></span>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>">
            <span class="text-danger"><?= $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" value="<?= htmlspecialchars($subject); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Message</label>
            <input type="text" name="message" class="form-control" value="<?= htmlspecialchars($message); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Pending" <?= $status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="In-Progress" <?= $status == 'In-Progress' ? 'selected' : ''; ?>>In-Progress</option>
                <option value="Resolved" <?= $status == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
            </select>
            <span class="text-danger"><?= $status_err; ?></span>
        </div>

        <div class="form-group">
            <label>Remark</label>
            <textarea name="remark" class="form-control <?= !empty($remark_err) ? 'is-invalid' : ''; ?>" style="height: 150px; width: 95%; margin-top: 6px; font-size: 16px;"><?= htmlspecialchars($remark); ?></textarea>
            <span class="invalid-feedback"><?= $remark_err;?></span>
        </div>

        <input type="hidden" name="inquiryId" value="<?= htmlspecialchars($inquiryId); ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="manageInquiries.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
