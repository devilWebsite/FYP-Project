<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);

// Initialize variables to store user details
$userName = "";
$userEmail = "";
$userPhoneNumber = "";

// If user is logged in, fetch their details
if ($isLoggedIn) {
    // Database connection details
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

    // Retrieve user details from database based on session username
    $sessionUsername = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT name, email, phoneNumber FROM login WHERE username = ?");
    $stmt->bind_param("s", $sessionUsername);
    $stmt->execute();
    $stmt->bind_result($userName, $userEmail, $userPhoneNumber);
    $stmt->fetch();

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();
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

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
  h1 {
    text-align: center;
}
h2 {
    margin: 0;
}
#multi-step-form-container {
    margin-top: 5rem;
}
.text-center {
    text-align: center;
}
.mx-auto {
    margin-left: auto;
    margin-right: auto;
}
.pl-0 {
    padding-left: 0;
}
.button {
    padding: 0.7rem 1.5rem;
    border: 1px solid #4361ee;
    background-color: #4361ee;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}
.submit-btn {
    border: 1px solid #0e8584;
    background-color: #0e8584;
}
.mt-3 {
    margin-top: 2rem;
}
.d-none {
    display: none;
}
.form-step {
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    padding: 3rem;
}
.font-normal {
    font-weight: normal;
}
ul.form-stepper {
    counter-reset: section;
    margin-bottom: 3rem;
}
ul.form-stepper .form-stepper-circle {
    position: relative;
}
ul.form-stepper .form-stepper-circle span {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
}
.form-stepper-horizontal {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
ul.form-stepper > li:not(:last-of-type) {
    margin-bottom: 0.625rem;
    -webkit-transition: margin-bottom 0.4s;
    -o-transition: margin-bottom 0.4s;
    transition: margin-bottom 0.4s;
}
.form-stepper-horizontal > li:not(:last-of-type) {
    margin-bottom: 0 !important;
}
.form-stepper-horizontal li {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: start;
    -webkit-transition: 0.5s;
    transition: 0.5s;
}
.form-stepper-horizontal li:not(:last-child):after {
    position: relative;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    height: 1px;
    content: "";
    top: 32%;
}
.form-stepper-horizontal li:after {
    background-color: #dee2e6;
}
.form-stepper-horizontal li.form-stepper-completed:after {
    background-color: #4da3ff;
}
.form-stepper-horizontal li:last-child {
    flex: unset;
}
ul.form-stepper li a .form-stepper-circle {
    display: inline-block;
    width: 40px;
    height: 40px;
    margin-right: 0;
    line-height: 1.7rem;
    text-align: center;
    background: rgba(0, 0, 0, 0.38);
    border-radius: 50%;
}
.form-stepper .form-stepper-active .form-stepper-circle {
    background-color: #4361ee !important;
    color: #fff;
}
.form-stepper .form-stepper-active .label {
    color: #4361ee !important;
}
.form-stepper .form-stepper-active .form-stepper-circle:hover {
    background-color: #4361ee !important;
    color: #fff !important;
}
.form-stepper .form-stepper-unfinished .form-stepper-circle {
    background-color: #f8f7ff;
}
.form-stepper .form-stepper-completed .form-stepper-circle {
    background-color: #0e8584 !important;
    color: #fff;
}
.form-stepper .form-stepper-completed .label {
    color: #0e8584 !important;
}
.form-stepper .form-stepper-completed .form-stepper-circle:hover {
    background-color: #0e8584 !important;
    color: #fff !important;
}
.form-stepper .form-stepper-active span.text-muted {
    color: #fff !important;
}
.form-stepper .form-stepper-completed span.text-muted {
    color: #fff !important;
}
.form-stepper .label {
    font-size: 1rem;
    margin-top: 0.5rem;
}
.form-stepper a {
    cursor: default;
}

/* Style the service options container */
.service-options {
  display: flex;
  flex-wrap: wrap;
  gap: 9px;
}

/* Style each service box */
.service-box {
  flex: 0 1 calc(50% - 9px);
  box-sizing: border-box;
  padding: 9px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f8f8f8;
  cursor: pointer;
  text-align: center;
}
/* Hide the default checkbox */
.service-box input[type="checkbox"] {
  display: none;
}

/* Create a custom checkbox */
.service-box .checkmark {
  display: block;
}

/* Style the input box for "Others" */
.service-box.other input[type="text"] {
  width: calc(90% - 20px);
  margin-top: 5px;
}

/* Change the background color of the service box when checked */
.service-box input[type="checkbox"]:checked + .checkmark {
  background-color: #4CAF50;
  color: white;
}

/* Style the input box */
input[type="text"],
input[type="email"],
input[type="tel"] {
  width: 90%;
  padding: 9px;
  margin: 9px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.button4 {border-radius: 12px;}

.address-box {
  border: 1px solid #000;
  padding: 20px;
  margin: 20px 0;
  background-color: #f8f8f8;
  margin-bottom: 20px;
  cursor: pointer;
}

/*Date and Time */
.date-picker {
    width: 280px;
    height: 35px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;

}

#timeOptions{
    margin-top: 20px;
}

label {
    font-weight: bold;
}

select {
    width: 90%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

#timeOptionsselect {
            display: inline-block;
            width: calc(50% - 9px); /* Adjust spacing as needed */
            margin-right: 9px;
        }

        .service-time {
            flex: 0 1 calc(50% - 9px);
            display: inline-block;
            margin-right: 10px; /* Adjust spacing between boxes */
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            cursor: pointer;
            text-align: center;
            margin-bottom: 10px;
        }

    .service-time input[type="radio"] {
        float: left;
    }

    .service-time label {
        display: block;
        cursor: pointer;
    }

    .service-time input[type="radio"]:checked + label {
        background-color: #ccc; /* Change background color when selected */
    }

    .summary-box {
    border: 2px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    background-color: #f9f9f9;
    width: 34%;
}

.summary-box h3 {
    margin-top: 0;
}

.hidden {
    display: none;
}

.dot-red::before {
    content: '🔴 ';
}

.dot-green::before {
    content: '🟢 ';
}
#time-container {
    margin-top: 14px;
    padding: 5px;
    width: 428px;
}

.d-none { display: none; }

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

OO

</style>


    </head>
    
    <body>
    
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
                                    <a class="dropdown-toggle active" data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false">Services</a>
                                
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item active" href="carService.php">Car Service</a>
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

    <section class="section section-bg" id="call-to-action" style="background-image: url(assets/images/banner-image-1-1920x500.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cta-content">
                        <br>
                        <br>
                        <h2>Car<em> Services</em></h2>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </section><br>

    <div>
    <h1>Book a Service Appointment</h1>

    <div id="multi-step-form-container">
        <!-- Form Steps / Progress Bar -->
        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
            <!-- Step 1 -->
            <li class="form-stepper-active text-center form-stepper-list" step="1">
                <a class="mx-2">
                    <span class="form-stepper-circle">
                        <span>1</span>
                    </span>
                    <div class="label"> Car Details</div>
                </a>
            </li>
            <!-- Step 2 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>2</span>
                    </span>
                    <div class="label text-muted">Service Type</div>
                </a>
            </li>
            <!-- Step 3 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                <a class="mx-3">
                    <span class="form-stepper-circle text-muted">
                        <span>3</span>
                    </span>
                    <div class="label text-muted">Appointment</div>
                </a>
            </li>
            <!-- Step 4 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                 <a class="mx-4">
                    <span class="form-stepper-circle text-muted">
                        <span>4</span>
                    </span>
                    <div class="label text-muted">Summary</div>
                </a>
            </li>
        </ul>
        <!-- Step Wise Form Content -->
        <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" action="appointmentDB.php" method="POST">            
            <!-- Step 1 Content -->
            <section id="step-1" class="form-step">
                <h2 class="font-normal">Car Details</h2>

                <!-- Step 1 input fields -->
                <div class="mt-3">
                <!-- Input field for car plate no -->
                <label for="carPlateNo">Car Plate No.</label><br>
                <input type="text" id="carPlateNo" name="carPlateNo" placeholder="Example: VAR1234" required><br><br>

                <!-- Input field for car plate no -->
                <label for="mileage">Mileage</label><br>
                <input type="text" id="mileage" name="mileage" placeholder="Example: XXXXXX KM" required><br><br>

                <!-- Input field for car brand -->
                <label for="carBrand">Car Brand</label><br>
                <select id="carBrand" name="carBrand" onchange="updateCarModels()" required>
                    <option value="" disabled selected>Select Car Brand</option>
                    <option value="BMW">BMW</option>
                    <option value="Audi">Audi</option>
                    <option value="Honda">Honda</option>
                    <option value="Hyundai">Hyundai</option>                
                    <option value="Nissan">Nissan</option>
                    <option value="Perodua">Perodua</option>
                    <option value="Proton">Proton</option>
                    <option value="Suzuki">Suzuki</option>
                    <option value="Toyota">Toyota</option>
                </select><br><br>

                <!-- Input field for car model --> 
                <label for="carModel">Car Model</label><br>
                <select id="carModel" name="carModel" required>
                    <option value="" disabled selected>Select Car Model</option>
                    <option value="X6">X6</option>
                    <option value="X4">X4</option>
                    <option value="XM">XM</option>
                    <option value="A8 L">A8 L</option>
                    <option value="RS 3 Sedan">RS 3 Sedan</option>
                    <option value="A3 Sedan">A3 Sedan</option>
                    <option value="Accord">Accord</option>
                    <option value="Civic">Civic</option>
                    <option value="City">City</option>
                    <option value="Jazz">Jazz</option>
                    <option value="Fit">Fit</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="SUVs & Crossovers">SUVs & Crossovers</option>
                    <option value="Tucson">Tucson</option>
                    <option value="Santa Fe">Santa Fe</option>
                    <option value="IONIQ">IONIQ</option>
                    <option value="CRETA">CRETA</option>
                    <option value="Almera">Almera</option>
                    <option value="Serena">Serena</option>
                    <option value="Navara">Navara</option>
                    <option value="Navara-single">Navara-single</option>
                    <option value="NV200">NV200</option>
                    <option value="Axia">Axia</option>
                    <option value="Alza">Alza</option>
                    <option value="Myvi">Myvi</option>
                    <option value="Ativa">Ativa</option>
                    <option value="Aruz">Aruz</option>
                    <option value="Bezza">Bezza</option>
                    <option value="Kancil">Kancil</option>
                    <option value="Kelisa">Kelisa</option>
                    <option value="Kembara">Kembara</option>
                    <option value="Knari">Knari</option>
                    <option value="Viva">Viva</option>
                    <option value="Ertiga">Ertiga</option>
                    <option value="Exora">Exora</option>
                    <option value="Gen2">Gen2</option>
                    <option value="Inspira">Inspira</option>
                    <option value="Iriz">Iriz</option>
                    <option value="Iswara">Iswara</option>
                    <option value="Juara">Juara</option>
                    <option value="Perdana">Perdana</option>
                    <option value="Putra">Putra</option>
                    <option value="Saga">Saga</option>
                    <option value="Saga Iswara">Saga Iswara</option>
                    <option value="Satria">Satria</option>
                    <option value="Suprima S">Suprima S</option>
                    <option value="Waja">Waja</option>
                    <option value="Wira">Wira</option>
                    <option value="Alto">Alto</option>
                    <option value="Wagon">Wagon</option>
                    <option value="ERV">ERV</option>
                    <option value="Camry">Camry</option>
                    <option value="Toyota">Hilux</option>
                    <option value="TRY230">Yaris</option>
                    <option value="Veloz">Veloz</option>
                    <option value="Vios">Vios</option>
                </select><br><br>

            <!-- Input field for car year -->
            <label for="carYear">Car Year</label><br>
            <input type="text" id="carYear" name="carYear" placeholder="Example: 1999" required><br><br>

              
                </div>

                <div class="mt-3">
                    <button class="button btn-navigate-form-step" type="button" step_number="2">Next</button>
                </div>
            </section>


            <!-- Step 2 Content, default hidden on page load. -->
            <section id="step-2" class="form-step d-none">
                <!-- Step 2 input fields -->
                <div class="mt-3">                    
                      <h2>I'm Looking For... </h2><br>
                      <h3>You can select more than one</h3>

                      <div class="service-options">
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="periodic-maintenance">
                            <span class="checkmark">Periodic Maintenance</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="brake-system">
                            <span class="checkmark">Brake System</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="battery">
                            <span class="checkmark">Battery</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="tyreService">
                            <span class="checkmark">Tyre Service</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="airconPollenFil">
                            <span class="checkmark">Aircon Pollen Filter</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="inspection">
                            <span class="checkmark">20-point inspection</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="airconSystem">
                            <span class="checkmark">Aircon System</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="suspension">
                            <span class="checkmark">Suspension</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="generalService">
                            <span class="checkmark">General Service</span>
                        </label>
                        <label class="service-box">
                            <input type="checkbox" name="services[]" value="others">
                            <span class="checkmark"> Others </span>
                        </label>
                        </div><br><br>

                      <div class="row">
                        <div class="col-25">
                          <h2>Remarks (Optional)</h2>
                          <h4 style="font-family: Garamond, serif;">Is there anything specific that you would like to get fixed? e.g. timing belt issues,alignment issues,etc</h4>
                        </div>
                      </div>
                      <div class="col-75">
                          <textarea id="remark" name="remark" style="height:200px; width: 75%; margin-top: 6px;"></textarea>
                        </div>
                </div>

                <div class="mt-3">
                    <button class="button btn-navigate-form-step" type="button" step_number="1">Prev</button>
                    <button class="button btn-navigate-form-step" type="button" step_number="3">Next</button>
                </div>
            </section>
         
            <!-- Step 3 Content, default hidden on page load. -->
            <section id="step-3" class="form-step d-none">
                <h2 class="font-normal">Service Center Location</h2>
                <!-- Step 3 input fields -->
                <div class="mt-3">
                    <button class="button button4">Car Member United Center</button>
                        <div class="address-box">
                            <input type="radio" id="rawang" name="serviceCenter" value="Rawang" required>
                            <label for="rawang"><strong>Service Center (Rawang)</strong></label>
                            <p>G-1 & 1-1, Jalan 1,<br>
                            Taman Bukit Rawang Jaya 2,<br>
                            48000 Rawang, Selangor, Malaysia</p>
                        </div>
                        <div class="address-box">
                            <input type="radio" id="puncak-alam" name="serviceCenter" value="Puncak Alam" required>
                            <label for="puncak-alam"><strong>Service Center (Puncak Alam)</strong></label>
                            <p>17B, Jalan Tiaj 2/1,<br>
                            Taman Industri Alam Jaya,<br>
                            42300 Puncak Alam, Selangor.</p>
                        </div>

                        <h3>Select a Date and Time</h3>
                <label for="date">Select Date:</label>
                <input type="date" name="appointmentDate" id="appointmentDate" class="date-picker" min="2024-04-20" max="2050-12-31" required>
                <div id="time-container" class="hidden">
                    <label for="time-options" disabled>Select Time:</label>
                    <select id="time-options" name="appointmentTime" required></select>
                </div>
            </div>
                <div class="mt-3">
                    <button class="button btn-navigate-form-step" type="button" step_number="2">Prev</button>
                    <button class="button btn-navigate-form-step" type="button" step_number="4">Next</button> <!-- Corrected step_number to 4 -->
                </div>
            </section>

            <section id="step-4" class="form-step d-none">   
            <h2 class="font-normal">Summary</h2><br><br>
            <div id="summary-content"></div>
        
            <div class="mt-4">
                <h3>Contact Details</h3>
                <label for="name"> Name<br>
                    <input type="text" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($userName); ?>" required></label><br>
                <label for="email"> Email<br>
                    <input type="email" name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($userEmail); ?>" required></label><br>
                <label for="phoneNumber"> Phone Number<br>
                    <input type="tel" name="phoneNumber" placeholder="Your Phone Number" value="<?php echo htmlspecialchars($userPhoneNumber); ?>" required></label><br>

            <button class="button btn-navigate-form-step" type="button" step_number="3">Prev</button>
        <button id="submitBtn" type="submit" class="button submit-btn">Book Appointment</button>
    </form>
            </div>
            </section>
        </form>
    </div>
</div>

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
                }
            };
            xhr.send();
        }  

        document.querySelector('.btn-navigate-form-step').addEventListener('click', function() {
            var isLoggedIn = "<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>";

            if (isLoggedIn === 'false') {
                if (confirm('Login to your account to submit your form')) {
                    window.location.href = 'login.php';
                }
            } else {
                document.getElementById('carServiceForm').submit();
            }
        });
    </script>

