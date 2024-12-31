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
        /* CSS for Gallery Layout */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .gallery-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .gallery-item {
            text-align: center;
        }

        .gallery-item img {
            margin-top: 30px;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
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
        .container {
            padding: 20px 0;
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

        .pagination-nav {
    display: flex;
    justify-content: center;
    margin-top: 20px; /* Optional: Adds some space above the pagination */
}

.pagination {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-item .page-link {
    color: #007bff;
    text-decoration: none;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    border-radius: 0.25rem;
}

.pagination .page-item .page-link:hover {
    background-color: #e9ecef;
}

.pagination .page-item.active .page-link {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
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
                            <li><a href="index.php" >Home</a></li>
                                <li><a href="carBrands.php" class="active">Brands</a></li>
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

    <!-- ***** Call to Action Start ***** -->
    <section class="section section-bg" id="call-to-action" style="background-image: url(assets/images1/banner-image-1-1920x500.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cta-content">
                        <br>
                        <br>
                        <h2>Our <em> Brands</em></h2>
                        <p>Car United is a distinguished online showroom, showcasing an exquisite collection of pre-owned vehicles from the world's most renowned car brands.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><br>
    <!-- ***** Call to Action End ***** -->

    <!-- ***** Car Brands Starts - PENDING ***** -->
    <div class="gallery">
    <?php
    // Database credentials
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
    // Query to fetch brand names and image paths from the database
    $query = "SELECT name, imagePath FROM brandlist WHERE status = 'Active'";
    $result = mysqli_query($conn, $query);

    // Initialize row count
    $row_count = 0;
    echo '<div class="gallery-row">';
    // Loop through the results and display images and brand names
    while ($row = mysqli_fetch_assoc($result)) {
        // Update the imagePath to include the full path from the root directory
        $imageSrc = "assets/images1/" . $row['imagePath'];
        echo '<div class="gallery-item">';
        echo '<a href="productPerBrand.php?brand=' . urlencode($row['name']) . '">';
        echo '<img src="' . $imageSrc . '" alt="' . $row['name'] . '" style="width:128px; height:118px;">'; // Set image size to 80px by 80px
        echo '</a>';
        echo '<p>' . $row['name'] . '</p>';
        echo '</div>';
        $row_count++;
        // Start a new row after every 5 images
        if ($row_count % 5 == 0) {
            echo '</div>'; // Close the current row
            echo '<div class="gallery-row">'; // Start a new row
        }
    }

    // Check if there are no active brands
    if (mysqli_num_rows($result) == 0) {
        echo '<p>No active brands available.</p>';
    }

    echo '</div>'; // Close the last row

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);

    ?>
</div>
    <!-- ***** Car Brands Ends ***** -->
    
    <!-- ***** Fleet Starts ***** -->
    <section class="section" id="search">
    <div class="container">
        <div class="contact-form">
            <form action="carBrands.php" method="GET" id="searchForm">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label for="brandType">Car Brand</label><br>
                            <select id="brandType" name="brandType">
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
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="carType">Car Model</label><br>
                            <select id="carType" name="carType">
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
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <select id="price" name="price">
                                <option value="">Any Price</option>
                                <option value="under_50">Under RM 50,000</option>
                                <option value="50-100">RM 50,000 - 100,000</option>
                                <option value="100-150">RM 100,000 - 150,000</option>
                                <option value="above_200">Above RM 200,000</option>
                            </select><br><br>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="transmission">Transmission:</label>
                            <select id="transmission" name="transmission">
                                <option value="">Any Transmission</option>
                                <option value="Manual">Manual</option>
                                <option value="Automatic">Automatic</option>
                            </select><br><br>
                        </div>
                    </div>

                    <div class="col-sm-4 offset-sm-4">
                        <div class="main-button text-center">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
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

// Pagination variables
$results_per_page = 9; // Number of cars to display per page (3 rows of 2 cars each)
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

// Initialize SQL query components
$sql = "SELECT * FROM carlist";
$where_conditions = [];
$params = [];

// Handle form inputs
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!empty($_GET['brandType'])) {
        $carBrand = $_GET['brandType'];
        $where_conditions[] = "brandType = ?";
        $params[] = $carBrand;
    }

    if (!empty($_GET['carType'])) {
        $carType = $_GET['carType'];
        $where_conditions[] = "carType = ?";
        $params[] = $carType;
    }

    if (!empty($_GET['transmission'])) {
        $transmission = $_GET['transmission'];
        $where_conditions[] = "transmission = ?";
        $params[] = $transmission;
    }

    if (!empty($_GET['price'])) {
        $priceRange = $_GET['price'];
        switch ($priceRange) {
            case 'under_50':
                $where_conditions[] = "price < 50000";
                break;
            case '50-100':
                $where_conditions[] = "price BETWEEN 50000 AND 100000";
                break;
            case '100-150':
                $where_conditions[] = "price BETWEEN 100000 AND 150000";
                break;
            case 'above_200':
                $where_conditions[] = "price > 200000";
                break;
        }
    }

    // Append WHERE conditions if there are any
    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }
}

