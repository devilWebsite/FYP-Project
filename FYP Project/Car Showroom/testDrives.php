<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);

$name = "";
$phoneNumber = "";

if ($isLoggedIn) {
    // Fetch the logged-in user's details from the database
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

    // Fetch user details
    $loggedInUsername = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT name, phoneNumber FROM login WHERE username = ?");
    $stmt->bind_param("s", $loggedInUsername);
    $stmt->execute();
    $stmt->bind_result($name, $phoneNumber);
    $stmt->fetch();
    $stmt->close();

    // Close the connection
    $conn->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!$isLoggedIn) {
        // Redirect to login page if user is not logged in
        echo "<script>
            alert('Login to your account to submit appointment form');
            window.location.href = 'login.php';
        </script>";
        exit;
    } else {
        // Proceed with booking appointment
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

        // Check if the form fields are set and not empty
        $appointmentDate = isset($_POST["appointmentDate"]) ? $_POST["appointmentDate"] : null;
        $appointmentTime = isset($_POST["appointmentTime"]) ? $_POST["appointmentTime"] : null;

        // Validate input
        if ($name && $phoneNumber && $appointmentDate && $appointmentTime) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO testdriveapp (name, phoneNumber, appointmentDate, appointmentTime) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $phoneNumber, $appointmentDate, $appointmentTime);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>
                    alert('Test drive booked successfully! We will contact you soon.');
                    window.location.href = 'testDrives.php';
                </script>";
                exit; // Terminate the script after redirection
            } else {
                // Set error message
                $message = "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Set error message for empty fields
            $message = "Please fill in all required fields.";
        }

        // Close the connection
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <title>FYP Project</title>

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    /* Basic reset */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* Form styling */
    form {
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        color: #666;
    }

    input[type="text"],
    input[type="tel"],
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    button {
        display: inline-block;
        background-color:#ed6c11 ;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #4cae4c;
    }

    /* QA section styling */
    #qa {
        background-color: #f4f4f4; /* Same as body background */
        padding: 10px;
        margin-top: 10px;
        border-radius: 8px;
        text-align: left; /* left the text inside the message box */
        border: 1px solid #ccc; /* Add a light grey border */
        box-shadow: 0 2px 5px rgba(0,0,0,0.2); /* Add a subtle shadow */
    }

    #qa p {
        margin-bottom: 10px;
    }

    /* Close button in QA section */
    #qa button {
        background-color: #d9534f;
        padding: 5px 10px;
        font-size: 0.8em;
    }

    #qa button:hover {
        background-color: #c9302c;
    }

.hidden {
    display: none;
}

        /* Dropdown content (hidden by default) */
        .dropdown-contentX {
    display: none;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.2); /* Black color with transparency */
    min-width: 160px;
    min-height: 90px;
    z-index: 1;
    font-size: 12px; /* Font size */
}

/* Links inside the dropdown */
.dropdown-contentX a {
    color: black; /* Text color */
    padding: 10px 14px;
    text-decoration: none;
    display: block;
}

/* Change link color on hover */
.dropdown-contentX a:hover {
    background-color: #ddd; /* Light grey background on hover */
}

/* Show the dropdown menu on hover */
.dropdownX:hover .dropdown-contentX {
    display: block;
}

/* Add this to ensure the dropdown works on click as well */
.dropdownX > span:active + .dropdown-contentX {
    display: block;
}

