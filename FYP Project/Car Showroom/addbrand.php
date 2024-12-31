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
$name = $imagePath = $status = "";
$name_err = $imagePath_err = $status_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate imagePath
    if(empty(trim($_POST["imagePath"]))) {
        $imagePath_err = "Please select an image path.";
    } else {
        $imagePath = trim($_POST["imagePath"]);
    }

    // Validate status
    if(empty(trim($_POST["status"]))) {
        $status_err = "Please provide valid status";     
    } else {
        $status = trim($_POST["status"]);
    }
    
    // Check input errors before inserting in the database
    if (empty($name_err) && empty($imagePath_err) && empty($status_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO brandlist (name, imagePath, status) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $name, $imagePath, $status);

            // Set parameters and execute the statement
            $stmt->execute();

            // Close statement
            $stmt->close();

            // Redirect to manageBrand.php after successful insertion
            header("Location: manageBrand.php");
            exit();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Add New Brand</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <h2>Add New Brand</h2>
                </div>
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="name">Brand Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="imagePath">Brand Image:</label>
                        <input type="file" class="form-control-file" id="imagePath" name="imagePath" accept="image/*" required onchange="previewImage(event)">
                        <img id="preview" src="#" alt="Preview" style="display: none; max-width: 200px; margin-top: 10px;">
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Insert New Record" href="manageBrand.php">
                    <a href="manageBrand.php" class="btn btn-default" style="color:red;">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div> 
<script>
    function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block'; // Show the image
    };
    reader.readAsDataURL(event.target.files[0]);
}

</script>
</body>
</html>