<script src="dateTimePicker.js"></script>
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
<script>
    
// Function to update summary
        function updateSummary() {
            var appointmentDate = document.getElementById("appointmentDate").value;
            var appointmentTime = document.getElementById("time-options").value;
            var serviceCenter = document.querySelector('input[name="serviceCenter"]:checked').value;
            var carPlateNo = document.getElementById("carPlateNo").value;
            var mileage = document.getElementById("mileage").value;
            var carBrand = document.getElementById("carBrand").value;
            var carModel = document.getElementById("carModel").value;
            var carYear = document.getElementById("carYear").value;
            var selectedServices = Array.from(document.querySelectorAll('input[name="services[]"]:checked')).map(el => el.nextElementSibling.innerText);
            var remarks = document.getElementById("remark").value;

            var summaryHTML = "<div class='summary-box'>";
            summaryHTML += "<h5>SERVICE APPOINTMENT DATE & TIME</h5>";
            summaryHTML += "<p>" + appointmentDate + ", " + appointmentTime + "</p>";
            summaryHTML += "<h5>SERVICE CENTER LOCATION</h5>";
            summaryHTML += "<p>Service Center " + serviceCenter + "<br>" + getSelectedAddress(serviceCenter) + "</p>";
            summaryHTML += "<h5>CAR DETAILS</h5>";
            summaryHTML += "<p>" + carYear + ", " + carModel + " " + carBrand + ", " + carPlateNo + ", " + mileage + "</p>";
            summaryHTML += "<h5>OTHER SERVICES PREFERENCE</h5>";
            summaryHTML += "<p>" + selectedServices.join(", ") + "</p>";
            summaryHTML += "<h5>REMARKS</h5>";
            summaryHTML += "<p>" + remarks + "</p>";
            summaryHTML += "</div>";

            document.getElementById("summary-content").innerHTML = summaryHTML;
        }

        // Get selected service center's address
        function getSelectedAddress(serviceCenter) {
            switch (serviceCenter) {
                case "Rawang":
                    return "G-1 & 1-1, Jalan 1, Taman Bukit Rawang Jaya 2, 48000 Rawang, Selangor, Malaysia";
                case "Puncak Alam":
                    return "17B, Jalan Tiaj 2/1, Taman Industri Alam Jaya, 42300 Puncak Alam, Selangor";
                default:
                    return "";
            }
        }

        // Attach event listener to form elements for updating summary
        var formElements = document.querySelectorAll("#userAccountSetupForm input, #userAccountSetupForm select, #userAccountSetupForm textarea");
        formElements.forEach(function(element) {
            element.addEventListener("change", updateSummary);
        });

        // Initially update summary
        updateSummary();