#favorites {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
        }
        #favorites .content {
            position: relative;
            margin: 10% auto;
            width: 80%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            animation-name: slideIn;
            animation-duration: 0.5s;
        }
        @keyframes slideIn {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
        }


    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
            if (isLoggedIn) {
                document.getElementById('name').value = "<?php echo htmlspecialchars($name); ?>";
                document.getElementById('phone').value = "<?php echo htmlspecialchars($phoneNumber); ?>";
                document.getElementById('name').readOnly = true;
                document.getElementById('phone').readOnly = true;
            }
        });
    </script>

    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.php" class="logo">Car United<em> Website</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.php" >Home</a></li>
                            <li><a href="carBrands.php">Brands</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >Services</a>
                              
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="carService.php">Car Service</a>
                                    <a class="dropdown-item" href="testDrives.php">Test Drives</a>
                                </div>
                            </li>
                            <li><a href="finance.php">Finance</a></li> 
                            <li><a href="contactUs.php">Contact Us</a></li> 
                            <?php
                            // Check if the user is logged in by checking if the session variable 'username' is set
                            if (isset($_SESSION['username'])) {
                                // If the user is logged in, display their username and a dropdown menu
                                echo "<li class='dropdownX' style='position: relative;font-size: 15.7px; color: black; top: 7.2px;'>";
                                echo "Welcome, " . htmlspecialchars($_SESSION['username']);
                                echo "<div class='dropdown-contentX'>";
                                echo "<a href='profileCust.php'>Profile</a>";
                                echo '<a href="#" id="viewFavorites">My Favorites</a>';
                                echo '<a href="CustAppointment.php" id="">My Appointments</a>';
                                echo "<a href='logout.php'>Logout</a>";
                                echo "</div>";
                                echo "</li>";
                            } else {
                                // If the user is not logged in, display the login link
                                echo "<li><a href='login.php'>Login</a></li>";
                            }
                            ?>
                       </ul>        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div id="favorites">
        <div class="content">
            <span class="close" onclick="closeFavorites()">X</span>
            <h3>My Favorites</h3><br>
            <div id="favoritesList">
                <!-- Favorites will be loaded here -->
            </div>
        </div>
    </div>

    <section class="section section-bg" id="call-to-action" style="background-image: url(assets/images1/banner-image-1-1920x500.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cta-content">
                        <br>
                        <br>
                        <h2>Test <em>Drives</em></h2>
                        <p>Get Ready for the Ultimate Drive. Book your test drive today and experience the thrill of the open road with the car of your dreams!</p>
                    </div>
                </div>
            </div>
        </div>
    </section><br><br>

    <!-- ***** Our Classes Start ***** -->
    <section class="section" id="our-classes">
        <h2 style="text-align: center;">Test Drive Appointment</h2>
        <p style="text-align: center;">Book a test drive today and explore more similar cars at this Experience Center.</p>

        <form id="testDriveForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter your name here" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phoneNumber" placeholder="0123456789" required>

    <label for="appointmentDate">Select Date:</label>
    <input type="date" id="appointmentDate" name="appointmentDate" class="date-picker" min="2024-04-20" max="2050-12-31" required>

    <div id="time-container" class="hidden">
        <label for="time-options">Select Time:</label>
        <select id="time-options" name="appointmentTime" required></select>
    </div>

    <button type="submit" class="btn btn-primary">Book Appointment</button>
    <?php
    if (isset($message)) {
        echo "<div class='alert alert-danger mt-3'>" . htmlspecialchars($message) . "</div>";
    }
    ?>
</form>
        <!-- Trigger button -->
        <button id="qa-trigger" style="font-size: 13px; display: block; margin: 0 auto;">Why are some slots unavailable?</button>
        <!-- Message box -->
        <div id="qa" style="display: none;">
        <p style="font-size: 14px;">Some appointment slots may not be available due to car in transit or scheduled maintenance. Secure the car by booking online or test drive other cars in store.</p>    
        </div>
    </section>
    <!-- ***** Our Classes End ***** -->

    <script>
document.addEventListener('DOMContentLoaded', function() {
    var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    const dateInput = document.getElementById('appointmentDate');
    const timeContainer = document.getElementById('time-container');
    const timeOptions = document.getElementById('time-options');

    dateInput.addEventListener('click', function(event) {
        if (!isLoggedIn) {
            alert('Login to your account to submit inquiry form');
            event.preventDefault(); // Prevent the date input from opening
            window.location.href = 'login.php'; // Redirect to login page
        }
    });

    dateInput.addEventListener('change', function() {
        if (dateInput.value && isLoggedIn) {
            fetchAvailableTimeSlots(dateInput.value);
            timeContainer.classList.remove('hidden');
        } else {
            timeContainer.classList.add('hidden');
        }
    });

    async function fetchAvailableTimeSlots(date) {
        try {
            const response = await fetch(`fetchTimeSlots.php?date=${date}`);
            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }
            const data = await response.json();
            updateTimeOptions(data.slots);
        } catch (error) {
            console.error('Error fetching time slots:', error);
        }
    }

    function updateTimeOptions(slots) {
        const timeOptions = document.getElementById('time-options');
        timeOptions.innerHTML = ''; // Clear existing options

        const timeSlots = [
            '09:00-11:00',
            '11:00-13:00',
            '13:00-15:00',
            '15:00-17:00'
        ];

        timeSlots.forEach(slot => {
            const option = document.createElement('option');
            option.value = slot;
            option.textContent = slot.replace('-', ' - ');
            if (slots.includes(slot)) {
                option.disabled = true; // Disable booked slots
                option.classList.add('dot-red'); // Add red dot
            } else {
                option.classList.add('dot-green'); // Add green dot
            }
            timeOptions.appendChild(option);
        });
    }
});
</script>

    <script>

