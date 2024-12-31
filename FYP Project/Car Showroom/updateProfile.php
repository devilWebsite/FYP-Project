<?php
session_start();
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

// Initialize message variables
$message = "";
$messageType = "";

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle file upload
        if (!empty($_FILES['avatar']['tmp_name'])) {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES['avatar']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message = "File is not an image.";
                $messageType = "error";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['avatar']['size'] > 500000) {
                $message = "Sorry, your file is too large.";
                $messageType = "error";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $messageType = "error";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                // Error messages are already set above
            } else {
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
                    // Update avatar path in the database
                    $avatarPath = $uploadFile;

                    // Update or insert avatar path in user profile table
                    $updateSql = "UPDATE login SET avatar=? WHERE username=?";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bind_param("ss", $avatarPath, $username);
                    $updateStmt->execute();
                    $updateStmt->close();

                    $message = "Avatar uploaded successfully.";
                    $messageType = "success";
                } else {
                    $message = "Sorry, there was an error uploading your file.";
                    $messageType = "error";
                }
            }
        }

        // Handle other form updates (name, email, phone number)
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['tel'])) {
            // Update user details in the database
            $newName = $_POST['name'];
            $newEmail = $_POST['email'];
            $newTel = $_POST['tel'];

            $updateSql = "UPDATE login SET name=?, email=?, phoneNumber=? WHERE username=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ssss", $newName, $newEmail, $newTel, $username);
            $updateStmt->execute();
            $updateStmt->close();
        }

        // Handle password change
        if (isset($_POST['password_current']) && isset($_POST['password']) && isset($_POST['password_confirmation'])) {
            $currentPassword = $_POST['password_current'];
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['password_confirmation'];

            // Check if new password and confirmation match
            if ($newPassword === $confirmPassword) {
                // Fetch current password from the database
                $passwordSql = "SELECT password FROM login WHERE username=?";
                $passwordStmt = $conn->prepare($passwordSql);
                $passwordStmt->bind_param("s", $username);
                $passwordStmt->execute();
                $passwordStmt->bind_result($hashed_password);
                $passwordStmt->fetch();
                $passwordStmt->close();

                // Verify current password
                if (password_verify($currentPassword, $hashed_password)) {
                    // Hash new password and update in the database
                    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updatePasswordSql = "UPDATE login SET password=? WHERE username=?";
                    $updatePasswordStmt = $conn->prepare($updatePasswordSql);
                    $updatePasswordStmt->bind_param("ss", $newHashedPassword, $username);
                    $updatePasswordStmt->execute();
                    $updatePasswordStmt->close();
                    $message = "Password updated successfully.";
                    $messageType = "success";
                } else {
                    $message = "Current password is incorrect.";
                    $messageType = "error";
                }
            } else {
                $message = "New password and confirmation do not match.";
                $messageType = "error";
            }
        }
    }

    // Fetch updated user details from the database
    $sql = "SELECT name, email, phoneNumber FROM login WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($name, $email, $tel);
    $stmt->fetch();
    $stmt->close();
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$conn->close();
?>