</script>
<script>
    // Object containing car models for each brand
    const carModels = {
                'BMW': ['X6', 'X4', 'XM'],
                'Audi': ['A8 L', 'RS 3 Sedan', 'A3 Sedan'],
                'Honda': ['Accord', 'Civic', 'City', 'Jazz', 'Fit', 'Hatchback', 'SUVs & Crossovers'],
                'Hyundai': ['Tucson', 'Santa Fe', 'IONIQ', 'CRETA'],
                'Nissan': ['Almera', 'Serena', 'Navara', 'Navara-single', 'NV200'],
                'Perodua': ['Axia', 'Alza', 'Myvi', 'Ativa', 'Aruz', 'Bezza', 'Kancil', 'Kelisa', 'Kembara', 'Knari', 'Viva'],
                'Proton': ['Ertiga', 'Exora', 'Gen2', 'Inspira', 'Iriz', 'Iswara', 'Perdana', 'Persona', 'Putra','Saga', 'Saga Iswara', 'Satria', 'Suprima S', 'Waja', 'Wira'],
                'Suzuki': ['Alto', 'Wagon', 'ERV'],
                'Toyota': ['Camry','Corolla', 'Veloz', 'Vios', 'Yaris', 'Hilux']
            };
        function updateCarModels() {
            const brand = document.getElementById('carBrand').value;
            const modelsDropdown = document.getElementById('carModel');
            modelsDropdown.innerHTML = ''; // Clear existing options

            if(brand && carModels[brand]) {
                carModels[brand].forEach(function(model) {
                    const option = document.createElement('option');
                    option.value = model;
                    option.text = model;
                    modelsDropdown.appendChild(option);
                });
            } else {
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Please select a car brand first';
                modelsDropdown.appendChild(defaultOption);
            }
        }
            /**
         * Define a function to navigate betweens form steps.
         * It accepts one parameter. That is - step number.
         */
        const navigateToFormStep = (stepNumber) => {
            /**
             * Hide all form steps.
             */
            document.querySelectorAll(".form-step").forEach((formStepElement) => {
                formStepElement.classList.add("d-none");
            });
            /**
             * Mark all form steps as unfinished.
             */
            document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
                formStepHeader.classList.add("form-stepper-unfinished");
                formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
            });
            /**
             * Show the current form step (as passed to the function).
             */
            document.querySelector("#step-" + stepNumber).classList.remove("d-none");
            /**
             * Select the form step circle (progress bar).
             */
            const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
            /**
             * Mark the current form step as active.
             */
            formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
            formStepCircle.classList.add("form-stepper-active");
            /**
             * Loop through each form step circles.
             * This loop will continue up to the current step number.
             * Example: If the current step is 3,
             * then the loop will perform operations for step 1 and 2.
             */
            for (let index = 0; index < stepNumber; index++) {
                /**
                 * Select the form step circle (progress bar).
                 */
                const formStepCircle = document.querySelector('li[step="' + index + '"]');
                /**
                 * Check if the element exist. If yes, then proceed.
                 */
                if (formStepCircle) {
                    /**
                     * Mark the form step as completed.
                     */
                    formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                    formStepCircle.classList.add("form-stepper-completed");
                }
            }
        };
        document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
      /**
       * Add a click event listener to the button.
       */
      formNavigationBtn.addEventListener("click", () => {
          /**
           * Get the value of the step.
           */
          const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
          /**
           * Call the function to navigate to the target form step.
           */
          navigateToFormStep(stepNumber);
      });
  });
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