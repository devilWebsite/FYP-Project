<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Car</title>
    <!-- library css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
            body{
            background-color: #f2f2f2;
        }
        
</style>
</head>
<body>
<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
    Admin Panel<b class="font-black"> Car United </b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="active">
        <a href="admin.php">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">Maintenance</p>
    <ul class="menu-list">
    <li class="--set-active-profile-html">
            <a href="manageBrand.php">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            <span class="menu-item-label">Brand List</span>
            </a>
      </li>

      <li class="--set-active-profile-html">
        <a href="manageInquiries.php">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Inquiries</span>
        </a>
      </li>

      <li class="--set-active-profile-html">
        <a href="manageCar.php">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Car List</span>
        </a>
      </li>

      <li>
        <a class="dropdown">
          <span class="icon"><i class="mdi mdi-view-list"></i></span>
          <span class="menu-item-label">Appointments</span>
          <span class="icon"><i class="mdi mdi-plus"></i></span>
        </a>
        <ul>
          <li>
            <a href="manageCarService.php">
              <span>Car Service</span>
            </a>
          </li>
          <li>
            <a href="manageTestDrives.php">
              <span>Test Drives</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div><br>
</aside>


<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h2 class="titulo-tabla" style= 'font-size: 38px;'>List of Car</h2>
            <a href="addCar.php" class="btn btn-success pull-right">+ Add New Brand</a>
            <br><br>
            <hr><br>

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

// Fetch data from the carlist table
$sql = "SELECT * FROM carlist";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        ?>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date Created</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Transmission</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr class="brand-row" data-id="<?= $row['id']; ?>">
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['dateCreated']; ?></td>
                        <td>
                        <?php
                            if ($row['productImg']) {
                                echo "<img src='" . $row['productImg'] . "' alt='brandType' style='width: 135px; height: 110px;'><br>";
                                echo $row['brandType']; // Display the brand name
                            } else {
                                echo "No image available<br>";
                                echo $row['brandType']; // Display the brand name even if no image is available
                            }
                            ?>
                        </td>
                        <td><?= $row['carType']; ?></td>
                        <td><?= $row['transmission']; ?></td>
                        <td>
                        <?php
                            switch($row['status']){
                                case 'Available':
                                    echo "<span class='badge badge-success'>Available</span>";
                                    break;
                                case 'Unavailable':
                                    echo "<span class='badge badge-success'>Unavailable</span>";
                                    break;
                                case 'Sold':
                                    echo "<span class='badge badge-secondary'>Sold</span>";
                                    break;
                            }

                            // Add a line break after the status
                            echo "<br>";

                            switch($row['newCar']){
                                case 'New':
                                    echo "<span class='badge badge-success' style = 'background-color: #387dc2;'>New</span>";
                                    break;
                            }
                        ?>

                        </td>                                        
                        <td style="align:center;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item" href="viewCar.php?id=<?= $row['id'] ?>">
                                        <span class="fa fa-edit text-primary"></span> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                        <span class="fa fa-trash text-danger"></span> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "<p class='lead'><em>No records were found.</em></p>";
    }
} else {
    echo "ERROR: Could not execute $sql. " . $conn->error;
}

// Close connection
$conn->close();
?>

        </div>
    </div>
</div>                                        

<!-- library js -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#example').DataTable();
});

    $(document).on('click', '.delete_data', function() {
    var carId = $(this).data('id'); // Get the data-id of the clicked element
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: 'deleteCar.php', // The PHP file that will handle the deletion
            type: 'POST',
            data: { id: carId },
            success: function(response) {
                if (response == 'success') {
                    // If the response is 'success', remove the table row
                    $('tr.brand-row[data-id="' + carId + '"]').remove();
                } else {
                    // If the response is not 'success', alert the error
                    alert('Error deleting record.');
                }
            }
        });
    }
});

</script>

<script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="js/chart.sample.min.js"></script>

<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>
</html>