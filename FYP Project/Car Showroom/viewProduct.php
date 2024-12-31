<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM carlist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the product details
        // Add other details as needed
    } else {
        echo 'Product not found.';
    }

    $stmt->close();
} else {
    echo 'No product ID specified.';
}

$conn->close();
?>


<nav class="sticky navbar">
    <div class="brand display__logo">
        <a href="#top" class="nav__link"> <span> CAR UNITED</span></a>
    </div>

    <input type="checkbox" id="nav" class="hidden" />
    <label for="nav" class="nav__open"><i></i><i></i><i></i></label>
    <div class="nav">
        <ul class="nav__items">
            <li><a href="index.php" class="nav__link">Home</a></li>
            <li><a href="carBrands.php" class="nav__link">Brand</a></li>
            <li class="nav__dropdown">
                <a href="#" class="nav__link">Services &#9662;</a>
                <ul class="dropdown__menu">
                    <li><a href="carService.php">Car Service</a></li>
                    <li><a href="testDrives.php">Test Drive</a></li>
                </ul>
            </li>
            <li><a href="finance.php" class="nav__link">Finance</a></li>
            <li><a href="contactUs.php" class="nav__link">Contact Us</a></li>
            <?php
            session_start(); // Start the session to access session variables

            // Check if the user is logged in by checking if the session variable 'username' is set
            if (isset($_SESSION['username'])) {
                // If the user is logged in, display their username and a dropdown menu
                echo '<li class="nav__dropdown">';
                echo '<a href="#" class="nav__link">Welcome, ' . htmlspecialchars($_SESSION['username']) . ' &#9662;</a>';
                echo '<ul class="dropdown__menu">';
                echo '<li><a href="profileCust.php">My Profile</a></li>';
                echo '<li><a href="#" id="viewFavorites">My Favorites</a></li>';
                echo '<li><a href="CustAppointment.php" id="">My Appointments</a></li>';
                echo '<li><a href="logout.php">Logout</a></li>';
                echo '</ul>';
                echo '</li>';
            } else {
                // If the user is not logged in, display the login link
                echo '<li class="nav__dropdown">';
                echo '<a href="login.php" class="nav__link">Login &#9662;</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</nav>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link rel="stylesheet" href="viewProduct.css">
    <style>

        body{
            background-color: #343a42;
            padding: 20px 0;
            height: 999px ;
            color: black; /* Adjust text color for better contrast */
            margin-bottom: 10px;
            animation: headerAnimation 10s infinite alternate;

        }
.image-gallery {
            position: relative;
            width: 500px; /* Adjust as needed */
            height: 300px; /* Adjust as needed */
            margin: 0 auto; /* Center the gallery */
        }

        #mainImage {
            width: 100%;
            height: 100%;
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 12px;
            padding: 10px;
            cursor: pointer;
        }

        #prev {
            left: 10px;
        }

        #next {
            right: 10px;
        }

        .thumbnail-images {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .image-row {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .thumbnail {
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .thumbnail:hover, .thumbnail.active {
            border-color: #e04f38;
        }

        .product-card {
            display: flex;
            flex-wrap: wrap;
            background-color: #fffefe;
            border-radius: 20px;
            box-shadow: 16 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            height: auto; /* Adjust height to auto */
        }


        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
    background-color: #343a42;
    padding: 20px 0;
    height: 999px ;
    color: black; /* Adjust text color for better contrast */
    margin-bottom: 10px;
    animation: headerAnimation 10s infinite alternate;
}


@keyframes headerAnimation {
    0% {
        background-color: #343a42;
    }
    50% {
        background-color: #13274d;
    }
    100% {
        background-color: #343a42;
    }
}

#favorites {
    position: fixed;
    top: 100px;
    right: 0;
    width: 600px;
    height: 75%;
    background: white;
    box-shadow: -2px 0 5px rgba(0,0,0,0.5);
    transform: translateX(100%);
    transition: transform 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
}
#favorites.open {
    transform: translateX(0);
}
#favorites .close {
    display: block;
    text-align: right;
    padding: 10px;
    font-size: 18px;
    cursor: pointer;
}
.favoriteItem {
    padding: 10px;
    border-bottom: 1px solid #ccc;
}
.favoriteItem img {
    width: 100%;
    height: auto;
}
.editForm {
    margin-top: 10px;
}
.editForm input {
    width: calc(100% - 20px);
    padding: 5px;
    margin: 5px 0;
}

    </style>
</head>
<body>


