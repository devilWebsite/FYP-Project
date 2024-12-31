<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Car Services</title>
    <!-- library css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

    <style>
body{
            background-color: #f2f2f2;
        }

        /* Custom styling for the side navigation */
aside.aside {
    background-color: #1e293b; /* Background color */
    color: #ffffff; /* Text color */
    width: 250px; /* Adjust the width as needed */
    height: 100%; /* Ensure full height of the container */
    position: fixed; /* Fixed positioning */
    top: 0; /* Position from the top */
    left: 0; /* Position from the left */
    overflow-y: auto; /* Enable vertical scrolling if needed */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional: Add box shadow */
    z-index: 1000; /* Ensure it's above other content */
}

/* Styling for the inner content */
aside.aside .aside-tools {
    padding: 20px; /* Padding for tools section */
    border-bottom: 1px solid #ffffff; /* Optional: Add border */
}

aside.aside .menu {
    padding: 20px; /* Padding for menu section */
}

aside.aside .menu .menu-label {
    color: #ffffff; /* Menu label text color */
    margin-bottom: 10px; /* Optional: Adjust spacing */
}

aside.aside .menu-list {
    list-style-type: none; /* Remove default list styles */
    padding: 0;
    margin: 0;
}

aside.aside .menu-list li {
    margin-bottom: 10px; /* Optional: Adjust spacing between menu items */
}

aside.aside .menu-list li a {
    color: #ffffff; /* Menu item text color */
    text-decoration: none; /* Remove underline */
    display: block;
    padding: 10px;
    transition: background-color 0.3s ease; /* Optional: Smooth transition */
}

aside.aside .menu-list li a:hover {
    background-color: rgba(255, 255, 255, 0.1); /* Optional: Hover background color */
    color: #ffffff; /* Optional: Hover text color */
}

aside.aside .menu-list li.active a {
    background-color: rgba(255, 255, 255, 0.2); /* Optional: Active background color */
    color: #ffffff; /* Optional: Active text color */
}

.container {
    margin-left: 310px; /* Adjust this value as needed */
    padding-top: 20px; /* Optional: Add padding to the top */
    padding-right: 20px; /* Optional: Add padding to the right */
    padding-bottom: 20px; /* Optional: Add padding to the bottom */
    padding-left: 20px; /* Optional: Add padding to the left */
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
          <span class="icon"><i class=""></i></span>
          <span class="menu-item-label">Car List</span>
        </a>
      </li>

      <li>
        <a class="dropdown">
          <span class="icon"><i class=""></i></span>
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
                <h3 class="titulo-tabla" style="font-size: 38px;">Manage Car Service - Appointment</h3><br>
                <a href="insert_serviceApp.php" class="btn btn-success pull-right">Add New Data</a><br><br>
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
                    
                    // Fetch inquiries from the inquiry table
                    $sql = "SELECT serviceId, name, email, phoneNumber, serviceCenter, appointmentDate, appointmentTime,remark FROM carserviceapp";
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
                                            <tr class="appointment-row">
                                                <td><?= $row['serviceId']; ?></td>
                                                <td><?= $row['name']; ?></td>
                                                <td><?= $row['phoneNumber']; ?></td>
                                                <td><?= $row['appointmentDate']; ?></td>
                                                <td><?= $row['appointmentTime']; ?></td>                                            
                                                <td style="height: 10px; width: 11.5%;" >
                                                  <a href='view_serviceApp.php?id=<?= $row['serviceId'] ?>' title='View Record' data-toggle='tooltip'>
                                                      <i class='fa fa-eye' aria-hidden='true' style='color:black;'></i>
                                                  </a>
                                                  <a href='update_serviceApp.php?id=<?= $row['serviceId'] ?>' title='Update Record' data-toggle='tooltip'>
                                                      <i class='fa fa-edit' aria-hidden='true' style='color:#3ca23c;'></i>
                                                  </a>
                                                  <button class='btn btn-danger btn-sm delete-btn' data-id='<?= $row['serviceId'] ?>'>
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

<!-- Modal Structure -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="delete_serviceApp.php" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                    <input type="hidden" name="id" id="delete-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- internal script -->

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
    $('#example').DataTable();

    // Get all checkbox elements
    const checkboxes = document.querySelectorAll('.appointment-done');

    // Load the checkbox states from localStorage (if available)
    checkboxes.forEach((checkbox, index) => {
        const savedState = localStorage.getItem('checkboxState' + index);
        checkbox.checked = savedState === 'checked';
    });

    // Add an event listener to save the checkbox state when it changes
    checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener('change', () => {
            const state = checkbox.checked ? 'checked' : 'unchecked';
            localStorage.setItem('checkboxState' + index, state);
        });
    });
});

$(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            $('#delete-id').val(id);
            $('#deleteModal').modal('show');
        });
    });

    </script>
    <script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>
    <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#example').DataTable();
});
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="js/chart.sample.min.js"></script>

<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>
</html>

