<?php session_start();?>

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

.card {
            margin-bottom: 30px;
            height: 100%;
        }
        .card img {
            width: 100%;
            height: auto;
        }
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }
        .card-text {
            margin-bottom: 1rem;
        }
        .social-icons a {
            text-decoration: none;
            color: #007bff;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .row {
            margin-bottom: 30px;
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
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="carBrands.php">Brands</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Services</a>
                              
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
                                echo "<li class='dropdownX' style='position: relative;font-size: 15.7px; color: White; top: 7.2px;'>";
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

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" id="top">
        <video autoplay muted loop id="bg-video">
            <source src="assets/images1/video3.mp4" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="caption">
                <h6 style="font-size: 19px;" >Car dealership</h6>
                <h2>Best <em>car united</em> in town!</h2>
                <div class="main-button">
                    <a href="promotion.php">Learn More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

   <!-- ***** Cars Starts  - PENDING***** --> 
   <section class="section" id="trainers">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                        <h2>Featured <em>Cars</em></h2>
                        <img src="assets/images/line-dec.png">
                        <p>Built for off-road adventures, featuring rugged capabilities, open-air freedom, and a classic design.</p>
                    </div>
                </div>
            <div class="container">
            <div class="row">
                    <?php
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

                    $sql = "SELECT * FROM carlist WHERE newCar = 'new' LIMIT 6";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $count = 0;
                        while($row = $result->fetch_assoc()) {
                            if ($count > 0 && $count % 3 == 0) {
                                echo '</div><div class="row">';
                            }
                            echo '<div class="col-md-4 d-flex align-items-stretch">';
                            echo '    <div class="card">';
                            echo '        <img src="' . $row['productImg'] . '" class="card-img-top" alt="Car Image">';
                            echo '        <div class="card-body">';
                            echo '            <h5 class="card-title">' . $row['carType'] . ' ' . $row['engine'] . '</h5>';
                            echo '            <p class="card-text">';
                            echo '                <i class="fa fa-dashboard"></i> ' . $row['mileage'] . 'km &nbsp;&nbsp;&nbsp;';
                            echo '                <i class="fa fa-cube"></i> ' . $row['year'] . ' &nbsp;&nbsp;&nbsp;';
                            echo '                <i class="fa fa-cog"></i> ' . $row['transmission'] . ' &nbsp;&nbsp;&nbsp;';
                            echo '            </p>';
                            echo '            <ul class="social-icons list-inline">';
                            echo '                <li class="list-inline-item"><a href="carBrands.php">+ View More Car</a></li>';
                            echo '            </ul>';
                            echo '        </div>';
                            echo '    </div>';
                            echo '</div>';
                            $count++;
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
            </div>                <div class="main-button text-center">
                    <a href="carBrands.php">View Cars</a>
                </div>
            </div>
        </div>
    </section>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- ***** Cars Ends ***** -->

    <section class="section section-bg" id="schedule" style="background-image: url(assets/images/about-fullscreen-1-1920x700.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading dark-bg">
                        <h2>About <em>Us</em></h2>
                        <img src="assets/images1/line-dec.png" alt="">
                        <p style="font-size: 17px;">Your Local Vehicle Experts.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cta-content text-center">
                        <p>Car United is a prominent Used Car Dealer in Rawang. We’re here to serve as your ultimate vehicle consultant. We believe in advising our customers on the best deals available on the market, and we strive to help by offering the vehicles that are most suitable to their needs.</p>
                        <p>Our team of experienced professionals is dedicated to providing exceptional customer service. We understand that purchasing a vehicle is a significant investment, and we aim to make the process as seamless and enjoyable as possible. Whether you're looking for a family car, a reliable work vehicle, or a first car for your teenager, we have a wide selection of quality used cars to choose from.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Testimonials Item Start ***** -->
    <section class="section" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                        <h2>Our <em>Testimonials</em></h2>
                        <img src="assets/images/line-dec.png" alt="waves">
                        <p>At Car United, we pride ourselves on providing exceptional customer service and quality vehicles. But don't just take our word for it—hear what our satisfied customers have to say!</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="features-items">
                        <li class="feature-item">
                            <div class="left-icon">
                                <img src="assets/images/features-first-icon.png" alt="First One">
                            </div>
                            <div class="right-content">
                                <h4>Lew Meng</h4>
                                <p><em>"I had a fantastic experience at Car United. The staff was knowledgeable and helped me find the perfect car for my needs. I highly recommend them to anyone looking for a reliable used vehicle."</em></p>
                            </div>
                        </li>
                        <li class="feature-item">
                            <div class="left-icon">
                                <img src="assets/images/features-first-icon.png" alt="second one">
                            </div>
                            <div class="right-content">
                                <h4>Samantha R.</h4>
                                <p><em>"From start to finish, the process was seamless. The team was friendly and professional, and I felt no pressure to make a purchase. I'm thrilled with my new car and the excellent service I received."</em></p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul class="features-items">
                        <li class="feature-item">
                            <div class="left-icon">
                                <img src="assets/images/features-first-icon.png" alt="fourth muscle">
                            </div>
                            <div class="right-content">
                                <h4>Michael</h4>
                                <p><em>"Car United exceeded my expectations. They offered me a great trade-in value for my old car and helped me finance my new one at a rate I could afford. I'll definitely be back for my next purchase."</em></p>
                            </div>
                        </li>
                        <li class="feature-item">
                            <div class="left-icon">
                                <img src="assets/images/features-first-icon.png" alt="training fifth">
                            </div>
                            <div class="right-content">
                                <h4>Jessica</h4>
                                <p><em>"I was nervous about buying a used car, but the transparency and honesty at Car United put me at ease. They provided all the vehicle history and condition details upfront. I'm very happy with my purchase."</em></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Testimonials Item End ***** -->

    <!-- ***** Call to Action Start ***** -->
    <section class="section section-bg" id="call-to-action" style="background-image: url(assets/images/banner-image-1-1920x500.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cta-content">
                        <h2>Send us a <em>message</em></h2>
                            <p> We value your feedback and inquiries. If you have any questions, comments, or need more information about our services, please don't hesitate to reach out to us. </p>
                            <p> Thank you for considering Car United. We look forward to assisting you! </p>                        <div class="main-button">
                            <a href="contactUs.php">Contact us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Call to Action End ***** -->

    
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <a href="mailto:membercar1778@gmail.com" style="margin-right: 12px;"><i class="fa fa-envelope"></i></a>
                <a href="https://web.facebook.com/membercarunited/?_rdc=1&_rdr" style="margin-right: 12px;"><i class="fa fa-facebook"></i></a>
                <a href="https://www.instagram.com/kerata_secondhand?igsh=MzRlODBiNWFlZA==" style="margin-right: 12px;"><i class="fa fa-instagram"></i></a>
                <a href="https://my.linkedin.com/in/tan-poh-geok-18492540" style="margin-right: 12px;"><i class="fa fa-linkedin"></i></a>
                <a href="tel:+60360915653" style="margin-right: 12px;"><i class="fa fa-phone"></i></a>
                </div>
            </div>
        </div>
    </footer>

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

        


// This script will toggle the dropdown on click
document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.querySelector('.dropdownX');
    dropdown.onclick = function(event) {
        event.stopPropagation();
        this.children[1].style.display = 'block';
    };
    window.onclick = function() {
        if (!event.target.matches('.dropdownX')) {
            var dropdowns = document.getElementsByClassName('dropdown-contentX');
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    };
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