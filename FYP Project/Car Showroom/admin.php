<!DOCTYPE html>
<html lang="en" class=""> 
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FYP Project - Admin</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
 .dark-mode * {
  background-color: black;
  color: white;
}


.notification {
      background-color: grey;
      color: white;
      text-decoration: none;
      padding: 8px 10px;
      position: relative;
      display: inline-block;
      border-radius: 2px;
    }

    .notification:hover {
      background: red;
    }

    .notification .badge {
      position: absolute;
      top: -10px;
      right: -10px;
      padding: 5px 10px;
      border-radius: 50%;
      background-color: red;
      color: white;
    }

  </style>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>

</head>
<body>

<div id="app">
    <!-- First Header -->
<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control"><input placeholder="Search everywhere..." class="input"></div>
    </div>
  </div>
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
            <img src="assets/images/admin.png" alt="Admin" class="rounded-full">
          </div>
          <div class="is-user-name"><span>Admin</span></div>
        </a>
      </div>
      <a title="Log out" class="navbar-item desktop-icon-only" href="logout.php">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
</nav>
    <!-- Header End -->

    <!-- Side Nav Start -->

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
  <button onclick="myFunction()" style='color: white;'>
    <i class="fas fa-moon"></i> Dark Mode
  </button>
</aside>

    <!-- Side Nav End -->

    <!-- Header 2/3 Start -->

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Dashboard</li>
    </ul>
    <!-- -->
    <a href="manageTestDrives.php" class="notification" id="notificationLink" style='float: right;'>
    <span>Test Drives</span>
    <span class="badge" id="notificationBadge">0</span>
</a>

</div>
</section><br>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Dashboard
    </h1>
    <a href="manageCarService.php" class="notification" id="carServiceNotification" style='float: right;'>
    <span>Car Service</span>
    <span class="badge" id="carServiceBadge">0</span>
</a>
    </div>
</section>

    <!-- Header 2/3 End -->

    <!-- Header 4 Start -->

  <section class="section main-section">
    <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Clients
              </h3>
              <h1>
                4
              </h1>
            </div>
            <span class="icon widget-icon text-green-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Cars
              </h3>
              <h1>
                4
              </h1>
            </div>
            <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Appointments
              </h3>
              <h1>
                20
              </h1>
            </div>
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>
        <!-- Header 4 Start -->

        <!-- Header 5 Start -->

    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-finance"></i></span>
          Performance
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div></div>
              </div>
            </div>
            <canvas id="big-line-chart" width="2992" height="1000" class="chartjs-render-monitor block" style="height: 400px; width: 1197px;"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Header 5 End -->

<!-- Header 6 Start -->
<div class="card has-table">
  <header class="card-header">
    <p class="card-header-title">
      <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
      Clients Inquiries
    </p>
    <a href="#" class="card-header-icon" onclick="location.reload()">
      <span class="icon"><i class="mdi mdi-reload"></i></span>
    </a>
  </header>
  <div class="card-content">
    <table>
      <thead>
        <tr>
          <th></th>
          <th>Id</th>
          <th>Name</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Created</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Assuming you have already connected to your MySQL database
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "project2";

          $conn = new mysqli($servername, $username, $password, $dbname);

          // Check connection
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          // Query to fetch the first 6 inquiries ordered by dateCreated descending
          $sql = "SELECT id, name, subject, status, dateCreated FROM inquiry ORDER BY dateCreated DESC LIMIT 6";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<tr>';
              echo '<td class="image-cell">';
              echo '<div class="image">';
              echo '<img src="https://avatars.dicebear.com/v2/initials/'.$row['name'].'.svg" class="rounded-full">';
              echo '</div>';
              echo '</td>';
              echo '<td>' . htmlspecialchars($row['id']) . '</td>';
              echo '<td>' . htmlspecialchars($row['name']) . '</td>';
              echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
              echo '<td>' . htmlspecialchars($row['status']) . '</td>';
              echo '<td>' . htmlspecialchars($row['dateCreated']) . '</td>';
              echo '<td class="actions-cell">';
              echo '<div class="buttons right nowrap">';
              echo '<form method="POST" action="delete_inquiry.php">';
              echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">';
              echo '<button class="button small red --jb-modal" data-target="sample-modal" type="button">';
              echo '<span class="icon"><i class="mdi mdi-trash-can"></i></span>';
              echo '</button>';
              echo '</form>';
              echo '</div>';
              echo '</td>';
              echo '</tr>';
            }
          } else {
            echo "<tr><td colspan='7'>No inquiries found</td></tr>";
          }

          $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>

<div id="sample-modal" class="modal">
  <div class="modal-background --jb-modal-close"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Delete Confirmation</p>
    </header>
    <section class="modal-card-body">
      <p>Are you sure you want to delete this item?</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button --jb-modal-close">Cancel</button>
      <button class="button red --jb-modal-confirm">Confirm</button>
    </footer>
  </div>
</div>

<!-- Scripts below are for demo only -->
<script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script type="text/javascript" src="js/chart.sample.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', () => {
  let deleteForm;
  
  document.querySelectorAll('.button.red').forEach(button => {
    button.addEventListener('click', (event) => {
      event.preventDefault();
      deleteForm = button.closest('form');
      const modal = document.querySelector('#sample-modal');
      modal.classList.add('is-active');
    });
  });

  document.querySelectorAll('.--jb-modal-close').forEach(close => {
    close.addEventListener('click', () => {
      document.querySelector('#sample-modal').classList.remove('is-active');
    });
  });

  document.querySelector('.--jb-modal-confirm').addEventListener('click', () => {
    if (deleteForm) {
      deleteForm.submit();
    }
  });
});


  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '658339141622648');
  fbq('track', 'PageView');

  function myFunction() {
   var element = document.body;
   element.classList.toggle("dark-mode");}
   function myFunction() {
      document.body.classList.toggle("dark-mode");
      const button = document.querySelector("button");
      const icon = button.querySelector("i");
      if (document.body.classList.contains("dark-mode")) {
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
      } else {
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
      }
    }

// Function to fetch new appointment counts and update badges
function fetchNewAppointmentCounts() {
      fetch('check_new_appointments.php')
        .then(response => response.json())
        .then(data => {
          document.getElementById('testDriveBadge').textContent = data.testDrive;
          document.getElementById('carServiceBadge').textContent = data.carService;
        })
        .catch(error => {
          console.error('Error fetching new appointment counts:', error);
        });
    }

    // Fetch counts initially on page load
    fetchNewAppointmentCounts();

    // Fetch counts periodically (e.g., every 30 seconds)
    setInterval(fetchNewAppointmentCounts, 30000); // Adjust interval as needed
    
    </script>

<script>
// Function to fetch the counts of test drive and car service appointments
function fetchCounts() {
    fetch('getCounts.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('notificationBadge').innerText = data.testDrive;
            document.getElementById('carServiceBadge').innerText = data.carService;
        })
        .catch(error => console.error('Error fetching counts:', error));
}

// Fetch the counts on page load and every 30 seconds
window.onload = fetchCounts;
setInterval(fetchCounts, 30000);
</script>

    
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>
</html>