// Count the total number of records
$count_sql = $sql;
$stmt = $conn->prepare($count_sql);
if ($stmt) {
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $stmt->store_result();
    $total_records = $stmt->num_rows;
    $stmt->close();
} else {
    echo "Error executing query: " . $conn->error;
}

// Calculate total pages
$total_pages = ceil($total_records / $results_per_page);

// Modify the SQL query to include LIMIT clause for pagination
$sql .= " LIMIT ?, ?";
$params[] = $start_from;
$params[] = $results_per_page;

// Prepare and bind parameters
$stmt = $conn->prepare($sql);
if ($stmt) {
    if (!empty($params)) {
        $types = str_repeat('s', count($params) - 2) . 'ii'; // Bind the last two parameters as integers
        $stmt->bind_param($types, ...$params);
    }

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Display results
    if ($result->num_rows > 0) {
        echo '<div class="container">';
        echo '<div class="row">';
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count > 0 && $count % 3 == 0) {
                echo '</div><div class="row">';
            }
            echo '<div class="col-lg-4 mb-4">';
            echo '    <div class="card">';
            echo '        <img src="' . $row['productImg'] . '" class="card-img-top" alt="Car Image">';
            echo '        <div class="card-body">';
            echo '            <span><sup>RM</sup>' . $row['price'] . '</span>';
            echo '            <h4 class="card-title">' . $row['carType'] . ' ' . $row['engine'] . '</h4>';
            echo '            <p class="card-text">';
            echo '                <i class="fa fa-dashboard"></i> ' . $row['mileage'] . 'km &nbsp;&nbsp;&nbsp;';
            echo '                <i class="fa fa-cube"></i> ' . $row['year'] . '  &nbsp;&nbsp;&nbsp;';
            echo '                <i class="fa fa-cog"></i> ' . $row['transmission'] . ' &nbsp;&nbsp;&nbsp;';
            echo '            </p>';
            echo '            <ul class="social-icons">';
            echo '                <li><a href="viewProduct.php?id=' . $row['id'] . '">+ View Car</a></li>';
            echo '            </ul>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
            $count++;
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo "<p>No cars found.</p>";
    }

    // Pagination links
    echo '<nav class="pagination-nav">';
    echo '  <ul class="pagination">';
    if ($current_page > 1) {
        echo '    <li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '    <li class="page-item ' . ($i == $current_page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }
    if ($current_page < $total_pages) {
        echo '    <li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a></li>';
    }
    echo '  </ul>';
    echo '</nav>';

    // Close statement and connection
    $stmt->close();
} else {
    echo "Error executing query: " . $conn->error;
}

// Close connection
$conn->close();
?>


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

</script>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <br>
                
            <nav>
              <ul class="pagination pagination-lg justify-content-center">

        </div>
    </section>
    
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