<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Add New Brand</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- add style css -->
    <link rel="stylesheet" href="css/css-create-style.css">

    <style>
        .img-preview-container {
            display: flex;
            flex-wrap: wrap;
        }
        .img-preview-container .row {
            width: 100%;
        }
        .img-preview-container img {
            max-width: 120%;
            max-height: 100%;
            margin: 3px;
        }
        body{
            background-color: #f2f2f2;
        }
    </style>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $carType = $_POST['name'];
    $brandType = $_POST['brandType'] == 'Others' ? $_POST['otherBrandType'] : $_POST['brandType'];
    $price = $_POST['price'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $fuel = $_POST['fuel'];
    $engine = $_POST['engine'];
    $transmission = $_POST['transmission'];
    $status = isset($_POST['status']) ? 'Sold' : 'Available';
    $newCar = $_POST['newCar'];

    // Ensure the uploads directory exists
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle product cover image
    $productCoverPath = '';
    if (!empty($_FILES['productCover']['name'])) {
        $productCoverPath = $target_dir . basename($_FILES["productCover"]["name"]);
        if (!move_uploaded_file($_FILES["productCover"]["tmp_name"], $productCoverPath)) {
            echo "Error uploading product cover image.";
            exit;
        }
    }

    // Handle other images
    $otherImagesPaths = [];
    $uploadErrors = [];
    if (!empty($_FILES['otherImages']['name'][0])) {
        foreach ($_FILES['otherImages']['name'] as $key => $filename) {
            $tmp_name = $_FILES['otherImages']['tmp_name'][$key];
            $target_file = $target_dir . basename($filename);
            if (move_uploaded_file($tmp_name, $target_file)) {
                $otherImagesPaths[] = $target_file;
            } else {
                $uploadErrors[] = "Error uploading image: " . $filename;
            }
        }
    }
    $otherImagesPathsStr = implode(',', $otherImagesPaths);

    if (!empty($uploadErrors)) {
        echo "Some images failed to upload: " . implode('; ', $uploadErrors);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO carlist (id, carType, brandType, price, year, mileage, fuel, engine, transmission, productImg, OtherImg, status, newCar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdisssssss", $id, $carType, $brandType, $price, $year, $mileage, $fuel, $engine, $transmission, $productCoverPath, $otherImagesPathsStr, $status, $newCar);

    if ($stmt->execute()) {
        // Redirect to manageCar.php after successful insertion
        header("Location: manageCar.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<script>    
    function handleBrandTypeChange(event) {
        const selectedValue = event.target.value;
        const otherBrandInputDiv = document.getElementById('otherBrandInputDiv');

        if (selectedValue === 'Others') {
            otherBrandInputDiv.innerHTML = `
                <label for="otherBrandType">Please specify</label>
                <input type="text" name="otherBrandType" id="otherBrandType" class="form-control" required>
            `;
        } else {
            otherBrandInputDiv.innerHTML = '';
        }
    }

    function previewImage(input, previewContainer) {
    const previewDiv = document.getElementById(previewContainer);
    previewDiv.innerHTML = ''; // Clear previous previews

    if (input.files) {
        const files = Array.from(input.files);
        let row;

        files.forEach((file, index) => {
            if (index % 3 === 0) {
                row = document.createElement('div');
                row.className = 'row';
                previewDiv.appendChild(row);
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'col-md-4'; // 3 columns per row

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '100%';
                img.style.margin = '5px';

                imgContainer.appendChild(img);
                row.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }
}

    function previewProductCover(input) {
        const productCoverPreview = document.getElementById('productCoverPreview');
        productCoverPreview.innerHTML = ''; // Clear previous preview

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '100%';
                img.style.margin = '5px';

                productCoverPreview.appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Usage example for "Add Other Images"
    document.getElementById('otherImages').addEventListener('change', function() {
        previewImage(this, 'otherImagesPreview');
    });

    // Usage example for "Product Cover"
    document.getElementById('productCover').addEventListener('change', function() {
        previewProductCover(this);
    });

    // Update hidden input based on checkbox
    function updateNewCarStatus(checkbox) {
        document.getElementById('newCarHidden').value = checkbox.checked ? 'New' : 'Non-New';
    }
    function previewImage(input, previewContainer) {
    const previewDiv = document.getElementById(previewContainer);
    previewDiv.innerHTML = ''; // Clear previous previews

    if (input.files) {
        const files = Array.from(input.files);
        let row;

        files.forEach((file, index) => {
            if (index % 3 === 0) {
                row = document.createElement('div');
                row.className = 'row';
                previewDiv.appendChild(row);
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'col-md-4'; // 3 columns per row

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.maxWidth = '100%';
                img.style.margin = '5px';

                imgContainer.appendChild(img);
                row.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }
}

</script>

</head>
<body>
<div class="container">
    <div class="signup-form">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Add New Car List</h2>
                    <div style="float: right";>
                        <label class="" style="display: flex; align-items: center;">
                            <input type="checkbox" name="newCarCheckbox" style="width: 28px; height: 28px; margin-right: 5px;" onclick="updateNewCarStatus(this)">
                            New
                        </label>
                    </div><br>
                    <hr>
                </div>
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <label for="id">Car Id</label>
                    <input type="number" name="id" class="form-control" style="width: 100% !important;" required>
                </div><br>
                
                <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="brandType">Brand Type</label>
                            <select name="brandType" id="brandType" class="form-control" required onchange="handleBrandTypeChange(event)">
                                <option value="BMW">BMW</option>
                                <option value="Audi">Audi</option>
                                <option value="Honda">Honda</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Nissan">Nissan</option>
                                <option value="Perodua">Perodua</option>
                                <option value="Proton">Proton</option>
                                <option value="Suzuki">Suzuki</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Others">Others</option>
                            </select>
                            <div id="otherBrandInputDiv" class="mt-2"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="name">Car Type:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" min="1000" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="year">Year</label>
                            <input type="text" class="form-control" id="year" name="year" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="fuel">Fuel</label>
                            <input type="text" class="form-control" id="fuel" name="fuel" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="mileage">Mileage</label>
                            <input type="text" class="form-control" id="mileage" name="mileage" required>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 form-group">
                            <label for="transmission">Transmission</label>
                            <select class="form-control" id="transmission" name="transmission" required>
                                <option value="Manual">Manual</option>
                                <option value="Automatic">Automatic</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="engine">Engine</label>
                            <input type="text" class="form-control" id="engine" name="engine" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="productCover">Product Cover</label>
                            <input type="file" class="form-control-file" id="productCover" name="productCover" required onchange="previewProductCover(this)">
                            <div id="productCoverPreview" class="img-preview-container mt-2"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="otherImages">Add Other Images</label>
                            <input type="file" class="form-control-file" id="otherImages" name="otherImages[]" multiple required onchange="previewImage(this, 'otherImagesPreview')">
                            <div id="otherImagesPreview" class="img-preview-container mt-2"></div>
                        </div>

                    </div><br>
                    <div class="col-md-6 form-group">
                        <label class="" style="display: flex; align-items: center;">
                            <input type="checkbox" name="status" style="width: 28px; height: 28px; margin-right: 5px;" value="Sold">
                            Sold
                        </label>
                    </div>

                    <input type="hidden" id="newCarHidden" name="newCar" value="Non-New">
                    
                    <div class="text-center mt-4">
                        <input type="submit" class="btn btn-primary" value="Insert New Record">
                        <a href="manageCar.php" class="btn btn-default" style="color:red;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div> 
</body>
</html>
