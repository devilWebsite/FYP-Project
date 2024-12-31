<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Car Brand</title>
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
        .brand-img {
            width: 28%;
            height: 28%;
            object-fit: cover;
            object-position: center center;
        }
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
            <h2 class="titulo-tabla" style= 'font-size: 38px;'>List of Brands</h2>
            <a href="addbrand.php" class="btn btn-success pull-right">+ Add New Brand</a>
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

                // Fetch data from the brandlist table
                $sql = "SELECT * FROM brandlist";
                $result = $conn->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        ?>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date Updated</th>
                                    <th>Image</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while ($row = $result->fetch_assoc()) {
                                    $imagePath = "assets/images1/" . $row['imagePath']; 
                                    echo "<tr class='brand-row'>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['dateUpdated'] . "</td>";
                                    echo "<td><img src='" . $imagePath . "' alt='Brand Image' class='brand-img'></td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "<td>";
                                    echo "  ";
                                    echo "<a href='updatebrand.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'>";
                                    echo "<i class='fa fa-edit' aria-hidden='true' style='color:#3ca23c;'></i>";
                                    echo "</a>";
                                    echo "  ";
                                    echo "<a href='deletebrand.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'>";
                                    echo "<i class='fa fa-trash' aria-hidden='true' style='color:red;'></i>";
                                    echo "</a>";
                                    echo "</td>";
                                    echo "</tr>";
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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

<!-- internal script -->
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission

        // Get input values (image, brand name, status)
        const imagePath = document.getElementById('imagePath').value;
        const name = document.getElementById('name').value;
        const status = document.getElementById('status').value;

        // Create a new row in the table
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>1</td>
            <td>${new Date().toLocaleString()}</td>
            <td><img src="${imagePath}" alt="Brand Image" class="brand-img"></td>
            <td>${name}</td>
            <td>${status}</td>
        `;

        // Append the new row to the table body
        document.querySelector('tbody').appendChild(newRow);

        // Clear input fields (optional)
        document.getElementById('imagePath').value = '';
        document.getElementById('name').value = '';
        document.getElementById('status').value = '';
    });

    // Initialize Bootstrap dropdowns
    $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
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