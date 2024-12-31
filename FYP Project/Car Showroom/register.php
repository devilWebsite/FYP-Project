<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $dbUsername = "root"; 
    $dbPassword = ""; 
    $dbname = "project2";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if new password and confirm password match
    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE login SET password=? WHERE username=?");
        $stmt->bind_param("ss", $hashedPassword, $username);

        // Execute the statement and check for errors
        if ($stmt->execute()) {
            // Redirect to index.php if the password was updated successfully
            header("Location: login.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Passwords do not match.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
    background-image: url('assets/images1/background2.avif');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    height: 100vh;
    margin: -20px 0 50px;
}

h1 {
    font-weight: bold;
    margin: 0;
    color: #333;
}

form {
    background-color: #FFFFFF;
    border-radius: 15px;
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                0 10px 10px rgba(0,0,0,0.22);
    padding: 40px 50px;
    width: 75%;
    max-width: 300px;
    text-align: center;
}

label {
    display: block;
    text-align: left;
    margin: 10px 0 5px;
    color: #333;
    font-size: 14px;
}

input[type="text"],
input[type="password"] {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
    border-radius: 4px;
}

input[type="submit"] {
    border-radius: 20px;
    border: 1px solid #ff7a38;
    background-color: #ff7a38;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
    cursor: pointer;
    display: block;
    margin: 20px auto;
}

input[type="submit"]:hover {
    background-color: #e76f51;
}

.form-actions {
    margin-top: 30px;
}

.password-container {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: -10px;
    top: 55%; 
    transform: translateY(-50%);
    border: none;
    background: none;
    cursor: pointer;
}

    </style>
</head>
<body>
    <div class="container">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Change Password</h2>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" title="Username" />

            <label for="newPassword">New Password:</label>
            <div class="password-container">
                <input type="password" id="newPassword" name="newPassword" title="New password" />
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPassword')">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <label for="confirmPassword">Confirm Password:</label>
            <div class="password-container">
                <input type="password" id="confirmPassword" name="confirmPassword" title="Confirm new password" />
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <p class="form-actions">
                <input type="submit" value="Change Password" title="Change password" />
            </p>

        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            var input = document.getElementById(inputId);
            var toggleBtn = input.nextElementSibling;

            if (input.type === "password") {
                input.type = "text";
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = "password";
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }

    </script>
</body>
</html>