<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Per Brand</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        .font-size-10 {
            font-size: 15px;
        }
        h5.mb-0 {
            font-size: 1rem;
        }
        small.ghj {
            font-size: 9px;
        }
        .mid {
            background: #ECEDF1;
        }
        h6.ml-1 {
            font-size: 13px;
        }
        small.key {
            text-decoration: underline;
            font-size: 9px;
            cursor: pointer;
        }
        .btn-danger {
            color: #FFCBD2;
        }
        .btn-danger:focus {
            box-shadow: none;
        }
        small.justify-content-center {
            font-size: 9px;
            cursor: pointer;
            text-decoration: underline;
        }
        @media screen and (max-width:400px) {
            .col-sm-3 {
                margin-bottom: 50px;
            }
        }

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
        body {
            background: #F5F1EE;
            font-family: 'Roboto', sans-serif;
            padding: 20px;
        }
        .card {
            width: 100%;
            border-radius: 7px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            height: 100%;
        }

        .card img {
            border-top-right-radius: 7px;
            border-top-left-radius: 7px;
            max-width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .card-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .card-text {
            font-size: 14px;
            margin-bottom: 0.5rem;
        }
        .card-price {
            font-size: 1.25rem;
            color: #dc3545;
            margin-top: auto;
            margin-bottom: 0;
        }
        .btn-details {
            background-color: #dc3545;
            color: #fff;
            border: none;
            text-align: center;
            padding: 8px 0;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-details:hover {
            background-color: #c82333;
        }
        .brand-details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .brand-image img {
            margin-right: 20px;
            width: 132px;
            height: 130px;
            object-fit: cover;
            border-radius: 7px;
        }
        .brand-name h2 {
            font-size: 1.5rem;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12">
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

            // Retrieve the brand name from the URL
            if (isset($_GET['brand'])) {
                $brand = urldecode($_GET['brand']);

                // Query to fetch brand details from the database
                $query = "SELECT imagePath FROM brandlist WHERE name = ? AND status = 'Active'";
                $stmt = $conn->prepare($query);

                // Check if the prepare() call failed
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }

                // Bind parameters
                $stmt->bind_param("s", $brand);

                // Execute the statement
                $stmt->execute();

                // Get result
                $result = $stmt->get_result();

                // Check if the brand exists
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $brandImageSrc = "assets/images1/" . $row['imagePath'];
                    echo '<div class="brand-details">';
                    echo '<div class="brand-image">';
                    echo '<img src="' . htmlspecialchars($brandImageSrc) . '" alt="' . htmlspecialchars($brand) . '" style="width:132px; height:130px;">';
                    echo '</div>';
                    echo '<div class="brand-name">';
                    echo '<h2>' . htmlspecialchars($brand) . '</h2>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<p>No brand found or not active.</p>';
                }

                // Close statement
                $stmt->close();
            } else {
                echo '<p>No brand specified.</p>';
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
</div>

<hr>

    <div class="container-fluid">
        <div class="row">
            <?php
            // Database connection parameters
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

            // Retrieve the brand name from the URL
            if (isset($_GET['brand'])) {
                $brand = urldecode($_GET['brand']);

                // Query to fetch car details from the database
                $query = "SELECT id, productImg, year, carType, engine, mileage, transmission, price FROM carlist WHERE brandType = ? ORDER BY id";
                $stmt = $conn->prepare($query);

                // Check if the prepare() call failed
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }

                // Bind parameters
                $stmt->bind_param("s", $brand);

                // Execute the statement
                $stmt->execute();

                // Get result
                $result = $stmt->get_result();

                // Loop through each car and display as a card
                while ($row = $result->fetch_assoc()) {
                    $productImg = htmlspecialchars($row['productImg']);
                    $year = htmlspecialchars($row['year']);
                    $carType = htmlspecialchars($row['carType']);
                    $engine = htmlspecialchars($row['engine']);
                    $mileage = htmlspecialchars($row['mileage']);
                    $transmission = htmlspecialchars($row['transmission']);
                    $price = htmlspecialchars($row['price']);
                    $id = htmlspecialchars($row['id']);

                    // Output HTML for each car
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $productImg . '" class="card-img-top">';
                    echo '<div class="card-body">';
                    echo '<h6 class="card-title">' . $year . ' ' . $carType . ' ' . $engine . '</h6>';
                    echo '<p class="card-text"><small style ="font-size: 15px;">' . $mileage . ' km | ' . $transmission . '</small></p>';
                    echo '<p class="card-text"><h5 class="text-danger"><small class="font-size-10">RM</small> ' . $price . '</h5></p>';
                    echo '<a href="viewProduct.php?id=' . $id . '" class="btn btn-danger btn-block">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // Close result set
                $result->close();
                // Close statement
                $stmt->close();
            } else {
                echo '<p>No brand specified.</p>';
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>
</html>
