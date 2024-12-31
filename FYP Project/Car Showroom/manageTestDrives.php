<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Test Drives</title>
    <!-- library css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="inquiry.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css">
  <script src="path/to/your/js/jquery.min.js"></script>

<style>
    body{
            background-color: #f2f2f2;
        }
.icon-edit,
.btn-sm {
    display: inline-block; /* Ensure they are inline */
    vertical-align: middle; /* Align vertically in the middle */
    margin-right: 5px; /* Adjust margin between buttons */
}

.icon-edit {
    color: #3498db; /* Blue */
}

.btn-sm {
    color: #e74c3c; /* Red */
}

.icon-edit:hover,
.btn-sm:hover {
    transform: translateY(-2px);
}


.btn-sm {
    color: #c0392b; /* Darker Red */
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
            <h3 class="titulo-tabla" style= 'font-size: 38px;'>Manage Test Drives - Appointment</h3><br>
            <hr><br>
            
            <a href="insertTestDrive.php" class="btn btn-success pull-right"> + New Appointment</a><br><br>

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
                
                // Fetch inquiries from the inquiry table
                $sql = "SELECT testDriveId, name, phoneNumber, appointmentDate, appointmentTime, remark FROM testdriveapp";
                $result = $conn->query($sql);
                
                if ($result) {
                    if ($result->num_rows > 0) {
            ?>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Appointment Id</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Action</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr class="appointment-row" id="row-<?= $row['testDriveId']; ?>">
                                            <td><?= $row['testDriveId']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['phoneNumber']; ?></td>
                                            <td><?= $row['appointmentDate']; ?></td>
                                            <td><?= $row['appointmentTime']; ?></td>                                            
                                            <td style="height: 10px; width: 10.1%;" >
                                                <!-- Updated link for edit -->
                                                <a href='updateTestDrive.php?id=<?= $row['testDriveId'] ?>' title='Edit Record' class='icon icon-edit' data-toggle='tooltip'>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class='btn-sm delete-btn' onclick="deleteAppointment(<?= $row['testDriveId']; ?>)">
                                                        <i class='fa fa-trash' aria-hidden='true'></i>
                                                </button>
                                            </td>
                                            <td>
                                              <textarea name="remark" class="form-control" style="height: 68px; width: 100%; margin-top: 6px; font-size: 16px;"readonly><?php echo htmlspecialchars($row['remark']); ?></textarea>
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
                    echo "ERROR: Could not able to execute $sql. " . $conn->error;
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
<script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="js/chart.sample.min.js"></script>

<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

<script>
  document.addEventListener('DOMContentLoaded', (event) => {
  // Retrieve all save buttons
  const saveButtons = document.querySelectorAll('[id^="saveRemarkButton-"]');

  saveButtons.forEach(button => {
    const id = button.id.split('-')[1];

    // Load the remark from localStorage if it exists
    const savedRemark = localStorage.getItem(`adminRemark-${id}`);
    if (savedRemark) {
      document.getElementById(`remark-${id}`).value = savedRemark;
    }

    // Add event listener to the save button
    button.addEventListener('click', () => {
      const remark = document.getElementById(`remark-${id}`).value;
      localStorage.setItem(`adminRemark-${id}`, remark);
      alert('Remark saved!');
    });
  });
});


$(document).ready(function() {
    // Initialize DataTable
    $('#example').DataTable();
});

function deleteAppointment(id) {
                if (confirm('Are you sure you want to delete this appointment?')) {
                    $.ajax({
                        url: 'deleteTestDrive.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            // If the record is successfully deleted, remove the row from the table
                            $('#row-' + id).remove();
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                }
            }

</script>

</body>
</html>

