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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$price = '';
$interestRate = '';

if ($id > 0) {
    // Fetch price from carlist table
    $query1 = "SELECT price FROM carlist WHERE id = ?";
    $stmt1 = $conn->prepare($query1);
    if ($stmt1) {
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($result1 && $result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $price = htmlspecialchars($row1['price']);
        }
        $stmt1->close();
    }

    // Fetch interestRate from finance table
    $query2 = "SELECT interestRate FROM finance LIMIT 1";
    $stmt2 = $conn->prepare($query2);
    if ($stmt2) {
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $interestRate = htmlspecialchars($row2['interestRate']);
        }
        $stmt2->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <title>FYP Project</title>

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
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
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .containerX {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            background-color: #000080;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #0000cd;
        }

        .fas.fa-undo {
            font-size: 24px;
            cursor: pointer;
            color: #000080;
        }

        #result {
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            padding: 20px;
            display: none;
        }

        #monthlyPayment {
            color: #28a745;
            font-size: 24px;
            font-weight: bold;
        }

        p {
            margin: 10px 0;
        }

        .disclaimer {
            font-size: 12px;
            color: #888;
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
                            <li><a href="finance.php" class="active">Finance</a></li> 
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
                        <h2>Finance Your <em> Dream Car</em></h2>
                        <p>We make it easy for you to own the car you want. Let us help you secure a loan from paperwork submission to getting fast loan approval.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Our Classes Start ***** -->
    <section class="section" id="our-classes">
    <div class="flex-container">
        <div class="containerX">
            <form id="loanForm">
                <h2>Finance Calculator</h2>  
                <div style="text-align: right;">
                    <i class="fas fa-undo" onclick="resetForm()"></i>
                </div>
                <div class="form-group">
                    <label for="price">Car Price (RM):</label>
                    <input type="number" id="price" name="price" value="<?= $price ?>" required />
                </div>

                <div class="form-group">
                    <label for="interestRate">Interest Rate (%):</label>
                    <input type="number" id="interestRate" name="interestRate" value="<?= $interestRate ?>" step="0.1" required />
                </div>

                <div class="form-group">
                    <label for="downPayment">Down Payment (RM):</label>
                    <input type="number" id="downPayment" name="downPayment" required />
                </div>

                <div class="form-group">
                    <label for="loanTenure">Loan Tenure (Years):</label>
                    <input type="number" id="loanTenure" name="loanTenure" required />
                </div>

                <button type="button" class="btn" onclick="calculateLoan()">Calculate</button>
            </form>

            <div id="result">
                <p>Your Estimated Monthly Payment: <br><br><span id="monthlyPayment">RM 0</span></p>
                <p class="disclaimer">Disclaimer: All interest rates and calculated amounts are estimations only. Actual amounts may differ based on your individual credit profile.</p>
            </div>
        </div>
    </div>
</section>
<!-- ***** Our Classes End ***** -->

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

        
    function calculateLoan() {
        var price = document.getElementById('price').value;
        var downPayment = document.getElementById('downPayment').value;
        var interestRate = document.getElementById('interestRate').value;
        var loanTenure = document.getElementById('loanTenure').value;

        var principal = price - downPayment;
        var monthlyInterestRate = (interestRate / 100) / 12;
        var numberOfPayments = loanTenure * 12;

        var monthlyPayment = (principal * monthlyInterestRate) / (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));
        monthlyPayment = monthlyPayment.toFixed(2);

        // After calculation, make the result visible
        document.getElementById('result').style.display = 'block';
        document.getElementById('monthlyPayment').innerText = 'RM ' + monthlyPayment;
    }

    function resetForm() {
        document.getElementById("loanForm").reset();
        document.getElementById('result').style.display = 'none'; // Hide the result again
    }
</script>


<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $price = $_POST['price'];
        $downPayment = $_POST['downPayment'];
        $interestRate = $_POST['interestRate'];
        $loanTenure = $_POST['loanTenure'];

        $principal = $price - $downPayment;
        $monthlyInterestRate = ($interestRate / 100) / 12;
        $numberOfPayments = $loanTenure * 12;

        $monthlyPayment = ($principal * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
        $monthlyPayment = number_format($monthlyPayment, 2);

        echo "Your Estimated Monthly Payment: RM " . $monthlyPayment;
    }
?>
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