<header class="header" id="header">
    <div class="container">
        <div class="product-card">
            <div class="product-images">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "project2";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                $query = "SELECT * FROM carlist WHERE id = ?";
                $stmt = $conn->prepare($query);
                if ($stmt) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<br>';
                            echo '<br>';
                            $productImg = htmlspecialchars($row['productImg']);
                            $otherImages = array_map('htmlspecialchars', array_map('trim', explode(',', $row['otherImg'])));

                            echo '<div class="image-gallery">';
                            echo '<button id="prev" class="nav-arrow">❮</button>';
                            echo '<img id="mainImage" src="' . $productImg . '" alt="Main Product Image">';
                            echo '<button id="next" class="nav-arrow">❯</button>';
                            echo '</div>';

                            if (!empty($otherImages)) {
                                echo '<div class="thumbnail-images">';
                                $count = 0;
                                foreach ($otherImages as $img) {
                                    // Start a new row after every 3 images
                                    if ($count % 3 === 0) {
                                        if ($count !== 0) {
                                            echo '</div>'; // Close the previous row if not the first row
                                        }
                                        echo '<div class="image-row"style="width: 30%;height: 30%;">'; // Open a new row
                                    }
                                    echo '<img class="thumbnail" src="' . $img . '" alt="Other Product Image">';
                                    $count++;
                                }
                                echo '</div>'; // Close the last row
                                echo '</div>'; // Close thumbnail-images
                            }
                        } else {
                            echo '<p>No car details found.</p>';
                        }
                    } else {
                        echo "<p>Query execution failed: " . $stmt->error . "</p>";
                    }

                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }

                $conn->close();
                ?>
            </div>

            <div class="product-details">
                <?php if (!empty($row)) { ?>
                    <br>
                    <h2>
                    <span class="text-muted"><?= htmlspecialchars($row['status']) ?></span>
                    </h2>
                    <br>
                    <h2>
                        <?= htmlspecialchars($row['year']) ?>
                        <?= htmlspecialchars($row['carType']) ?>
                        <?= htmlspecialchars($row['engine']) ?>
                    </h2>
                    <p><?= htmlspecialchars($row['transmission']) ?> | <?= htmlspecialchars($row['mileage']) ?> km</p>
                    <p>
                        <span class="currency">RM </span><span class="price"><?= htmlspecialchars($row['price']) ?></span>
                    </p>
                    <div class="actions">
                        <a href="finance.php?id=<?= htmlspecialchars($row['id']) ?>">Loan Calculator</a>

                            <!-- Loan Eligibility -->

                        <a href="#" id="loanEligibilityLink">Loan Eligibility</a>
                        <div id="loanModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Loan Eligibility Information</h2>
                                <p>Here is some important information about loan eligibility:</p>
                                <ul>
                                    <li>Minimum age: 18 years</li>
                                    <li>Maximum age: 60 years</li>
                                    <li>Minimum income: $20,000 per year</li>
                                    <li>Employment status: Must be employed or self-employed</li>
                                    <li>Credit score: A good credit score improves your chances of eligibility</li>
                                </ul>
                                <p>If you need further assistance, please contact us by clicking the button below:</p>
                                <a href="contactUs.php" class="btn">Contact Us</a>
                            </div>
                        </div>
                        <br>                     
                        <div class="container4">
                            <button id="testDrive" class="btn">Free Test Drive</button>
                            <a href="#" id="addToFavourites" data-id="<?php echo htmlspecialchars($id); ?>">
                                <img src="assets/images1/savedImg.jpg" alt="Save Image" style="width: 15%; height: 5.9%; margin-top: 20px; margin-bottom: -12px;">
                            </a>
                        </div>
                        <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car_id = $_GET['id'];

// Fetch car details from carlist table
$sql = "SELECT id, productImg, carType, engine FROM carlist WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
    $productImg = $car['productImg'];
    $carType = $car['carType'];
    $engine = $car['engine'];
} else {
    die('Car not found.');
}

$stmt->close();
$conn->close();
?>

<div id="favorites">
        <span class="close">X</span>
        <h2>My Favorites</h2>
        <div id="favoritesList">
            <!-- Favorites will be loaded here -->
        </div>
    </div>

                    </div>
                    <p class="help-text">
                        Need more help? Contact us via 
                        <a href="tel:03-60915653" class="phone-icon-link">
                            <span class="phone-icon">📞</span>
                        </a>
                    </p>
                    <br><br><br><br><br><br><br><br>

                    <a href="carBrands.php" class="btn" style="float: right; font-size: 14px; background: grey;">Back</a>
                    
                    <?php } ?>
            </div>    
        </div>
    </div>
</header><br><br><br><br><br><br><br><b><br></br><br>

