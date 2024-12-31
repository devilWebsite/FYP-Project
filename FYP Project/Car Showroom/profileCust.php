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
        if (!empty($_FILES['pic']['tmp_name'])) {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['pic']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES['pic']['tmp_name']);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $message = "File is not an image.";
                $messageType = "error";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['pic']['size'] > 500000) {
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
                if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadFile)) {
                    // Update pic path in the database
                    $picPath = $uploadFile;

                    // Update or insert pic path in user profile table
                    $updateSql = "UPDATE login SET pic=? WHERE username=?";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bind_param("ss", $picPath, $username);
                    $updateStmt->execute();
                    $updateStmt->close();

                    $message = "pic uploaded successfully.";
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
    $sql = "SELECT name, email, phoneNumber, pic FROM login WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($name, $email, $tel,$picPath);
    $stmt->fetch();
    $stmt->close();
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$conn->close();
?>

<section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Edit Profile
          </p>
        </header>

        <div class="card-content">
        <form method="post" action="profileCust.php" enctype="multipart/form-data">
    <div class="field">
        <label class="label">pic</label>
        <div class="field-body">
            <div class="field file">
                <label class="upload control">
                    <input type="file" name="pic" required>
                </label>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Name</label>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input type="text" name="name" class="input" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <p class="help">Required. Your name</p>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">E-mail</label>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input type="email" name="email" class="input" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <p class="help">Required. Your e-mail</p>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">Phone Number</label>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <input type="tel" name="tel" class="input" value="<?php echo htmlspecialchars($tel); ?>" required>
                </div>
                <p class="help">Required. Your phone number</p>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button green">
                Submit
            </button>
        </div>
    </div>
</form>

        </div>
      </div>


      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Profile
          </p>
        </header>
        <div class="card-content">
            <div class="image w-48 h-48 mx-auto">
                <img src="<?php echo isset($picPath) ? htmlspecialchars($picPath) : 'assets/default-pic.png'; ?>" alt="" class="rounded-full" style = "width: 450px; height: 450px;">
            </div>
        </div>
          <hr>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input type="text" name="name" readonly value="<?php echo htmlspecialchars($name); ?>" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
              <input type="email" name="email"  readonly value="<?php echo htmlspecialchars($email); ?>" class="input is-static">
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>

    <button id="reschedule-button" onclick="window.location.href='index.php'" style="float: right;">Back to Home Page</button>

    <div class="card">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-lock"></i></span>
                Change Password
            </p>
        </header>
        <div class="card-content">
            <form method="post" action="profileCust.php">
                <div class="field">
                    <label class="label">Current password</label>
                    <div class="control">
                        <input type="password" name="password_current" autocomplete="current-password" class="input" required>
                    </div>
                    <p class="help">Required. Your current password</p>
                    
                </div>
                <hr>
                <div class="field">
                    <label class="label">New password</label>
                    <div class="control">
                        <input type="password" autocomplete="new-password" name="password" class="input" required>
                    </div>
                    <p class="help">Required. New password</p>
                </div>
                <div class="field">
                    <label class="label">Confirm password</label>
                    <div class="control">
                        <input type="password" autocomplete="new-password" name="password_confirmation" class="input" required>
                    </div>
                    <p class="help">Required. New password one more time</p>
                </div>
                <hr>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button green">
                            Submit
                        </button>
                    </div>
                </div>
            </form>      
        </div>
    </div>
  </section>
  
  <script>
        function showModal(message, type) {
            var modal = document.getElementById("myModal");
            var modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = message;
            modalContent.className = type;
            modal.style.display = "block";
        }

        window.onload = function() {
            <?php if (!empty($message)) { ?>
                showModal("<?php echo $message; ?>", "<?php echo $messageType; ?>");
            <?php } ?>
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>

  <style>

#reschedule-button {
    background-color: #d47713;
   color: #fff;
    padding: 10px 20px;
   border: none;
   border-radius: 5px;
   cursor: pointer;
    }
   
   #reschedule-button:hover {
    background-color: #444;
    }

            /* Modal styles */
            .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }

    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f6;
    margin: 0;
    padding: 20px;
}

.section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Grid Layout */
.grid {
    display: grid;
    gap: 20px;
}

.grid-cols-1 {
    grid-template-columns: 1fr;
}

@media (min-width: 1024px) {
    .lg\:grid-cols-2 {
        grid-template-columns: 1fr 1fr;
    }
}

/* Card Styles */
.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background: #f5f5f5;
    padding: 16px;
    border-bottom: 1px solid #e5e5e5;
}

.card-header-title {
    font-size: 18px;
    font-weight: bold;
    display: flex;
    align-items: center;
}

.card-header-title .icon {
    margin-right: 10px;
}

.card-content {
    padding: 20px;
}

/* Form Styles */
.field {
    margin-bottom: 20px;
}

.label {
    font-weight: bold;
    margin-bottom: 5px;
}

.control {
    display: flex;
    align-items: center;
}

.input {
    width: 100%;
    padding: 10px;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
}

.input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

.input.is-static {
    background-color: #f5f5f5;
    cursor: not-allowed;
}

.button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button.blue {
    background-color: #007bff;
}

.button.green {
    background-color: #28a745;
}

.button:focus,
.button:hover {
    background-color: #0056b3;
}

.button.green:focus,
.button.green:hover {
    background-color: #218838;
}

/* Image Styles */
.image {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

.image img {
    border-radius: 50%;
}

/* Helpers */
.help {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.hr {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #e5e5e5;
}

  </style>
