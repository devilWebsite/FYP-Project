<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT id, productImg, carType, engine FROM favourites WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="favoriteItem" data-id="' . htmlspecialchars($row['id']) . '">';
            echo '<img src="' . htmlspecialchars($row['productImg']) . '" alt="' . htmlspecialchars($row['carType']) . '" style="width: 200px; height: 150px;">';
            echo '<div class="favoriteDetails">';
            echo '<p>' . htmlspecialchars($row['carType']) . ' ' . htmlspecialchars($row['engine']) . '</p>';
            echo '</div>';
            echo '<button class="removeFavorite">Remove</button>';
            echo '</div>';
        }
    } else {
        echo 'No favorites found.';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request.';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            #favorites {
    position: fixed;
    top: 100px;
    right: 0;
    width: 400px;
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
    
<script>
    $(document).ready(function() {
    $('#addToFavourites').on('click', function(e) {
        e.preventDefault();

        var carId = $(this).data('id');

        $.ajax({
            url: 'add_to_favourites.php',
            type: 'POST',
            data: { id: carId },
            success: function(response) {
                alert(response);
                $('#viewFavorites').addClass('animate__animated animate__wobble');
                setTimeout(function() {
                    $('#viewFavorites').removeClass('animate__animated animate__wobble');
                }, 1000);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('#viewFavorites').on('click', function(e) {
        e.preventDefault();

        $('html, body').animate({ scrollTop: 0 }, 'fast');
        loadFavorites();
        $('#favorites').addClass('open');
    });

    $('#favorites .close').on('click', function() {
        $('#favorites').removeClass('open');
    });

    function loadFavorites() {
        $.ajax({
            url: 'get_favourites.php',
            type: 'GET',
            success: function(response) {
                $('#favoritesList').html(response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
});

$(document).ready(function() {
    // Click handler for removeFavorite buttons
    $(document).on('click', '.removeFavorite', function() {
        var favoriteId = $(this).closest('.favoriteItem').data('id');

        // AJAX call to delete favorite
        $.ajax({
            url: 'remove_favorite.php',
            type: 'POST',
            data: { id: favoriteId },
            success: function(response) {
                console.log(response); // Log response for debugging
                loadFavorites(); // Reload favorites list after removal
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    // Function to load favorites
    function loadFavorites() {
        $.ajax({
            url: 'get_favorites.php',
            type: 'GET',
            success: function(response) {
                $('#favoritesList').html(response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
});

</script>
</body>
</html>