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

$message = "Successfully Registered";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        // Handle sign-up
        $name = $_POST['name'];
        $phone_number = $_POST['phoneNumber'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

        $sql = "INSERT INTO login (name, phoneNumber, email, username, password) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $name, $phone_number, $email, $username, $password);

            if ($stmt->execute()) {
                $message = "New record created successfully";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } elseif (isset($_POST['signin'])) {
        // Handle sign-in
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT password FROM login WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $message = "Invalid username or password";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    // Retrieve data from POST request
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM adminLogin WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username exists, now check password
        $row = $result->fetch_assoc();
        if ($input_password === $row['password']) {
            // Password is correct, set session variable
            $_SESSION['admin_logged_in'] = true;

            // Redirect to the admin dashboard or another protected page
            header('Location: admin.php');
            exit();
        } else {
            // Invalid password
            echo 'Invalid password.';
        }
    } else {
        // Username does not exist
        echo 'Invalid username.';
    }
    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FYP Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

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
        }

        h2 {
            text-align: center;
        }

        p {
            font-size: 14px;
            font-weight: 100;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
        }

        span {
            font-size: 12px;
        }

        a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }

        button {
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
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }

        form {
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        input {
            background-color: #eee;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                        0 10px 10px rgba(0,0,0,0.22);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container{
            transform: translateX(-100%);
        }

        .overlay {
            background: #ed7032;
            background: -webkit-linear-gradient(to right, #FF4B2B, #ed7032);
            background: linear-gradient(to right, #FF4B2B, #ed7032);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }
        .overlay-container .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 12px 10px;
        }

    </style>
</head>
<body>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="login.php" method="POST">
            <h1>Create Account</h1>
            <span>or use your email for registration</span>
            <input type="text" name="name" placeholder="Name" required />
            <input type="tel" name="phoneNumber" placeholder="Phone Number" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="login.php" method="POST">
            <h1>Sign in</h1>
            <span>or use your account</span>
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <a href="register.php">Forgot your password?</a>
            <button type="submit" name="signin">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <button onclick="window.location.href='index.php';" class="close-btn" style="position: absolute; top: 10px; right: 10px; padding: 9px 10px; border: none; background: none;">
                <i class="fas fa-times"></i>
            </button>
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button><br>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button><br>
            </div>
        </div>
    </div>
</div>

<?php
    if ($message) {
        echo "<p>$message</p>";
    }
    ?>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active"); 
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    document.querySelector('.close-btn').addEventListener('click', function() {
    window.location.href = 'index.php';
});
</script>

</body>
</html>