<main><br>
    <!-- Car Overview Section -->
    <section class="home">
    <div id="home">
    <div class="overview">
                <h2>Overview

                <p style= 'float: right; font-size: 14px; '><strong>ID:</strong> <?= htmlspecialchars($row['id']) ?></p>

                </h2>
                <div class="overview-details">
                    <p><strong> CAR UNITED Value:</strong> Provides a wallet-friendly solution of roadworthy vehicles with a hassle-free buying experience.</p>
                    <ul class="features">
                        <li><span class="feature-tick">✔</span> Hassle-free and Professional</li>
                        <li><span class="feature-tick">✔</span> Affordable, Fixed Price</li>
                        <li><span class="feature-tick">✔</span> Optional 1-Year Warranty</li>
                    </ul>
                    <h3>Key Highlights:</h3>
                    <ul class="highlights">
                        <li><strong>Current Mileage:</strong> <?= htmlspecialchars($row['mileage']) ?> km</li>
                        <li><strong>Transmission:</strong> <?= htmlspecialchars($row['transmission']) ?></li>
                        <li><strong>Principal Warranty:</strong> No</li>
                        <li><strong>Fuel Type:</strong> <?= htmlspecialchars($row['fuel']) ?></li>
                    </ul>
                </div>
            </div>
        </div><br><br>

		</div>
	</section>
        <section class="portfolio">
		<div id="portfolio">
			<section class="section2" id="car-purchase-process">
        <div class="container2">
            <h2 style="text-align: center; color: #000080;">Car Purchase Process</h2>
            <div class="card-container">
                <div class="card">
                    <div class="step-number">1</div>
                    <i class="fas fa-laptop"></i>
                    <h3>Book Online</h3>
                    <p>Reserve a car online or schedule a call with us.</p>
                </div>
                <div class="card">
                    <div class="step-number">2</div>
                    <i class="fas fa-car"></i>
                    <h3>Test Drive</h3>
                    <p>Visit our Experience Center for a test drive.</p>
                </div>
                <div class="card">
                    <div class="step-number">3</div>
                    <i class="fas fa-money-bill-wave"></i>
                    <h3>Make the Payment</h3>
                    <p>Pay by cash or loan. We'll handle everything for free.</p>
                </div>
                <div class="card">
                    <div class="step-number">4</div>
                    <i class="fas fa-truck"></i>
                    <h3>Delivery or Pick Up</h3>
                    <p>Pick up your car at our centers or have it delivered to your doorstep.</p>
                </div>
            </div>
        </div>
    </section><br><br><br><br><br><br><br>

        <section class="contact">
		<div id="contact">
        <section class="faq-section" id="faq">
    <div class="container1">
        <h2 class="faq-title">Frequently Asked Questions (FAQ)</h2>
        
        <div class="faq-item">
            <div class="faq-question">How do I reserve a car online?</div>
            <div class="faq-answer">You can reserve a car by visiting our website, selecting the car you're interested in, and clicking the "Reserve" button. Follow the on-screen instructions to complete the reservation process.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Can I schedule a test drive before purchasing?</div>
            <div class="faq-answer">Yes, you can schedule a test drive by selecting a suitable date and time on our website or by contacting our customer service.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">What payment methods do you accept?</div>
            <div class="faq-answer">We accept payments by cash, bank transfer, and various loan options. Our finance team can assist you in finding the best payment plan.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Is there a warranty on second-hand cars?</div>
            <div class="faq-answer">Yes, we offer a limited warranty on all our certified second-hand cars. The warranty details vary depending on the car model and year.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Can I return the car if I'm not satisfied?</div>
            <div class="faq-answer">We offer a 7-day return policy on all our cars. If you're not satisfied with your purchase, you can return the car within 7 days for a full refund, provided it is in the same condition as when purchased.</div>
        </div>
    </div>
</section>

</div>
</section>
</main>


    
<script>
        document.querySelectorAll('.faq-question').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
            // Get the modal
var modal = document.getElementById("loanModal");

// Get the link that opens the modal
var link = document.getElementById("loanEligibilityLink");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the link, open the modal
link.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

   
    document.getElementById('testDrive').onclick = () => {
        window.location.href = 'testDrives.php';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var mainImage = document.getElementById('mainImage');
        var thumbnails = document.querySelectorAll('.thumbnail');
        var prevButton = document.getElementById('prev');
        var nextButton = document.getElementById('next');

        var currentIndex = 0;
        var images = [
            '<?php echo $productImg; ?>', // The main product image
            <?php foreach ($otherImages as $img) { echo "'" . $img . "',"; } ?>
        ];

        function updateMainImage(index) {
            mainImage.src = images[index];
            thumbnails.forEach((thumb, idx) => {
                thumb.classList.toggle('active', idx === index);
            });
        }

        prevButton.addEventListener('click', function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
            updateMainImage(currentIndex);
        });

        nextButton.addEventListener('click', function() {
            currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
            updateMainImage(currentIndex);
        });

        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                currentIndex = index + 1; // Adjust index for main image + thumbnails
                updateMainImage(currentIndex);
            });
        });

        updateMainImage(currentIndex);
    });

    document.addEventListener("DOMContentLoaded", function() {
        var thumbnailImages = document.querySelectorAll(".thumbnail");
        var header = document.getElementById("header");

        function adjustHeaderHeight() {
            var rows = Math.ceil(thumbnailImages.length / 3);
            var headerHeight = 400 + (rows * 40); // Adjust multiplier as needed
            header.style.height = headerHeight + "px";
        }

        adjustHeaderHeight();
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="viewProduct.js"></script>

</body>
</html>