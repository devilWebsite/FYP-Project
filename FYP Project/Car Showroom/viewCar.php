<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #d4d2d2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product {
            display: flex;
            gap: 20px;
        }
        .product-images {
            flex: 1;
            text-align: center;
            position: relative;
        }
        .product-images img {
            width: 100%;
            max-width: 400px;
            height: auto;
        }
        .other-images {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .other-images img {
            width: 130px;
            height: 100px;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .product-details {
            flex: 1;
        }
        .product-details h2 {
            margin: 0 6 10px;
        }
        .product-details p {
            margin: 9px 0;
        }
        .actions {
            margin: 20px 0;
        }
        .actions .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-right: 10px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .actions .btn:hover {
            opacity: 0.8;
        }
        .help-text {
            margin-top: 20px;
            font-size: 14px;
        }
        .phone-icon {
            font-size: 18px;
        }
        .text-muted {
            color: #6c757d;
            font-size: 16.5px;
            float: right;
        }
        .currency {
            font-size: 0.95em;
        }
        .price {
            font-size: 1.5em;
        }
        #update {
            background-color: #29853f;
            color: white;
        }
        #cancel {
            background-color: #d62c29;
            color: white;
        }
        #update,
        #cancel {
            margin: 15px; 
            padding: 12px 22px; 
            float: right;
            cursor: pointer;
        }
        .containerx {
            margin-right: 45%;
        }
        .image-gallery {
            position: relative;
            width: 500px; /* Adjust as needed */
            height: 300px; /* Adjust as needed */
            margin: 0 auto; /* Center the gallery */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
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

                /*fa fa heart */
                .container4 {
    display: flex;
    align-items: center;
}

#testDrive {
    /* Add any styling you want for the button here */
    margin-right: 10px; /* Space between the button and the checkbox */
}

input[type="checkbox"] {
    display: none; /* Hide the default checkbox */
}

input[type="checkbox"] + label {
    width: 26px;
    height: 26px;
    position: relative;
    cursor: pointer;
    display: inline-block;
    background: url('assets/images1/Heart_corazón.png') no-repeat center center;
    background-size: cover;
    top: 15;
}

input[type="checkbox"] + label:before,
input[type="checkbox"] + label:after {
    content: "";
    background: url('assets/images1/Heart_corazón.png') no-repeat center center;
    background-size: cover;
    height: 26px;
    width: 26px;
    position: absolute;
    top: 0;
    left: 0;
    transform: translate3D(0, 0, 0);
}

input[type="checkbox"] + label:before {
    filter: grayscale(100%);
}

input[type="checkbox"] + label:after {
    opacity: 0;
    filter: grayscale(0%);
}

input[type="checkbox"]:checked + label:before {
    filter: grayscale(0%);
}

input[type="checkbox"]:checked + label:after {
    animation: ascend ease-in-out 800ms;
}

@keyframes ascend {
    0% {
        transform: translate3D(0, 0, 0);
        opacity: 1;
    }
    100% {
        transform: translate3D(0, -100%, 0);
        opacity: 0;
    }
}

/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
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

.btn:hover {
    background-color: #45a049;
}


    </style>
</head>
<body>
<div class="container">
        <div class="product">
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

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

$query = "SELECT productImg, OtherImg, carType, year, engine, mileage, transmission, status, price FROM carlist WHERE id = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $productImg = htmlspecialchars($row['productImg']);
            $otherImages = array_map('htmlspecialchars', array_map('trim', explode(',', $row['OtherImg'])));

            echo '<div class="image-gallery">';
            echo '<button id="prev" class="nav-arrow">❮</button>';
            echo '<img id="mainImage" src="' . $productImg . '" alt="Main Product Image">';
            echo '<button id="next" class="nav-arrow">❯</button>';
            echo '</div>';

            if (!empty($otherImages)) {
                echo '<div class="thumbnail-images" >';
                $count = 0;
                foreach ($otherImages as $img) {
                    // Start a new row after every 3 images
                    if ($count % 3 === 0) {
                        echo '<div class="image-row" style="width: 30%;height: 30%;">';
                    }
                    echo '<img class="thumbnail" src="' . $img . '" alt="Other Product Image">';
                    $count++;
                    // Close the row after 3 images
                    if ($count % 3 === 0 || $count === count($otherImages)) {
                        echo '</div>';
                    }
                }
                echo '</div>';
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
                    <h2>
                        <?= htmlspecialchars($row['year']) ?>
                        <?= htmlspecialchars($row['carType']) ?>
                        <?= htmlspecialchars($row['engine']) ?>
                        <span class="text-muted"><?= htmlspecialchars($row['status']) ?></span>
                    </h2>
                    <p><?= htmlspecialchars($row['transmission']) ?> | <?= htmlspecialchars($row['mileage']) ?> km</p><br>
                    <p>
                        <span class="currency">RM </span><span class="price"><?= htmlspecialchars($row['price']) ?></span>
                    </p>
                    <div class="actions">
                        <a href="finance.php">Loan Calculator</a>
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
                        <br><br>                        
                        <div class="container4">
                            <button id="testDrive" class="btn">Free Test Drive</button>
                            <input type="checkbox" id="heartCheckbox">
                            <label for="heartCheckbox"></label>
                        </div>
                    </div>
                    <p class="help-text">Need more help? Contact us via <span class="phone-icon">📞</span></p>
                <?php } ?>
            </div>

        </div>
    </div>

<div class="containerx">
        <button id="cancel" class="btn">Back</button>
        <button id="update" class="btn">Update</button>
    </div>


    <script>

    document.getElementById('testDrive').onclick = () => {
        window.location.href = 'testDrives.php';
    };

    document.getElementById('update').onclick = () => {
        window.location.href = 'updateCar.php?id=<?= $id ?>';
    };

    document.getElementById('cancel').onclick = () => {
        window.location.href = 'manageCar.php';
    };

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
</script>
</body>
</html>
