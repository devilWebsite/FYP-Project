<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['username'])) {
        echo "<script>
            alert('Login to your account to submit inquiry form');
            window.location.href = 'login.php';
        </script>";
    } else {
        // Handle the appointment booking
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

        // Retrieve form data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phoneNumber"];
        $carPlateNo = $_POST["carPlateNo"];
        $mileage = $_POST["mileage"];
        $carBrand = $_POST["carBrand"];
        $carModel = $_POST["carModel"];
        $carYear = $_POST["carYear"];
        
        // Check if services checkbox array is set and not empty
        $services = isset($_POST["services"]) && is_array($_POST["services"]) ? implode(", ", $_POST["services"]) : "";
        
        $remark = $_POST["remark"];
        $serviceCenter = $_POST["serviceCenter"];
        $appointmentDate = $_POST["appointmentDate"];
        $appointmentTime = $_POST["appointmentTime"];
    
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO carserviceapp (email, name, phoneNumber, carPlateNo, mileage, carBrand, carModel, carYear, services, remark, serviceCenter, appointmentDate, appointmentTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssisssss", $email, $name, $phoneNumber, $carPlateNo, $mileage, $carBrand, $carModel, $carYear, $services, $remark, $serviceCenter, $appointmentDate, $appointmentTime);
    
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to another page with a confirmation message
            echo "<script>
                alert('Your car service booked successfully! We will contact you soon.');
                window.location.href = 'testDrives.php';
            </script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
