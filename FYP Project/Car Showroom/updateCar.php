<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables with empty values
$id = $carType = $price = $year = $status = $mileage = $transmission = $engine = $productImg = $otherImg = $newCar = "";
$carType_err = $price_err = $year_err = $status_err = $mileage_err = $transmission_err = $engine_err = $newCar_err = "";

// Check if ID parameter is set in the URL
if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = trim($_GET['id']);
} else {
    die("Error: ID parameter is missing.");
}

// Fetch existing record when the page loads
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $sql = "SELECT * FROM carlist WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $carType = $row["carType"];
                $price = $row["price"];
                $year = $row["year"];
                $status = $row["status"];
                $mileage = $row["mileage"];
                $transmission = $row["transmission"];
                $engine = $row["engine"];
                $productImg = $row["productImg"];
                $otherImg = $row["otherImg"];
                $newCar = $row["newCar"];
            } else {
                die("Error: Record not found.");
            }
        } else {
            die("Error: Could not execute query.");
        }
        $stmt->close();
    } else {
        die("Error: Could not prepare query.");
    }
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input values
    $input_carType = trim($_POST["carType"]);
    if (empty($input_carType)) {
        $carType_err = "Please enter a car type.";
    } else {
        $carType = $input_carType;
    }

    $input_price = trim($_POST["price"]);
    if (empty($input_price)) {
        $price_err = "Please enter the price.";
    } else {
        $price = $input_price;
    }

    $input_year = trim($_POST["year"]);
    if (empty($input_year)) {
        $year_err = "Please enter the year.";
    } else {
        $year = $input_year;
    }

    $input_mileage = trim($_POST["mileage"]);
    if (empty($input_mileage)) {
        $mileage_err = "Please enter the mileage.";
    } else {
        $mileage = $input_mileage;
    }

    $input_transmission = trim($_POST["transmission"]);
    if (empty($input_transmission)) {
        $transmission_err = "Please select the transmission type.";
    } else {
        $transmission = $input_transmission;
    }

    $input_engine = trim($_POST["engine"]);
    if (empty($input_engine)) {
        $engine_err = "Please enter the engine type.";
    } else {
        $engine = $input_engine;
    }

    // Handle the newCar checkbox value
    $newCar = isset($_POST['newCar']) ? 'New' : 'Non-New';

    // Handle the status input
    $input_status = trim($_POST["status"] ?? "");
    $valid_statuses = ['Available', 'Unavailable', 'Sold'];

    if (empty($input_status)) {
        $status_err = "Please select the status.";
    } elseif (!in_array($input_status, $valid_statuses)) {
        $status_err = "Please select a valid status.";
    } else {
        $status = $input_status;
    }

    // Check for errors before updating the database
    if (empty($carType_err) && empty($price_err) && empty($year_err) && empty($status_err) && empty($mileage_err) && empty($transmission_err) && empty($engine_err)) {
        $sql = "UPDATE carlist SET carType=?, price=?, year=?, status=?, mileage=?, transmission=?, engine=?, newCar=? WHERE id=?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssssi", $carType, $price, $year, $status, $mileage, $transmission, $engine, $newCar, $id);

            if ($stmt->execute()) {
                header("location: viewCar.php?id=" . $id);
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } else {
            echo "Error: Could not prepare update statement.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<style>
                body{
            background-color: #f2f2f2;
        }
</style>
</head>
<body>
    <div class="container">
        <h2>Update Car Details</h2>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="carType">Car Type</label>
                <input type="text" name="carType" class="form-control" value="<?= htmlspecialchars($carType); ?>" readonly>
                <span class="text-danger"><?= $carType_err; ?></span>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($price); ?>">
                <span class="text-danger"><?= $price_err; ?></span>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="text" name="year" class="form-control" value="<?= htmlspecialchars($year); ?>" readonly>
                <span class="text-danger"><?= $year_err; ?></span>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="Available" <?= ($status == 'Available') ? 'selected' : ''; ?>>Available</option>
                    <option value="Unavailable" <?= ($status == 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                    <option value="Sold" <?= ($status == 'Sold') ? 'selected' : ''; ?>>Sold</option>
                </select>
                <span class="text-danger"><?= $status_err; ?></span>
            </div>
            <div class="form-group">
                <label for="mileage">Mileage</label>
                <input type="text" name="mileage" class="form-control" value="<?= htmlspecialchars($mileage); ?>" readonly>
                <span class="text-danger"><?= $mileage_err; ?></span>
            </div>
            <div class="form-group">
                <label for="transmission">Transmission</label>
                <select name="transmission" class="form-control">
                    <option value="Manual" <?= ($transmission == 'Manual') ? 'selected' : ''; ?>>Manual</option>
                    <option value="Automatic" <?= ($transmission == 'Automatic') ? 'selected' : ''; ?>>Automatic</option>
                </select>
                <span class="text-danger"><?= $transmission_err; ?></span>
            </div>
            <div class="form-group">
                <label for="engine">Engine</label>
                <input type="text" name="engine" class="form-control" value="<?= htmlspecialchars($engine); ?>" readonly>
                <span class="text-danger"><?= $engine_err; ?></span>
            </div>

            <div class="form-row">
    <div class="col-md-6">
        <div class="form-group" style='float: left;'>
            <label class="checkbox-inline float-right">
                <input type="checkbox" name="newCar" <?= ($newCar == 'New') ? 'checked' : ''; ?>> New Car
            </label>
        </div>
    </div>
</div>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
                <a href="viewCar.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