const viewFavorites = document.getElementById('viewFavorites');
const favoritesModal = document.getElementById('favorites');

viewFavorites.addEventListener('click', function () {
    favoritesModal.style.display = 'block';
    loadFavorites();
    scrollToTop();
});

function closeFavorites() {
    favoritesModal.style.display = 'none';
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function loadFavorites() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_favourites.php', true);
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById('favoritesList').innerHTML = this.responseText;
            addRemoveFavoriteListeners(); // Add event listeners to remove buttons
        }
    };
    xhr.send();
}

function addRemoveFavoriteListeners() {
    const removeButtons = document.querySelectorAll('.removeFavorite');
    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const favoriteItem = this.closest('.favoriteItem');
            const id = favoriteItem.getAttribute('data-id');
            removeFavorite(id, favoriteItem);
        });
    });
}

function removeFavorite(id, favoriteItem) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'remove_favorite.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status === 200) {
            console.log(this.responseText);
            if (this.responseText === 'Favorite removed successfully!') {
                favoriteItem.remove();
            } else {
                alert('Failed to remove favorite.');
            }
        }
    };
    xhr.send('id=' + encodeURIComponent(id));
}

        
        // Function to toggle the message box visibility
        document.getElementById('qa-trigger').onclick = function() {
                var qaBox = document.getElementById('qa');
                if (qaBox.style.display === 'none') {
                    qaBox.style.display = 'block';
                } else {
                    qaBox.style.display = 'none';
                }
            };


    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('appointmentDate');
        const timeContainer = document.getElementById('time-container');

        dateInput.addEventListener('change', function() {
            if (dateInput.value) {
                fetchAvailableTimeSlots(dateInput.value);
                timeContainer.classList.remove('hidden');
            } else {
                timeContainer.classList.add('hidden');
            }
        });
    });

/////////////////////////////////////////////////////////////
    dateInput.addEventListener('change', () => {
        // Check if the selected date is a weekday (Monday to Saturday)
        const selectedDate = new Date(dateInput.value);
        const dayOfWeek = selectedDate.getDay(); // 0 (Sunday) to 6 (Saturday)

        if (dayOfWeek >= 1 && dayOfWeek <= 6) {
            // Weekday selected, show time options
            timeOptions.style.display = 'block';
        } else {
            // Sunday or invalid date selected, hide time options
            timeOptions.style.display = 'none';
            // Reset the date input value to prevent selecting Sundays
            dateInput.value = ''; // Or any other method to reset the date input
            alert("Appointment date can be choosed from Monday to Saturday.");
        }
    });

    // Disable Sundays in the date picker
    dateInput.addEventListener('input', () => {
        const selectedDate = new Date(dateInput.value);
        const dayOfWeek = selectedDate.getDay(); // 0 (Sunday) to 6 (Saturday)

        if (dayOfWeek === 0) {
            // Sunday selected, reset the date input value
            dateInput.value = ''; // Or any other method to reset the date input
            alert("Appointment date can be choosed from Monday to Saturday.");
        }
    });
    function bookTestDrive() {
            // Implement your logic to handle form submission here
            // You can send the form data to a server or perform any other actions
            alert("Test drive booked successfully! We will back soon");
        }
    </script>

<script>
        // Get today's date in the format YYYY-MM-DD
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        // Set the min attribute to today's date
        document.getElementById('appointmentDate').setAttribute('min', today);
        document.getElementById('appointmentDate').setAttribute('max', '2050-12-31');
    </script>


    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/mixitup.js"></script> 
    <script src="assets/js/accordions.js"></script>
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

  </body>
</html>