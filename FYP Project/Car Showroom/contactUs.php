<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$customerName = "";
$customerEmail = "";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch customer details from database
    $sql = "SELECT name, email FROM login WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        
        if ($stmt->execute()) {
            $stmt->bind_result($customerName, $customerEmail);
            $stmt->fetch();
        }
        
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        $message = "You must be logged in to submit an inquiry.";
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $inquiry_message = $_POST['message'];

        $sql = "INSERT INTO inquiry (name, email, subject, message) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $name, $email, $subject, $inquiry_message);

            if ($stmt->execute()) {
                // Set a success flag
                $_SESSION['form_success'] = true;

                // Redirect to avoid form resubmission on page refresh
                header("Location: contactUs.php?success=1");
                exit();
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

$conn->close();
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
        /* Dropdown content (hidden by default) */
        .dropdown-contentX {
            display: none;
            position: absolute;
            background-color: rgba(0, 0, 0, 0.2);
            min-width: 160px;
            min-height: 90px;
            z-index: 1;
            font-size: 12px;
        }

        /* Links inside the dropdown */
        .dropdown-contentX a {
            color: black;
            padding: 10px 14px;
            text-decoration: none;
            display: block;
        }

        /* Change link color on hover */
        .dropdown-contentX a:hover {
            background-color: #ddd;
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
                            <li><a href="index.php">Home</a></li>
                            <li><a href="carBrands.php">Brands</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Services</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="carService.php">Car Service</a>
                                    <a class="dropdown-item" href="testDrives.php">Test Drives</a>
                                </div>
                            </li>
                            <li><a href="finance.php">Finance</a></li>
                            <li><a href="contactUs.php" class="active">Contact Us</a></li>
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

            <!-- Favorites will be loaded here -->
        <section class="section section-bg" id="call-to-action" style="background-image: url(assets/images/banner-image-1-1920x500.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cta-content">
                        <br>
                        <br>
                        <h2>Feel free to <em>Contact Us</em></h2>
                        <p>Our team is ready to assist you with any inquiries about our car collection and services. Reach out to us via email or phone, and we'll ensure a prompt and informative response to enhance your experience with us.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Features Item Start ***** -->
    <section class="section" id="features">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                        <h2>contact <em> info</em></h2>
                        <img src="assets/images/line-dec.png" alt="waves">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>

                    <h5><a href="#">03-60915653</a></h5>

                    <br>
                </div>

                <div class="col-md-4">
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>

                    <h5><a href="#">membercar1778@gmail.com</a></h5>

                    <br>
                </div>

                <div class="col-md-4">
                    <div class="icon">
                        <i class="fa fa-map-marker"></i>
                    </div>

                    <h5>Taman Bukit Rawang Jaya 2</h5>

                    <br>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Item End ***** -->

    <!-- ***** Contact Us Area Starts ***** -->
    <section class="section" id="contact-us" style="margin-top: 0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div id="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19434.20509637282!2d101.56664076532327!3d3.334646569589911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc42665af9dcf1%3A0x6b7ad90ff9c20798!2sMEMBER%20CAR%20UNITED!5e0!3m2!1sen!2smy!4v1717657782513!5m2!1sen!2smy" width="100%" height="600px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="contact-form section-bg" style="background-image: url(assets/images/contact-1-720x480.jpg)">
                        <form id="contact" action="contactUs.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" id="name" placeholder="
                                        Your Name*" value="<?php echo htmlspecialchars($customerName); ?>" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email*" value="<?php echo htmlspecialchars($customerEmail); ?>" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="subject" type="text" id="subject" placeholder="Subject">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" id="message" placeholder="Message" required=""></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button id="reschedule-button" type="submit" class="main-button">Send Message</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                        <input type="hidden" id="login-status" value="<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Contact Us Area Ends ***** -->


    <script>
        
document.addEventListener('DOMContentLoaded', function () {
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

});

document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('contact').addEventListener('submit', function (event) {
            const loggedIn = document.getElementById('login-status').value === 'true';
            if (!loggedIn) {
                event.preventDefault();
                if (confirm("You must be logged in to submit an inquiry. Would you like to log in now?")) {
                    window.location.href = 'login.php';
                }
            return;
        }

        // Reschedule button event listener
        const rescheduleButton = document.getElementById('reschedule-button');
        if (rescheduleButton) {
            rescheduleButton.addEventListener('click', () => {
                alert('Inquiry submitted successfully! We will get back to you shortly. Thank you.');
            });
        }

        // Display the success message after the form is successfully submitted
        setTimeout(() => {
            alert('Inquiry submitted successfully! We will get back to you shortly. Thank you.');
            document.getElementById('contact').reset(); // Clear the form fields
        }, 100); // Show the message and clear the form slightly after submission
    });
});


</script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/animation.js"></script>
    <script src="assets/js/imagesloaded.js"></script>
    <script src="assets/js/custom.js"></script>

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
